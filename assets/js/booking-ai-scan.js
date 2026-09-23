/**
 * Booking AI scan — voucher image / pasted text / passports -> fills the booking form.
 * Used by: booking/list (New Booking modal, mode "create") and booking/edit (mode "edit").
 *
 * Flow: scan -> review table (tick what to apply) -> fill the existing form fields -> staff checks -> Submit.
 * Nothing is saved by the AI; images go to Google Drive only after the booking is saved
 * (create) or when the scanned data is applied (edit).
 */
(function ($) {
    'use strict';

    const API = {
        voucher: 'pages/booking/function/ai-scan-voucher.php',
        passport: 'pages/booking/function/ai-scan-passport.php',
        upload: 'pages/booking/function/drive-upload.php',
        list: 'pages/booking/function/drive-list.php',
        file: 'pages/booking/function/drive-file.php'
    };
    const THAILAND_ID = 182; // nationalitys.id of Thailand
    // PHP defaults: max_file_uploads = 20, post_max_size = 8M -> small batches of already-shrunk photos
    const FILES_PER_REQUEST = 10;

    const state = {
        mode: 'create',
        bookingId: 0,
        voucherFile: null,
        voucherResult: null,
        passportFiles: [],
        passportResult: null,
        pending: [], // [{file, kind}] waiting for Drive upload (create mode)
        $form: null
    };

    // ------------------------------------------------------------------ helpers

    function esc(value) {
        return $('<div>').text(value === null || value === undefined ? '' : String(value)).html();
    }

    function toast(icon, title) {
        if (typeof Swal === 'undefined') return;
        Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3500, timerProgressBar: true })
            .fire({ icon: icon, title: title });
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function waitFor(check, timeoutMs = 10000) {
        const start = Date.now();
        while (Date.now() - start < timeoutMs) {
            try {
                if (check()) return true;
            } catch (e) { /* element not ready yet */ }
            await sleep(120);
        }
        return false;
    }

    // Downscale phone photos in the browser (max 2000px JPEG) so uploads stay small on the server
    function shrinkImage(file, maxDim = 2000, quality = 0.85) {
        return new Promise(resolve => {
            if (!file || !/^image\/(jpeg|png|webp)$/.test(file.type)) {
                resolve(file);
                return;
            }
            const url = URL.createObjectURL(file);
            const img = new Image();
            img.onload = () => {
                URL.revokeObjectURL(url);
                const scale = Math.min(1, maxDim / Math.max(img.width, img.height));
                if (scale === 1 && file.size <= 1.5 * 1024 * 1024) {
                    resolve(file);
                    return;
                }
                const canvas = document.createElement('canvas');
                canvas.width = Math.max(1, Math.round(img.width * scale));
                canvas.height = Math.max(1, Math.round(img.height * scale));
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#fff'; // transparent PNG screenshots -> white background
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                canvas.toBlob(blob => {
                    const name = (file.name || 'image').replace(/\.[^.]+$/, '') + '.jpg';
                    resolve(blob ? new File([blob], name, { type: 'image/jpeg' }) : file);
                }, 'image/jpeg', quality);
            };
            img.onerror = () => {
                URL.revokeObjectURL(url);
                resolve(file); // e.g. HEIC: send as-is
            };
            img.src = url;
        });
    }

    function chunk(list, size) {
        const out = [];
        for (let i = 0; i < list.length; i += size) out.push(list.slice(i, i + size));
        return out;
    }

    function formatMoney(value) {
        const n = Number(value) || 0;
        return n.toLocaleString('en-US', { maximumFractionDigits: 2 });
    }

    function formatDateTh(ymd) {
        if (!ymd) return '';
        const p = ymd.split('-');
        return p.length === 3 ? `${p[2]}/${p[1]}/${p[0]}` : ymd;
    }

    // Booking form fields only — booking/list also has a search form that reuses ids like #voucher_no
    function fld(selector) {
        return state.$form && state.$form.length ? state.$form.find(selector) : $(selector);
    }

    // Change a (select2) select without firing its inline onchange handler, unless fireInline=true
    function setSelect(selector, value, fireInline) {
        const $el = fld(selector);
        if (!$el.length) return false;
        const el = $el[0];
        const inline = el.onchange;
        if (!fireInline) el.onchange = null;
        $el.val(value).trigger('change');
        if (!fireInline) el.onchange = inline;
        return true;
    }

    function setInput(selector, value) {
        const $el = fld(selector);
        if (!$el.length) return false;
        $el.val(value);
        flash($el);
        return true;
    }

    function flash($el) {
        const $target = $el.hasClass('select2-hidden-accessible') ? $el.next('.select2').find('.select2-selection') : $el;
        $target.addClass('ai-scan__field--filled');
        setTimeout(() => $target.removeClass('ai-scan__field--filled'), 2500);
    }

    function ageType(birthDate, refDate) {
        if (!birthDate) return 1;
        const b = new Date(birthDate);
        const r = refDate ? new Date(refDate) : new Date();
        if (isNaN(b.getTime())) return 1;
        let age = r.getFullYear() - b.getFullYear();
        const m = r.getMonth() - b.getMonth();
        if (m < 0 || (m === 0 && r.getDate() < b.getDate())) age--;
        if (age < 2) return 3;
        if (age < 12) return 2;
        return 1;
    }

    const AGE_LABEL = { 1: 'Adult', 2: 'Child', 3: 'Infant', 4: 'FOC' };
    const TYPE_TO_AGE = { adult: 1, child: 2, infant: 3, foc: 4 };

    function travelDate() {
        return fld('#travel_date').val() || '';
    }

    function isEdit() {
        return state.mode === 'edit';
    }

    // ------------------------------------------------------------------ panel / tabs

    function showTab(tab) {
        const $panel = $('#ai-scan');
        const $btn = $panel.find(`[data-ai-tab="${tab}"]`);
        const open = !$btn.hasClass('active');
        $panel.find('[data-ai-tab]').removeClass('active');
        $panel.find('[data-ai-section]').prop('hidden', true);
        if (open) {
            $btn.addClass('active');
            $panel.find(`[data-ai-section="${tab}"]`).prop('hidden', false);
            if (tab === 'files') loadDriveFiles();
        }
    }

    function activeSection() {
        const $s = $('#ai-scan [data-ai-section]:not([hidden])');
        return $s.length ? $s.data('ai-section') : '';
    }

    function bindDropzone($zone, $input, onFiles) {
        $zone.on('click', function (e) {
            if ($(e.target).is('input')) return;
            $input.trigger('click');
        });
        $zone.on('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $input.trigger('click');
            }
        });
        $input.on('change', function () {
            onFiles(Array.from(this.files || []));
            this.value = '';
        });
        $zone.on('dragover dragenter', function (e) {
            e.preventDefault();
            $zone.addClass('ai-scan__dropzone--over');
        });
        $zone.on('dragleave drop', function (e) {
            e.preventDefault();
            $zone.removeClass('ai-scan__dropzone--over');
        });
        $zone.on('drop', function (e) {
            const files = Array.from(e.originalEvent.dataTransfer.files || []).filter(f => /^image\//.test(f.type));
            if (files.length) onFiles(files);
        });
    }

    async function setVoucherFile(file) {
        state.voucherFile = file ? await shrinkImage(file) : null;
        const $img = $('#ai-voucher-preview');
        if (state.voucherFile) {
            $img.attr('src', URL.createObjectURL(state.voucherFile)).prop('hidden', false);
            $('#ai-voucher-hint').prop('hidden', true);
            $('#ai-voucher-clear-img').prop('hidden', false);
        } else {
            $img.attr('src', '').prop('hidden', true);
            $('#ai-voucher-hint').prop('hidden', false);
            $('#ai-voucher-clear-img').prop('hidden', true);
        }
    }

    async function addPassportFiles(files) {
        const images = files.filter(f => /^image\//.test(f.type)).slice(0, Math.max(0, 40 - state.passportFiles.length));
        if (files.length > images.length) toast('info', 'รับได้สูงสุด 40 รูปต่อครั้ง');
        for (const f of images) {
            state.passportFiles.push(await shrinkImage(f));
        }
        renderPassportThumbs();
    }

    function renderPassportThumbs() {
        const html = state.passportFiles.map((f, i) => `
            <div class="ai-scan__thumb">
                <img src="${URL.createObjectURL(f)}" alt="">
                <button type="button" class="btn btn-danger ai-scan__thumb-remove" data-ai-remove-passport="${i}">&times;</button>
                <div class="text-truncate">${esc(f.name || ('รูป ' + (i + 1)))}</div>
            </div>`).join('');
        $('#ai-passport-thumbs').html(html);
        $('#ai-passport-count').text(state.passportFiles.length);
        $('#ai-passport-run').prop('disabled', state.passportFiles.length === 0);
    }

    function busy($btn, on, label) {
        if (on) {
            $btn.data('ai-html', $btn.html()).prop('disabled', true)
                .html(`<span class="spinner-border spinner-border-sm mr-50"></span>${label || 'กำลังประมวลผล...'}`);
        } else {
            $btn.prop('disabled', false).html($btn.data('ai-html'));
            if (typeof feather !== 'undefined') feather.replace({ width: 14, height: 14 });
        }
    }

    function ajaxForm(url, formData) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                timeout: 180000,
                success: res => (res && res.success) ? resolve(res) : reject(new Error((res && res.message) || 'เกิดข้อผิดพลาด')),
                error: (xhr, status) => {
                    const msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message
                        : (status === 'timeout' ? 'หมดเวลารอ AI กรุณาลองใหม่' : 'เชื่อมต่อไม่สำเร็จ กรุณาลองใหม่');
                    reject(new Error(msg));
                }
            });
        });
    }

    // ------------------------------------------------------------------ voucher scan

    async function runVoucher() {
        const text = $('#ai-voucher-text').val().trim();
        if (!state.voucherFile && !text) {
            toast('warning', 'กรุณาแนบรูป Voucher หรือวางข้อความก่อน');
            return;
        }
        const fd = new FormData();
        if (state.voucherFile) fd.append('voucher_image', state.voucherFile);
        if (text) fd.append('voucher_text', text);

        const $btn = $('#ai-voucher-run');
        busy($btn, true, 'AI กำลังอ่าน Voucher...');
        try {
            const res = await ajaxForm(API.voucher, fd);
            state.voucherResult = res.data;
            renderVoucherReview(res.data);
        } catch (err) {
            $('#ai-voucher-result').html(`<div class="alert alert-danger p-1 mt-1">${esc(err.message)}</div>`);
        } finally {
            busy($btn, false);
        }
    }

    function paxText(p) {
        const parts = [];
        if (p.adult) parts.push(`${p.adult} ผู้ใหญ่`);
        if (p.child) parts.push(`${p.child} เด็ก`);
        if (p.infant) parts.push(`${p.infant} ทารก`);
        if (p.foc) parts.push(`${p.foc} FOC`);
        return parts.join(', ');
    }

    function renderVoucherReview(d) {
        const warn = key => (d.uncertain || []).indexOf(key) !== -1;
        // On edit, fields that change the price/booking identity start un-ticked
        const offOnEdit = ['travel_date', 'agent', 'product', 'pax', 'cot', 'extra'];
        const rows = [];
        const add = (key, label, valueHtml, isWarn, hasValue) => {
            if (!hasValue) return;
            const checked = isEdit() && offOnEdit.indexOf(key) !== -1 ? '' : 'checked';
            rows.push(`
                <tr class="${isWarn ? 'ai-scan__row--warn' : ''}">
                    <td><div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ai-apply-${key}" data-ai-apply="${key}" ${checked}>
                        <label class="custom-control-label" for="ai-apply-${key}"></label></div></td>
                    <th>${label}</th>
                    <td>${valueHtml}${isWarn ? ' <span class="ai-scan__warn">⚠ ตรวจสอบ</span>' : ''}</td>
                </tr>`);
        };

        add('travel_date', 'Travel Date', esc(formatDateTh(d.travel_date)), warn('travel_date'), !!d.travel_date);

        // Agent: matched / candidates / keep as typed name
        if (d.agent.raw || d.agent.id) {
            let options = '';
            const seen = {};
            (d.agent.candidates || []).forEach(c => {
                seen[c.id] = true;
                options += `<option value="${c.id}" ${c.id === d.agent.id ? 'selected' : ''}>${esc(c.name)} (${c.score}%)</option>`;
            });
            if (d.agent.id && !seen[d.agent.id]) options = `<option value="${d.agent.id}" selected>${esc(d.agent.name)}</option>` + options;
            options += `<option value="outside" ${!d.agent.id ? 'selected' : ''}>กรอกเอง: ${esc(d.agent.raw)}</option>`;
            const html = `<div class="small text-muted">อ่านได้: ${esc(d.agent.raw || '-')}</div>
                <select class="form-control form-control-sm" id="ai-agent-choice">${options}</select>`;
            add('agent', 'Agent', html, warn('agent_name') || !d.agent.id, true);
        }

        add('voucher_no', 'Voucher', esc(d.voucher_no), warn('voucher_no'), !!d.voucher_no);
        add('sender', 'Sender', esc(d.sender), warn('sender_name'), !!d.sender);
        add('telephone', 'Telephone', esc(d.telephone), warn('customer_phone'), !!d.telephone);

        const cats = (d.categories || []).map(c => c.name).join(' + ');
        const prodHtml = d.product.id
            ? `<b>${esc(d.product.name)}</b>${cats ? ' / ' + esc(cats) : ''}${d.booking_type === 2 ? ' <span class="badge badge-light-warning">Private</span>' : ''}
               <div class="small text-muted">${esc(d.tour_text)}</div>`
            : `<span class="text-danger">ไม่พบโปรแกรมที่ตรงกัน</span> <span class="small text-muted">${esc(d.tour_text)}</span>`;
        add('product', 'Programe', prodHtml, warn('product_id') || !d.product.id, !!(d.product.id || d.tour_text));

        const thai = paxText(d.pax_thai);
        const foreign = paxText(d.pax_foreign);
        const paxHtml = [thai ? `Thai: ${esc(thai)}` : '', foreign ? `Foreign: ${esc(foreign)}` : ''].filter(Boolean).join('<br>');
        add('pax', 'จำนวนคน', paxHtml, warn('pax_adult') || warn('pax_thai') || warn('pax_foreign'), !!(thai || foreign));

        add('language', 'ภาษาไกด์', esc(d.language.name), warn('guide_language'), !!d.language.id);

        const tr = [];
        if (d.transfer === 'none') tr.push('<b>เดินทางมาเอง</b>');
        if (d.transfer === 'unknown') tr.push('<span class="ai-scan__warn">ยังไม่ระบุการรับส่ง</span>');
        if (d.pickup_place) tr.push(`รับ: ${esc(d.pickup_place)}`);
        if (d.pickup_zone.id) tr.push(`โซน: ${esc(d.pickup_zone.name)}`);
        else if (d.pickup_place) tr.push('<span class="ai-scan__warn">เลือกโซนเอง</span>');
        if (d.start_pickup) tr.push(`เวลา: ${esc(d.start_pickup)}${d.end_pickup && d.end_pickup !== d.start_pickup ? ' - ' + esc(d.end_pickup) : ''}`);
        if (d.room_no) tr.push(`ห้อง: ${esc(d.room_no)}`);
        if (d.dropoff_place) tr.push(`ส่ง: ${esc(d.dropoff_place)}${d.dropoff_zone.id ? ' (' + esc(d.dropoff_zone.name) + ')' : ''}`);
        add('transfer', 'รับส่ง', tr.join(' • '), warn('pickup_place') || warn('pickup_zone_id') || warn('transfer') || (d.pickup_place && !d.pickup_zone.id),
            !!(d.pickup_place || d.start_pickup || d.room_no || d.dropoff_place || d.transfer === 'none'));

        const money = [];
        if (d.total_price !== null) money.push(`ราคารวม ${formatMoney(d.total_price)}`);
        if (d.deposit !== null) money.push(`มัดจำ ${formatMoney(d.deposit)}`);
        add('cot', 'Cash on tour', `<b>${formatMoney(d.cot)}</b>${money.length ? ' <span class="small text-muted">(' + money.join(', ') + ')</span>' : ''}`,
            warn('cot'), d.cot !== null);

        if ((d.passengers || []).length) {
            const list = d.passengers.map(p => `${esc(p.name)} <span class="small text-muted">${AGE_LABEL[TYPE_TO_AGE[p.type]] || ''}${p.nationality_name ? ' • ' + esc(p.nationality_name) : ''}${p.passport_no ? ' • ' + esc(p.passport_no) : ''}</span>`).join('<br>');
            add('passengers', 'รายชื่อลูกค้า', list, warn('passengers'), true);
        }

        if ((d.extra_charges || []).length) {
            const list = d.extra_charges.map(e => `${esc(e.name)}: ${formatMoney(e.amount)}`).join('<br>');
            add('extra', 'Extra Charge', list, warn('extra_charges'), true);
        }

        add('remark', 'Remark', esc(d.remark), false, !!d.remark);

        if (!rows.length) {
            $('#ai-voucher-result').html('<div class="alert alert-warning p-1 mt-1">AI ไม่พบข้อมูล Booking ในรูป/ข้อความนี้</div>');
            return;
        }

        const note = isEdit()
            ? '<small class="text-muted d-block mb-50">หน้าแก้ไข: ช่องที่มีผลกับราคา (วันที่, Agent, โปรแกรม, จำนวนคน, COT, Extra) ไม่ได้ติ๊กไว้ — ติ๊กเองถ้าต้องการเปลี่ยน</small>'
            : '';
        $('#ai-voucher-result').html(`
            <div class="table-responsive mt-1">
                <table class="table table-sm table-bordered ai-scan__review mb-50"><tbody>${rows.join('')}</tbody></table>
            </div>
            ${note}
            <button type="button" class="btn btn-success" id="ai-voucher-apply"><i data-feather="check"></i> ใส่ข้อมูลลงฟอร์ม</button>
            <span class="small text-muted ml-50">แถวสีเหลือง = AI ไม่แน่ใจ กรุณาตรวจ</span>`);
        if (typeof feather !== 'undefined') feather.replace({ width: 14, height: 14 });
    }

    function applyChecked(key) {
        return $(`#ai-voucher-result [data-ai-apply="${key}"]`).is(':checked');
    }

    // ------------------------------------------------------------------ apply voucher -> form

    async function applyVoucher() {
        const d = state.voucherResult;
        if (!d) return;
        const $btn = $('#ai-voucher-apply');
        busy($btn, true, 'กำลังกรอกข้อมูล...');
        try {
            // 1) travel date
            if (applyChecked('travel_date') && d.travel_date) {
                const fp = fld('#travel_date')[0] && fld('#travel_date')[0]._flatpickr;
                if (fp) fp.setDate(d.travel_date, false); else fld('#travel_date').val(d.travel_date);
                flash(fp && fp.altInput ? $(fp.altInput) : fld('#travel_date'));
            }

            // 2) agent (no inline handler: program reload happens once below)
            if (applyChecked('agent')) {
                const choice = $('#ai-agent-choice').val();
                if (choice === 'outside') {
                    setSelect('#agent', 'outside', false);
                    fld('#agent_outside').val(d.agent.raw);
                    fld('#frm-agent').prop('hidden', true);
                    fld('#frm-agent-outside').prop('hidden', false);
                    flash(fld('#agent_outside'));
                } else if (choice) {
                    setSelect('#agent', choice, false);
                    fld('#frm-agent').prop('hidden', false);
                    fld('#frm-agent-outside').prop('hidden', true);
                    flash(fld('#agent'));
                }
            }

            // 3) program + categories + pax (waits for the page's own AJAX)
            const wantProduct = applyChecked('product') && d.product.id;
            if (wantProduct) {
                fld(isEdit() ? `#booktype${d.booking_type}` : `#book_type${d.booking_type}`).prop('checked', true);
                await applyProgram(d);
            }
            if (applyChecked('pax')) {
                await applyPax(d);
            }

            // 4) transfer
            if (applyChecked('transfer')) {
                await applyTransfer(d);
            }

            // 5) simple fields
            if (applyChecked('voucher_no') && d.voucher_no) {
                const sel = isEdit() ? '#voucher_no_agent' : '#voucher_no';
                setInput(sel, d.voucher_no);
                if (!isEdit() && typeof window.check_no_agent === 'function') window.check_no_agent(fld(sel)[0]);
            }
            if (applyChecked('sender') && d.sender) setInput('#sender', d.sender);
            if (applyChecked('telephone') && d.telephone) {
                if (fld('#telephone').length) setInput('#telephone', d.telephone);
                else setCustomerTelephone(d.telephone);
            }
            if (applyChecked('language') && d.language.id) {
                setSelect('#language_id', String(d.language.id), false);
                flash(fld('#language_id'));
            }
            if (applyChecked('cot') && d.cot !== null) setInput('#cot', formatMoney(d.cot));
            if (applyChecked('remark') && d.remark) {
                const cur = fld('#bp_note').val().trim();
                if (cur.indexOf(d.remark) === -1) setInput('#bp_note', cur ? cur + '\n' + d.remark : d.remark);
            }

            // 6) passengers
            if (applyChecked('passengers') && (d.passengers || []).length) {
                const people = d.passengers.map(p => ({
                    name: p.name,
                    passport_no: p.passport_no,
                    birth_date: p.birth_date,
                    nationality_id: p.nationality_id,
                    age: TYPE_TO_AGE[p.type] || 1
                }));
                await fillCustomers(people, false);
            }

            // 7) extra charges
            if (applyChecked('extra') && (d.extra_charges || []).length) {
                applyExtras(d.extra_charges);
            }

            // 8) keep the voucher photo for Drive
            if (state.voucherFile) await queueUpload([{ file: state.voucherFile, kind: 'voucher' }]);

            toast('success', 'ใส่ข้อมูลลงฟอร์มแล้ว กรุณาตรวจก่อนกด Submit');
        } catch (err) {
            toast('error', err.message || 'กรอกข้อมูลไม่สำเร็จ');
        } finally {
            busy($btn, false);
        }
    }

    async function applyProgram(d) {
        setSelect('#product_id', String(d.product.id), false);
        flash(fld('#product_id'));
        const wanted = (d.categories || []).map(c => String(c.id));
        if (typeof window.search_program !== 'function') return;

        // edit page pre-selects the booking's current categories from #cate_id — replace them with ours
        if (isEdit() && wanted.length) fld('#cate_id').val(JSON.stringify(wanted.map(Number)));

        fld('#category_id').find('option').remove();
        window.search_program();
        const loaded = await waitFor(() => fld('#category_id option').length > 0 &&
            wanted.every(id => fld(`#category_id option[value="${id}"]`).length));
        if (!loaded || !wanted.length) {
            toast('warning', 'เลือก Categorys เองอีกครั้ง');
            return;
        }
        setSelect('#category_id', wanted, false);
        flash(fld('#category_id'));
        if (typeof window.check_category === 'function') window.check_category();

        // wait for the rate blocks the page loads per category
        const needThai = d.categories.some(c => c.customer === 1);
        const needForeign = d.categories.some(c => c.customer === 2);
        await waitFor(() => (!needThai || fld('#adult_thai').length) && (!needForeign || fld('#adult_foreign').length));
        await sleep(150);
    }

    async function applyPax(d) {
        const groups = [['thai', d.pax_thai], ['foreign', d.pax_foreign]];
        let changed = false;
        groups.forEach(([g, pax]) => {
            if (!pax || !(pax.adult + pax.child + pax.infant + pax.foc)) return;
            if (!fld(`#adult_${g}`).length) {
                toast('warning', `ไม่พบช่องจำนวนคน (${g === 'thai' ? 'Thai' : 'Foreign'}) — เลือก Categorys ให้ตรงก่อน`);
                return;
            }
            ['adult', 'child', 'infant', 'foc'].forEach(k => setInput(`#${k}_${g}`, pax[k] || 0));
            changed = true;
        });
        if (changed && typeof window.rows_customer === 'function') window.rows_customer();
        if (typeof window.check_rate === 'function') window.check_rate();
    }

    async function applyTransfer(d) {
        if (isEdit()) {
            if (d.transfer === 'none') fld('#pickup_type_2').prop('checked', true);
            if (d.transfer === 'pickup') fld('#pickup_type_1').prop('checked', true);
            if (d.pickup_zone.id) setSelect('#zone_pickup', String(d.pickup_zone.id), true);
            if (d.pickup_place) setInput('#hotel_pickup_outside', d.pickup_place);
            // drop-off: the voucher's own drop-off, otherwise "same as pickup" (clear the old booking's values)
            const dropZone = d.dropoff_zone.id || d.pickup_zone.id;
            if (dropZone) setSelect('#dropoff', String(dropZone), false);
            if (d.dropoff_place || d.pickup_place) setInput('#hotel_dropoff_outside', d.dropoff_place || '');
        } else {
            if (d.pickup_zone.id) {
                setSelect('#zone_pickup', String(d.pickup_zone.id), true); // loads zone pickup time + hotels
                flash(fld('#zone_pickup'));
            } else if (d.pickup_place) {
                fld('#zone_pickup').next('.select2').find('.select2-selection').addClass('ai-scan__field--check');
            }
            if (d.pickup_place) setInput('#hotel_outside', d.pickup_place);
            // no drop-off on the voucher -> empty fields (create.php then uses the pickup place/zone)
            setSelect('#zone_dropoff', String(d.dropoff_zone.id || 0), !!d.dropoff_zone.id);
            setInput('#dropoff_outside', d.dropoff_place || '');
            await sleep(200);
        }
        // voucher time wins over the zone default time
        if (d.start_pickup) setInput('#start_pickup', d.start_pickup);
        if (d.end_pickup || d.start_pickup) setInput('#end_pickup', d.end_pickup || d.start_pickup);
        if (d.room_no) setInput('#room_no', d.room_no);
    }

    function applyExtras(extras) {
        const $rep = $('.extra-charge-repeater').first();
        if (!$rep.length) return;
        fld('#accordionTwo').removeClass('hidden').addClass('show');

        extras.forEach(ex => {
            let $item = $rep.find('[data-repeater-item]').filter(function () {
                const $sel = $(this).find('select[name$="[extra_charge]"]');
                const $name = $(this).find('input[name$="[extc_name]"]');
                return (!$sel.val() || $sel.val() === '0') && !$name.val();
            }).first();
            if (!$item.length) {
                $rep.find('[data-repeater-create]').first().trigger('click');
                $item = $rep.find('[data-repeater-item]').last();
            }
            const $sel = $item.find('select[name$="[extra_charge]"]');
            if (ex.extra_charge_id) {
                $sel.val(String(ex.extra_charge_id)).trigger('change'); // inline chang_extra_charge()
            } else {
                $item.find('input[name$="[extc_name]"]').val(ex.name);
            }
            $item.find('select[name$="[extra_type]"]').val('2').trigger('change'); // Total
            $item.find('input[name$="[extra_num_private]"]').val(1);
            $item.find('input[name$="[extra_rate_private]"]').val(formatMoney(ex.amount));
            flash($item.find('input[name$="[extra_rate_private]"]'));
        });
        try {
            if (typeof window.checke_rate_extar === 'function') window.checke_rate_extar();
        } catch (e) { /* totals refresh is cosmetic */ }
    }

    // ------------------------------------------------------------------ customers rows

    // create page: flat arrays inside #frm-customer rebuilt by rows_customer()
    function createRows() {
        const $f = fld('#frm-customer');
        const names = $f.find('[name="customers[cus_name][]"]');
        const rows = [];
        names.each(function (i) {
            rows.push({
                $name: $(this),
                $idCard: $f.find('[name="customers[id_card][]"]').eq(i),
                $birth: $f.find('[name="customers[cus_birth_date][]"]').eq(i),
                $nation: $f.find('[name="customers[cus_nationality_id][]"]').eq(i),
                age: Number($f.find('[name="customers[cus_age][]"]').eq(i).val()) || 1
            });
        });
        return rows;
    }

    // edit page: jquery.repeater items
    function editRows() {
        const rows = [];
        $('.itinerary-repeater [data-repeater-item]').each(function () {
            const $it = $(this);
            rows.push({
                $item: $it,
                $name: $it.find('input[name$="[cus_name]"]'),
                $idCard: $it.find('input[name$="[id_card]"]'),
                $birth: $it.find('input[name$="[cus_birth_date]"]'),
                $nation: $it.find('select[name$="[cus_nationality_id]"]'),
                $age: $it.find('select[name$="[cus_age]"]'),
                $tel: $it.find('input[name$="[cus_telephone]"]'),
                age: Number($it.find('select[name$="[cus_age]"]').val()) || 0
            });
        });
        return rows;
    }

    function normName(v) {
        return String(v || '').toUpperCase().replace(/^(MR|MRS|MS|MISS|MSTR|DR)\.?\s+/, '').replace(/[^A-Z0-9\u0E00-\u0E7F\u4E00-\u9FFF]+/g, '');
    }

    // same passport no., or (no passport on one side) same name
    function samePerson(row, p) {
        const rowPass = String(row.$idCard.val() || '').trim().toUpperCase();
        const pPass = String(p.passport_no || '').trim().toUpperCase();
        if (rowPass && pPass) return rowPass === pPass;
        const a = normName(row.$name.val());
        return a !== '' && a === normName(p.name);
    }

    function rowIsEmpty(r) {
        return !String(r.$name.val() || '').trim() && !String(r.$idCard.val() || '').trim();
    }

    function writeRow(r, p) {
        if (p.name) r.$name.val(p.name);
        if (p.passport_no) r.$idCard.val(p.passport_no);
        if (p.birth_date) r.$birth.val(p.birth_date);
        if (p.nationality_id) r.$nation.val(String(p.nationality_id)).trigger('change');
        if (r.$age && p.age) r.$age.val(String(p.age === 4 ? 3 : p.age)); // edit page select has no value 4 (FOC shares 3)
        flash(r.$name);
    }

    function snapshotCreateRows() {
        return createRows().filter(r => !rowIsEmpty(r)).map(r => ({
            name: r.$name.val(), passport_no: r.$idCard.val(), birth_date: r.$birth.val(),
            nationality_id: r.$nation.val(), age: r.age
        }));
    }

    function placeInRows(rows, people) {
        const left = [];
        people.forEach(p => {
            let r = rows.find(x => rowIsEmpty(x) && x.age === p.age);
            if (!r) r = rows.find(x => rowIsEmpty(x));
            if (r) writeRow(r, p); else left.push(p);
        });
        return left;
    }

    /**
     * Put people into the customer rows.
     * growPax=true (passports): on the create page, raises the pax counts when there are not enough rows.
     */
    async function fillCustomers(people, growPax) {
        if (!people.length) return;

        if (isEdit()) {
            const $rep = $('.itinerary-repeater');
            people.forEach(p => {
                // already in the list (same passport no. or same name): only complete missing passport data
                const match = editRows().find(r => samePerson(r, p));
                if (match) {
                    if (!String(match.$idCard.val() || '').trim() && p.passport_no) writeRow(match, p);
                    return;
                }
                let r = editRows().find(rowIsEmpty);
                if (!r) {
                    $rep.find('[data-repeater-create]').first().trigger('click');
                    const rows = editRows();
                    r = rows[rows.length - 1];
                }
                writeRow(r, p);
            });
            return;
        }

        // create page
        let rows = createRows();
        people = people.filter(p => {
            const match = rows.find(r => samePerson(r, p));
            if (!match) return true;
            if (!String(match.$idCard.val() || '').trim() && p.passport_no) writeRow(match, p);
            return false;
        });
        const emptyByAge = age => rows.filter(r => rowIsEmpty(r) && r.age === age).length;

        if (growPax) {
            const need = { 1: 0, 2: 0, 3: 0 };
            people.forEach(p => { need[p.age === 4 ? 1 : p.age]++; });
            const grow = {};
            let total = 0;
            [1, 2, 3].forEach(age => {
                grow[age] = Math.max(0, need[age] - emptyByAge(age));
                total += grow[age];
            });
            if (total > 0) {
                const thaiShare = people.every(p => Number(p.nationality_id) === THAILAND_ID);
                const group = (thaiShare && fld('#adult_thai').length) ? 'thai' : (fld('#adult_foreign').length ? 'foreign' : (fld('#adult_thai').length ? 'thai' : ''));
                if (!group) {
                    toast('warning', 'กรุณาเลือก Programe และ Categorys ก่อน แล้วค่อยใส่ Passport');
                    return;
                }
                const snap = snapshotCreateRows();
                const keys = { 1: 'adult', 2: 'child', 3: 'infant' };
                [1, 2, 3].forEach(age => {
                    if (!grow[age]) return;
                    const $in = fld(`#${keys[age]}_${group}`);
                    $in.val((Number($in.val()) || 0) + grow[age]);
                    flash($in);
                });
                if (typeof window.rows_customer === 'function') window.rows_customer();
                rows = createRows();
                placeInRows(rows, snap.map(s => ({ ...s, age: Number(s.age) || 1 })));
                rows = createRows();
            }
        }

        const left = placeInRows(rows, people);
        if (left.length) {
            toast('warning', `มีรายชื่อเกินจำนวนคน ${left.length} คน — เพิ่มจำนวน Pax ก่อน`);
        }
    }

    function setCustomerTelephone(tel) {
        const rows = editRows();
        if (rows.length && rows[0].$tel && rows[0].$tel.length) {
            rows[0].$tel.val(tel);
            flash(rows[0].$tel);
        }
    }

    // ------------------------------------------------------------------ passport scan

    async function runPassport() {
        if (!state.passportFiles.length) return;
        const $btn = $('#ai-passport-run');
        const total = state.passportFiles.length;
        busy($btn, true, `AI กำลังอ่าน ${total} รูป...`);
        try {
            // batches of FILES_PER_REQUEST; file_index is re-based to the full list
            const merged = { success: true, people: [], errors: [] };
            const batches = chunk(state.passportFiles, FILES_PER_REQUEST);
            for (let b = 0; b < batches.length; b++) {
                const offset = b * FILES_PER_REQUEST;
                if (batches.length > 1) $btn.contents().last()[0].textContent = `AI กำลังอ่าน ${Math.min(offset + FILES_PER_REQUEST, total)}/${total} รูป...`;
                const fd = new FormData();
                batches[b].forEach(f => fd.append('passport_images[]', f));
                const res = await ajaxForm(API.passport, fd);
                (res.people || []).forEach(p => merged.people.push(Object.assign({}, p, { file_index: p.file_index + offset })));
                (res.errors || []).forEach(e => merged.errors.push(Object.assign({}, e, { file_index: e.file_index + offset })));
            }
            state.passportResult = merged;
            renderPassportReview(merged);
        } catch (err) {
            $('#ai-passport-result').html(`<div class="alert alert-danger p-1 mt-1">${esc(err.message)}</div>`);
        } finally {
            busy($btn, false);
        }
    }

    function existingPassports() {
        const values = isEdit()
            ? editRows().map(r => r.$idCard.val())
            : createRows().map(r => r.$idCard.val());
        return values.map(v => String(v || '').trim().toUpperCase()).filter(Boolean);
    }

    function renderPassportReview(res) {
        const ref = travelDate();
        const have = existingPassports();
        const seen = {};
        const rows = (res.people || []).map((p, i) => {
            const age = ageType(p.birth_date, ref);
            const dup = p.passport_no && (have.indexOf(p.passport_no) !== -1 || seen[p.passport_no]);
            if (p.passport_no) seen[p.passport_no] = true;
            const warn = !p.nationality_id || !p.birth_date || !p.passport_no;
            const file = state.passportFiles[p.file_index];
            return `
                <tr class="${warn ? 'ai-scan__row--warn' : ''} ${dup ? 'ai-scan__row--off' : ''}">
                    <td><div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ai-pp-${i}" data-ai-person="${i}" ${dup ? '' : 'checked'}>
                        <label class="custom-control-label" for="ai-pp-${i}"></label></div></td>
                    <td>${file ? `<img src="${URL.createObjectURL(file)}" alt="" width="40" height="40" style="object-fit:cover;border-radius:3px">` : ''}</td>
                    <td>${esc(p.name)}${dup ? ' <span class="badge badge-light-secondary">มีในรายชื่อแล้ว</span>' : ''}</td>
                    <td>${esc(p.passport_no) || '<span class="ai-scan__warn">-</span>'}</td>
                    <td>${p.nationality_id ? esc(p.nationality_name) : `<span class="ai-scan__warn">${esc(p.nationality_name || '-')} (เลือกเอง)</span>`}</td>
                    <td>${p.birth_date ? esc(formatDateTh(p.birth_date)) : '<span class="ai-scan__warn">-</span>'}</td>
                    <td>${AGE_LABEL[age]}</td>
                </tr>`;
        });

        const errors = (res.errors || []).map(e => `<li>${esc(e.file_name || ('รูป ' + (e.file_index + 1)))}: ${esc(e.message)}</li>`).join('');
        if (!rows.length) {
            $('#ai-passport-result').html(`<div class="alert alert-warning p-1 mt-1">ไม่พบข้อมูล Passport${errors ? '<ul class="mb-0">' + errors + '</ul>' : ''}</div>`);
            return;
        }
        $('#ai-passport-result').html(`
            <div class="table-responsive mt-1">
                <table class="table table-sm table-bordered ai-scan__review mb-50">
                    <thead><tr><th></th><th></th><th>ชื่อ</th><th>Passport / ID</th><th>สัญชาติ</th><th>วันเกิด</th><th>ประเภท</th></tr></thead>
                    <tbody>${rows.join('')}</tbody>
                </table>
            </div>
            ${errors ? `<div class="alert alert-warning p-50 small"><ul class="mb-0">${errors}</ul></div>` : ''}
            <button type="button" class="btn btn-success" id="ai-passport-apply"><i data-feather="user-plus"></i> เพิ่มลงรายชื่อลูกค้า (${rows.length} คน)</button>
            <span class="small text-muted ml-50">ประเภทคิดจากวันเกิดเทียบวันเดินทาง (ต่ำกว่า 2 ปี = Infant, ต่ำกว่า 12 ปี = Child)</span>`);
        if (typeof feather !== 'undefined') feather.replace({ width: 14, height: 14 });
    }

    async function applyPassports() {
        const res = state.passportResult;
        if (!res) return;
        const ref = travelDate();
        const picked = [];
        const fileIdx = {};
        $('#ai-passport-result [data-ai-person]:checked').each(function () {
            const p = res.people[Number($(this).data('ai-person'))];
            if (!p) return;
            picked.push({
                name: p.name,
                passport_no: p.passport_no,
                birth_date: p.birth_date,
                nationality_id: p.nationality_id,
                age: ageType(p.birth_date, ref)
            });
            fileIdx[p.file_index] = true;
        });
        if (!picked.length) {
            toast('warning', 'ยังไม่ได้เลือกรายชื่อ');
            return;
        }
        const $btn = $('#ai-passport-apply');
        busy($btn, true, 'กำลังเพิ่มรายชื่อ...');
        try {
            await fillCustomers(picked, true);
            const files = Object.keys(fileIdx).map(i => state.passportFiles[Number(i)]).filter(Boolean)
                .map(f => ({ file: f, kind: 'passport' }));
            await queueUpload(files);
            toast('success', `เพิ่ม ${picked.length} รายชื่อแล้ว กรุณาตรวจก่อนกด Submit`);
            if (isEdit()) toast('info', 'ตรวจจำนวน Pax ให้ตรงกับรายชื่อด้วย');
        } finally {
            busy($btn, false);
        }
    }

    // ------------------------------------------------------------------ Google Drive

    async function queueUpload(items) {
        items = items.filter(it => it.file && state.pending.every(p => p.file !== it.file));
        if (!items.length) return;
        if (isEdit() && state.bookingId > 0) {
            await uploadNow(state.bookingId, items);
            loadDriveFiles();
        } else {
            items.forEach(it => state.pending.push(it));
        }
    }

    async function uploadNow(bookingId, items) {
        let uploaded = 0;
        let failed = 0;
        for (const batch of chunk(items, FILES_PER_REQUEST)) {
            const fd = new FormData();
            fd.append('booking_id', bookingId);
            batch.forEach(it => {
                fd.append('images[]', it.file);
                fd.append('kinds[]', it.kind);
            });
            try {
                const res = await ajaxForm(API.upload, fd);
                uploaded += res.uploaded || 0;
                failed += (res.errors || []).length;
            } catch (err) {
                // Drive problems must never block the booking itself
                failed += batch.length;
            }
        }
        if (uploaded) toast('success', `เก็บรูปเข้า Google Drive แล้ว ${uploaded} รูป`);
        if (failed) toast('warning', `อัปโหลดรูปเข้า Drive ไม่สำเร็จ ${failed} รูป (ข้อมูล Booking บันทึกแล้ว)`);
    }

    /** Called by the New Booking submit handler after the booking was created. */
    async function afterCreate(bookingId) {
        bookingId = Number(bookingId) || 0;
        if (bookingId <= 0 || !state.pending.length) return;
        const items = state.pending.slice();
        state.pending = [];
        await uploadNow(bookingId, items);
    }

    function loadDriveFiles() {
        if (!isEdit() || !state.bookingId) return;
        const fd = new FormData();
        fd.append('booking_id', state.bookingId);
        ajaxForm(API.list, fd).then(res => {
            const items = res.items || [];
            $('#ai-files-count').text(res.configured === false ? '!' : items.length);
            if (res.configured === false) {
                $('#ai-files-list').html('<div class="text-muted">ยังไม่ได้ตั้งค่า Google Drive (config/secrets.php)</div>');
                return;
            }
            if (!items.length) {
                $('#ai-files-list').html('<div class="text-muted">ยังไม่มีรูปที่แนบ</div>');
                return;
            }
            $('#ai-files-list').html(items.map(f => `
                <a class="ai-scan__thumb" href="${API.file}?id=${encodeURIComponent(f.id)}" target="_blank" rel="noopener" title="${esc(f.name)}">
                    <img src="${API.file}?id=${encodeURIComponent(f.id)}" alt="" loading="lazy">
                    <div>${f.kind === 'passport' ? 'Passport' : 'Voucher'}</div>
                    <div class="text-muted">${esc(f.created)}</div>
                </a>`).join(''));
        }).catch(err => {
            $('#ai-files-count').text('!');
            $('#ai-files-list').html(`<div class="text-danger">${esc(err.message)}</div>`);
        });
    }

    // ------------------------------------------------------------------ reset / init

    function resetVoucher() {
        setVoucherFile(null);
        $('#ai-voucher-text').val('');
        $('#ai-voucher-result').empty();
        state.voucherResult = null;
    }

    function resetPassport() {
        state.passportFiles = [];
        state.passportResult = null;
        renderPassportThumbs();
        $('#ai-passport-result').empty();
    }

    function init() {
        const $panel = $('#ai-scan');
        if (!$panel.length) return;
        state.mode = $panel.data('mode') === 'edit' ? 'edit' : 'create';
        state.bookingId = Number($panel.data('booking-id')) || 0;
        state.$form = $panel.closest('form');

        $panel.on('click', '[data-ai-tab]', function () { showTab($(this).data('ai-tab')); });

        bindDropzone($('#ai-voucher-drop'), $('#ai-voucher-file'), files => { if (files[0]) setVoucherFile(files[0]); });
        bindDropzone($('#ai-passport-drop'), $('#ai-passport-file'), addPassportFiles);

        $('#ai-voucher-clear-img').on('click', () => setVoucherFile(null));
        $('#ai-voucher-run').on('click', runVoucher);
        $('#ai-voucher-reset').on('click', resetVoucher);
        $(document).on('click', '#ai-voucher-apply', applyVoucher);

        $('#ai-passport-run').on('click', runPassport);
        $('#ai-passport-reset').on('click', resetPassport);
        $(document).on('click', '#ai-passport-apply', applyPassports);
        $(document).on('click', '[data-ai-remove-passport]', function (e) {
            e.stopPropagation();
            state.passportFiles.splice(Number($(this).data('ai-remove-passport')), 1);
            renderPassportThumbs();
        });

        // Ctrl+V an image straight into the open section
        document.addEventListener('paste', function (e) {
            const section = activeSection();
            if (section !== 'voucher' && section !== 'passport') return;
            if (!isEdit() && !$('#modal-form-booking').hasClass('show')) return;
            const items = Array.from((e.clipboardData && e.clipboardData.items) || []);
            const files = items.filter(it => it.kind === 'file' && /^image\//.test(it.type)).map(it => it.getAsFile()).filter(Boolean);
            if (!files.length) return; // plain text paste keeps its normal behaviour
            e.preventDefault();
            if (section === 'voucher') setVoucherFile(files[0]);
            else addPassportFiles(files);
        });

        // New Booking modal closed without saving -> drop scan state
        $('#modal-form-booking').on('hidden.bs.modal', function () {
            resetVoucher();
            resetPassport();
            state.pending = [];
        });

        if (isEdit()) loadDriveFiles();
        if (typeof feather !== 'undefined') feather.replace({ width: 14, height: 14 });
    }

    window.BookingAiScan = { afterCreate: afterCreate };
    $(init);
})(jQuery);

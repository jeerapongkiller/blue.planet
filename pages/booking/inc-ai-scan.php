<?php
/**
 * AI scan panel (voucher image / pasted text / passports) for the booking form.
 * Included by pages/booking/list.php (New Booking modal) and pages/booking/edit.php.
 *
 * Set before include:
 *   $aiScanMode      = 'create' | 'edit'
 *   $aiScanBookingId = booking id (edit only)
 *
 * NOTE: this panel sits inside the booking <form>; its inputs intentionally have NO name
 * attribute so they are never submitted with the booking.
 */
$aiScanMode = isset($aiScanMode) && $aiScanMode === 'edit' ? 'edit' : 'create';
$aiScanBookingId = isset($aiScanBookingId) ? (int)$aiScanBookingId : 0;
?>
<div class="card border shadow-none ai-scan" id="ai-scan" data-mode="<?php echo $aiScanMode; ?>" data-booking-id="<?php echo $aiScanBookingId; ?>">
    <div class="card-header py-75 px-1 ai-scan__header">
        <h5 class="mb-0 ai-scan__title"><i data-feather="zap" class="text-primary"></i> AI กรอกข้อมูลอัตโนมัติ</h5>
        <div class="ai-scan__tabs">
            <button type="button" class="btn btn-sm btn-outline-primary" data-ai-tab="voucher">
                <i data-feather="file-text"></i> สแกน Voucher / วางข้อความ
            </button>
            <button type="button" class="btn btn-sm btn-outline-primary" data-ai-tab="passport">
                <i data-feather="credit-card"></i> สแกน Passport
            </button>
            <?php if ($aiScanMode === 'edit') { ?>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-ai-tab="files">
                    <i data-feather="image"></i> รูปที่แนบ (Drive) <span class="badge badge-light-secondary ml-25" id="ai-files-count">-</span>
                </button>
            <?php } ?>
        </div>
    </div>

    <!-- Voucher: image and/or pasted text -->
    <div class="card-body p-1 ai-scan__section" data-ai-section="voucher" hidden>
        <div class="row">
            <div class="col-md-5 col-12 mb-1">
                <div class="ai-scan__dropzone" id="ai-voucher-drop" tabindex="0">
                    <input type="file" id="ai-voucher-file" accept="image/*" hidden>
                    <div class="ai-scan__dropzone-hint" id="ai-voucher-hint">
                        <i data-feather="upload-cloud" class="font-large-1 text-primary"></i>
                        <div>คลิกเพื่อเลือกรูป Voucher / ลากรูปมาวาง / กด <b>Ctrl+V</b></div>
                        <small class="text-muted">รูปถ่าย voucher กระดาษ, ภาพแคปแชท LINE / WhatsApp</small>
                    </div>
                    <img id="ai-voucher-preview" class="ai-scan__preview" alt="" hidden>
                </div>
                <button type="button" class="btn btn-sm btn-flat-danger mt-25" id="ai-voucher-clear-img" hidden><i data-feather="x"></i> ลบรูป</button>
            </div>
            <div class="col-md-7 col-12 mb-1">
                <textarea class="form-control ai-scan__text" id="ai-voucher-text" rows="6" placeholder="วางข้อความจาก LINE / อีเมล เช่น&#10;22.09 Phi Khay Maya Speed Boat English guide&#10;Hotel: Secret Cliff Resort  Room:221&#10;PAX:2  Vc A1934  Cot:1600&#10;&#10;(ถ้าแนบรูปด้วย ข้อความนี้จะใช้เป็นหมายเหตุเพิ่มเติม)"></textarea>
            </div>
        </div>
        <div class="d-flex flex-wrap align-items-center">
            <button type="button" class="btn btn-primary mr-50 mb-50" id="ai-voucher-run">
                <i data-feather="cpu"></i> อ่านข้อมูลด้วย AI
            </button>
            <button type="button" class="btn btn-outline-secondary mr-50 mb-50" id="ai-voucher-reset">ล้าง</button>
            <small class="text-muted mb-50">AI อ่านได้ทั้งลายมือและภาพแคปแชท — กรุณาตรวจข้อมูลก่อนกดบันทึกทุกครั้ง</small>
        </div>
        <div id="ai-voucher-result"></div>
    </div>

    <!-- Passports: one or many photos -->
    <div class="card-body p-1 ai-scan__section" data-ai-section="passport" hidden>
        <div class="ai-scan__dropzone ai-scan__dropzone--multi" id="ai-passport-drop" tabindex="0">
            <input type="file" id="ai-passport-file" accept="image/*" multiple hidden>
            <div class="ai-scan__dropzone-hint">
                <i data-feather="users" class="font-large-1 text-primary"></i>
                <div>เลือกรูป Passport / บัตรประชาชน ได้หลายรูปพร้อมกัน (สูงสุด 40 รูป)</div>
                <small class="text-muted">1 รูปมีหลายเล่มก็ได้ หรือใช้รูปรายชื่อ/ใบงานก็ได้ • ลากมาวาง หรือ Ctrl+V</small>
            </div>
        </div>
        <div class="ai-scan__thumbs" id="ai-passport-thumbs"></div>
        <div class="d-flex flex-wrap align-items-center mt-50">
            <button type="button" class="btn btn-primary mr-50 mb-50" id="ai-passport-run" disabled>
                <i data-feather="cpu"></i> อ่าน Passport (<span id="ai-passport-count">0</span> รูป)
            </button>
            <button type="button" class="btn btn-outline-secondary mr-50 mb-50" id="ai-passport-reset">ล้าง</button>
        </div>
        <div id="ai-passport-result"></div>
    </div>

    <?php if ($aiScanMode === 'edit') { ?>
        <!-- Drive attachments of this booking -->
        <div class="card-body p-1 ai-scan__section" data-ai-section="files" hidden>
            <div id="ai-files-list" class="ai-scan__thumbs"></div>
        </div>
    <?php } ?>
</div>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Invoice - <?php echo $main_title; ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Sweetalert2 CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/sweetalert2.min.css">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/app-user.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

    <!-- <style>
        .table-black {
            color: #FFFFFF;
            background-color: #77006dff;
        }

        .table-black-2 {
            color: #FFFFFF;
            background-color: #c03eb5ff;
        }
    </style> -->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern navbar-floating footer-static menu-collapsed pace-done" data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <?php include 'layouts/header.php'; ?>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <?php include 'layouts/main-menu.php'; ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <?php include 'pages/' . $_GET['pages'] . '.php'; ?>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <?php include 'layouts/footer.php'; ?>
    <!-- END: Footer-->

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN Sweetalert2 JS -->
    <script src="app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <!-- END Sweetalert2 JS -->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <?php
    $columntarget = $_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2 ? '4, 5' : '4, 5';
    ?>

    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
        $(document).ready(function() {
            var jqForm = $('#invoice-search-form'),
                jqFormInv = $('#invoice-form'),
                picker = $('#dob'),
                dtPicker = $('#dob-bootstrap-val'),
                range = $('.flatpickr-range'),
                select = $('.select2');

            // select2
            select.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this
                    .select2({
                        placeholder: 'Select ...',
                        dropdownParent: $this.parent()
                    })
                    .change(function() {
                        $(this).valid();
                    });
            });

            // Range
            if (range.length) {
                range.flatpickr({
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr('step', null);
                        }
                    },
                    mode: 'range',
                    static: true,
                    altInput: true,
                    altFormat: 'j F Y',
                    dateFormat: 'Y-m-d'
                });
            }

            // Picker
            if (picker.length) {
                picker.flatpickr({
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr('step', null);
                        }
                    }
                });
            }

            if (dtPicker.length) {
                dtPicker.flatpickr({
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr('step', null);
                        }
                    }
                });
            }

            //Numeral
            $('.numeral-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            });

            // jQuery Validation
            // --------------------------------------------------------------------
            jqForm.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/invoice/function/search-agent.php",
                    type: "POST",
                    data: serializedData + "&action=search-booking",
                    success: function(response) {
                        if (response != 'false') {
                            $('#div-invoice-custom').html(response);
                        }
                    }
                });
                e.preventDefault();
            });

            if (jqFormInv.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormInv.validate({
                    rules: {
                        'name': {
                            required: true
                        }
                    },
                    messages: {

                    },
                    submitHandler: function(form) {
                        // update ajax request data
                        var bo_id = [];
                        let checked = $(".checkbox-bookings");
                        for (let index = 0; index < checked.length; index++) {
                            if (checked[index].checked == true) {
                                bo_id.push(checked[index].value);
                            }
                        }
                        var formData = new FormData(form);
                        formData.append('action', 'create');
                        formData.append('bo_id', JSON.stringify(bo_id));
                        $.ajax({
                            url: "pages/invoice/function/create.php",
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                // $('#div-show').html(response);
                                if (response != false && response > 0) {
                                    Swal.fire({
                                        title: "The information has been added successfully.",
                                        icon: "success",
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            var tab = document.getElementsByClassName('tab-pane active')[0].id;
                                            var travel_date = tab != 'custom' ? tab == 'today' ? '<?php echo $today; ?>' : '<?php echo $tomorrow; ?>' : document.getElementById('travel_date').value;
                                            search_start_date(tab, travel_date);
                                            $('#modal-invoice').modal('hide');
                                            search_start_date('today', '<?php echo $today; ?>');
                                            search_start_date('tomorrow', '<?php echo $tomorrow; ?>');
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Please try again.",
                                        icon: "error",
                                    });
                                }
                            }
                        });
                    }
                });
            }

            search_start_date('today', '<?php echo $today; ?>');
            search_start_date('tomorrow', '<?php echo $tomorrow; ?>');
        });

        function checkbox(type) {
            var checkbox_all = type == 'booking' ? document.getElementById('checkbo_all').checked : document.getElementById('checkmanage_all').checked;
            var checkbox = type == 'booking' ? document.getElementsByClassName('checkbox-bookings') : document.getElementsByClassName('checkbox-manage');

            if (checkbox_all == true && checkbox.length > 0) {
                for (let index = 0; index < checkbox.length; index++) {
                    checkbox[index].checked = true;
                }
            } else if (checkbox_all == false && checkbox.length > 0) {
                for (let index = 0; index < checkbox.length; index++) {
                    checkbox[index].checked = false;
                }
            }
        }

        function search_start_date(tabs, travel_date) {
            var formData = new FormData();
            formData.append('action', 'search-booking');
            formData.append('travel_date', travel_date);
            $.ajax({
                url: "pages/invoice/function/search-agent.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != 'false') {
                        if (tabs == 'custom') {
                            $('#div-invoice-custom').html(response);
                        } else {
                            $('#' + tabs).html(response);
                        }
                    }
                }
            });
        }

        function modal_detail(agent_id, agent_name, travel_date, search_product, search_island) {
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('agent_id', agent_id);
            formData.append('travel_date', travel_date);
            formData.append('search_product', search_product);
            formData.append('search_island', search_island);
            $.ajax({
                url: "pages/invoice/function/search-booking.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != 'false') {
                        $('#div-modal-detail').html(response);
                    }
                }
            });
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function check_box_booking() {
            let checked = $(".checkbox-bookings");
            if (checked.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'กรุณาเลือก Booking ที่จะออก Invoice.',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            } else {
                $('#modal-add-invoice').modal('show');
                modal_invoice();
            }
        }

        function modal_invoice() {
            let checked = $(".checkbox-bookings");
            var array_booking = document.getElementById('array_booking').value;
            var array_rates = document.getElementById('array_rates').value;
            var array_extar = document.getElementById('array_extar').value;
            if (checked.length > 0 && array_booking !== '') {
                document.getElementById('agent_name_text').innerHTML = document.getElementById('agent_value').dataset.name;
                document.getElementById('agent_tax_text').innerHTML = document.getElementById('agent_value').dataset.license;
                document.getElementById('agent_tel_text').innerHTML = document.getElementById('agent_value').dataset.telephone;
                document.getElementById('agent_address_text').innerHTML = document.getElementById('agent_value').dataset.address;
                var res = $.parseJSON(array_booking);
                var res_rates = array_rates !== '' ? $.parseJSON(array_rates) : undefined;
                var res_extar = array_extar !== '' ? $.parseJSON(array_extar) : undefined;
                var text_html = '';
                var text_rates = '';
                var total = 0;
                var amount = 0;
                var cot = 0;
                var discount = 0;
                var no = 1;
                for (let index = 0; index < checked.length; index++) {
                    if (checked[index].checked == true) {
                        var color = checked[0].dataset.color;
                        var darken = checked[0].dataset.darken;
                        document.getElementById('tr-color').style.backgroundColor = '#' + color;
                        document.getElementById('tr-darken').style.backgroundColor = '#' + darken;
                        var rowspan = 0;
                        text_rates = '';
                        var id = checked[index].value;
                        discount = res[id].discount !== '-' ? Number(discount + res[id].discount) : discount;
                        cot = res[id].cot !== '-' ? Number(cot + res[id].cot) : Number(cot);

                        if (res_rates !== undefined && (res_rates[id] !== undefined)) {
                            rowspan = res_rates[id].id.length;
                            for (let y = 0; y < res_rates[id].id.length; y++) {
                                if (y == 0) {
                                    // var customer = res_rates[id].customer[y] == 1 ? ' (Thai)' : ' (Foreign)';
                                    var customer = res[id].status == 2 || res[id].status == 4 ? ' (' + res_rates[id].category_name[y] + ') ' + res[id].status_name : ' (' + res_rates[id].category_name[y] + ')';
                                    text_html += '<tr>' +
                                        '<td class="text-center">' + Number(no++) + '</td>' +
                                        '<td class="text-center" rowspan="' + rowspan + '"> ' + res[id].text_date + ' </td>' +
                                        '<td rowspan="' + rowspan + '"> ' + res[id].cus_name + ' </td>' +
                                        '<td> ' + res[id].product_name + customer + ' </td>' +
                                        '<td class="text-center" rowspan="' + rowspan + '"> ' + res[id].voucher_no + ' </td>' +
                                        '<td class="text-center"> ' + res_rates[id].adult[y] + ' </td>' +
                                        '<td class="text-center"> ' + res_rates[id].child[y] + ' </td>' +
                                        '<td class="text-center"> ' + numberWithCommas(res_rates[id].rate_adult[y]) + ' </td>' +
                                        '<td class="text-center"> ' + numberWithCommas(res_rates[id].rate_child[y]) + ' </td>' +
                                        '<td class="text-center" rowspan="' + rowspan + '"> ' + res[id].discount + ' </td>' +
                                        '<td class="text-center"> ' + numberWithCommas(res_rates[id].total[y]) + ' </td>' +
                                        '<td class="text-center" rowspan="' + rowspan + '"> ' + numberWithCommas(res[id].cot) + ' </td>' +
                                        '</tr>';

                                    amount = res_rates[id].total[y] !== '-' ? Number(amount + res_rates[id].total[y]) : Number(amount);
                                } else if (y > 0) {
                                    // var customer = res_rates[id].customer[y] == 1 ? ' (Thai)' : ' (Foreign)';
                                    var customer = ' (' + res_rates[id].category_name[y] + ') ';
                                    text_html += '<tr>' +
                                        '<td class="text-center">' + Number(no++) + '</td>' +
                                        '<td> ' + res[id].product_name + customer + ' </td>' +
                                        '<td class="text-center"> ' + res_rates[id].adult[y] + ' </td>' +
                                        '<td class="text-center"> ' + res_rates[id].child[y] + ' </td>' +
                                        '<td class="text-center"> ' + numberWithCommas(res_rates[id].rate_adult[y]) + ' </td>' +
                                        '<td class="text-center"> ' + numberWithCommas(res_rates[id].rate_child[y]) + ' </td>' +
                                        '<td class="text-center"> ' + numberWithCommas(res_rates[id].total[y]) + ' </td>' +
                                        '</tr>';

                                    amount = res_rates[id].total[y] !== '-' ? Number(amount + res_rates[id].total[y]) : Number(amount);
                                }
                            }
                        }

                        if (res_extar !== undefined && (res_extar[id] !== undefined)) {
                            for (let index = 0; index < res_extar[id].id.length; index++) {
                                amount = res_extar[id].total !== '-' ? Number(amount + res_extar[id].total[index]) : Number(amount);
                                text_html += '<tr>' +
                                    '<td class="text-left" colspan="2"> ' + res_extar[id].name[index] + ' </td>' +
                                    '<td class="text-left" colspan="3">  </td>' +
                                    '<td class="text-center"> ' + res_extar[id].adult[index] + ' </td>' +
                                    '<td class="text-center"> ' + res_extar[id].child[index] + ' </td>' +
                                    '<td class="text-center"> ' + numberWithCommas(res_extar[id].rate_adult[index]) + ' </td>' +
                                    '<td class="text-center"> ' + numberWithCommas(res_extar[id].rate_child[index]) + ' </td>' +
                                    '<td class="text-center">-</td>' +
                                    '<td class="text-center"> ' + numberWithCommas(res_extar[id].total[index]) + ' </td>' +
                                    '<td class="text-center">-</td>' +
                                    '</tr>';
                            }
                        }
                    }
                }

                text_html += '<tr>' +
                    '<td colspan="10"></td>' +
                    '<td class="text-center"><b>รวมเป็นเงิน</b><br><small>(Total)</small></td>' +
                    '<td class="text-center" id="price-multi-total"></td>' +
                    '</tr>'

                if (discount > 0) {
                    // amount = amount - discount;
                    text_html += '<tr>' +
                        '<td colspan="10"></td>' +
                        '<td class="text-center"><b>ส่วนลด</b><br><small>(Discount)</small></td>' +
                        '<td class="text-center">' + numberWithCommas(discount) + '</td>' +
                        '</tr>'
                }

                if (cot > 0) {
                    // amount = amount - cot;
                    text_html += '<tr>' +
                        '<td colspan="10"></td>' +
                        '<td class="text-center"><b>Cash on tour</b></td>' +
                        '<td class="text-center">' + numberWithCommas(cot) + '</td>' +
                        '</tr>'
                }

                text_html += '<tr id="tr-multi-vat" hidden>' +
                    '<td colspan="10"></td>' +
                    '<td class="text-center"><b id="vat-multi-text"></b><br><small>(Vat)</small></td>' +
                    '<td class="text-center" id="price-multi-vat"></td>' +
                    '</tr>';

                text_html += '<tr id="tr-multi-withholding" hidden>' +
                    '<td colspan="10"></td>' +
                    '<td class="text-center"><b id="withholding-multi-text"></b><br><small>(Withholding Tax)</small></td>' +
                    '<td class="text-center" id="price-multi-withholding"></td>' +
                    '</tr>';

                text_html += '<tr>' +
                    '<td colspan="10"></td>' +
                    '<td class="text-center"><b>ยอดชำระ</b><br><small>(Payment Amount)</small></td>' +
                    '<td class="text-center" id="price-multi-amount"></td>' +
                    '</tr>';

                $('#tbody-multi-booking').html(text_html);

                document.getElementById('discount').value = discount;
                document.getElementById('cot').value = cot;
                document.getElementById('price_total').value = amount;
            }

            $('#inv_date').flatpickr({
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.isMobile) {
                        $(instance.mobileInput).attr('step', null);
                    }
                },
                static: true,
                altInput: true,
                altFormat: 'j F Y',
                dateFormat: 'Y-m-d',
                defaultDate: 'today'
            });

            $('#rec_date').flatpickr({
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.isMobile) {
                        $(instance.mobileInput).attr('step', null);
                    }
                },
                static: true,
                altInput: true,
                altFormat: 'j F Y',
                dateFormat: 'Y-m-d',
                defaultDate: 'today'
            });

            calculator_price();
        }

        function check_diff_date(type) {
            var today = document.getElementById('input_today').value;
            var rec_date = document.getElementById(type).value;
            const date1 = new Date(today);
            const date2 = new Date(rec_date);
            const diffTime = date2.getTime() - date1.getTime();
            const diffDays = diffTime / (1000 * 60 * 60 * 24);
            var days = diffDays <= 0 ? '' : "อีก " + diffDays + " วัน";
            $('#diff_rec_date').html(days);
        }

        function calculator_price() {
            var type = 'multi';
            var vat_total = 0;
            var vat_cut = 0;
            var withholding_total = 0;
            var total = 0;
            var price_amount = document.getElementById('price-' + type + '-amount');
            var vat = document.getElementById('vat');
            var withholding = document.getElementById('withholding');
            var price_withholding = document.getElementById('price-' + type + '-withholding');
            var price_total = document.getElementById('price_total');
            var tr_vat = document.getElementById('tr-' + type + '-vat');
            var vat_text = document.getElementById('vat-' + type + '-text');
            var price_vat = document.getElementById('price-' + type + '-vat');
            var price_total_1 = document.getElementById('price-' + type + '-total');
            var tr_withholding = document.getElementById('tr-' + type + '-withholding');
            var withholding_text = document.getElementById('withholding-' + type + '-text');
            var discount = document.getElementById('discount');
            var cot = document.getElementById('cot');
            var amount = document.getElementById('amount');
            tr_vat.hidden = vat.value > 0 ? false : true;
            vat_text.innerHTML = vat.value > 0 ? vat.value == 1 ? 'รวมภาษี 7%' : 'แยกภาษี 7%' : '';
            tr_withholding.hidden = withholding.value > 0 ? false : true;
            withholding_text.innerHTML = withholding.value > 0 ? 'หักภาษี ณ ที่จ่าย ' + withholding.value + ' %' : '';
            // --- sum price total --- //
            total = price_total.value;
            // --- vat and withholding --- //
            if (vat.value == 1) {
                vat_total = Number(((total * 100) / 107));
                vat_cut = vat_total;
                vat_total = Number(total - vat_total);
                withholding_total = withholding.value > 0 ? Number((vat_cut * withholding.value) / 100) : 0;
                total = Number(total - withholding_total);
            } else if (vat.value == 2) {
                vat_total = Number(((total * 7) / 100));
                total = Number(total) + Number(vat_total);
                withholding_total = withholding.value > 0 ? Number(((total - vat_total) * withholding.value) / 100) : 0;
                total = Number(total - withholding_total);
            }

            price_vat.innerHTML = Number(vat_total).toLocaleString("en-US", {
                maximumFractionDigits: 2
            });

            price_withholding.innerHTML = Number(withholding_total).toLocaleString("en-US", {
                maximumFractionDigits: 2
            });

            price_total_1.innerHTML = Number(total).toLocaleString("en-US", {
                maximumFractionDigits: 2
            });

            total = discount.value > 0 ? Number(total - discount.value) : total;
            total = cot.value > 0 ? Number(total - cot.value) : total;

            price_amount.innerHTML = Number(total).toLocaleString("en-US", {
                maximumFractionDigits: 2
            });

            amount.value = total;
        }
    </script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->
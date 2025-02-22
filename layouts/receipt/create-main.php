<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Receipt - <?php echo $main_title; ?></title>
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

    <style>
        .table-black {
            color: #FFFFFF;
            background-color: #003285;
        }

        .table-black-2 {
            color: #FFFFFF;
            background-color: #0060ff;
        }
    </style>
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
    <script src="app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
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
            var jqForm = $('#receipt-search-form'),
                jqFormRec = $('#receipt-form'),
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

            // Ajax Search
            // --------------------------------------------------------------------
            jqForm.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/receipt/function/search-agent.php",
                    type: "POST",
                    data: serializedData + "&action=search-invoice",
                    success: function(response) {
                        if (response != 'false') {
                            $('#div-receipt-custom').html(response);
                        }
                    }
                });
                e.preventDefault();
            });

            // jQuery Validation
            // --------------------------------------------------------------------
            if (jqFormRec.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormRec.validate({
                    rules: {

                    },
                    messages: {

                    },
                    submitHandler: function(form) {
                        // update ajax request data
                        var formData = new FormData(form);
                        formData.append('action', 'create');
                        $.ajax({
                            url: "pages/receipt/function/create.php",
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
                                            location.reload(); // refresh page
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

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function search_start_date(tabs, travel_date) {
            var formData = new FormData();
            formData.append('action', 'search-invoice');
            formData.append('travel_date', travel_date);
            $.ajax({
                url: "pages/receipt/function/search-agent.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != 'false') {
                        $('#' + tabs).html(response);
                    }
                }
            });
        }

        function modal_detail(agent_id, agent_name, travel_date) {
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('agent_id', agent_id);
            formData.append('travel_date', travel_date);
            $.ajax({
                url: "pages/receipt/function/search-invoice.php",
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

        function modal_receipt(cover_id) {
            var array_booking = document.getElementById('array_booking').value;
            var array_rates = document.getElementById('array_rates').value;
            var array_extar = document.getElementById('array_extar').value;
            var array_invoice = document.getElementById('array_invoice').value;
            if (cover_id > 0 && array_booking !== '') {
                var res = $.parseJSON(array_booking);
                var res_rates = array_rates !== '' ? $.parseJSON(array_rates) : '';
                var res_extar = array_extar !== '' ? $.parseJSON(array_extar) : '';
                var res_invoice = array_invoice !== '' ? $.parseJSON(array_invoice) : '';

                document.getElementById('cover_id').value = cover_id;

                document.getElementById('agent_name_text').innerHTML = document.getElementById('agent_value').dataset.name;
                document.getElementById('agent_tax_text').innerHTML = document.getElementById('agent_value').dataset.license;
                document.getElementById('agent_tel_text').innerHTML = document.getElementById('agent_value').dataset.telephone;
                document.getElementById('agent_address_text').innerHTML = document.getElementById('agent_value').dataset.address;

                document.getElementById('inv_full_text').innerHTML = res_invoice[cover_id].inv_full;
                document.getElementById('branch_text').innerHTML = res_invoice[cover_id].brch_name;
                document.getElementById('inv_date_text').innerHTML = res_invoice[cover_id].inv_date;
                document.getElementById('rec_date_text').innerHTML = res_invoice[cover_id].rec_date;
                document.getElementById('due_date_text').innerHTML = res_invoice[cover_id].due_date;

                var text_html = '';
                var total = 0;
                var amount = 0;
                var cot = 0;
                var discount = 0;
                var no = 1;
                if (res !== undefined && (res[cover_id] !== undefined)) {
                    for (let index = 0; index < res[cover_id].id.length; index++) {
                        var rowspan = 0;
                        text_rates = '';
                        var id = res[cover_id].id[index];
                        discount = res[id].discount !== '-' ? Number(discount + res[id].discount) : Number(discount);
                        cot = res[id].cot !== '-' ? Number(cot + res[id].cot) : Number(cot);

                        text_html += '<input type="hidden" name="bo_id[]" value="' + id + '">';

                        if (res_rates !== undefined && (res_rates[id] !== undefined)) {
                            rowspan = res_rates[id].id.length;
                            for (let y = 0; y < res_rates[id].id.length; y++) {
                                if (y == 0) {
                                    // var customer = res_rates[id].customer[y] == 1 ? ' (Thai)' : ' (Foreign)';
                                    var customer = res[id].status == 2 || res[id].status == 4 ? ' (' + res_rates[id].category_name[y] + ') '  + res[id].status_name : ' (' + res_rates[id].category_name[y] + ')';
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
                                    var customer = res_rates[id].customer[y] == 1 ? ' (Thai)' : ' (Foreign)';
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
                        '</tr>';

                        if (res_extar !== undefined && (res_extar[id] !== undefined)) {
                            for (let index = 0; index < res_extar[id].id.length; index++) {
                                amount = res_extar[id].total !== '-' ? Number(amount + res_extar[id].total[index]) : Number(amount);
                                text_html += '<tr>' +
                                    '<td class="text-left" colspan="5"> ' + res_extar[id].name[index] + ' </td>' +
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

                    text_html += '<tr>' +
                        '<td colspan="10"></td>' +
                        '<td class="text-center"><b>รวมเป็นเงิน</b><br><small>(Total)</small></td>' +
                        '<td class="text-center">' + numberWithCommas(amount) + '</td>' +
                        '</tr>'

                    if (discount > 0) {
                        amount = amount - discount;
                        text_html += '<tr>' +
                            '<td colspan="10"></td>' +
                            '<td class="text-center"><b>ส่วนลด</b><br><small>(Discount)</small></td>' +
                            '<td class="text-center">' + numberWithCommas(discount) + '</td>' +
                            '</tr>'
                    }

                    if (cot > 0) {
                        amount = amount - cot;
                        text_html += '<tr>' +
                            '<td colspan="10"></td>' +
                            '<td class="text-center"><b>Cash on tour</b></td>' +
                            '<td class="text-center">' + numberWithCommas(cot) + '</td>' +
                            '</tr>'
                    }

                    if (res_invoice[cover_id].vat == 1) {
                        vat_total = Number(((amount * 100) / 107));
                        vat_cut = vat_total;
                        vat_total = Number(amount - vat_total);
                        withholding_total = res_invoice[cover_id].withholding > 0 ? Number((vat_cut * res_invoice[cover_id].withholding) / 100) : 0;
                        amount = Number(amount - withholding_total);
                        withholding_total = Number(withholding_total).toLocaleString("en-US", {
                            maximumFractionDigits: 2
                        });
                    } else if (res_invoice[cover_id].vat == 2) {
                        vat_total = Number(((amount * 7) / 100));
                        amount = Number(amount) + Number(vat_total);
                        withholding_total = res_invoice[cover_id].withholding > 0 ? Number(((amount - vat_total) * res_invoice[cover_id].withholding) / 100) : 0;
                        amount = Number(amount - withholding_total);
                        withholding_total = Number(withholding_total).toLocaleString("en-US", {
                            maximumFractionDigits: 2
                        });
                    }

                    if (res_invoice[cover_id].vat > 0) {
                        text_vat = res_invoice[cover_id].vat == 1 ? 'รวมภาษี 7%' : 'แยกภาษี 7%';
                        text_html += '<tr>' +
                            '<td colspan="10"></td>' +
                            '<td class="text-center"><b id="vat-multi-text">' + text_vat + '</b><br><small>(Vat)</small></td>' +
                            '<td class="text-center">' + Number(vat_total).toLocaleString("en-US", {
                                maximumFractionDigits: 2
                            }) + '</td>' +
                            '</tr>';
                    }

                    if (res_invoice[cover_id].withholding > 0) {
                        text_html += '<tr>' +
                            '<td colspan="10"></td>' +
                            '<td class="text-center"><b id="withholding-multi-text">หัก ณ ที่จ่าย (' + res_invoice[cover_id].withholding + '%)</b><br><small>(Withholding Tax)</small></td>' +
                            '<td class="text-center">' + numberWithCommas(withholding_total) + '</td>' +
                            '</tr>';
                    }

                    text_html += '<tr>' +
                        '<td colspan="10"></td>' +
                        '<td class="text-center"><b>ยอดชำระ</b><br><small>(Payment Amount)</small></td>' +
                        '<td class="text-center">' + Number(amount).toLocaleString("en-US", {
                            maximumFractionDigits: 2
                        }) + '</td>' +
                        '</tr>';

                }
                $('#tbody-multi-booking').html(text_html);

                document.getElementById('amount').value = amount;
            }

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

            $('#date_check').flatpickr({
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

            // calculator_price();
        }


        function check_diff_date(type) {
            var today = document.getElementById('today').value;
            var rec_date = document.getElementById(type).value;
            const date1 = new Date(today);
            const date2 = new Date(rec_date);
            const diffTime = date2.getTime() - date1.getTime();
            const diffDays = diffTime / (1000 * 60 * 60 * 24);
            var days = diffDays <= 0 ? '' : "อีก " + diffDays + " วัน";
            $('#diff_rec_date').html(days);
        }

        function check_payment() {
            var payments_type = document.getElementById('payments_type').value;
            document.getElementById('div-bank-account').hidden = payments_type == 4 ? false : true;
            document.getElementById('div-bank').hidden = payments_type == 5 ? false : true;
            document.getElementById('div-check-no').hidden = payments_type == 5 ? false : true;
            document.getElementById('div-check-date').hidden = payments_type == 5 ? false : true;
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
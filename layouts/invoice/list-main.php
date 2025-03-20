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
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
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
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-wizard.css">
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
    <script src="app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="app-assets/js/scripts/node_modules/dom-to-image/src/dom-to-image.js"></script>
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
        // Ajax Delete Invoice
        // --------------------------------------------------------------------
        function deleteInvoice() {
            var cover_id = $('#cover_id').val();
            var bo_arr = document.getElementsByName('bo_id[]');
            var bo_id = [];
            if (bo_arr.length) {
                for (let index = 0; index < bo_arr.length; index++) {
                    bo_id.push(bo_arr[index].value);
                }
            }
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "pages/invoice/function/delete.php",
                        type: "POST",
                        data: {
                            cover_id: cover_id,
                            bo_id: bo_id,
                            action: 'delete'
                        },
                        success: function(response) {
                            if (response != false) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Your item has been deleted.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                }).then(function() {
                                    var tab = document.getElementsByClassName('tab-pane active')[0].id;
                                    var travel_date = tab != 'custom' ? tab == 'today' ? '<?php echo $today; ?>' : '<?php echo $tomorrow; ?>' : document.getElementById('travel_date').value;
                                    search_start_date(tab, travel_date);
                                    $('#modal-add-invoice').modal('hide');
                                    search_start_date('today', '<?php echo $today; ?>');
                                    search_start_date('tomorrow', '<?php echo $tomorrow; ?>');

                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Please try again.',
                                    text: 'Failed to delete data!',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Please try again.',
                                text: 'Failed to delete data!',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                        }
                    });
                }
            });
        }

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

            // Ajax Search
            // --------------------------------------------------------------------
            jqForm.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/invoice/function/search-agent.php",
                    type: "POST",
                    data: serializedData + "&action=search-invoice",
                    success: function(response) {
                        if (response != false) {
                            $("#div-invoice-custom").html(response);
                        }
                    }
                });
                e.preventDefault();
            });

            // jQuery Validation
            // --------------------------------------------------------------------
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
                    messages: {},
                    submitHandler: function(form) {
                        // update ajax request data
                        var formData = new FormData(form);
                        formData.append('action', 'edit');
                        formData.append('cover_id', $('#cover_id').val());
                        $.ajax({
                            url: "pages/invoice/function/edit.php",
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
                                            $('#modal-add-invoice').modal('hide');
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

        function search_start_date(tabs, travel_date) {
            var formData = new FormData();
            formData.append('action', 'search-invoice');
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

        function modal_detail(agent_id, agent_name, travel_date) {
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('agent_id', agent_id);
            formData.append('travel_date', travel_date);
            $.ajax({
                url: "pages/invoice/function/search-invoice.php",
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

        function modal_invoice() {
            $('#modal-show').modal('toggle');
            $('#modal-add-invoice').modal('show');
            $("#modal-add-invoice").css({
                "overflow-y": "auto"
            });

            var array_booking = document.getElementById('array_booking').value;
            var array_rates = document.getElementById('array_rates').value;
            var array_extar = document.getElementById('array_extar').value;
            if (array_booking !== '') {
                document.getElementById('cover_id').value = document.getElementById('agent_value').dataset.cover;
                document.getElementById('inv_date').value = document.getElementById('agent_value').dataset.inv_date;
                document.getElementById('rec_date').value = document.getElementById('agent_value').dataset.rec_date;
                document.getElementById('vat').value = document.getElementById('agent_value').dataset.vat;
                document.getElementById('withholding').value = document.getElementById('agent_value').dataset.withholding;
                document.getElementById('bank_account').value = document.getElementById('agent_value').dataset.bank_account;
                document.getElementById('note').value = document.getElementById('agent_value').dataset.note;

                document.getElementById('inv_no_text').innerHTML = document.getElementById('agent_value').dataset.inv_full;
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
                for (let index = 0; index < res.id.length; index++) {
                    var rowspan = 0;
                    text_rates = '';
                    var id = res.id[index];
                    discount = res[id].discount !== '-' ? Number(discount + res[id].discount) : Number(discount);
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

                    // text_html += '<tr>' +
                    //     '<td class="text-center">' + Number(no++) + '<input type="hidden" name="bo_id[]" value="' + id + '"></td>' +
                    //     '<td class="text-center"> ' + res[id].text_date + ' </td>' +
                    //     '<td> ' + res[id].cus_name + ' </td>' +
                    //     '<td> ' + res[id].product_name + ' </td>' +
                    //     '<td class="text-center"> ' + res[id].voucher_no + ' </td>' +
                    //     '<td class="text-center"> ' + res[id].adult + ' </td>' +
                    //     '<td class="text-center"> ' + res[id].child + ' </td>' +
                    //     '<td class="text-center"> ' + numberWithCommas(res[id].rate_adult) + ' </td>' +
                    //     '<td class="text-center"> ' + numberWithCommas(res[id].rate_child) + ' </td>' +
                    //     '<td class="text-center"> ' + res[id].discount + ' </td>' +
                    //     '<td class="text-center"> ' + numberWithCommas(res[id].total) + ' </td>' +
                    //     '<td class="text-center"> ' + numberWithCommas(res[id].cot) + ' </td>' +
                    //     '</tr>';

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

                text_html += '<tr>' +
                    '<td colspan="10"></td>' +
                    '<td class="text-center"><b>รวมเป็นเงิน</b><br><small>(Total)</small></td>' +
                    '<td class="text-center" id="price-multi-total"></td>' +
                    '</tr>'

                if (discount > 0) {
                    text_html += '<tr>' +
                        '<td colspan="10"></td>' +
                        '<td class="text-center"><b>ส่วนลด</b><br><small>(Discount)</small></td>' +
                        '<td class="text-center">' + numberWithCommas(discount) + '</td>' +
                        '</tr>'
                }

                if (cot > 0) {
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
                defaultDate: document.getElementById('agent_value').dataset.inv_date
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
                defaultDate: document.getElementById('agent_value').dataset.rec_date
            });

            calculator_price();

            $("#vat").val(document.getElementById('agent_value').dataset.vat).trigger("change");
            $("#withholding").val(document.getElementById('agent_value').dataset.withholding).trigger("change");
            $("#bank_account").val(document.getElementById('agent_value').dataset.bank_account).trigger("change");
        }

        function modal_show_invoice(cover_id) {
            var formData = new FormData();
            formData.append('action', 'preview');
            formData.append('cover_id', cover_id);
            $.ajax({
                url: "pages/invoice/print.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != false) {
                        $("#div-show-invoice").html(response);
                    }
                }
            });
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

        function download_image() {
            var img_name = document.getElementById('name_img').value;
            var node = document.getElementById('invoice-preview-vertical');
            domtoimage.toJpeg(node, {
                    quality: 0.95
                })
                .then(function(dataUrl) {
                    var link = document.createElement('a');
                    link.download = img_name + '.jpg';
                    link.href = dataUrl;
                    link.click();
                });
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
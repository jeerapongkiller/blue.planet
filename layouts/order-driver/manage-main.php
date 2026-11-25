<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Management Transfer - <?php echo $main_title; ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/dragula.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
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
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/app-user.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/extensions/ext-component-drag-drop.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/fontawesome/css/all.css" rel="stylesheet">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

    <style>
        .list-group-flush>.list-group-item {
            border-width: 0;
        }

        .list-group-item {
            padding: 0;
        }

        .table th,
        .table td {
            padding: 0.72rem 1rem;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #6E6B7B;
        }

        .table thead th {
            border-bottom: 1px solid #6E6B7B;
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
    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="app-assets/js/scripts/node_modules/dom-to-image/src/dom-to-image.js"></script>
    <script src="app-assets/fonts/fontawesome/js/all.js"></script>
    <script src="app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
    <script src="app-assets/vendors/js/extensions/dragula.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN Sweetalert2 JS -->
    <script src="app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <script src="app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <!-- END Sweetalert2 JS -->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
        $(document).ready(function() {
            var jqFormTransfer = $('#transfer-form'),
                jqFormDriver = $('#driver-car-search-form'),
                FormEdTransfer = $('#edit-manage-form'),
                picker = $('#dob'),
                DatePicker = $('.date-picker'),
                dtPicker = $('#dob-bootstrap-val'),
                select = $('.select2'),
                pageBlockSpinner = $('.btn-page-block-spinner'),
                horizontalWizard = document.querySelector('.horizontal-wizard-example');

            if (pageBlockSpinner.length) {
                pageBlockSpinner.on('click', function() {
                    $.blockUI({
                        message: '<div class="spinner-grow spinner-grow-sm text-white" role="status"></div>',
                        timeout: 1000,
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                });
            }

            // dragula([document.getElementById('basic-list-group')]);


            //Numeral
            $('.numeral-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            });

            // Time
            $('.time-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    time: true,
                    timePattern: ['h', 'm']
                });
            });

            if (DatePicker.length) {
                DatePicker.flatpickr({
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr('step', null);
                        }
                    },
                    // static: true,
                    altInput: true,
                    altFormat: 'j F Y',
                    dateFormat: 'Y-m-d'
                });
            }

            // select2
            if (select.length) {
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
            }

            if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
                var horizontaStepper = new Stepper(horizontalWizard, {
                    linear: false
                });
                $(horizontalWizard)
                    .find('.btn-next')
                    .on('click', function() {
                        horizontaStepper.next();
                    });
                $(horizontalWizard)
                    .find('.btn-prev')
                    .on('click', function() {
                        horizontaStepper.previous();
                    });

                $(horizontalWizard)
                // .find('.btn-submit')
                // .on('click', function () {
                //     alert('Submitted..!!');
                // });

                horizontaStepper.to(<?php echo !empty($_GET['search_retrun']) ? $_GET['search_retrun'] : 1; ?>);
                // console.log(horizontaStepper);
                // horizontalWizard.addEventListener('shown.bs-stepper', function(event) {
                //     console.log('Moved to step ' + event.detail.indexStep)
                // })
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

            // Ajax Search
            // --------------------------------------------------------------------
            FormEdTransfer.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/order-driver/function/edit-manage-transfer.php",
                    type: "POST",
                    data: serializedData + "&action=edit",
                    success: function(response) {
                        // console.log(response);
                        if (response != false && response > 0) {
                            location.reload(); // refresh page
                        } else {
                            Swal.fire({
                                title: "Please try again.",
                                icon: "error",
                            });
                        }
                    }
                });
                e.preventDefault();
            });

            jqFormTransfer.on("submit", function(e) {
                var action = ($('#manage_id').val() !== '' && $('#manage_id').val() > 0) ? 'edit' : 'create';
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/order-driver/function/" + action + "-transfer.php",
                    type: "POST",
                    data: serializedData + "&action=" + action + "&travel_date=" + $('#date_travel_booking').val() + "&return=" + $('#return').val(),
                    success: function(response) {
                        // console.log(response);
                        if (action === 'create' && response != false) {
                            location.reload(); // refresh page
                            // $('#modal-transfers').modal('hide');
                            // $('#modal-booking').modal('show');
                            // var res = $.parseJSON(response);
                            // search_booking('next', res.travel_date, res.retrun, res.id);
                        } else if (action === 'edit' && response != false) {
                            location.reload(); // refresh page
                        } else {
                            Swal.fire({
                                title: "Please try again.",
                                icon: "error",
                            });
                        }
                    }
                });
                e.preventDefault();
            });

            search_start_date('today', '<?php echo $today; ?>');
            search_start_date('tomorrow', '<?php echo $tomorrow; ?>');
            search_start_date('custom', '<?php echo $get_date; ?>');
        });

        function search_start_date(type, date) {
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('type', type);
            formData.append('date', date);
            $.ajax({
                url: "pages/order-driver/function/search-report.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != 'false') {
                        $('#' + type).html(response);
                    }
                }
            });
        }

        function search_report(date) {
            window.location.search = "?pages=order-driver/manage&date_travel_booking=" + date;
        }

        function checkbox(type, programe_id) {
            var checkbox_all = type == 'booking' ? document.getElementById('checkbo_all' + programe_id).checked : document.getElementById('checkmanage_all').checked;
            var checkbox = type == 'booking' ? document.getElementsByClassName('checkbox-' + programe_id) : document.getElementsByClassName('checkbox-manage');

            if (checkbox_all == true && checkbox.length > 0) {
                for (let index = 0; index < checkbox.length; index++) {
                    checkbox[index].checked = true;
                }
            } else if (checkbox_all == false && checkbox.length > 0) {
                for (let index = 0; index < checkbox.length; index++) {
                    checkbox[index].checked = false;
                }
            }

            sum_checkbox();
        }

        function sum_checkbox() {
            var bookings = document.getElementsByClassName('checkbox-book');
            var manage = document.getElementsByClassName('checkbox-manage');
            var sum_true = 0;
            var sum_false = 0;
            var sum_toc_true = 0;
            var sum_toc_false = 0;
            var adult_sum = 0;
            var child_sum = 0;
            var infant_sum = 0;
            var foc_sum = 0;
            var toc = 0;
            var adult = 0;
            var child = 0;
            var infant = 0;
            var foc = 0;
            if (bookings.length > 0) {
                for (let index = 0; index < bookings.length; index++) {
                    toc = document.getElementById('toc-bookings' + bookings[index].value).innerHTML;
                    adult = document.getElementById('adult' + bookings[index].value).innerHTML;
                    child = document.getElementById('child' + bookings[index].value).innerHTML;
                    infant = document.getElementById('infant' + bookings[index].value).innerHTML;
                    foc = document.getElementById('foc' + bookings[index].value).innerHTML;
                    if (bookings[index].checked == true) {
                        sum_true = Number(sum_true + 1);
                        sum_toc_true = Number(sum_toc_true) + Number(toc);
                        adult_sum = Number(adult_sum) + Number(adult);
                        child_sum = Number(child_sum) + Number(child);
                        infant_sum = Number(infant_sum) + Number(infant);
                        foc_sum = Number(foc_sum) + Number(foc);
                    } else {
                        sum_false = Number(sum_false + 1);
                        sum_toc_false = Number(sum_toc_false) + Number(toc);
                    }
                }
            }
            if (manage.length > 0) {
                for (let index = 0; index < manage.length; index++) {
                    toc = document.getElementById('toc-manage' + manage[index].value).innerHTML;
                    adult = document.getElementById('adult' + manage[index].value).innerHTML;
                    child = document.getElementById('child' + manage[index].value).innerHTML;
                    infant = document.getElementById('infant' + manage[index].value).innerHTML;
                    foc = document.getElementById('foc' + manage[index].value).innerHTML;
                    if (manage[index].checked == true) {
                        sum_true = Number(sum_true + 1);
                        sum_toc_true = Number(sum_toc_true) + Number(toc);
                        adult_sum = Number(adult_sum) + Number(adult);
                        child_sum = Number(child_sum) + Number(child);
                        infant_sum = Number(infant_sum) + Number(infant);
                        foc_sum = Number(foc_sum) + Number(foc);
                    } else {
                        sum_false = Number(sum_false + 1);
                        sum_toc_false = Number(sum_toc_false) + Number(toc);
                    }
                }
            }
            document.getElementById('toc-true').innerHTML = sum_toc_true;
            document.getElementById('adult-sum').innerHTML = adult_sum;
            document.getElementById('child-sum').innerHTML = child_sum;
            document.getElementById('infant-sum').innerHTML = infant_sum;
            document.getElementById('foc-sum').innerHTML = foc_sum;
        }

        function modal_transfer(travel_date, manage_id, i, type) {
            document.getElementById('text-travel-date').innerHTML = '<b>' + travel_date + '</b>';
            if (manage_id > 0) {
                var arr_mange = document.getElementById('arr_mange' + manage_id).value;
                var res = $.parseJSON(arr_mange);

                $("#driver").val(res.driver_id[i]).trigger("change");

                document.getElementById('manage_id').value = res.id[i];
                document.getElementById('island_id').value = res.island_id[i];
                document.getElementById('car').value = res.car_id[i];
                document.getElementById('driver').value = res.driver_id[i];
                document.getElementById('seat').value = res.seat[i];
                document.getElementById('license').value = res.license[i];
                document.getElementById('telephone').value = res.telephone[i];
                document.getElementById('note').value = res.note[i];
                document.getElementById('outside_driver').value = res.driver_id[i] == 0 ? res.driver_name[i] : '';

                $("#island_id").val(res.island_id[i]).trigger("change");
                $("#car").val(res.car_id[i]).trigger("change");
                $("#seat").val(res.seat[i]).trigger("change");
                document.getElementById('delete_manage').disabled = false;
            } else {
                $("#island_id").val(0).trigger("change");
                $("#driver").val(0).trigger("change");
                $("#car").val(0).trigger("change");
                $("#seat").val(0).trigger("change");
                document.getElementById('delete_manage').disabled = true;
                document.getElementById('transfer-form').reset();
            }
            document.getElementById('retrun').value = type;
        }

        function check_outside(type) {
            if (type == 'driver') {
                var driver = document.getElementById('driver').value
                document.getElementById('frm-driver').hidden = driver == 'outside' ? true : false;
                document.getElementById('frm-driver-outside').hidden = driver == 'outside' ? false : true;
            } else if (typeof type !== undefined && type == 'outside_driver') {
                document.getElementById('frm-driver-outside').hidden = true;
                document.getElementById('frm-driver').hidden = false;
            }
            if (type == 'car') {
                var car = document.getElementById('car').value
                document.getElementById('frm-car').hidden = car == 'outside' ? true : false;
                document.getElementById('frm-car-outside').hidden = car == 'outside' ? false : true;
            } else if (typeof type !== undefined && type == 'outside_car') {
                document.getElementById('frm-car-outside').hidden = true;
                document.getElementById('frm-car').hidden = false;
            }
            if (type == 'guide') {
                var guide = document.getElementById('guide').value
                document.getElementById('frm-guide').hidden = guide == 'outside' ? true : false;
                document.getElementById('frm-guide-outside').hidden = guide == 'outside' ? false : true;
            }
        }

        function check_driver() {
            var driver = document.getElementById('driver');

            document.getElementById('frm-driver').hidden = driver.value == 'outside' ? true : false;
            document.getElementById('frm-driver-outside').hidden = driver.value == 'outside' ? false : true;

            if (driver.value !== 'outside') {
                document.getElementById('license').value = driver.options[driver.selectedIndex].getAttribute("data-license");
                document.getElementById('seat').value = driver.options[driver.selectedIndex].getAttribute("data-seat");
                document.getElementById('telephone').value = driver.options[driver.selectedIndex].getAttribute("data-telephone");
                if (driver.options[driver.selectedIndex].getAttribute("data-seat") > 0) {
                    $("#seat").val(driver.options[driver.selectedIndex].getAttribute("data-seat")).trigger("change");
                }
            }
        }

        function search_booking(type, travel_date, retrun, manage_id, car, island_id) {
            // get data
            // var formData = new FormData();
            // formData.append('action', 'search');
            // formData.append('travel_date', String(travel_date));
            // formData.append('return', retrun);
            // formData.append('manage_id', manage_id);
            // formData.append('car', car);
            // formData.append('type', type);
            var serializedData = $('#booking-search-form').serialize();
            $.ajax({
                url: "pages/order-driver/function/search-manage-booking.php",
                type: "POST",
                // processData: false,
                // contentType: false,
                data: serializedData + "&action=search&return=" + retrun + "&car=" + car + "&manage_id=" + manage_id + "&island_id=" + island_id + "&type=" + type,
                success: function(response) {
                    $('#div-manage-boooking').html(response);
                    sum_checkbox();

                    if (type !== 'next') {
                        var tbody = document.querySelector('#list-group tbody');
                        // สร้าง Dragula instance
                        if (tbody) {
                            dragula([tbody], {
                                moves: function(el, container, handle) {
                                    return handle.tagName.toLowerCase() === 'td'; // กำหนดให้ลากได้เฉพาะที่ td
                                }
                            }).on('drop', function(el, target, source, sibling) {
                                // console.log('Dropped element:', el);
                            });
                        }
                    }
                }
            });

            if (type == 'next') {
                $('#modal-booking').on('hidden.bs.modal', function() {
                    location.reload(); // refresh page
                });
            }
        }

        function submit_booking_manage(type, t_return, manage_id) {
            var bt_id = document.getElementsByName('bt_id[]');
            var manage_bt = (document.getElementsByName('manage_bt[]')) ? document.getElementsByName('manage_bt[]') : '';
            var before = (document.getElementById('before_managebt')) ? document.getElementById('before_managebt') : '';
            var before2 = (document.getElementById('before_managebt2')) ? document.getElementById('before_managebt2') : '';
            var transfer = [];
            var dropoff = [];
            var dropoff_2 = [];
            var bt_manage = [];
            if (bt_id) {
                for (let index = 0; index < bt_id.length; index++) {
                    if (bt_id[index].checked == true) {
                        transfer.push(bt_id[index].value);
                        if ($('#return').val() == 1) {
                            dropoff.push($('#bt2_' + bt_id[index].value).val());
                        }
                    }
                }
            }
            if (manage_bt) {
                for (let index = 0; index < manage_bt.length; index++) {
                    if (manage_bt[index].checked == true) {
                        bt_manage.push(manage_bt[index].value);
                        if ($('#return').val() == 1) {
                            dropoff_2.push($('#manage_bt2_' + manage_bt[index].value).val());
                        }
                    }
                }
            }
            if (manage_id > 0) {
                var formData = new FormData();
                formData.append('action', 'create');
                formData.append('manage_id', manage_id);
                formData.append('return', t_return);
                formData.append('transfer', JSON.stringify(transfer));
                formData.append('dropoff', JSON.stringify(dropoff));
                formData.append('dropoff_2', JSON.stringify(dropoff_2));
                formData.append('manage_bt', JSON.stringify(bt_manage));
                formData.append('before', before.value);
                formData.append('before2', before2.value);
                $.ajax({
                    url: "pages/order-driver/function/create_booking_manage.php",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        location.reload();
                        // console.log(response);
                        // if (response != false && response > 0) {
                        //     location.reload(); // refresh page
                        // } else {
                        //     Swal.fire({
                        //         title: "Please try again.",
                        //         icon: "error",
                        //     });
                        // }
                    }
                });
            } else if (type == 'next' && bt_manage == '') {
                location.reload(); // refresh page
            } else {
                Swal.fire({
                    title: "Please try again.",
                    icon: "error",
                });
            }
        }

        function modal_manage_transfer(bt_id, reteun, mange_id) {
            var array_trans = document.getElementById('array_trans').value;
            document.getElementById('edit_bt_id').value = typeof bt_id !== undefined ? bt_id : 0;
            document.getElementById('brfore_manage_id').value = typeof mange_id !== undefined ? mange_id : 0;

            if (array_trans !== '') {
                $('#edit_manage').find('option').remove();
                $('#edit_manage').append("<option value=\"\">กรุญาเลือกรถ...</option>");
                var res = $.parseJSON(array_trans);
                var count = Object.keys(res.mange_id).length;
                if (count) {
                    for (let index = 0; index < count; index++) {
                        if ((reteun == 1 && res.pickup[index] == 1) || (reteun == 2 && res.dropoff[index] == 1)) {
                            selected = (mange_id !== undefined && res.mange_id[index] == mange_id) ? 'selected' : '';
                            $('#edit_manage').append("<option value=\"" + res.mange_id[index] + "\" " + selected + ">" + res.car[index] + "</option>");
                        }
                    }
                }
                $('#edit_manage').append("<option value=\"0\" >ไม่มีการจัดรถ</option>");
            } else {
                $('#edit_manage').find('option').remove();
                $('#edit_manage').append("<option value=\"\">กรุญาเลือกรถ...</option>");
            }
        }

        function check_cover(type) {
            var mange_id = document.getElementsByName('mange_id[]');
            if (mange_id) {
                for (let index = 0; index < mange_id.length; index++) {
                    document.getElementById('text-head-h4-' + mange_id[index].value).innerHTML = type == 1 ? 'ใบงานจัดรถ Pick Up' : 'ใบงานจัดรถ Drop off';
                    document.getElementById('text-pier' + mange_id[index].value).innerHTML = type == 1 ? 'รับลูกค้าส่ง' + mange_id[index].dataset.pier : 'รับ' + mange_id[index].dataset.pier + 'ส่งลูกค้าที่โรงแรม';
                }
            }
        }

        function delete_transfer() {
            var manage_id = document.getElementById('manage_id');
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
                        url: "pages/order-driver/function/delete-manage.php",
                        type: "POST",
                        data: {
                            manage_id: manage_id.value,
                            return: $('#return').val(),
                            action: 'delete'
                        },
                        success: function(response) {
                            // console.log(response);
                            if (response != false) {
                                location.reload();
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

        function download_image() {
            var img_name = document.getElementById('name_img').value;
            var node = document.getElementById('div-driver-job-image');
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
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Management Boat - <?php echo $main_title; ?></title>
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

        .vc-column {
            word-wrap: break-word;
            /* white-space: normal; */
        }

        .badge-light-orange {
            background: #f5cba7;
            color: #d35400;
            padding: 5px 20px;
            border-radius: 30px;
            display: inline-block;
            font-size: 20px;
            font-weight: 500;
        }

        .badge-light-sky {
            background: #aed6f1;
            color: #006cb4;
            padding: 5px 20px;
            border-radius: 30px;
            display: inline-block;
            font-size: 20px;
            font-weight: 500;
        }

        .badge-light-green-2 {
            background: #abebc6;
            color: #239b56;
            padding: 5px 20px;
            border-radius: 30px;
            display: inline-block;
            font-size: 20px;
            font-weight: 500;
        }

        .badge-light-purple {
            background: #d7c4e0;
            color: #662e93;
            padding: 5px 20px;
            border-radius: 30px;
            display: inline-block;
            font-size: 20px;
            font-weight: 500;
        }

        /* @media print {
            body {
                visibility: hidden;
            }

            #div-boat-job-image {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
            }
        } */
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
    <script src="app-assets/vendors/js/extensions/dragula.min.js"></script>
    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="app-assets/js/scripts/node_modules/dom-to-image/src/dom-to-image.js"></script>
    <script src="app-assets/fonts/fontawesome/js/all.js"></script>
    <script src="app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
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
            var // jqFormBooking = $('#booking-search-form'),
                jqFormManage = $('#boat-search-form'),
                jqFormBoat = $('#boat-form'),
                FormEdBoat = $('#edit-manage-form'),
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
                    static: true,
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
            FormEdBoat.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/order-boat/function/edit-manage-boat.php",
                    type: "POST",
                    data: serializedData + "&action=edit",
                    success: function(response) {
                        // console.log(response);
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
                e.preventDefault();
            });

            jqFormBoat.on("submit", function(e) {
                var action = ($('#manage_id').val() !== '' && $('#manage_id').val() > 0) ? 'edit' : 'create';
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/order-boat/function/" + action + "-boat.php",
                    type: "POST",
                    data: serializedData + "&action=" + action + "&travel_date=" + $('#date_travel_booking').val(),
                    success: function(response) {
                        // console.log(response);
                        if (action === 'create' && response != false) {
                            // $('#modal-boat').modal('hide');
                            // $('#modal-booking').modal('show');
                            // var res = $.parseJSON(response);
                            // search_booking('next', res.travel_date, res.id);
                            location.reload(); // refresh page
                        } else if (action === 'edit' && response != false) {
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
                url: "pages/order-boat/function/search-report.php",
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
            window.location.search = "?pages=order-boat/manage&date_travel_booking=" + date;
        }

        // function checkbox(type) {
        //     var checkbox_all = type == 'booking' ? document.getElementById('checkbo_all').checked : document.getElementById('checkmanage_all').checked;
        //     var checkbox = type == 'booking' ? document.getElementsByClassName('checkbox-bookings') : document.getElementsByClassName('checkbox-manage');

        //     if (checkbox_all == true && checkbox.length > 0) {
        //         for (let index = 0; index < checkbox.length; index++) {
        //             checkbox[index].checked = true;
        //         }
        //     } else if (checkbox_all == false && checkbox.length > 0) {
        //         for (let index = 0; index < checkbox.length; index++) {
        //             checkbox[index].checked = false;
        //         }
        //     }

        //     sum_checkbox();
        // }

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
            var bookings = document.getElementsByClassName('checkbox-bookings');
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
            document.getElementById('booking-true').innerHTML = sum_true;
            document.getElementById('booking-false').innerHTML = sum_false;
            document.getElementById('toc-true').innerHTML = sum_toc_true;
            document.getElementById('toc-false').innerHTML = sum_toc_false;
            document.getElementById('adult-sum').innerHTML = adult_sum;
            document.getElementById('child-sum').innerHTML = child_sum;
            document.getElementById('infant-sum').innerHTML = infant_sum;
            document.getElementById('foc-sum').innerHTML = foc_sum;
        }

        function search_booking(type, travel_date, manage_id) {
            // get data
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('travel_date', String(travel_date));
            formData.append('manage_id', manage_id);
            formData.append('type', type);
            $.ajax({
                url: "pages/order-boat/function/search-manage-booking.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
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

        function modal_boat(travel_date, manage_id, i) {
            document.getElementById('text-travel-date').innerHTML = '<b>' + travel_date + '</b>';

            if (manage_id > 0) {
                var arr_mange = document.getElementById('arr_mange' + manage_id).value;
                var res = $.parseJSON(arr_mange);

                document.getElementById('manage_id').value = res.id[i];
                // document.getElementById('programe').value = res.product_id[i];
                // document.getElementById('guide').value = res.guide[i];
                document.getElementById('time').value = res.time[i];
                document.getElementById('color').value = res.color_id[i];
                // document.getElementById('captains').value = res.captain_id[i];
                document.getElementById('guides').value = res.guide_id[i];
                // document.getElementById('crew_first').value = res.crewf_id[i];
                // document.getElementById('crew_second').value = res.crews_id[i];
                document.getElementById('note').value = res.note[i];
                document.getElementById('counter').value = res.counter[i];
                document.getElementById('outside_boat').value = res.outside_boat[i];

                // $("#programe").val(res.product_id[i]).trigger("change");
                $("#color").val(res.color_id[i]).trigger("change");
                // $("#captains").val(res.captain_id[i]).trigger("change");
                $("#guides").val(res.guide_id[i]).trigger("change");
                // $("#crew_first").val(res.crewf_id[i]).trigger("change");
                // $("#crew_second").val(res.crews_id[i]).trigger("change");

                // document.getElementById('programe').disabled = true;
                document.getElementById('delete_manage').disabled = false;
                check_boat(res.boat_id[i] != 0 ? res.boat_id[i] : "outside");
            } else {
                // document.getElementById('programe').disabled = false;
                document.getElementById('delete_manage').disabled = true;
                // document.getElementById('frm-boats').hidden = false;
                // document.getElementById('frm-boats-outside').hidden = true;
                // document.getElementById('frm-captain').hidden = false;
                // document.getElementById('frm-captain-outside').hidden = true;
                document.getElementById('frm-guide').hidden = false;
                document.getElementById('frm-guide-outside').hidden = true;
                // document.getElementById('frm-crew-first').hidden = false;
                // document.getElementById('frm-crew-first-outside').hidden = true;
                // document.getElementById('frm-crew-second').hidden = false;
                // document.getElementById('frm-crew-second-outside').hidden = true;
                document.getElementById('boat-form').reset();
                check_boat(0);
            }
        }

        function modal_customers(manage_id, travel_date, boat_name) {
            // document.getElementById('text-prak').innerHTML = park_name;
            document.getElementById('text-travel-customer').innerHTML = travel_date;
            // document.getElementById('text-programe').innerHTML = programe_name;
            document.getElementById('text-boat').innerHTML = boat_name;
            if (manage_id > 0) {
                var customers = document.getElementById('customers' + manage_id).value;
                var res = $.parseJSON(customers);
                var count = Object.keys(res.id).length;
                var text_table = '';
                var adult = 0;
                var child = 0;
                var infant = 0;
                var foc = 0;
                if (count > 0) {
                    for (let index = 0; index < count; index++) {
                        adult = res.age[index] == 1 ? Number(adult + 1) : Number(adult);
                        child = res.age[index] == 2 ? Number(child + 1) : Number(child);
                        infant = res.age[index] == 3 ? Number(infant + 1) : Number(infant);
                        foc = res.age[index] == 4 ? Number(foc + 1) : Number(foc);

                        text_table += '<tr>';
                        text_table += '<td class="text-center">' + res.age_name[index] + '</td>';
                        text_table += '<td>' + res.name[index] + '</td>';
                        text_table += '<td class="text-center">' + res.voucher_no[index] + '</td>';
                        text_table += '<td class="text-center">' + res.nation[index] + '</td>';
                        text_table += '<td class="text-center">' + res.birth[index] + '</td>';
                        text_table += '</tr>';
                    }
                    text_table += '<tr>';
                    text_table += '<td class="text-center" colspan="5">TOTAL ' + Number(adult + child + infant + foc) + ' PAX | A ' + Number(adult) + ' | C ' + Number(child) + ' | INF ' + Number(infant) + ' | FOC ' + Number(foc) + '</td>';
                    text_table += '</tr>';
                }
                document.getElementById('table-tbody-customers').innerHTML = text_table;
                document.getElementById('print-customer').href += "&manage_id=" + manage_id;
                document.getElementById('excel-customer').href += "&manage_id=" + manage_id;
            }
        }

        function submit_booking_manage(type, manage_id) {
            var bo_id = document.getElementsByName('bo_id[]');
            var manage_bo = document.getElementsByName('manage_bo[]');
            var before = (document.getElementById('before_managebo')) ? document.getElementById('before_managebo') : '';
            var booking = [];
            var bo_manage = [];
            if (bo_id) {
                for (let index = 0; index < bo_id.length; index++) {
                    if (bo_id[index].checked == true) {
                        booking.push(bo_id[index].value);
                    }
                }
            }
            if (manage_bo) {
                for (let index = 0; index < manage_bo.length; index++) {
                    if (manage_bo[index].checked == true) {
                        bo_manage.push(manage_bo[index].value);
                    }
                }
            }

            if (manage_id > 0) {
                var formData = new FormData();
                formData.append('action', 'create');
                formData.append('manage_id', manage_id);
                formData.append('booking', JSON.stringify(booking));
                formData.append('manage_bo', JSON.stringify(bo_manage));
                formData.append('before', before.value);
                $.ajax({
                    url: "pages/order-boat/function/create_booking_manage.php",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        // console.log(response);
                        if (response != false && response > 0) {
                            Swal.fire({
                                title: "The information has been updated.",
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
            } else if (type == 'next' && booking == '') {
                Swal.fire({
                    title: "The information has been updated.",
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

        function check_boat(boat_id) {
            var array_boat = document.getElementById('array_boat').value;

            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('arr_boats', array_boat);
            formData.append('boat_id', boat_id);
            formData.append('travel_date', $('#date_travel_booking').val());
            $.ajax({
                url: "pages/order-boat/function/search-boat.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    // console.log(response);
                    if (response != '' && response != false) {
                        $('#boats').find('option').remove();
                        var res = $.parseJSON(response);
                        var countprod = Object.keys(res.id).length;
                        $('#boats').append("<option value=\"\">กรุญาเลือกเรือ...</option>");
                        selected = (boat_id !== undefined && boat_id == 'outside') ? 'selected' : '';
                        $('#boats').append("<option value=\"outside\" " + selected + ">กรอกข้อมูลเพิ่มเติม</option>");
                        if (countprod) {
                            for (let index = 0; index < countprod; index++) {
                                selected = (boat_id !== undefined && res.id[index] == boat_id) ? 'selected' : '';
                                $('#boats').append("<option value=\"" + res.id[index] + "\" data-name=\"" + res.name[index] + " (" + res.refcode[index] + ")\" " + selected + ">" + res.name[index] + " (" + res.refcode[index] + ")</option>");
                            }
                        }
                        if (boat_id !== undefined && boat_id == 'outside') {
                            check_outside('boat');
                        }
                    }
                }
            });
        }

        function chang_color(type) {
            var color = $('#color').find(':selected').attr('data-color');
            document.getElementById('div-color').style.background = color;
        }

        function modal_manage_boat(boat_id, bo_id, bo_mange_id, mange_id) {
            var array_boat = document.getElementById('array_boat').value;
            document.getElementById('bo_mange_id').value = typeof bo_mange_id !== undefined ? bo_mange_id : 0;
            document.getElementById('edit_bo_id').value = typeof bo_id !== undefined ? bo_id : 0;
            document.getElementById('brfore_manage_id').value = typeof mange_id !== undefined ? mange_id : 0;
            if (array_boat !== '') {
                $('#edit_manage').find('option').remove();
                $('#edit_manage').append("<option value=\"\">กรุญาเลือกเรือ...</option>");
                var res = $.parseJSON(array_boat);
                var count = Object.keys(res.id).length;
                if (count) {
                    for (let index = 0; index < count; index++) {
                        // if (boat_id == res.boat_id[index]) {
                        selected = (mange_id !== undefined && res.mange_id[index] == mange_id) ? 'selected' : '';
                        name_boat = (res.refcode[index] !== '') ? res.name[index] + " (" + res.refcode[index] + ")" : res.name[index];
                        $('#edit_manage').append("<option value=\"" + res.mange_id[index] + "\" " + selected + ">" + name_boat + "</option>");
                        // }
                    }
                }
                $('#edit_manage').append("<option value=\"0\" >ไม่มีการจัดเรือ</option>");
            } else {
                $('#edit_manage').find('option').remove();
                $('#edit_manage').append("<option value=\"\">กรุญาเลือกเรือ...</option>");
            }
        }

        function delete_boat() {
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
                        url: "pages/order-boat/function/delete-manage.php",
                        type: "POST",
                        data: {
                            manage_id: manage_id.value,
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
                                    location.reload();
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

        function check_outside(params) {
            if (typeof params !== undefined && params == 'boats' && document.getElementById('boats').value == 'outside') {
                document.getElementById('frm-boats').hidden = true;
                document.getElementById('frm-boats-outside').hidden = false;
            } else if (typeof params !== undefined && params == 'outside_boat') {
                document.getElementById('frm-boats-outside').hidden = true;
                document.getElementById('frm-boats').hidden = false;
            } else if (typeof params !== undefined && params == 'captains' && document.getElementById('captains').value == 'outside') {
                document.getElementById('frm-captain').hidden = true;
                document.getElementById('frm-captain-outside').hidden = false;
            } else if (typeof params !== undefined && params == 'outside_captain') {
                document.getElementById('frm-captain').hidden = false;
                document.getElementById('frm-captain-outside').hidden = true;
            } else if (typeof params !== undefined && params == 'guides' && document.getElementById('guides').value == 'outside') {
                document.getElementById('frm-guide').hidden = true;
                document.getElementById('frm-guide-outside').hidden = false;
            } else if (typeof params !== undefined && params == 'outside_guide') {
                document.getElementById('frm-guide').hidden = false;
                document.getElementById('frm-guide-outside').hidden = true;
            } else if (typeof params !== undefined && params == 'crew_first' && document.getElementById('crew_first').value == 'outside') {
                document.getElementById('frm-crew-first').hidden = true;
                document.getElementById('frm-crew-first-outside').hidden = false;
            } else if (typeof params !== undefined && params == 'outside_crew_first') {
                document.getElementById('frm-crew-first').hidden = false;
                document.getElementById('frm-crew-first-outside').hidden = true;
            } else if (typeof params !== undefined && params == 'crew_second' && document.getElementById('crew_second').value == 'outside') {
                document.getElementById('frm-crew-second').hidden = true;
                document.getElementById('frm-crew-second-outside').hidden = false;
            } else if (typeof params !== undefined && params == 'outside_crew_second') {
                document.getElementById('frm-crew-second').hidden = false;
                document.getElementById('frm-crew-second-outside').hidden = true;
            }
        }

        function download_image(type) {
            var img_name = type == 'customers' ? document.getElementById('customer_img').value : document.getElementById('name_img').value;
            var node = type == 'customers' ? document.getElementById('div-park-job-image') : document.getElementById('div-boat-job-image');
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
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Booking - <?php echo $main_title; ?></title>
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
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/fontawesome/css/all.css" rel="stylesheet">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

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
    <script src="app-assets/fonts/fontawesome/js/all.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
    <script src="app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
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
    $columntarget = $_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2 ? '5, 6' : '5';
    ?>

    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
        // Ajax Delete Booking
        // --------------------------------------------------------------------
        function deleteBooking(booking_id) {
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
                        url: "pages/booking/function/delete.php",
                        type: "POST",
                        data: {
                            booking_id: booking_id,
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
                                    location.href = './?pages=booking/list';
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
            $('.booking-list-table').DataTable({
                "searching": false,
                order: [
                    // [4, 'desc']
                ],
                dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                    '<"col-lg-12 col-xl-6" l>' +
                    '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                    '>t' +
                    '<"d-flex justify-content-between mx-2 row mb-1"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                columnDefs: [{
                    // targets: [<?php echo $columntarget; ?>],
                    orderable: false
                }],
                language: {
                    sLengthMenu: 'Show _MENU_'
                },
                // Buttons with Dropdown
                buttons: [],
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                },
            });

            var jqFormBooking = $('#booking-create-form'),
                jqForm = $('#booking-search-form'),
                picker = $('#dob'),
                dtPicker = $('#dob-bootstrap-val'),
                basicPickr = $('.flatpickr-basic'),
                pageBlockSpinner = $('.btn-page-block-spinner'),
                select = $('.select2');

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

            // Default
            if (basicPickr.length) {
                basicPickr.flatpickr({
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

            if ($('#search_travel').length) {
                $('#search_travel').flatpickr({
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

            $('.time-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    time: true,
                    timePattern: ['h', 'm']
                });
            });

            //Numeral
            $('.numeral-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            });

            $('.outside-text').on('click', function(e) {
                e.preventDefault();
                document.getElementById('frm-agent').hidden = false;
                document.getElementById('frm-agent-outside').hidden = true;

                $("#agent").val(0).trigger("change");
            });

            $('.extra-charge-repeater').repeater({
                show: function() {
                    $(this).slideDown();
                    $(this).find('[data-extra-repeater="select2"]').select2();
                    $('.numeral-mask').toArray().forEach(function(field) {
                        new Cleave(field, {
                            numeral: true,
                            numeralThousandsGroupStyle: 'thousand'
                        });
                    });

                    // Feather Icons
                    if (feather) {
                        feather.replace({
                            width: 14,
                            height: 14
                        });
                    }
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                ready: function() {
                    // Init select2
                    $('[data-extra-repeater="select2"]').select2();
                },
                isFirstItemUndeletable: false
            });

            // Ajax Search
            // --------------------------------------------------------------------
            jqForm.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/booking/function/search.php",
                    type: "POST",
                    data: serializedData + "&action=search",
                    success: function(response) {
                        if (response != false) {
                            $("#booking-search-table").html(response);

                            $('.booking-list-table').DataTable({
                                "searching": false,
                                order: [
                                    // [4, 'desc']
                                ],
                                dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                                    '<"col-lg-12 col-xl-6" l>' +
                                    '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                                    '>t' +
                                    '<"d-flex justify-content-between mx-2 row mb-1"' +
                                    '<"col-sm-12 col-md-6"i>' +
                                    '<"col-sm-12 col-md-6"p>' +
                                    '>',
                                columnDefs: [{
                                    // targets: [<?php echo $columntarget; ?>],
                                    orderable: false
                                }],
                                language: {
                                    sLengthMenu: 'Show _MENU_'
                                },
                                // Buttons with Dropdown
                                buttons: [],
                                language: {
                                    paginate: {
                                        // remove previous & next text from pagination
                                        previous: '&nbsp;',
                                        next: '&nbsp;'
                                    }
                                },
                            });

                            if (feather) {
                                feather.replace({
                                    width: 14,
                                    height: 14
                                });
                            }

                            search_start_date('custom', 'booking', $('#search_travel').val());
                        }
                    }
                });
                e.preventDefault();
            });

            if (jqFormBooking.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormBooking.validate({
                    rules: {
                        'product_id': {
                            required: true
                        },
                        'category_id[]': {
                            required: true
                        },
                        'agent': {
                            required: true
                        }
                    },
                    messages: {

                    },
                    submitHandler: function(form) {

                        $.blockUI({
                            message: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
                            css: {
                                backgroundColor: 'transparent',
                                border: '0'
                            },
                            overlayCSS: {
                                backgroundColor: '#fff',
                                opacity: 0.8
                            }
                        });

                        // update ajax request data
                        var formData = new FormData(form);
                        formData.append('action', 'create');
                        formData.append('quick', 1);
                        $.ajax({
                            url: "pages/booking/function/create.php",
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                // console.log(response);
                                if (response != false && response > 0) {
                                    Swal.fire({
                                        title: "The information has been added successfully.",
                                        icon: "success",
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            window.location.href = './?pages=booking/edit&id=' + response; // refresh page
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Please try again.",
                                        icon: "error",
                                    });
                                }
                            },
                            complete: function() {
                                $.unblockUI();
                            }
                        });
                    }
                });
            }

            $("#category_id").select2({
                maximumSelectionLength: 2
            });

            // search_start_date('today', 'boat', '');
            // search_start_date('tomorrow', 'boat', '');
            // search_start_date('today', 'driver', '');
            // search_start_date('tomorrow', 'driver', '');
            search_start_date('today', 'booking', '');
            search_start_date('tomorrow', 'booking', '');
            search_start_date('day3', 'booking', '<?php echo $day3; ?>');
            search_start_date('day4', 'booking', '<?php echo $day4; ?>');
            search_start_date('day5', 'booking', '<?php echo $day5; ?>');
            search_start_date('day6', 'booking', '<?php echo $day6; ?>');
            search_start_date('day7', 'booking', '<?php echo $day7; ?>');
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function search_form_report(search_travel) {
            // console.log(search_travel)
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('search_travel', search_travel);
            $.ajax({
                url: "pages/booking/function/search.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != false) {
                        $("#booking-search-table").html(response);

                        $('.booking-list-table').DataTable({
                            "searching": false,
                            order: [
                                // [4, 'desc']
                            ],
                            dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                                '<"col-lg-12 col-xl-6" l>' +
                                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                                '>t' +
                                '<"d-flex justify-content-between mx-2 row mb-1"' +
                                '<"col-sm-12 col-md-6"i>' +
                                '<"col-sm-12 col-md-6"p>' +
                                '>',
                            columnDefs: [{
                                // targets: [<?php echo $columntarget; ?>],
                                orderable: false
                            }],
                            language: {
                                sLengthMenu: 'Show _MENU_'
                            },
                            // Buttons with Dropdown
                            buttons: [],
                            language: {
                                paginate: {
                                    // remove previous & next text from pagination
                                    previous: '&nbsp;',
                                    next: '&nbsp;'
                                }
                            },
                        });

                        if (feather) {
                            feather.replace({
                                width: 14,
                                height: 14
                            });
                        }

                        search_start_date('custom', 'booking', $('#search_travel').val());
                    }
                }
            });
        }

        function search_start_date(type_date, type, date) {
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('type_date', type_date);
            formData.append('type', type);
            formData.append('date', date);
            $.ajax({
                url: "pages/booking/function/search-report.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != 'false' && type == 'boat') {
                        $('#boat-report-' + type_date).html(response);
                    } else if (response != 'false' && type == 'driver') {
                        $('#driver-report-' + type_date).html(response);
                    } else if (response != 'false' && type == 'booking') {
                        $('#' + type_date).html(response);
                    }
                }
            });
        }

        function check_time(params) {
            var hotel = params == 'zone_pickup' ? '#hotel_pickup' : '#hotel_dropoff';
            var zone_id = params == 'zone_pickup' ? document.getElementById('zone_pickup') : document.getElementById('zone_dropoff');
            var start_pickup = $('#zone_pickup').find(':selected').attr('data-start-pickup');
            var end_pickup = $('#zone_pickup').find(':selected').attr('data-end-pickup');
            document.getElementById('start_pickup').value = typeof start_pickup !== 'undefined' ? start_pickup : '00:00';
            document.getElementById('end_pickup').value = typeof end_pickup !== 'undefined' ? end_pickup : '00:00';

            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('zone_id', zone_id.value);
            $.ajax({
                url: "pages/booking/function/search-hotel.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    $(hotel).find('option').remove();
                    $(hotel).append("<option data-zone='0' value='0'>Please Select Hotel...</option>");
                    $(hotel).append("<option data-zone='0' value='outside'>กรอกข้อมูลเพิ่มเติม</option>");
                    if (response != '' && response != false) {
                        var res = $.parseJSON(response);
                        var count = Object.keys(res).length;
                        if (count) {
                            for (let index = 0; index < count; index++) {
                                $(hotel).append("<option value=\"" + res[index].id + "\">" + res[index].name + "</option>");
                            }
                        }
                    }
                }
            });

            // console.log($('#hotel_pickup').find('option[value="381"]'));
            // $('#hotel_pickup').find('option[value="381"]').prop('disabled', true);
            // $('#hotel_pickup').find('option[value="381"]').css("display","none");
            // $('#hotel_pickup').find('option[value="381"]').hide();
        }

        function search_program() {
            var open_rates = document.getElementById('open-rates').value;
            var book_type = document.getElementById('book_type1').checked == true ? 1 : 2;
            var agent = document.getElementById('agent').value;
            var product_id = document.getElementById('product_id').value;

            document.getElementById('frm-agent').hidden = agent !== 'outside' ? false : true;
            document.getElementById('frm-agent-outside').hidden = agent !== 'outside' ? true : false;

            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('prod_id', product_id);
            $.ajax({
                url: "pages/booking/function/search-category.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != '' && response != false) {
                        $('#category_id').find('option').remove();
                        var res = $.parseJSON(response);
                        var countcate = Object.keys(res.id).length;
                        if (countcate) {
                            for (let index = 0; index < countcate; index++) {
                                $('#category_id').append("<option value=\"" + res.id[index] + "\" data-transfer=\"" + res.transfer[index] + "\" data-customer=\"" + res.customer[index] + "\">" + res.name[index] + "</option>");
                            }
                        } else {
                            $('#category_id').append("<option value=\"0\" data-transfer=\"0\" data-customer=\"0\"></option>");
                        }

                        check_category();
                    }
                }
            });
        }

        function check_category() {
            var book_type = document.getElementsByName('booking_type')[0].checked == true ? 1 : 2;
            var agent = document.getElementById('agent').value;
            var product_id = document.getElementById('product_id').value;
            var travel_date = document.getElementById('travel_date').value;

            const selectElement = document.getElementById('category_id');
            const selectedOptions = Array.from(selectElement.selectedOptions);

            let showThai = false;
            let showForeign = false;
            let transfer = false;

            selectedOptions.forEach(option => {
                const dataCustomer = option.getAttribute('data-customer');
                const dataTransfer = option.getAttribute('data-transfer');
                transfer = dataTransfer == 1 ? true : false;
                if (dataCustomer == 1) {
                    showThai = true;
                    var formData = new FormData();
                    formData.append('action', 'search');
                    formData.append('agent_id', agent);
                    formData.append('product_id', product_id);
                    formData.append('category_id', option.value);
                    formData.append('travel_date', travel_date);
                    formData.append('book_type', book_type);
                    formData.append('dataCustomer', dataCustomer);
                    $.ajax({
                        url: "pages/booking/function/search-rate.php",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function(response) {
                            if (response != '' && response != false) {
                                document.getElementById('div-thai').innerHTML = response;
                                check_rate();
                            }
                        }
                    });
                }
                if (dataCustomer == 2) {
                    showForeign = true;
                    var formData = new FormData();
                    formData.append('action', 'search');
                    formData.append('agent_id', agent);
                    formData.append('product_id', product_id);
                    formData.append('category_id', option.value);
                    formData.append('travel_date', travel_date);
                    formData.append('book_type', book_type);
                    formData.append('dataCustomer', dataCustomer);
                    $.ajax({
                        url: "pages/booking/function/search-rate.php",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function(response) {
                            if (response != '' && response != false) {
                                document.getElementById('div-foreign').innerHTML = response;
                                check_rate();
                            }
                        }
                    });
                }
            });

            document.getElementById('div-thai').hidden = !showThai;
            document.getElementById('div-foreign').hidden = !showForeign;
            document.getElementById('customer_thai').value = !showThai == false ? 1 : 0;
            document.getElementById('customer_foreign').value = !showForeign == false ? 1 : 0;

            document.getElementById('div-transfer').hidden = (transfer == false) ? true : false;
            document.getElementById('start_pickup').value = (transfer == true) ? '08:15' : '';
            document.getElementById('end_pickup').value = (transfer == true) ? '08:15' : '';
            document.getElementById('include').value = (transfer === true) ? '1' : '2';
        }

        function check_rate() {
            let total_thai = 0;
            let total_foreign = 0;
            let amount = 0;

            const book_type = document.getElementById('book_type1').checked ? 1 : 2;

            // ฟังก์ชันย่อยสำหรับคำนวณยอดรวม
            function calculateTotal(adult, child, infant, rateAdult, rateChild, rateInfant, privateRates, bookType) {
                if (bookType === 1) {
                    return (
                        parseFloat(rateAdult) * parseInt(adult || 0) +
                        parseFloat(rateChild) * parseInt(child || 0) +
                        parseFloat(rateInfant) * parseInt(infant || 0)
                    );
                } else {
                    return parseFloat(privateRates || 0);
                }
            }

            // คำนวณสำหรับ Thai
            if (document.getElementById('customer_thai').value == 1) {
                const adult = document.getElementById('adult_thai')?.value || 0;
                const child = document.getElementById('child_thai')?.value || 0;
                const infant = document.getElementById('infant_thai')?.value || 0;

                const rateAdult = document.getElementById('rate_adult_thai')?.value.replace(/,/g, '') || 0;
                const rateChild = document.getElementById('rate_child_thai')?.value.replace(/,/g, '') || 0;
                const rateInfant = document.getElementById('rate_infant_thai')?.value.replace(/,/g, '') || 0;
                const privateRates = book_type == 2 ? document.getElementById('private_rates_thai')?.value.replace(/,/g, '') || 0 : 0;

                total_thai = calculateTotal(adult, child, infant, rateAdult, rateChild, rateInfant, privateRates, book_type);
                document.getElementById('rate_total_thai') && (document.getElementById('rate_total_thai').value = total_thai);
            }

            // คำนวณสำหรับ Foreign
            if (document.getElementById('customer_foreign').value == 1) {
                const adult = document.getElementById('adult_foreign')?.value || 0;
                const child = document.getElementById('child_foreign')?.value || 0;
                const infant = document.getElementById('infant_foreign')?.value || 0;

                const rateAdult = document.getElementById('rate_adult_foreign')?.value.replace(/,/g, '') || 0;
                const rateChild = document.getElementById('rate_child_foreign')?.value.replace(/,/g, '') || 0;
                const rateInfant = document.getElementById('rate_infant_foreign')?.value.replace(/,/g, '') || 0;
                const privateRates = book_type == 2 ? document.getElementById('private_rates_foreign')?.value.replace(/,/g, '') || 0 : 0;

                total_foreign = calculateTotal(adult, child, infant, rateAdult, rateChild, rateInfant, privateRates, book_type);
                document.getElementById('rate_total_foreign') && (document.getElementById('rate_total_foreign').value = total_foreign);
            }

            // คำนวณยอดรวม
            amount = total_thai + total_foreign;
            document.getElementById('rate_total').value = amount;
            document.getElementById('text-total-price').innerHTML = numberWithCommas(amount);
        }

        // function check_time() {
        //     var product_id = document.getElementById('product_id').value;
        //     var zone_id = document.getElementById('zone_pickup').value;

        //     var formData = new FormData();
        //     formData.append('action', 'search');
        //     formData.append('product_id', product_id);
        //     formData.append('zone_id', zone_id);
        //     $.ajax({
        //         url: "pages/booking/function/search-time-zone.php",
        //         type: "POST",
        //         processData: false,
        //         contentType: false,
        //         data: formData,
        //         success: function(response) {
        //             var res = $.parseJSON(response);
        //             document.getElementById('start_pickup').value = res.start_pickup;
        //             document.getElementById('end_pickup').value = res.end_pickup;
        //             // $(hotel).find('option').remove();
        //             // $(hotel).append("<option data-zone='0' value='0'>Please Select Hotel...</option>");
        //             // $(hotel).append("<option data-zone='0' value='outside'>กรอกข้อมูลเพิ่มเติม</option>");
        //             // if (response != '' && response != false) {
        //             //     var res = $.parseJSON(response);
        //             //     var count = Object.keys(res).length;
        //             //     if (count) {
        //             //         for (let index = 0; index < count; index++) {
        //             //             $(hotel).append("<option value=\"" + res[index].id + "\">" + res[index].name + "</option>");
        //             //         }
        //             //     }
        //             // }
        //         }
        //     });
        // }

        function check_outside(params) {
            return false; // ปิดการใช้งาน
            if (typeof params !== undefined && params == 'hotel_pickup' && document.getElementById('hotel_pickup').value == 'outside') {
                document.getElementById('frm-hotel-pickup').hidden = true;
                document.getElementById('frm-hotel-outside').hidden = false;
            } else if (typeof params !== undefined && params == 'hotel_outside') {
                document.getElementById('frm-hotel-outside').hidden = true;
                document.getElementById('frm-hotel-pickup').hidden = false;
            } else if (typeof params !== undefined && params == 'hotel_dropoff' && document.getElementById('hotel_dropoff').value == 'outside') {
                document.getElementById('frm-dropoff').hidden = true;
                document.getElementById('frm-dropoff-outside').hidden = false;
            } else if (typeof params !== undefined && params == 'dropoff_outside') {
                document.getElementById('frm-dropoff').hidden = false;
                document.getElementById('frm-dropoff-outside').hidden = true;
            }
        }

        function check_no_agent(voucher_no) {
            var agent = document.getElementById('agent');

            var formData = new FormData();
            formData.append('action', 'check');
            formData.append('agent', agent.value);
            formData.append('voucher_no', voucher_no.value);
            $.ajax({
                url: "pages/booking/function/check-voucher-no.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    document.getElementById("invalid-voucher-no").style.display = (response > 0) ? "block" : "none";
                }
            });
        }

        function accordion_check(type) {
            var accordion = type == 'note' ? document.getElementById('accordionOne') : document.getElementById('accordionTwo');
            if (accordion.classList[3] !== 'hidden') {
                accordion.classList.remove("show");
                accordion.classList.add("hidden");
            } else {
                accordion.classList.remove("hidden");
                accordion.classList.add("show");
            }
        }

        function rows_customer() {
            var adult = 0;
            var child = 0;
            var infant = 0;
            var foc = 0;
            // คำนวณสำหรับ Thai
            if (document.getElementById('customer_thai').value == 1) {
                adult = Number(adult) + Number(document.getElementById('adult_thai')?.value || 0);
                child = Number(child) + Number(document.getElementById('child_thai')?.value || 0);
                infant = Number(infant) + Number(document.getElementById('infant_thai')?.value || 0);
                foc = Number(foc) + Number(document.getElementById('foc_thai')?.value || 0);
            }
            // คำนวณสำหรับ Foreign
            if (document.getElementById('customer_foreign').value == 1) {
                adult = Number(adult) + Number(document.getElementById('adult_foreign')?.value || 0);
                child = Number(child) + Number(document.getElementById('child_foreign')?.value || 0);
                infant = Number(infant) + Number(document.getElementById('infant_foreign')?.value || 0);
                foc = Number(foc) + Number(document.getElementById('foc_foreign')?.value || 0);
            }
            var sum = Number(adult) + Number(child) + Number(infant) + Number(foc);
            var frm = document.getElementById('frm-customer');
            var text = '';
            var text_age = '';
            var cus_age = 0;
            for (let index = 0; index < sum; index++) {
                // console.log(adult.value + ' | ' + child.value + ' | ' + infant.value + ' | ' + foc.value + ' | ' + Number(index + 1));
                if ((Number(adult) - Number(index + 1)) >= 0) {
                    text_age = 'Adult';
                    cus_age = 1;
                } else if (((Number(adult) + Number(child)) - Number(index + 1)) >= 0) {
                    text_age = 'Children';
                    cus_age = 2;
                } else if (((Number(adult) + Number(child) + Number(infant)) - Number(index + 1)) >= 0) {
                    text_age = 'Infant';
                    cus_age = 3;
                } else {
                    text_age = 'FOC';
                    cus_age = 4;
                }

                var head = index == 0 ? 1 : 0;

                text += '<div class="col-md-1 col-12">' +
                    '<div class="form-group pt-2">' +
                    '<strong>' + text_age + '</strong>' +
                    '<input type="hidden" name="customers[head][]" value="' + head + '" />' +
                    '<input type="hidden" name="customers[cus_age][]" value="' + cus_age + '" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2 col-12">' +
                    '<div class="form-group">' +
                    '<label for="id_card">ID Passport/ ID Card</label>' +
                    '<input type="text" class="form-control" name="customers[id_card][]" value="" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-4 col-12">' +
                    '<div class="form-group">' +
                    '<label for="name">Name</label>' +
                    '<input type="text" class="form-control" name="customers[cus_name][]" value="" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2 col-12">' +
                    '<div class="form-group">' +
                    '<label for="birth_date">Birth Date</label>' +
                    '<input type="date" class="form-control birth-date" name="customers[cus_birth_date][]" value="" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3 col-12">' +
                    '<div class="form-group">' +
                    '<label for="nationality_id">Nationality</label>' +
                    '<select class="form-control nationality" id="customers' + index + '" name="customers[cus_nationality_id][]">' +
                    '<option value="0">Please Select Nationality...</option>' +
                    <?php
                    $nations = $bookObj->shownation();
                    foreach ($nations as $nation) {
                    ?> '<option value="<?php echo $nation['id']; ?>" ';
                text += '><?php echo $nation['name']; ?></option>' +
                <?php
                    }
                ?> '</select>' +
                '</div>' +
                '</div>';
            }

            frm.innerHTML = text;

            // select2
            $('.nationality').each(function() {
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

            check_rate();
        }

        // Script Function Extra Charge
        // ------------------------------------------------------------------------------------
        function chang_extra_charge(select) {
            if (select.value > 0) {
                var ex_name = select.name.replace('[extra_charge]', '[extc_name]');
                document.getElementsByName(ex_name)[0].readOnly = select.value != 0 ? true : false;

                var ex_inp_ad = select.name.replace('[extra_charge]', '[extra_rate_adult]');
                var extar_ad = document.getElementById('extar_ad' + select.value).value;
                document.getElementsByName(ex_inp_ad)[0].value = numberWithCommas(extar_ad);

                var ex_inp_chd = select.name.replace('[extra_charge]', '[extra_rate_child]');
                var extar_chd = document.getElementById('extar_chd' + select.value).value;
                document.getElementsByName(ex_inp_chd)[0].value = numberWithCommas(extar_chd);

                var ex_inp_inf = select.name.replace('[extra_charge]', '[extra_rate_infant]');
                var extar_inf = document.getElementById('extar_inf' + select.value).value;
                document.getElementsByName(ex_inp_inf)[0].value = numberWithCommas(extar_inf);

                var ex_inp_total = select.name.replace('[extra_charge]', '[extra_rate_private]');
                var extar_total = document.getElementById('extar_total' + select.value).value;
                document.getElementsByName(ex_inp_total)[0].value = numberWithCommas(extar_total);
            }
        }

        function check_extar_type(select) {
            var adult = Number(0);
            var child = Number(0);
            var infant = Number(0);

            // Thai
            if (document.getElementById('customer_thai').value == 1) {
                adult = Number(document.getElementById('adult_thai')?.value) + adult || adult;
                child = Number(document.getElementById('child_thai')?.value) + child || child;
                infant = Number(document.getElementById('infant_thai')?.value) + infant || infant;
            }

            // Foreign
            if (document.getElementById('customer_foreign').value == 1) {
                adult = Number(document.getElementById('adult_foreign')?.value) + adult || adult;
                child = Number(document.getElementById('child_foreign')?.value) + child || child;
                infant = Number(document.getElementById('infant_foreign')?.value) + infant || infant;
            }

            var div_name_perpax = select.name.replace('[extra_type]', '[div_extar_perpax]');
            document.getElementsByName(div_name_perpax)[0].hidden = select.value == 1 ? false : true;
            document.getElementsByName(div_name_perpax)[1].hidden = select.value == 1 ? false : true;
            document.getElementsByName(div_name_perpax)[2].hidden = select.value == 1 ? false : true;

            var extra_adult = select.name.replace('[extra_type]', '[extra_adult]');
            document.getElementsByName(extra_adult)[0].value = adult;
            var extra_child = select.name.replace('[extra_type]', '[extra_child]');
            document.getElementsByName(extra_child)[0].value = child;
            var extra_infant = select.name.replace('[extra_type]', '[extra_infant]');
            document.getElementsByName(extra_infant)[0].value = infant;

            var div_name_total = select.name.replace('[extra_type]', '[div_extar_total]');
            document.getElementsByName(div_name_total)[0].hidden = select.value == 2 ? false : true;

            checke_rate_extar();
        }

        function checke_rate_extar() {
            var $div = $('div[id^="div-extra-charge"]');
            for (let index = 0; index < $div.length; index++) {
                var total = 0;
                var extra_type = document.getElementsByName('extra-charge[' + index + '][extra_type]');

                var adult = document.getElementsByName('extra-charge[' + index + '][extra_adult]');
                var rate_adult = document.getElementsByName('extra-charge[' + index + '][extra_rate_adult]');
                var child = document.getElementsByName('extra-charge[' + index + '][extra_child]');
                var rate_child = document.getElementsByName('extra-charge[' + index + '][extra_rate_child]');
                var infant = document.getElementsByName('extra-charge[' + index + '][extra_infant]');
                var rate_infant = document.getElementsByName('extra-charge[' + index + '][extra_rate_infant]');
                var ex_total = document.getElementsByName('extra-charge[' + index + '][extra_num_private]');
                var rate_total = document.getElementsByName('extra-charge[' + index + '][extra_rate_private]');

                total = extra_type[0].value != 0 ? extra_type[0].value == 2 ? Number(ex_total[0].value * rate_total[0].value.replace(/,/g, '')) : Number((adult[0].value * rate_adult[0].value.replace(/,/g, '')) + (child[0].value * rate_child[0].value.replace(/,/g, '')) + (infant[0].value * rate_infant[0].value.replace(/,/g, ''))) : 0;
                document.getElementsByName('extra-charge[' + index + '][extc_total]')[0].innerHTML = numberWithCommas(total);
            }
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
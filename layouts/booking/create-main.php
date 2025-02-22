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
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
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
    <script src="app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
    <script src="app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
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

    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
        $(document).ready(function() {
            var jqFormBooking = $('#booking-create-form'),
                picker = $('#dob'),
                dtPicker = $('#travel_date'),
                timePickr = $('.flatpickr-time'),
                horizontalWizard = document.querySelector('.horizontal-wizard-example'),
                select = $('.select2'),
                pageBlockSpinner = $('.btn-page-block-spinner'),
                touchspin = $('.touchspin');

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

            // Start time
            if (timePickr.length) {
                timePickr.flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    time_24hr: true
                    // defaultDate: "07:00"
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
                    },
                    static: true,
                    altInput: true,
                    altFormat: 'j F Y',
                    dateFormat: 'Y-m-d',
                    defaultDate: 'today'
                });
            }

            // Time
            $('.time-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    time: true,
                    timePattern: ['h', 'm']
                });
            });

            // Default Spin
            touchspin.TouchSpin({
                buttondown_class: 'btn btn-primary',
                buttonup_class: 'btn btn-primary',
                buttondown_txt: feather.icons['minus'].toSvg(),
                buttonup_txt: feather.icons['plus'].toSvg()
            });

            // form repeater jquery
            $('.itinerary-repeater').repeater({
                show: function() {
                    $(this).slideDown();

                    $(this).find('[data-itinerary-repeater="select2"]').select2();

                    // $(this).find('[data-extra-repeater="datepicker"]').flatpickr();

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
                    $('[data-itinerary-repeater="select2"]').select2();
                    // $('[data-extra-repeater="datepicker"]').flatpickr();
                },
                isFirstItemUndeletable: true
            });

            $('.extra-charge-repeater').repeater({
                show: function() {
                    $(this).slideDown();

                    $(this).find('[data-extra-repeater="select2"]').select2();

                    // $(this).find('[data-extra-repeater="datepicker"]').flatpickr();

                    // new Tagify(this.querySelector('[data-extra-repeater="tagify"]'));

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

                    // Init flatpickr
                    // $('[data-extra-repeater="datepicker"]').flatpickr();

                    // Init Tagify
                    // new Tagify(document.querySelector('[data-extra-repeater="tagify"]'));
                },
                isFirstItemUndeletable: true
            });

            $('.payments-repeater').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();

                    $(this).find('[data-payments-repeater="select2"]').select2();

                    $(this).find('[data-payments-repeater="datepicker"]').flatpickr({
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

                    $(this).find('[data-payments-repeater="numeral-mask"]').toArray().forEach(function(field) {
                        new Cleave(field, {
                            numeral: true,
                            numeralThousandsGroupStyle: 'thousand'
                        });
                    });

                    // new Tagify(this.querySelector('[data-transfer-repeater="tagify"]'));
                    this.querySelector('[data-div-payments="account"]').hidden = true;
                    this.querySelector('[data-div-payments="card"]').hidden = true;

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
                    $('[data-payments-repeater="select2"]').select2();

                    // Init flatpickr
                    $('[data-payments-repeater="datepicker"]').flatpickr({
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

                    $('[data-payments-repeater="numeral-mask"]').toArray().forEach(function(field) {
                        new Cleave(field, {
                            numeral: true,
                            numeralThousandsGroupStyle: 'thousand'
                        });
                    });

                    // Init Tagify
                    // new Tagify(document.querySelector('[data-transfer-repeater="tagify"]'));
                },
                isFirstItemUndeletable: false
            });

            // Horizontal Wizard
            // --------------------------------------------------------------------
            if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
                var numberedStepper = new Stepper(horizontalWizard),
                    $form = $(horizontalWizard).find('form');
                $form.each(function() {
                    var $this = $(this);

                    $.validator.addMethod("regex", function(value, element, regexp) {
                        return this.optional(element) || regexp.test(value);
                    }, "Please check your input.");

                    $this.validate({
                        rules: {}
                    });
                });

                $(horizontalWizard)
                    .find('.btn-next')
                    .each(function() {
                        $(this).on('click', function(e) {
                            var isValid = $(this).parent().siblings('form').valid();
                            if (isValid) {
                                numberedStepper.next();
                            } else {
                                e.preventDefault();
                            }
                        });
                    });

                $(horizontalWizard)
                    .find('.btn-prev')
                    .on('click', function() {
                        numberedStepper.previous();
                    });

                $(horizontalWizard)
                    .find('.btn-submit')
                    .on('click', function() {
                        var isValid = $(this).parent().siblings('form').valid();
                        var form = $(horizontalWizard).find('form');
                        var FormAppen = new FormData();
                        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                        var check = document.getElementById('doubly_agent').value;
                        if (form.length && check == 'true') {
                            for (let index = 0; index < form.length; index++) {
                                var form_index = document.getElementById(form[index]['id']);
                                var formData = new FormData(form_index);
                                for (var formElement of formData) {
                                    FormAppen.append(formElement[0], formElement[1]);
                                }
                            }
                            FormAppen.append('action', 'create');
                            $.ajax({
                                url: "pages/booking/function/create.php",
                                type: "POST",
                                processData: false,
                                contentType: false,
                                data: FormAppen,
                                success: function(response) {
                                    // $('#show-response').html(response);
                                    if (response != false && response > 0) {
                                        Swal.fire({
                                            title: "The information has been added successfully.",
                                            icon: "success",
                                        }).then(function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href = './?pages=booking/edit&id=' + response + '&action=details'; // refresh page
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
                        } else {
                            Swal.fire({
                                title: "เอเยนต์นี้มีในระบบแล้ว กรุณาลองใหม่!",
                                icon: "error",
                            });
                        }
                    });
            }

            if (jqFormBooking.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormBooking.validate({
                    rules: {
                        'product_id': {
                            required: true
                        },
                        'category_id': {
                            required: true
                        }
                    },
                    messages: {

                    },
                    submitHandler: function(form) {
                        // update ajax request data
                        var formData = new FormData(form);
                        formData.append('action', 'create');
                        $.ajax({
                            url: "pages/booking/function/create.php",
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                // $('#div-show').html(response);
                                if (response != false && response > 0) {
                                    Swal.fire({
                                        title: "The information has been updated.",
                                        icon: "success",
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            // window.location.href = './?pages=booking/list';
                                            window.location.href = './?pages=booking/edit&id=' + response; // refresh page
                                        }
                                    })
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

            check_date();
        });

        // Script Function Booking
        // ------------------------------------------------------------------------------------
        function check_hotel(type) {
            var hotel = document.getElementById('hotel_' + type);
            document.getElementById('hotel_' + type + '_outside').disabled = hotel.value > 0 ? true : false;
            if (type == 'pickup') {
                var zone = $('#hotel_pickup').find(':selected').attr('data-zone');
                document.getElementById('pickup').value = zone;
                $("#pickup").val(zone).trigger("change");
            }

            if (type == 'dropoff') {
                var zone = $('#hotel_dropoff').find(':selected').attr('data-zone');
                document.getElementById('dropoff').value = zone;
                $("#dropoff").val(zone).trigger("change");
            }
        }

        function check_time(type) {
            var start_pickup = $('#pickup').find(':selected').attr('data-start-pickup');
            var end_pickup = $('#pickup').find(':selected').attr('data-end-pickup');

            document.getElementById('start_pickup').value = typeof start_pickup !== 'undefined' ? start_pickup : '00:00';
            document.getElementById('end_pickup').value = typeof end_pickup !== 'undefined' ? end_pickup : '00:00';
        }

        // Script Function Program
        // ------------------------------------------------------------------------------------
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function check_date() {
            var bp_id = document.getElementById('bp_id').value;
            var travel_date = document.getElementById('travel_date').value;
            var book_type = document.getElementById('booktype_join').checked == true ? 1 : 2;
            var open_rates = document.getElementById('open-rates').value;
            document.getElementsByClassName('td-x')[0].hidden = (book_type == 1 && open_rates == 1) ? false : true;
            document.getElementsByClassName('td-x')[1].hidden = (book_type == 1 && open_rates == 1) ? false : true;
            document.getElementsByClassName('td-x')[2].hidden = (book_type == 1 && open_rates == 1) ? false : true;
            document.getElementById('td-adult').hidden = (book_type == 1 && open_rates == 1) ? false : true;
            document.getElementById('td-child').hidden = (book_type == 1 && open_rates == 1) ? false : true;
            document.getElementById('td-infant').hidden = (book_type == 1 && open_rates == 1) ? false : true;
            if (open_rates == 1) {
                document.getElementById('rate_total').readOnly = (book_type == 1) ? true : false;
            } else {
                document.getElementById('div-total').hidden = true;
            }

            if ($('#travel_date').length) {
                $('#travel_date').flatpickr({
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr('step', null);
                        }
                    },
                    static: true,
                    altInput: true,
                    altFormat: 'j F Y',
                    dateFormat: 'Y-m-d',
                    defaultDate: bp_id > 0 ? travel_date : 'today'
                });
            }

            if ($('#paid_date').length) {
                $('#paid_date').flatpickr({
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
            }

            search_program();
        }

        function search_program() {
            var product_id = document.getElementById('product_id').value;
            var agent = document.getElementById('agent').value;
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
                    // $('#div-show').html(response);
                    if (response != '' && response != false) {
                        $('#category_id').find('option').remove();
                        var res = $.parseJSON(response);
                        var countcate = Object.keys(res.id).length;
                        if (countcate) {
                            for (let index = 0; index < countcate; index++) {
                                $('#category_id').append("<option value=\"" + res.id[index] + "\">" + res.name[index] + "</option>");
                            }
                        } else {
                            $('#category_id').append("<option value=\"0\"></option>");
                        }

                        check_category();
                    }
                }
            });
        }

        function check_category() {
            var book_type = document.getElementById('booktype_join').checked == true ? 1 : 2;
            var category_id = document.getElementById('category_id').value;
            var agent = document.getElementById('agent').value;
            var travel_date = document.getElementById('travel_date').value;
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('agent_id', (agent !== 'outside') ? agent : 0);
            formData.append('category_id', category_id);
            formData.append('travel_date', travel_date);
            $.ajax({
                url: "pages/booking/function/search-rate.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response != '' && response != false) {
                        var res = $.parseJSON(response);
                        // console.log(res.prodrid);
                        if (book_type == 1) {
                            document.getElementById('pror_id').value = res.prodrid;
                            document.getElementById('rate_adult').value = res.rate_adult;
                            document.getElementById('rate_child').value = res.rate_child;
                            document.getElementById('rate_infant').value = res.rate_infant;
                        } else if (book_type == 2) {
                            document.getElementById('rate_total').value = res.rate_private;
                        }

                        check_rate();
                    }
                }
            });
        }

        function check_rate(type) {
            var product_id = document.getElementById('product_id');
            var category_id = document.getElementById('category_id');
            var book_type = document.getElementById('booktype_join').checked == true ? 1 : 2;
            /* Number of People */
            var adult = document.getElementById('adult');
            var child = document.getElementById('child');
            var infant = document.getElementById('infant');
            /* Rates Product (Join) */
            if (book_type == 1) {
                var rate_adult = document.getElementById('rate_adult').value.replace(/,/g, '');
                var rate_child = document.getElementById('rate_child').value.replace(/,/g, '');
                var rate_infant = document.getElementById('rate_infant').value.replace(/,/g, '');
            }
            /* default, total, edit Rates */
            var total_product = 0;
            var rate_total = document.getElementById('rate_total');
            /* Calculate Rates Product */
            if (book_type == 1) {
                total_product = Number(total_product) + Number(rate_adult) * Number(adult.value);
                total_product = Number(total_product) + Number(rate_child) * Number(child.value);
                total_product = Number(total_product) + Number(rate_infant) * Number(infant.value);
            } else {
                // total_product = typeof type !== 'undefined' ? Number(rate_total.value.replace(/,/g, '')) : Number(rate_default.value);
                total_product = Number(rate_total.value.replace(/,/g, ''));
            }
            /* Calculate Rates Total */
            rate_total.value = numberWithCommas(total_product);
        }

        function duplicate_pax() {
            var adult = document.getElementById('adult');
            var child = document.getElementById('child');
            var infant = document.getElementById('infant');
            var foc = document.getElementById('foc');

            document.getElementById('tran_adult_pax').value = adult.value;
            document.getElementById('tran_child_pax').value = child.value;
            document.getElementById('tran_infant_pax').value = infant.value;
            document.getElementById('tran_foc_pax').value = foc.value;

            check_rate();
        }

        // Script Function Transfer
        // ------------------------------------------------------------------------------------
        function check_pickup_type() {
            var type = document.getElementById('pickup_type_2');
            if (type.checked == true) {
                document.getElementById('transfer_type_join').checked = true;
                document.getElementById('div-transfer-type-form').hidden = true;
                document.getElementById('transfer_type_private').disabled = true;
                document.getElementById('tran_adult').hidden = true;
                document.getElementById('tran_child').hidden = true;
                document.getElementById('tran_infant').hidden = true;
            } else {
                document.getElementById('transfer_type_private').disabled = false;
                document.getElementById('tran_adult').hidden = false;
                document.getElementById('tran_child').hidden = false;
                document.getElementById('tran_infant').hidden = false;
            }
        }

        function check_transfer_type() {
            var transfer_join = document.getElementById('transfer_type_join');
            var div_transfer_type = document.getElementById('div-transfer-type-form');
            if (transfer_join.checked != true) {
                document.getElementsByName('td-transfer')[0].hidden = true;
                document.getElementsByName('td-transfer')[1].hidden = true;
                document.getElementsByName('td-transfer')[2].hidden = true;
                document.getElementsByName('td-transfer')[3].hidden = true;
                document.getElementsByName('td-transfer')[4].hidden = true;
                document.getElementsByName('td-transfer')[5].hidden = true;

                document.getElementById('tran_total_price').readOnly = false;
            } else {
                document.getElementsByName('td-transfer')[0].hidden = false;
                document.getElementsByName('td-transfer')[1].hidden = false;
                document.getElementsByName('td-transfer')[2].hidden = false;
                document.getElementsByName('td-transfer')[3].hidden = false;
                document.getElementsByName('td-transfer')[4].hidden = false;
                document.getElementsByName('td-transfer')[5].hidden = false;

                document.getElementById('tran_total_price').readOnly = true;
            }

            // check_rate_transfer();
        }

        function check_rate_transfer() {
            var type_id = document.getElementById('transfer_type_join').checked == true ? 1 : 2;
            /* Number of People */
            var adult = document.getElementById('tran_adult').value;
            var child = document.getElementById('tran_child').value;
            var infant = document.getElementById('tran_infant').value;
            adult = adult.replace(/,/g, '');
            child = child.replace(/,/g, '');
            infant = infant.replace(/,/g, '');
            /* Rate extra */
            var rate_adult = document.getElementById('tran_adult_pax').value;
            var rate_child = document.getElementById('tran_child_pax').value;
            var rate_infant = document.getElementById('tran_infant_pax').value;
            var tran_total_price = document.getElementById('tran_total_price');
            var total_price = 0;
            if (type_id == 1) {
                total_price = total_price + (Number(adult) * Number(rate_adult));
                total_price = total_price + (Number(child) * Number(rate_child));
                total_price = total_price + (Number(infant) * Number(rate_infant));
            } else {
                // var rate_arr = document.getElementsByName('array_rate_private[]');
                // for (let index = 0; index < rate_arr.length; index++) {
                //     total_price = total_price + (Number(rate_arr[index].value.replace(/,/g, '')));
                // }
                var arr_total = document.querySelectorAll("[data-car-total]");
                for (let index = 0; index < arr_total.length; index++) {
                    total_price = total_price + (Number(arr_total[index].value.replace(/,/g, '')));
                }
            }
            tran_total_price.value = numberWithCommas(total_price);
        }

        function check_time(params) {
            var zone_id = params == 'zone_pickup' ? document.getElementById('zone_pickup') : document.getElementById('zone_dropoff');
            var start_pickup = $('#zone_pickup').find(':selected').attr('data-start-pickup');
            var end_pickup = $('#zone_pickup').find(':selected').attr('data-end-pickup');
            document.getElementById('start_pickup').value = typeof start_pickup !== 'undefined' ? start_pickup : '00:00';
            document.getElementById('end_pickup').value = typeof end_pickup !== 'undefined' ? end_pickup : '00:00';
        }

        // Script Function Payment
        // ------------------------------------------------------------------------------------
        function check_payments_type(select) {
            // console.log(select.value);
            var div_account = select.name.replace('[payments_type]', '[div-bank-account]');
            var div_card = select.name.replace('[payments_type]', '[div-card]');
            // var payments_type = document.getElementById('payments_type').value;
            // document.getElementById('div-bank-account').hidden = select.value == 7 ? false : true;
            document.getElementsByName(div_account)[0].hidden = select.value == 7 ? false : true;
            document.getElementsByName(div_card)[0].hidden = select.value == 8 ? false : true;
            // document.getElementById('div-card-no').hidden = select.value == 8 ? false : true;
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
            var adult = document.getElementById('adult').value;
            var child = document.getElementById('child').value;
            var infant = document.getElementById('infant').value;

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
            // // get the last DIV which ID starts with ^= "another-participant"
            // var $div = $('div[id^="another-participant"]:last');
            // // Read the Number from that DIV's ID (i.e: 1 from "another-participant1")
            // // And increment that number by 1
            // var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;
            // // Clone it and assign the new ID (i.e: from num 4 to ID "another-participant4")
            // var $klon = $div.clone().prop('id', 'another-participant' + num);
            // // for each of the inputs inside the dive, clear it's value and 
            // // increment the number in the 'name' attribute by 1
            // $klon.find('input').each(function() {
            //     this.value = "";
            //     let name_number = this.name.match(/\d+/);
            //     name_number++;
            //     this.name = this.name.replace(/\[[0-9]\]+/, '[' + name_number + ']')
            // });
            // // Finally insert $klon after the last div
            // $div.after($klon);
            // console.log(document.getElementsByName('extra-charge').length);

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
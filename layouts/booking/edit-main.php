<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Booking -
        <?php echo $main_title; ?>
    </title>
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
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">
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

    <?php if ($_GET['action'] == "details") { ?>
        <script src="app-assets/vendors/js/forms/wizard/booking/bs-stepper-details.min.js"></script>
    <?php } else { ?>
        <script src="app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <?php } ?>

    <!-- BEGIN: Page Vendor JS-->
    <!-- <script src="app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script> -->
    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
    <script src="app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
    <script src="app-assets/fonts/fontawesome/js/all.js"></script>
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

    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
        // Ajax Delete Product
        // --------------------------------------------------------------------
        function deleteProduct() {
            var bp_id = document.getElementById('bp_id').value;
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
                        url: "pages/booking/function/delete-prod.php",
                        type: "POST",
                        data: {
                            bp_id: bp_id,
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
                                    // location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                                    <?php if (!empty($_GET['action'])) { ?>
                                        var set_location = window.location;
                                        var get_location = String(set_location).replace("&action=<?php echo $_GET['action']; ?>", "&action=product");
                                    <?php } else { ?>
                                        var get_location = window.location + '&action=product';
                                    <?php } ?>
                                    window.location.href = get_location;
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

        function deletePayment() {
            var paid_id = document.getElementById('paid_id').value;
            var paid_detail_id = document.getElementById('paid_detail_id').value;
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
                        url: "pages/booking/function/paid-delete.php",
                        type: "POST",
                        data: {
                            paid_id: paid_id,
                            paid_detail_id: paid_detail_id,
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
                                    // location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                                    <?php if (!empty($_GET['action'])) { ?>
                                        var set_location = window.location;
                                        var get_location = String(set_location).replace("&action=<?php echo $_GET['action']; ?>", "&action=product");
                                    <?php } else { ?>
                                        var get_location = window.location + '&action=product';
                                    <?php } ?>
                                    window.location.href = get_location;
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
            var jqFormBooking = $('#booking-edit-form'),
                jqFormInv = $('#invoice-form'),
                picker = $('#dob'),
                dtPicker = $('#dob-bootstrap-val'),
                timePickr = $('.flatpickr-time'),
                verticalWizard = document.querySelector('.vertical-wizard-example'),
                horizontalWizard = document.querySelector('.horizontal-wizard-example'),
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

            //Numeral
            $('.numeral-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            });

            $('.date-flatpickr').flatpickr({
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

            // Start time
            if (timePickr.length) {
                timePickr.flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    time_24hr: true,
                    static: true
                    // defaultDate: "07:00"
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

            // Default Spin
            $('.touchspin').TouchSpin({
                buttondown_class: 'btn btn-primary',
                buttonup_class: 'btn btn-primary',
                buttondown_txt: feather.icons['minus'].toSvg(),
                buttonup_txt: feather.icons['plus'].toSvg()
            });

            // Time
            $('.time-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    time: true,
                    timePattern: ['h', 'm']
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

                    check_start_extra();
                },
                isFirstItemUndeletable: false
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
                    this.querySelector('[class="d-flex align-items-center justify-content-center mt-2 mb-2"]').remove();

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
                var horizontalStepper = new Stepper(horizontalWizard, {
                    linear: false
                });
                $(horizontalWizard)
                    .find('.btn-next')
                    .on('click', function() {
                        horizontalStepper.next();
                    });
                $(horizontalWizard)
                    .find('.btn-prev')
                    .on('click', function() {
                        horizontalStepper.previous();
                    });

                $(horizontalWizard)
                // .find('.btn-submit')
                // .on('click', function() {
                //     alert('Submitted..!!');
                // });
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
                        'category_id[]': {
                            required: true
                        }
                    },
                    messages: {
                        // 'pax_group': {
                        //     regex: "This tat license is already taken! Try another."
                        // }
                    },
                    submitHandler: function(form) {
                        // update ajax request data
                        var formData = new FormData(form);
                        formData.append('action', 'edit');
                        $.ajax({
                            url: "pages/booking/function/edit.php",
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                // $('#div-show').html(response);
                                if (response != false && response > 0) {
                                    if ($('#bp_action').val() == 'create') {
                                        // sendline();
                                        Swal.fire({
                                            title: "The information has been updated.",
                                            icon: "success",
                                        }).then(function(isConfirm) {
                                            if (isConfirm) {
                                                // location.reload(); // refresh page
                                                window.location.href = window.location + "&action=details";
                                                // window.location.href = './?pages=booking/list';
                                            }
                                        })
                                    } else if ($('#search_travel').val() !== '' && $('#search_agent').val() !== '') {
                                        Swal.fire({
                                            title: "The information has been updated.",
                                            icon: "success",
                                        }).then(function(isConfirm) {
                                            if (isConfirm) {
                                                location.href = "./?pages=invoice/create&search_travel=" + $('#search_travel').val() + "&search_agent=" + $('#search_agent').val();
                                                // window.location.href = window.location + "&action=details";
                                            }
                                        })
                                    } else {
                                        Swal.fire({
                                            title: "The information has been updated.",
                                            icon: "success",
                                        }).then(function(isConfirm) {
                                            if (isConfirm) {
                                                // location.reload(); // refresh page
                                                window.location.href = window.location + "&action=details";
                                                // window.location.href = './?pages=booking/list';
                                            }
                                        });
                                    }
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
                        var action = $('#inv_id').val() > 0 ? 'edit' : 'create';
                        var formData = new FormData(form);
                        formData.append('action', action);
                        formData.append('bo_id', $('#bo_id').val());
                        $.ajax({
                            url: "pages/booking/function/" + action + "-invoice.php",
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

            $("#category_id").select2({
                maximumSelectionLength: 2
            });

            check_date();
            check_transfer_type();
            check_charge();
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        // Script Function Booking
        // ------------------------------------------------------------------------------------
        function check_charge() {
            document.getElementById('div-rates-charge').hidden = document.getElementById('book_status').value == 4 || status.value == 2 ? false : true;
        }

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

        // Script Function Program
        // ------------------------------------------------------------------------------------
        function check_date() {
            var bp_id = document.getElementById('bp_id').value;
            var travel_date = document.getElementById('travel_date').value;
            var book_type = document.getElementById('booktype1').checked == true ? 1 : 2;
            var open_rates = document.getElementById('open-rates').value;
            if (open_rates == 1) {
                document.getElementById('rate_total').hidden = (book_type == 1) ? true : false;
                document.getElementById('text-total-price').hidden = (book_type == 1) ? false : true;
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
            // check_payment();
        }

        function search_program() {
            var agent = document.getElementById('agent').value;
            document.getElementById('frm-agent').hidden = agent !== 'outside' ? false : true;
            document.getElementById('frm-agent-outside').hidden = agent !== 'outside' ? true : false;
            var product_id = document.getElementById('product_id').value;
            var cate_id = document.getElementById('cate_id').value;
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
                                var check_selected = (cate_id.includes(res.id[index]) == true) ? "selected" : "";
                                $('#category_id').append("<option value=\"" + res.id[index] + "\" data-transfer=\"" + res.transfer[index] + "\" data-customer=\"" + res.customer[index] + "\" " + check_selected + ">" + res.name[index] + "</option>");
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
            var book_type = document.getElementById('booktype1').checked == true ? 1 : 2;
            var agent = document.getElementById('agent').value;
            var product_id = document.getElementById('product_id').value;
            var travel_date = document.getElementById('travel_date').value;
            var bpr_array = document.getElementById('bpr_array').value;
            var res_bpr = bpr_array !== '' ? $.parseJSON(bpr_array) : 'undefined';

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

                                if (res_bpr !== '') {
                                    for (let index = 0; index < res_bpr['id'].length; index++) {
                                        if (res_bpr['customer'][index] == 1) {
                                            document.getElementById('bpr_thai_id').value = res_bpr['id'][index];
                                            document.getElementById('adult_thai').value = res_bpr['adult'][index];
                                            document.getElementById('child_thai').value = res_bpr['child'][index];
                                            document.getElementById('infant_thai').value = res_bpr['infant'][index];
                                            document.getElementById('foc_thai').value = res_bpr['foc'][index];
                                            if (book_type == 1) {
                                                document.getElementById('rate_adult_thai').value = res_bpr['rate_adult'][index];
                                                document.getElementById('rate_child_thai').value = res_bpr['rate_child'][index];
                                                document.getElementById('rate_infant_thai').value = res_bpr['rate_infant'][index];
                                            } else if (book_type == 2) {
                                                document.getElementById('private_rates_thai').value = res_bpr['rate_private'][index];
                                            }
                                        }
                                    }
                                }

                                rows_customer();
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

                                if (res_bpr !== '') {
                                    for (let index = 0; index < res_bpr['id'].length; index++) {
                                        if (res_bpr['customer'][index] == 2) {
                                            document.getElementById('bpr_foreign_id').value = res_bpr['id'][index];
                                            document.getElementById('adult_foreign').value = res_bpr['adult'][index];
                                            document.getElementById('child_foreign').value = res_bpr['child'][index];
                                            document.getElementById('infant_foreign').value = res_bpr['infant'][index];
                                            document.getElementById('foc_foreign').value = res_bpr['foc'][index];
                                            if (book_type == 1) {
                                                document.getElementById('rate_adult_foreign').value = res_bpr['rate_adult'][index];
                                                document.getElementById('rate_child_foreign').value = res_bpr['rate_child'][index];
                                                document.getElementById('rate_infant_foreign').value = res_bpr['rate_infant'][index];
                                            } else if (book_type == 2) {
                                                document.getElementById('private_rates_foreign').value = res_bpr['rate_private'][index];
                                            }
                                        }
                                    }
                                }

                                rows_customer();
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
        }

        // function search_program() {
        //     var agent = document.getElementById('agent').value;
        //     document.getElementById('frm-agent').hidden = agent !== 'outside' ? false : true;
        //     document.getElementById('frm-agent-outside').hidden = agent !== 'outside' ? true : false;
        //     var product_id = document.getElementById('product_id').value;
        //     var cate_id = document.getElementById('cate_id').value;
        //     var formData = new FormData();
        //     formData.append('action', 'search');
        //     formData.append('prod_id', product_id);
        //     $.ajax({
        //         url: "pages/booking/function/search-category.php",
        //         type: "POST",
        //         processData: false,
        //         contentType: false,
        //         data: formData,
        //         success: function(response) {
        //             // $('#div-show').html(response);
        //             if (response != '' && response != false) {
        //                 $('#category_id').find('option').remove();
        //                 var res = $.parseJSON(response);
        //                 var countcate = Object.keys(res.id).length;
        //                 if (countcate) {
        //                     for (let index = 0; index < countcate; index++) {
        //                         var check_selected = (cate_id.includes(res.id[index]) == true) ? "selected" : "";
        //                         $('#category_id').append("<option value=\"" + res.id[index] + "\" data-transfer=\"" + res.transfer[index] + "\" data-customer=\"" + res.customer[index] + "\" " + check_selected + ">" + res.name[index] + "</option>");
        //                     }
        //                 } else {
        //                     $('#category_id').append("<option value=\"0\" data-transfer=\"0\" data-customer=\"0\"></option>");
        //                 }

        //                 check_category();
        //             }
        //         }
        //     });
        // }


        // function check_category() {
        //     var bp_id = document.getElementById('bp_id').value;
        //     var book_type_id = document.getElementById('book_type_id').value;
        //     var book_type = document.getElementById('booktype1').checked == true ? 1 : 2;
        //     var category_id = document.getElementById('category_id').value;
        //     var cate_id = document.getElementById('cate_id').value;
        //     var agent = document.getElementById('agent').value;
        //     var agent_id = document.getElementById('agent_id').value;
        //     var travel_date = document.getElementById('travel_date').value;
        //     var travel = document.getElementById('travel').value;
        //     var formData = new FormData();
        //     formData.append('action', 'search');
        //     formData.append('agent_id', (agent !== 'outside') ? agent : 0);
        //     formData.append('category_id', category_id);
        //     formData.append('travel_date', travel_date);
        //     $.ajax({
        //         url: "pages/booking/function/search-rate.php",
        //         type: "POST",
        //         processData: false,
        //         contentType: false,
        //         data: formData,
        //         success: function(response) {
        //             if (response != '' && response != false) {
        //                 var res = $.parseJSON(response);
        //                 // console.log(res.prodrid);
        //                 if (book_type == 1) {
        //                     if (bp_id > 0 && travel == travel_date && category_id == cate_id && agent_id == agent && book_type_id == book_type) {
        //                         document.getElementById('pror_id').value = document.getElementById('prod_rate_id').value;
        //                         document.getElementById('rate_adult').value = document.getElementById('rate_ad').value;
        //                         document.getElementById('rate_child').value = document.getElementById('rate_chd').value;
        //                         document.getElementById('rate_infant').value = document.getElementById('rate_int').value;
        //                     } else {
        //                         document.getElementById('pror_id').value = res.prodrid;
        //                         document.getElementById('rate_adult').value = res.rate_adult;
        //                         document.getElementById('rate_child').value = res.rate_child;
        //                         document.getElementById('rate_infant').value = res.rate_infant;
        //                     }
        //                 } else if (book_type == 2) {
        //                     if (bp_id > 0 && travel == travel_date && category_id == cate_id && agent_id == agent && book_type_id == book_type) {
        //                         document.getElementById('rate_total').value = document.getElementById('rate_tt').value;
        //                     } else {
        //                         document.getElementById('rate_total').value = res.rate_private;
        //                     }
        //                 }

        //                 check_rate();
        //             }
        //         }
        //     });
        // }

        function rows_customer() {
            duplicate_pax();
        }

        function duplicate_pax() {
            var adult = Number(0);
            var child = Number(0);
            var infant = Number(0);
            var foc = Number(0);

            // Thai
            if (document.getElementById('customer_thai').value == 1) {
                adult = Number(document.getElementById('adult_thai')?.value) + adult || adult;
                child = Number(document.getElementById('child_thai')?.value) + child || child;
                infant = Number(document.getElementById('infant_thai')?.value) + infant || infant;
                foc = Number(document.getElementById('foc_thai')?.value) + foc || foc;
            }

            // Foreign
            if (document.getElementById('customer_foreign').value == 1) {
                adult = Number(document.getElementById('adult_foreign')?.value) + adult || adult;
                child = Number(document.getElementById('child_foreign')?.value) + child || child;
                infant = Number(document.getElementById('infant_foreign')?.value) + infant || infant;
                foc = Number(document.getElementById('foc_foreign')?.value) + foc || foc;
            }
            // console.log(adult + ' | '  + child + ' | '  + infant + ' | ' + foc);

            document.getElementById('tran_adult_pax').value = adult;
            document.getElementById('tran_child_pax').value = child;
            document.getElementById('tran_infant_pax').value = infant;
            document.getElementById('tran_foc_pax').value = foc;

            check_rate();
        }

        function check_booking_type() {
            var book_type = document.getElementById('booktype1').checked == true ? 1 : 2;
            document.getElementById('rate_total').readOnly = book_type == 1 ? true : false;
            document.getElementById('adult_pax').hidden = book_type == 1 ? true : false;
            document.getElementById('child_pax').hidden = book_type == 1 ? true : false;
            document.getElementById('infant_pax').hidden = book_type == 1 ? true : false;
        }

        function check_private_type() {
            var bp_id = document.getElementById('bp_id');
            if (bp_id.value == 0) {
                var private_type = document.getElementById('private_type_pax').checked == true ? 1 : 2;
            } else {
                var private_type = document.getElementById('private_type').value;
                document.getElementById('private_type_text').innerHTML = (private_type == 1) ? 'Per Pax' : 'Total';
            }
            document.getElementById('adult_pax').hidden = private_type == 1 ? false : true;
            document.getElementById('child_pax').hidden = private_type == 1 ? false : true;
            document.getElementById('infant_pax').hidden = private_type == 1 ? false : true;
            document.getElementById('rate_total').readOnly = private_type == 1 ? true : false;
            check_rate();
        }

        function check_date_agent() {
            var booking_type = document.getElementById('booktype1').checked == true ? 1 : 2;
            var bp_id = $('#bp_id').val();
            var product_id = bp_id > 0 ? $('#product_id').val() : 0;
            var formData = new FormData();
            formData.append('action', 'check');
            formData.append('bp_id', bp_id);
            formData.append('product_id', product_id);
            formData.append('booking_type', booking_type);
            formData.append('agent_id', $("#agent").val());
            formData.append('travel_date', $("#travel_date").val());
            $.ajax({
                url: "pages/booking/function/check-date.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    // $('#div-show').html(response);
                    $('#product_id').find('option').remove();
                    $('#div-data-category').html('');
                    if (response != '' && response != false) {
                        var check_id = [];
                        var res = $.parseJSON(response);
                        var count = Object.keys(res.prod_id).length
                        for (let index = 0; index <= count; index++) {
                            if (res.prod_id[index] != undefined && res.prod_id[index] > 0 && check_id.includes(res.prod_id[index]) == false) {
                                check_id.push(res.prod_id[index]);
                                $('#product_id').append("<option value=\"" + res.prod_id[index] + "\" data-bpr=\"" + res.bpr_id[index] + "\" data-seat=\"" + res.over_seat[index] + "\" data-name=\"" + res.prod_name[index] + "\">" + res.prod_name[index] + "</option>");
                            }
                            if (res.proca_id[index] != undefined && res.proca_id[index] > 0) {
                                $('#div-data-category').append("<input type=\"hidden\" id=\"data_category\" name=\"data_category" + res.prod_id[index] + "[]\" data-name=\"" + res.proca_name[index] + "\" data-period=\"" + res.prop_id[index] + "\" value=\"" + res.proca_id[index] + "\">");
                            }
                        }
                    } else {
                        $('#product_id').append("<option value=\"0\" data-bpr=\"0\" data-seat=\"0\" data-name=\"0\"></option>");
                    }

                    check_product();
                }
            });
        }

        function add_rate_pax(type) {
            // document.getElementById('div-transfer-type-form').hidden = private_type[0].checked == true ? true : false;
            var rate_pax = document.getElementById(type + '_pax').value;
            rate_pax = rate_pax.replace(/,/g, '');
            document.getElementById('rate_' + type).value = rate_pax;
            document.getElementById('rate_' + type + '_text').innerHTML = '(฿' + numberWithCommas(rate_pax) + ')';
            check_rate_transfer();
        }

        function check_rate() {
            let total_thai = 0;
            let total_foreign = 0;
            let amount = 0;

            const book_type = document.getElementById('booktype1').checked == true ? 1 : 2;

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

        // Script Function Payment
        // ------------------------------------------------------------------------------------
        function check_payments_type(select) {
            var div_account = select.name.replace('[payments_type]', '[div-bank-account]');
            var div_card = select.name.replace('[payments_type]', '[div-card]');
            document.getElementsByName(div_account)[0].hidden = select.value == 7 ? false : true;
            document.getElementsByName(div_card)[0].hidden = select.value == 8 ? false : true;
        }

        // Script Function Customer
        // ------------------------------------------------------------------------------------
        function modal_customer(type, num) {
            var head = [];
            var array_head = document.getElementsByName('array_head[]');
            if (array_head.length > 0) {
                for (let index = 0; index < array_head.length; index++) {
                    head.push(array_head[index].value);
                }
            }
            document.getElementById('div-head').hidden = (head.includes('1') == true) ? (type == 'edit' && $('#head_' + num).val() == 1) ? false : true : false;
            document.getElementById('head').checked = (head.includes('1') == true) ? (type == 'edit' && $('#head_' + num).val() == 1) ? true : false : false;
            document.getElementById('cus_action').value = type;
            document.getElementById('cus_i').value = typeof num !== 'undefined' ? num : '';
            document.getElementById('cus_id').value = type == 'edit' ? $('#cus_id_' + num).val() : 0;
            document.getElementById('id_card').value = type == 'edit' ? $('#id_card_' + num).val() : '';
            document.getElementById('cus_name').value = type == 'edit' ? $('#cus_name_' + num).val() : '';
            document.getElementById('birth_date').value = type == 'edit' ? $('#birth_date_' + num).val() : '';
            document.getElementById('nationality').value = type == 'edit' ? $('#nationality_' + num).val() : 0;
            document.getElementById('telephone').value = type == 'edit' ? $('#telephone_' + num).val() : '';
            document.getElementById('email').value = type == 'edit' ? $('#email_' + num).val() : '';
            document.getElementById('facebook').value = type == 'edit' ? $('#facebook_' + num).val() : '';
            document.getElementById('whatsapp').value = type == 'edit' ? $('#whatsapp_' + num).val() : '';
            document.getElementById('address').value = type == 'edit' ? $('#address_' + num).val() : '';
            document.getElementById('cus_name').classList.remove('error');
            document.getElementById('cus_name-error').hidden = true;

            var date = type == 'edit' ? $('#birth_date_' + num).val() : 'today';
            var nationality = type == 'edit' ? $('#nationality_' + num).val() : 0;
            $('#birth_date').flatpickr({
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.isMobile) {
                        $(instance.mobileInput).attr('step', null);
                    }
                },
                static: true,
                altInput: true,
                altFormat: 'j F Y',
                dateFormat: 'Y-m-d',
                defaultDate: date
            });

            $('#nationality').each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this
                    .select2({
                        placeholder: 'Select ...',
                        dropdownParent: $this.parent(),
                        'val': nationality
                    })
                    .change(function() {
                        $(this).valid();
                    })
            });
        }

        function add_customer(type, num) {
            var cus_i = type != 'deleted' ? document.getElementById('cus_i').value : num;
            var cus_action = type != 'deleted' ? document.getElementById('cus_action').value : type;
            var cus_no = document.getElementById('cus_no');

            if (cus_action == 'add') {
                cus_no.value = Number(cus_no.value) + 1;
                var href = 'data-toggle="modal" data-target="#modal-customer" onclick="modal_customer(\'edit\', ' + cus_no.value + ');" style="color:#6E6B7B"';
                var head = document.getElementById('head').checked == true ? 1 : 0;
                var id_card = document.getElementById('id_card');
                var cus_name = document.getElementById('cus_name');
                var birth_date = document.getElementById('birth_date');
                var nationality = document.getElementById('nationality');
                var nation_name = typeof $('#nationality').find(':selected').attr('data-name') != 'undefined' ? $('#nationality').find(':selected').attr('data-name') : '';
                var telephone = document.getElementById('telephone');
                var email = document.getElementById('email');
                var facebook = document.getElementById('facebook');
                var whatsapp = document.getElementById('whatsapp');
                var address = document.getElementById('address');

                if (cus_name.value == '') {
                    cus_name.classList.add('error');
                    document.getElementById('cus_name-error').hidden = false;
                    return false;
                }

                $('#tbody-customer').append("<tr id=\"tr-" + cus_no.value + "\">" +
                    "<td> <a href=\"javascript:void(0);\" " + href + "> <span id=\"text_id_card_" + cus_no.value + "\">" + id_card.value + "</span></a>" +
                    "<input type=\"hidden\" id=\"id_card_" + cus_no.value + "\" name=\"array_id_card[]\" value=\"" + id_card.value + "\">" +
                    "</td>" +
                    "<td> <a href=\"javascript:void(0);\" " + href + "> <span id=\"text_cus_name_" + cus_no.value + "\">" + cus_name.value + "</span></a>" +
                    "<input type=\"hidden\" id=\"cus_name_" + cus_no.value + "\" name=\"array_cus_name[]\" value=\"" + cus_name.value + "\">" +
                    "</td>" +
                    "<td> <a href=\"javascript:void(0);\" " + href + "> <span id=\"text_telephone_" + cus_no.value + "\">" + telephone.value + "</span></a>" +
                    "<input type=\"hidden\" id=\"telephone_" + cus_no.value + "\" name=\"array_telephone[]\" value=\"" + telephone.value + "\">" +
                    "</td>" +
                    "<td> <a href=\"javascript:void(0);\" " + href + "> <span id=\"text_email_" + cus_no.value + "\">" + email.value + "</span></a>" +
                    "<input type=\"hidden\" id=\"email_" + cus_no.value + "\" name=\"array_email[]\" value=\"" + email.value + "\">" +
                    "</td>" +
                    "<td> <a href=\"javascript:void(0);\" " + href + "> <span id=\"text_nationality_" + cus_no.value + "\">" + nation_name + "</span></a>" +
                    "<input type=\"hidden\" id=\"nationality_" + cus_no.value + "\" name=\"array_nationality[]\" value=\"" + nationality.value + "\">" +
                    "</td>" +
                    "<td> <a href=\"javascript:void(0);\" " + href + "> <span id=\"text_whatsapp_" + cus_no.value + "\">" + whatsapp.value + "</span></a>" +
                    "<input type=\"hidden\" id=\"whatsapp_" + cus_no.value + "\" name=\"array_whatsapp[]\" value=\"" + whatsapp.value + "\">" +
                    "</td>" +
                    "<td class=\"text-center\">" +
                    "<a href=\"javascript:void(0);\" onclick=\"add_customer('deleted', " + cus_no.value + ");\">" +
                    "<i class=\"fas fa-times\" class=\"mr-50\"></i>" +
                    "</a>" +
                    "<input type=\"hidden\" id=\"cus_id_" + cus_no.value + "\" name=\"array_id[]\" value=\"0\">" +
                    "<input type=\"hidden\" id=\"head_" + cus_no.value + "\" name=\"array_head[]\" value=\"" + head + "\">" +
                    "<input type=\"hidden\" id=\"facebook_" + cus_no.value + "\" name=\"array_facebook[]\" value=\"" + facebook.value + "\">" +
                    "<input type=\"hidden\" id=\"birth_date_" + cus_no.value + "\" name=\"array_birth_date[]\" value=\"" + birth_date.value + "\">" +
                    "<textarea cols=\"30\" rows=\"1\" id=\"address_" + cus_no.value + "\" name=\"array_address[]\" hidden>" + address.value + "</textarea>" +
                    "</td>" +
                    "</tr>"
                );

                $('#modal-customer').modal('hide');
            }

            if (cus_action == 'edit') {
                document.getElementById('text_id_card_' + cus_i).innerHTML = document.getElementById('id_card').value;
                document.getElementById('id_card_' + cus_i).value = document.getElementById('id_card').value;
                document.getElementById('text_cus_name_' + cus_i).innerHTML = document.getElementById('cus_name').value;
                document.getElementById('cus_name_' + cus_i).value = document.getElementById('cus_name').value;
                document.getElementById('text_telephone_' + cus_i).innerHTML = document.getElementById('telephone').value;
                document.getElementById('telephone_' + cus_i).value = document.getElementById('telephone').value;
                document.getElementById('text_email_' + cus_i).innerHTML = document.getElementById('email').value;
                document.getElementById('email_' + cus_i).value = document.getElementById('email').value;
                document.getElementById('text_nationality_' + cus_i).innerHTML = $('#nationality').find(':selected').attr('data-name') != 'undefined' ? $('#nationality').find(':selected').attr('data-name') : '';
                document.getElementById('nationality_' + cus_i).value = document.getElementById('nationality').value;
                document.getElementById('text_whatsapp_' + cus_i).innerHTML = document.getElementById('whatsapp').value;
                document.getElementById('whatsapp_' + cus_i).value = document.getElementById('whatsapp').value;
                document.getElementById('head_' + cus_i).value = document.getElementById('head').checked == true ? 1 : 0;
                document.getElementById('facebook_' + cus_i).value = document.getElementById('facebook').value;
                document.getElementById('birth_date_' + cus_i).value = document.getElementById('birth_date').value;
                document.getElementById('address_' + cus_i).value = document.getElementById('address').value;

                $('#modal-customer').modal('hide');
            }

            if (cus_action == 'deleted') {
                cus_no.value = Number(cus_no.value) - 1;
                $('table#table-customer tr#tr-' + num).remove();
            }

        }

        // Script Function Transfer
        // ------------------------------------------------------------------------------------
        function modal_car(type, num) {
            document.getElementById('car_action').value = type;
            document.getElementById('car_i').value = typeof num !== 'undefined' ? num : '';
            document.getElementById('cars_category').value = type == 'edit' ? $('#car_' + num).val() : '';
            document.getElementById('rate_private').value = type == 'edit' ? $('#rate_private_' + num).val() : 0;
            document.getElementById('cars_category').classList.remove('error');
            document.getElementById('cars_category-error').hidden = true;

            var cars_category = type == 'edit' ? $('#car_' + num).val() : 0;
            $('#cars_category').each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this
                    .select2({
                        placeholder: 'Select ...',
                        dropdownParent: $this.parent(),
                        'val': cars_category
                    })
                    .change(function() {
                        $(this).valid();
                    })
            });
        }

        function add_car(type, num) {
            var car_i = type != 'deleted' ? document.getElementById('car_i').value : num;
            var car_action = type != 'deleted' ? document.getElementById('car_action').value : type;
            var car_no = document.getElementById('car_no');

            if (car_action == 'add') {
                car_no.value = Number(car_no.value) + 1;
                var href = 'data-toggle="modal" data-target="#modal-car" onclick="modal_car(\'edit\', ' + car_no.value + ');" style="color:#6E6B7B"';
                var cars_category = document.getElementById('cars_category');
                var rate_private = document.getElementById('rate_private');

                if (cars_category.value == '') {
                    cars_category.classList.add('error');
                    document.getElementById('cars_category-error').hidden = false;
                    return false;
                }

                $('#tbody-car').append("<tr id=\"tr-" + car_no.value + "\">" +
                    "<td> <a href=\"javascript:void(0);\" " + href + "> <span id=\"text_car_" + car_no.value + "\">" + $('#cars_category').find(':selected').attr('data-name') + "</span></a>" +
                    "<input type=\"hidden\" id=\"car_" + car_no.value + "\" name=\"array_car[]\" value=\"" + cars_category.value + "\">" +
                    "</td>" +
                    "<td> <a href=\"javascript:void(0);\" " + href + "> <span id=\"text_rate_private_" + car_no.value + "\">" + rate_private.value + "</span></a>" +
                    "<input type=\"hidden\" id=\"rate_private_" + car_no.value + "\" name=\"array_rate_private[]\" value=\"" + rate_private.value + "\">" +
                    "</td>" +
                    "<td>" +
                    "<a href=\"javascript:void(0);\" onclick=\"add_car('deleted', " + car_no.value + ");\">" +
                    "<i class=\"fas fa-times\" class=\"mr-50\"></i>" +
                    "</a>" +
                    "<input type=\"hidden\" id=\"btr_id_" + car_no.value + "\" name=\"array_btr_id[]\" value=\"0\">" +
                    "</td>" +
                    "</tr>"
                );
                $('#modal-car').modal('hide');
            }

            if (car_action == 'edit') {
                document.getElementById('text_car_' + car_i).innerHTML = $('#cars_category').find(':selected').attr('data-name');
                document.getElementById('car_' + car_i).value = document.getElementById('cars_category').value;
                document.getElementById('text_rate_private_' + car_i).innerHTML = document.getElementById('rate_private').value;
                document.getElementById('rate_private_' + car_i).value = document.getElementById('rate_private').value;

                $('#modal-car').modal('hide');
            }

            if (type == 'deleted') {
                car_no.value = Number(car_no.value) - 1;
                $('table#table-cars tr#tr-' + num).remove();
            }

            check_rate_transfer();
        }

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
            // var transfer_join = document.getElementById('transfer_type_join');
            // var div_transfer_type = document.getElementById('div-transfer-type-form');
            // if (transfer_join.checked != true) {
            //     document.getElementsByName('td-transfer')[0].hidden = true;
            //     document.getElementsByName('td-transfer')[1].hidden = true;
            //     document.getElementsByName('td-transfer')[2].hidden = true;
            //     document.getElementsByName('td-transfer')[3].hidden = true;
            //     document.getElementsByName('td-transfer')[4].hidden = true;
            //     document.getElementsByName('td-transfer')[5].hidden = true;

            //     document.getElementById('tran_total_price').readOnly = false;
            // } else {
            //     document.getElementsByName('td-transfer')[0].hidden = false;
            //     document.getElementsByName('td-transfer')[1].hidden = false;
            //     document.getElementsByName('td-transfer')[2].hidden = false;
            //     document.getElementsByName('td-transfer')[3].hidden = false;
            //     document.getElementsByName('td-transfer')[4].hidden = false;
            //     document.getElementsByName('td-transfer')[5].hidden = false;

            //     document.getElementById('tran_total_price').readOnly = true;
            // }

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

        // Script Function Extra Charge
        // ------------------------------------------------------------------------------------
        function check_start_extra() {
            var $div = $('div[id^="div-start-extra-charge"]');
            for (let index = 0; index < $div.length; index++) {
                var extra_charge = document.getElementsByName('extra-charge[' + index + '][extra_charge]')[0].value;
                var extra_type = document.getElementsByName('extra-charge[' + index + '][extra_type]')[0].value;
                // readOnly Name
                document.getElementsByName('extra-charge[' + index + '][extc_name]')[0].readOnly = extra_charge != 0 ? true : false;
                // hidden perpax or private
                document.getElementsByName('extra-charge[' + index + '][div_extar_perpax]')[0].hidden = extra_type == 1 ? false : true;
                document.getElementsByName('extra-charge[' + index + '][div_extar_perpax]')[1].hidden = extra_type == 1 ? false : true;
                document.getElementsByName('extra-charge[' + index + '][div_extar_perpax]')[2].hidden = extra_type == 1 ? false : true;

                document.getElementsByName('extra-charge[' + index + '][div_extar_total]')[0].hidden = extra_type == 2 ? false : true;
            }
            if ($div.length > 0) {
                checke_rate_extar();
            }
        }

        function chang_extra_charge(select) {
            // console.log(select.value);
            if (select.value > 0) {
                var ex_name = select.name.replace('[extra_charge]', '[extc_name]');
                document.getElementsByName(ex_name)[0].readOnly = select.value != 0 ? true : false;
                if (select.value != 0) {
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
            checke_rate_extar();
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
        }

        function checke_rate_extar() {
            var $start = $('div[id^="div-start-extra-charge"]');
            if ($start.length > 0) {
                for (let index = 0; index < $start.length; index++) {
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

            var $div = $('div[id^="div-extra-charge"]');
            if ($div.length > 0) {
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
        }


        function modal_add_invoice() {
            var inv_id = document.getElementById('inv_id').value;
            if (inv_id > 0) {
                check_diff_date();
                calculator_price();
            }
        }

        function check_diff_date() {
            var today = document.getElementById('today').value;
            var rec_date = document.getElementById('rec_date').value;
            const date1 = new Date(today);
            const date2 = new Date(rec_date);
            const diffTime = date2.getTime() - date1.getTime();
            const diffDays = diffTime / (1000 * 60 * 60 * 24);
            var days = diffDays <= 0 ? '' : "อีก " + diffDays + " วัน";
            $('#diff_rec_date').html(days);
        }

        function calculator_price() {
            let checked = $(".dt-checkboxes:checked");
            var vat_total = 0;
            var vat_cut = 0;
            var withholding_total = 0;
            var total = 0;
            var price_amount = document.getElementById('price-amount');
            var vat = document.getElementById('vat');
            var withholding = document.getElementById('withholding');
            var price_withholding = document.getElementById('price-withholding');
            var price_total = document.getElementById('price_total');
            var tr_vat = document.getElementById('tr-vat');
            var vat_text = document.getElementById('vat-text');
            var price_vat = document.getElementById('price-vat');
            var tr_withholding = document.getElementById('tr-withholding');
            var withholding_text = document.getElementById('withholding-text');
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
            price_amount.innerHTML = Number(total).toLocaleString("en-US", {
                maximumFractionDigits: 2
            });
            amount.value = total;
        }

        function download_image(type) {
            switch (type) {
                case 'voucher':
                    var img_name = document.getElementById('booking_full').value;
                    var node = document.getElementById('div-inc-print');
                    break;
            }
            domtoimage.toJpeg(node, {
                    quality: 0.99
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
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Tour - <?php echo $main_title; ?></title>
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
        <script src="app-assets/vendors/js/forms/wizard/tour/bs-stepper-details.min.js"></script>
    <?php } ?>

    <?php if ($_GET['action'] == "itinerary") { ?>
        <script src="app-assets/vendors/js/forms/wizard/tour/bs-stepper-itinerary.min.js"></script>
    <?php } ?>

    <?php if ($_GET['action'] == "images") { ?>
        <script src="app-assets/vendors/js/forms/wizard/tour/bs-stepper-images.min.js"></script>
    <?php } ?>

    <?php if ($_GET['action'] == "photo") { ?>
        <script src="app-assets/vendors/js/forms/wizard/tour/bs-stepper-photo.min.js"></script>
    <?php } ?>

    <?php if ($_GET['action'] == "period") { ?>
        <script src="app-assets/vendors/js/forms/wizard/tour/bs-stepper-period.min.js"></script>
    <?php } ?>

    <?php if ($_GET['action'] == "rates") { ?>
        <script src="app-assets/vendors/js/forms/wizard/tour/bs-stepper-rates.min.js"></script>
    <?php } ?>

    <?php if ($_GET['action'] == "category") { ?>
        <script src="app-assets/vendors/js/forms/wizard/tour/bs-stepper-category.min.js"></script>
    <?php } ?>

    <?php if ($_GET['action'] == "allotm") { ?>
        <script src="app-assets/vendors/js/forms/wizard/tour/bs-stepper-allotm.min.js"></script>
    <?php } ?>

    <?php if (empty($_GET['action'])) { ?>
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
        function deleteProduct(product_id) {
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
                        url: "pages/tour/function/delete.php",
                        type: "POST",
                        data: {
                            product_id: product_id,
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
                                    location.href = './?pages=tour/list';
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
            var jqFormDetail = $('#product-detail-edit-form'),
                jqFormPeriod = $('#product-period-form'),
                jqFormRates = $('#product-rates-form'),
                jqFormCategory = $('#product-category-form'),
                jqFormRatesTrans = $('#product-rates-transfer-form'),
                jqFormTimeZone = $('#time-zone-form'),
                picker = $('#dob'),
                allotm_from_date = $('#allotm_from_date'),
                allotm_to_date = $('#allotm_to_date'),
                dtPicker = $('#dob-bootstrap-val'),
                timePickr = $('.flatpickr-time'),
                bsStepper = document.querySelectorAll('.bs-stepper'),
                verticalWizard = document.querySelector('.vertical-wizard-example'),
                select = $('.select2'),
                horizontalWizard = document.querySelector('.horizontal-wizard-example');

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

                // $(horizontalWizard)
                //     .find('.btn-submit')
                //     .on('click', function() {
                //         alert('Submitted..!!');
                //     });
            }

            // Adds crossed class
            if (typeof bsStepper !== undefined && bsStepper !== null) {
                for (var el = 0; el < bsStepper.length; ++el) {
                    bsStepper[el].addEventListener('show.bs-stepper', function(event) {
                        var index = event.detail.indexStep;
                        var numberOfSteps = $(event.target).find('.step').length - 1;
                        var line = $(event.target).find('.step');

                        // The first for loop is for increasing the steps,
                        // the second is for turning them off when going back
                        // and the third with the if statement because the last line
                        // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

                        for (var i = 0; i < index; i++) {
                            line[i].classList.add('crossed');

                            for (var j = index; j < numberOfSteps; j++) {
                                line[j].classList.remove('crossed');
                            }
                        }
                        if (event.detail.to == 0) {
                            for (var k = index; k < numberOfSteps; k++) {
                                line[k].classList.remove('crossed');
                            }
                            line[0].classList.remove('crossed');
                        }
                    });
                }
            }

            //Numeral
            $('.numeral-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
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

            // Time
            $('.time-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    time: true,
                    timePattern: ['h', 'm']
                });
            });

            // picker from date (on change)
            $('#allotm_from_date').on('change', function() {
                $('#allotm_to_date').flatpickr({
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr('step', null);
                        }
                    },
                    static: true,
                    altInput: true,
                    altFormat: 'j F Y',
                    dateFormat: 'Y-m-d',
                    minDate: this.value,
                    defaultDate: $('#allotm_from_date').val()
                });
            });

            // picker end date (on change)
            $('#allotm_from_date, #allotm_to_date').on('change', function() {
                check_allotm();
            });

            // picker from date (on change)
            $('#period_from_date').on('change', function() {
                $('#period_to_date').flatpickr({
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr('step', null);
                        }
                    },
                    static: true,
                    altInput: true,
                    altFormat: 'j F Y',
                    dateFormat: 'Y-m-d',
                    minDate: this.value,
                    defaultDate: $('#period_from_date').val()
                });
                check_period();
            });

            // picker to date (on change)
            $('#period_to_date').on('change', function() {
                check_period();
            });

            // form repeater jquery
            $('.itinerary-repeater, .repeater-default').repeater({
                show: function() {
                    $(this).slideDown();
                    // Feather Icons
                    if (feather) {
                        feather.replace({
                            width: 14,
                            height: 14
                        });
                    }
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: true
            });

            // Default Spin
            $('.touchspin').TouchSpin({
                buttondown_class: 'btn btn-primary',
                buttonup_class: 'btn btn-primary',
                buttondown_txt: feather.icons['minus'].toSvg(),
                buttonup_txt: feather.icons['plus'].toSvg()
            });

            // Spin Min - Max
            var touchspinValue = $('.touchspin-min-max'),
                counterMin = 1,
                counterMax = 15;
            if (touchspinValue.length > 0) {
                touchspinValue
                    .TouchSpin({
                        min: counterMin,
                        max: counterMax,
                        buttondown_txt: feather.icons['minus'].toSvg(),
                        buttonup_txt: feather.icons['plus'].toSvg()
                    })
                    .on('touchspin.on.startdownspin', function() {
                        var $this = $(this);
                        $('.bootstrap-touchspin-up').removeClass('disabled-max-min');
                        if ($this.val() == counterMin) {
                            $(this).siblings().find('.bootstrap-touchspin-down').addClass('disabled-max-min');
                        }
                    })
                    .on('touchspin.on.startupspin', function() {
                        var $this = $(this);
                        $('.bootstrap-touchspin-down').removeClass('disabled-max-min');
                        if ($this.val() == counterMax) {
                            $(this).siblings().find('.bootstrap-touchspin-up').addClass('disabled-max-min');
                        }
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

            // jQuery Validation
            // --------------------------------------------------------------------
            if (jqFormDetail.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");


                jqFormDetail.validate({
                    rules: {
                        'name': {
                            required: true
                        }
                    },
                    submitHandler: function(form) {
                        // update ajax request data
                        var formData = new FormData(form);
                        formData.append('action', 'edit');

                        $.ajax({
                            url: "pages/tour/function/edit.php",
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                // alert(response);
                                // $('#div-test').html(response);
                                if (response != false && response > 0) {
                                    Swal.fire({
                                        title: "The information has been updated.",
                                        icon: "success",
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            location.reload(); // refresh page

                                            //     <?php //if (!empty($_GET['action'])) { 
                                                    ?>
                                            //         var set_location = window.location;
                                            //         var get_location = String(set_location).replace("&action=<?php //echo $_GET['action']; 
                                                                                                                ?>", "&action=details");
                                            //     <?php //} else { 
                                                    ?>
                                            //         var get_location = window.location + '&action=details';
                                            //     <?php //} 
                                                    ?>
                                            //     window.location.href = get_location;
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Please try again.",
                                        icon: "error",
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    }
                });
            }

            if (jqFormTimeZone.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormTimeZone.validate({
                    rules: {

                    },
                    messages: {

                    },
                    submitHandler: function(form) {
                        // update ajax request data
                        var formData = new FormData(form);
                        formData.append('action', 'action');
                        formData.append('product_id', $('#product_id').val());
                        $.ajax({
                            url: "pages/tour/function/time-zone.php",
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

            if (jqFormPeriod.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormPeriod.validate({
                    rules: {
                        // 'telephone': {
                        //     required: true
                        // },
                    },
                    messages: {
                        // 'period_end_date': {
                        //     remote: "This tat license is already taken! Try another."
                        // }
                    },
                    submitHandler: function(form) {
                        // update ajax request data
                        if ($('#period_status').val() == 'FALSE') {
                            Swal.fire({
                                title: "This period is not available.",
                                icon: "error",
                            });
                            return false;
                        }
                        var formData = new FormData(form);
                        var position = $('#period_action').val() == 'edit' ? 'edit-period.php' : 'create-period.php';

                        $.ajax({
                            url: "pages/tour/function/" + position,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                if (response != false && response > 0) {
                                    Swal.fire({
                                        title: "The information has been updated.",
                                        icon: "success",
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            location.reload(); // refresh page
                                            // <?php //if (!empty($_GET['action'])) { 
                                                ?>
                                            //     var set_location = window.location;
                                            //     var get_location = String(set_location).replace("&action=<?php //echo $_GET['action']; 
                                                                                                            ?>", "&action=period");
                                            // <?php //} else { 
                                                ?>
                                            //     var get_location = window.location + '&action=period';
                                            // <?php //} 
                                                ?>
                                            // window.location.href = get_location;
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

            if (jqFormRates.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormRates.validate({
                    rules: {
                        'rate_adult': {
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
                        var position = $('#rate_action').val() == 'create' ? 'create-rate.php' : 'edit-rate.php';

                        $.ajax({
                            url: "pages/tour/function/" + position,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                // alert(response);
                                if (response != false && response > 0) {
                                    Swal.fire({
                                        title: "The information has been updated.",
                                        icon: "success",
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            location.reload(); // refresh page
                                            <?php //if (!empty($_GET['action'])) { 
                                            ?>
                                            //var //set_location = window.location;
                                            //var //get_location = String(set_location).replace("&action=<?php //echo $_GET['action']; 
                                                                                                            ?>", "&action=rates");
                                            <?php //} else { 
                                            ?>
                                            //var get_location = window.location + '&action=rates';
                                            <?php //} 
                                            ?>
                                            // window.location.href = get_location;
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

            if (jqFormCategory.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormCategory.validate({
                    rules: {
                        'name': {
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
                        var position = $('#category_action').val() == 'create' ? 'create-category.php' : 'edit-category.php';
                        $.ajax({
                            url: "pages/tour/function/" + position,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                // alert(response);
                                if (response != false && response > 0) {
                                    Swal.fire({
                                        title: "The information has been updated.",
                                        icon: "success",
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            location.reload(); // refresh page
                                            // <?php //if (!empty($_GET['action'])) { 
                                                ?>
                                            //     var set_location = window.location;
                                            //     var get_location = String(set_location).replace("&action=<?php //echo $_GET['action']; 
                                                                                                            ?>", "&action=category");
                                            // <?php //} else { 
                                                ?>
                                            //     var get_location = window.location + '&action=category';
                                            // <?php //} 
                                                ?>
                                            // window.location.href = './?pages=tour/edit&id=' + response; // refresh page
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
        });

        function change_country() {
            var country = document.getElementById('country').value;
            $.post("pages/tour/function/ajxCountry.php", {
                    country: $("#country").val()
                    // district: $("#district").val()

                },
                function(result) {
                    $("#ajx_province").html(result);
                    $('#dropoff').val(null);

                    var select = $('.select2');

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
            );
            return false;
        }

        function change_province() {
            var province = document.getElementById('province').value;
            $.post("pages/tour/function/ajxProvince.php", {
                    province: $("#province").val()

                },
                function(result) {
                    $("#ajx_location").html(result);
                    var select = $('.select2');

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
            );
            return false;
        }

        function change_location() {
            var dropoff = document.getElementById('dropoff').value;
            $.post("pages/tour/function/ajxLocation.php", {
                    dropoff: $("#dropoff").val()

                },
                function(result) {
                    $("#ajx_zone").html(result);
                    var select = $('.select2');

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
            );
            return false;
        }

        // Modal Edit Period
        // --------------------------------------------------------------------
        function modal_period(action, category_id, period_id, is_approved, period_from, period_to) {
            document.getElementById('period_action').value = action;
            document.getElementById('period_category_id').value = category_id;
            document.getElementById('period_is_approved').checked = typeof is_approved == 'undefined' || is_approved == 1 ? true : false;
            document.getElementById('period_id').value = typeof period_id !== 'undefined' ? period_id : 0;
            var period_from = typeof period_from !== 'undefined' ? period_from : 'today';
            var period_to = typeof period_to !== 'undefined' ? period_to : 'today';

            $('#period_from_date').flatpickr({
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.isMobile) {
                        $(instance.mobileInput).attr('step', null);
                    }
                },
                static: true,
                altInput: true,
                altFormat: 'j F Y',
                dateFormat: 'Y-m-d',
                minDate: this.value,
                defaultDate: period_from
            });

            $('#period_to_date').flatpickr({
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.isMobile) {
                        $(instance.mobileInput).attr('step', null);
                    }
                },
                static: true,
                altInput: true,
                altFormat: 'j F Y',
                dateFormat: 'Y-m-d',
                minDate: period_from,
                defaultDate: period_to
            });

            check_period();
        }

        // Ajax Check Date Period
        // --------------------------------------------------------------------
        function check_period() {
            var formData = new FormData();
            formData.append('action', 'check');
            formData.append('period_id', $("#period_id").val());
            formData.append('category_id', $("#period_category_id").val());
            formData.append('period_from_date', $("#period_from_date").val());
            formData.append('period_to_date', $("#period_to_date").val());
            $.ajax({
                url: "pages/tour/function/check-period.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    document.getElementById('period_status').value = response;
                    // if (response == 'FALSE') {
                    //     Swal.fire({
                    //         title: "This period is not available.",
                    //         icon: "error",
                    //     });
                    // }
                }
            });
        }

        // Modal Category
        // --------------------------------------------------------------------
        function modal_category(action, arr_value) {
            document.getElementById('category_action').value = action;
            document.getElementById('category_id').value = typeof arr_value !== 'undefined' && arr_value['id'] !== '' ? arr_value['id'] : 0;
            document.getElementById('customer').value = typeof arr_value !== 'undefined' && arr_value['customer'] !== '' ? arr_value['customer'] : 0;
            document.getElementById('category_name').value = typeof arr_value !== 'undefined' && arr_value['name'] !== '' ? arr_value['name'] : '';
            document.getElementById('category_is_approved').checked = typeof arr_value !== 'undefined' ? arr_value['is_approved'] == 1 ? true : false : true;
            document.getElementById('in_transfer').checked = typeof arr_value !== 'undefined' ? arr_value['transfer'] == 1 ? true : false : true;
            document.getElementById('cate_detail').value = typeof arr_value !== 'undefined' && arr_value['detail'] !== '' ? arr_value['detail'] : '';
            document.getElementById('delete-category').hidden = typeof arr_value !== 'undefined' && arr_value['id'] !== '' ? false : true;

            $("#customer").val(arr_value['customer']).trigger("change");
        }

        // Ajax Delete Category
        // --------------------------------------------------------------------
        function deleteCategory() {
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
                        url: "pages/tour/function/delete-category.php",
                        type: "POST",
                        data: {
                            id: $('#category_id').val(),
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
                                }).then(function(isConfirm) {
                                    if (isConfirm) {
                                        location.reload(); // refresh page
                                    }
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

        // Ajax Delete Rate
        // --------------------------------------------------------------------
        function deletePeriod() {
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
                        url: "pages/tour/function/delete-period.php",
                        type: "POST",
                        data: {
                            id: $('#period_id').val(),
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
                                }).then(function(isConfirm) {
                                    if (isConfirm) {
                                        location.reload(); // refresh page
                                    }
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
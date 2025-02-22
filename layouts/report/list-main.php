<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Report - <?php echo $main_title; ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap">
    
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Sweetalert2 CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/sweetalert2.min.css">
    <!-- END: Sweetalert2 CSS-->

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
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/extensions/ext-component-toastr.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="app-assets/fonts/fontawesome/css/all.css" rel="stylesheet">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

    <style>
        .table-vouchure-t2 td {
            padding: 0.72rem !important;
        }

        .table-vouchure-t2 th {
            padding: 0.72rem !important;
            border-bottom: 1px solid #6E6B7B !important;
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
    <script src="app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
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
    <script src="app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
        $(document).ready(function() {
            var jqForm = $('#report-search-form'),
                picker = $('#dob'),
                dtPicker = $('#dob-bootstrap-val'),
                rangePickr = $('.flatpickr-range'),
                horizontalWizard = document.querySelector('.horizontal-wizard-example'),
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

            // Range
            if (rangePickr.length) {
                rangePickr.flatpickr({
                    mode: "range",
                    altInput: true,
                    altFormat: "j F Y",
                    dateFormat: "Y-m-d",
                    // defaultDate: ["today", "today"],
                    onClose: function(selectedDates, dateStr, instance) {
                        var dateStart = instance.formatDate(selectedDates[0], "Y-m-d");
                        var dateEnd = instance.formatDate(selectedDates[1], "Y-m-d");
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

            // Ajax Search
            // --------------------------------------------------------------------
            jqForm.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/report/function/search.php",
                    type: "POST",
                    data: serializedData + "&action=search",
                    success: function(response) {
                        if (response != false) {
                            $("#stepper-report-search").html(response);

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
                            }

                        } else {
                            $("#stepper-report-search").html('');
                        }
                    }
                });
                e.preventDefault();
            });

        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function fun_text_sum() {
            document.getElementById('text-sum-adult').innerHTML = numberWithCommas(Number($('#sum_adult').val()));
            document.getElementById('text-sum-child').innerHTML = numberWithCommas(Number($('#sum_child').val()));
            document.getElementById('text-sum-infant').innerHTML = numberWithCommas(Number($('#sum_infant').val()));

            var calChartBooking = (Number($('#sum_rec').val()) / Number($('#sum_booking').val()) * 100).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            var pay_sum = Number($('#pay_not').val()) + Number($('#pay_wait').val()) + Number($('#pay_bill').val()) + Number($('#pay_paid').val()) + Number($('#pay_cot').val()),
                pay_not = (Number($('#pay_not').val()) / pay_sum * 100).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }),
                pay_wait = (Number($('#pay_wait').val()) / pay_sum * 100).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }),
                pay_bill = (Number($('#pay_bill').val()) / pay_sum * 100).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }),
                pay_paid = (Number($('#pay_paid').val()) / pay_sum * 100).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }),
                pay_cot = (Number($('#pay_cot').val()) / pay_sum * 100).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
        }

        function fun_search_period() {
            var search_period = document.getElementById('search_period').value;
            document.getElementById('div-travel-date').hidden = search_period == 'custom' ? false : true;

            const date = new Date();
            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();
            switch (search_period) {
                case 'tomorrow':
                    day = date.getDate() + 1;
                    break;
                case 'week':
                    day = date.getDate() + 7;
                    break;
                case 'month':
                    month = date.getMonth() + 2;
                    break;
                case 'year':
                    year = date.getFullYear() + 1;
                    break;
            }
            let currentDate = `${year}-${month}-${day}`;
            // console.log(currentDate);
            $('#search_travel_date').flatpickr({
                static: true,
                mode: "range",
                altInput: true,
                altFormat: "j F Y",
                dateFormat: "Y-m-d",
                defaultDate: [currentDate, currentDate],
                onClose: function(selectedDates, dateStr, instance) {
                    var dateStart = instance.formatDate(selectedDates[0], "Y-m-d");
                    var dateEnd = instance.formatDate(selectedDates[1], "Y-m-d");
                }
            });
        }

        function download_image(type) {
            var img_name = document.getElementById('name-img-' + type).value;
            var node = document.getElementById('image-report-' + type);
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
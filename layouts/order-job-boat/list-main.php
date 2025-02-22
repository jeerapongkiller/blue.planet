<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Job Order - <?php echo $main_title; ?></title>
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
    // $columntarget = $_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2 ? '0' : '0';
    ?>

    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
        $(document).ready(function() {
            var jqForm = $('#order-job-search-form'),
                jqFormPark = $('#order-park-form'),
                picker = $('#dob'),
                dtPicker = $('#dob-bootstrap-val'),
                select = $('.select2');

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

            fun_search_period();

            // Ajax Search
            // --------------------------------------------------------------------
            jqForm.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/order-job-boat/function/search.php",
                    type: "POST",
                    data: serializedData + "&action=search",
                    success: function(response) {
                        if (response != 'false') {
                            $("#order-job-search-table").html(response);
                        }
                    }
                });
                e.preventDefault();
            });

            // jQuery Validation
            // --------------------------------------------------------------------
            if (jqFormPark.length) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    return this.optional(element) || regexp.test(value);
                }, "Please check your input.");

                jqFormPark.validate({
                    rules: {
                        // 'payments_type': {
                        //     required: true
                        // }
                    },
                    messages: {

                    },
                    submitHandler: function(form) {
                        // update ajax request data
                        var position = $('#orboat_park_id').val() > 0 ? 'park-edit.php' : 'park-create.php';
                        var formData = new FormData(form);
                        $.ajax({
                            url: "pages/order-job-boat/function/" + position,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                // $('#show-div-park').html(response);
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
        });

        function modal_customer(orboat_id) {
            if (typeof orboat_id !== 'undefined') {
                var customers = $('.customers' + orboat_id);
                $('#tbody-customer').find('tr').remove();
                var text_html = '';
                for (let index = 0; index < customers.length; index++) {
                    var customer = JSON.parse(customers[index].value);
                    if (customer['cus_name'].length > 0) {
                        for (let a = 0; a < customer['cus_name'].length; a++) {
                            text_html += '<tr>' +
                                '<td class="text-center text-nowrap">' + customer['cus_age'][a] + '</td>' +
                                '<td class="text-center">' + customer['id_card'][a] + '</td>' +
                                '<td class="text-center">' + customer['cus_name'][a] + '</td>' +
                                '<td class="text-center">' + customer['birth_date'][a] + '</td>' +
                                '<td class="text-center">' + customer['nation_name'][a] + '</td>' +
                                '</tr>';
                        }
                    }
                }
                $('#tbody-customer').append(text_html);
            }
        }

        function modal_park(park_id, orboat_id, orboat_park_id, array_orpark) {
            document.getElementById('orboat_id').value = typeof orboat_id !== 'undefined' ? orboat_id : 0;
            document.getElementById('orboat_park_id').value = orboat_park_id > 0 ? orboat_park_id : 0;
            document.getElementById('parks').value = typeof park_id !== 'undefined' ? park_id : 0;
            document.getElementById('action_park').value = orboat_park_id > 0 ? 'edit' : 'create';

            park_id = (orboat_park_id > 0 && array_orpark != '') ? array_orpark['orpark_park'][0] : park_id;
            document.getElementById('parks').value = (orboat_park_id > 0 && array_orpark != '') ? array_orpark['orpark_park'][0] : park_id;
            document.getElementById('rate_adult_eng').value = (orboat_park_id > 0 && array_orpark != '') ? array_orpark['adult_eng'][0] : 0;
            document.getElementById('rate_child_eng').value = (orboat_park_id > 0 && array_orpark != '') ? array_orpark['child_eng'][0] : 0;
            document.getElementById('rate_adult_th').value = (orboat_park_id > 0 && array_orpark != '') ? array_orpark['adult_th'][0] : 0;
            document.getElementById('rate_child_th').value = (orboat_park_id > 0 && array_orpark != '') ? array_orpark['child_th'][0] : 0;

            $('#parks').each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this
                    .select2({
                        placeholder: 'Select ...',
                        dropdownParent: $this.parent(),
                        'val': typeof park_id !== 'undefined' ? park_id : 0
                    })
                    .change(function() {
                        $(this).valid();
                    })
            });


            document.getElementById('parks_text').innerHTML = $('#parks').find(':selected').attr('data-name');

            var ad_eng = 0;
            var chd_eng = 0;
            var ad_th = 0;
            var chd_th = 0;
            if (typeof orboat_id !== 'undefined') {
                var nationality = $('.nationality' + orboat_id);
                for (let index = 0; index < nationality.length; index++) {
                    ad_eng = Number(ad_eng) + Number(nationality[index].dataset.ad_eng);
                    chd_eng = Number(chd_eng) + Number(nationality[index].dataset.chd_eng);
                    ad_th = Number(ad_th) + Number(nationality[index].dataset.ad_th);
                    chd_th = Number(chd_th) + Number(nationality[index].dataset.chd_th);
                }
            }
            document.getElementById('adult_eng').innerHTML = ad_eng;
            document.getElementById('child_eng').innerHTML = chd_eng;
            document.getElementById('adult_th').innerHTML = ad_th;
            document.getElementById('child_th').innerHTML = chd_th;

            if (orboat_park_id > 0 && array_orpark != '') {
                calculator_parks();
            } else {
                check_parks();
            }
        }

        function check_parks() {
            var parks = document.getElementById('parks').value;
            if (parks != 0) {
                var ad_eng = $('#parks').find(':selected').attr('data-adult-eng');
                var chd_eng = $('#parks').find(':selected').attr('data-child-eng');
                var ad_th = $('#parks').find(':selected').attr('data-adult-th');
                var chd_th = $('#parks').find(':selected').attr('data-child-th');

                document.getElementById('rate_adult_eng').value = ad_eng;
                document.getElementById('rate_child_eng').value = chd_eng;
                document.getElementById('rate_adult_th').value = ad_th;
                document.getElementById('rate_child_th').value = chd_th;
            }

            calculator_parks();
        }

        function calculator_parks() {
            var orboat_id = document.getElementById('orboat_id').value;
            var rate_adult_eng = document.getElementById('rate_adult_eng').value.replace(/,/g, '');
            var rate_child_eng = document.getElementById('rate_child_eng').value.replace(/,/g, '');
            var rate_adult_th = document.getElementById('rate_adult_th').value.replace(/,/g, '');
            var rate_child_th = document.getElementById('rate_child_th').value.replace(/,/g, '');
            var total = 0;
            var ad_eng = 0;
            var chd_eng = 0;
            var ad_th = 0;
            var chd_th = 0;
            if (orboat_id > 0) {
                var nationality = $('.nationality' + orboat_id);
                for (let index = 0; index < nationality.length; index++) {
                    ad_eng = Number(ad_eng) + Number(nationality[index].dataset.ad_eng);
                    chd_eng = Number(chd_eng) + Number(nationality[index].dataset.chd_eng);
                    ad_th = Number(ad_th) + Number(nationality[index].dataset.ad_th);
                    chd_th = Number(chd_th) + Number(nationality[index].dataset.chd_th);
                }
            }
            total = Number(total) + (Number(rate_adult_eng) * Number(ad_eng));
            total = Number(total) + (Number(rate_child_eng) * Number(chd_eng));
            total = Number(total) + (Number(rate_adult_th) * Number(ad_th));
            total = Number(total) + (Number(rate_child_th) * Number(chd_th));
            document.getElementById('total_park').value = numberWithCommas(total);

            document.getElementById('adult_eng').innerHTML = ad_eng + ' X ' + rate_adult_eng + ' = ' + numberWithCommas(Number(rate_adult_eng * ad_eng));
            document.getElementById('child_eng').innerHTML = chd_eng + ' X ' + rate_child_eng + ' = ' + numberWithCommas(Number(rate_child_eng * chd_eng));
            document.getElementById('adult_th').innerHTML = ad_th + ' X ' + rate_adult_th + ' = ' + numberWithCommas(Number(rate_adult_th * ad_th));
            document.getElementById('child_th').innerHTML = chd_th + ' X ' + rate_child_th + ' = ' + numberWithCommas(Number(rate_child_th * chd_th));
            document.getElementById('park_total').innerHTML = numberWithCommas(total)
        }

        function fun_search_period() {
            var search_period = document.getElementById('search_period').value;
            document.getElementById('div_custom_form').hidden = search_period == 'custom' ? false : true;
            // document.getElementById('div_custom_to').hidden = search_period == 'custom' ? false : true;

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

            $('#date_travel_form').flatpickr({
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.isMobile) {
                        $(instance.mobileInput).attr('step', null);
                    }
                },
                static: true,
                altInput: true,
                altFormat: 'j F Y',
                dateFormat: 'Y-m-d',
                defaultDate: currentDate
            });

            // $('#date_travel_to').flatpickr({
            //     onReady: function(selectedDates, dateStr, instance) {
            //         if (instance.isMobile) {
            //             $(instance.mobileInput).attr('step', null);
            //         }
            //     },
            //     static: true,
            //     altInput: true,
            //     altFormat: 'j F Y',
            //     dateFormat: 'Y-m-d',
            //     defaultDate: currentDate
            // });
        }

        // function export_excel() {
        //     var formData = new FormData();
        //     // formData.append('action', 'check');
        //     // formData.append('id', $('#bo_id').val());
        //     $.ajax({
        //         url: "pages/order-job-boat/function/excel.php",
        //         type: "POST",
        //         processData: false,
        //         contentType: false,
        //         data: formData,
        //         success: function(response) {
        //             console.log(response);
        //             // if (response != false && response > 0) {
        //             //     Swal.fire({
        //             //         title: "The information has been updated.",
        //             //         icon: "success",
        //             //     }).then(function(isConfirm) {
        //             //         if (isConfirm) {
        //             //             location.reload(); // refresh page
        //             //         }
        //             //     });
        //             // } else {
        //             //     Swal.fire({
        //             //         title: "Please try again.",
        //             //         icon: "error",
        //             //     });
        //             // }
        //         }
        //     });
        // }

        function download_image() {
            var img_name = document.getElementById('name_img').value;
            console.log(img_name);
            var node = document.getElementById('order-job-image-table');
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

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
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
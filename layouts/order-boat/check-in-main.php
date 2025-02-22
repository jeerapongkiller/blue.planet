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
            background-color: #333;
        }

        .table-black-2 {
            color: #FFFFFF;
            background-color: #4f4e4e;
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
                    url: "pages/order-boat/function/search-agent.php",
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
                            url: "pages/order-boat/function/edit.php",
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

        function search_start_date(tabs, travel_date) {
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('travel_date', travel_date);
            $.ajax({
                url: "pages/order-boat/function/search-boat-check.php",
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

        function modal_detail(manage_id, boat_name, travel_date, text_travel) {
            document.getElementById('text-travel').innerHTML = text_travel;
            document.getElementById('text-boat').innerHTML = boat_name;
            if (manage_id > 0) {
                var bookings = document.getElementById('array_booking').value;
                var res = $.parseJSON(bookings);
                var count = Object.keys(res[manage_id].id).length;
                var text_table = '';
                var adult = 0;
                var child = 0;
                var infant = 0;
                var foc = 0;
                var bo_id = 0;
                if (count > 0) {
                    for (let index = 0; index < count; index++) {
                        adult = res[manage_id].adult[index] !== '-' ? Number(adult + res[manage_id].adult[index]) : Number(adult);
                        child = res[manage_id].child[index] !== '-' ? Number(child + res[manage_id].child[index]) : Number(child);
                        infant = res[manage_id].infant[index] !== '-' ? Number(infant + res[manage_id].infant[index]) : Number(infant);
                        foc = res[manage_id].foc[index] !== '-' ? Number(foc + res[manage_id].foc[index]) : Number(foc);
                        check = res[manage_id].check[index] > 0 ? 'checked' : '';
                        text_table += '<tr>';
                        text_table += '<td class="text-center">' +
                            '<div class="custom-control custom-checkbox">' +
                            // '<input type="text" name="before_check[]" value="' + res[manage_id].id[index] + '" />' +
                            '<input class="custom-control-input dt-checkboxes checkbox-bookings" type="checkbox" data-check="' + res[manage_id].check[index] + '" id="checkbox' + res[manage_id].id[index] + '" value="' + res[manage_id].id[index] + '" ' + check + ' />' +
                            '<label class="custom-control-label" for="checkbox' + res[manage_id].id[index] + '"></label>' +
                            '</div>' +
                            '</td>';
                        text_table += '<td>' + res[manage_id].time_pickup[index] + '</td>';
                        text_table += '<td>' + res[manage_id].car[index] + '</td>';
                        text_table += '<td>' + res[manage_id].agent_name[index] + '</td>';
                        text_table += '<td>' + res[manage_id].cus_name[index] + '</td>';
                        text_table += '<td>' + res[manage_id].voucher_no[index] + '</td>';
                        text_table += '<td style="padding: 5px;">' + res[manage_id].text_hotel[index] + '</td>';
                        text_table += '<td>' + res[manage_id].room_no[index] + '</td>';
                        text_table += '<td class="text-center">' + res[manage_id].adult[index] + '</td>';
                        text_table += '<td class="text-center">' + res[manage_id].child[index] + '</td>';
                        text_table += '<td class="text-center">' + res[manage_id].infant[index] + '</td>';
                        text_table += '<td class="text-center">' + res[manage_id].foc[index] + '</td>';
                        text_table += '<td class="text-center">' + res[manage_id].cot[index] + '</td>';
                        // text_table += '<td>' + res[manage_id].note[index] + '</td>';
                        text_table += '</tr>';
                    }
                    text_table += '<tr>';
                    text_table += '<td class="text-center" colspan="13">TOTAL ' + Number(adult + child + infant + foc) + ' PAX | A ' + Number(adult) + ' | C ' + Number(child) + ' | INF ' + Number(infant) + ' | FOC ' + Number(foc) + '</td>';
                    text_table += '</tr>';
                }
                document.getElementById('table-tbody-booking').innerHTML = text_table;
                document.getElementById('print-check').href += "&travel_date=" + travel_date + "&manage_id=" + manage_id;
            }
        }

        function checkbox() {
            var checkbox_all = document.getElementById('checkall').checked;
            var checkbox = document.getElementsByClassName('checkbox-bookings');

            if (checkbox_all == true && checkbox.length > 0) {
                for (let index = 0; index < checkbox.length; index++) {
                    checkbox[index].checked = true;
                }
            } else if (checkbox_all == false && checkbox.length > 0) {
                for (let index = 0; index < checkbox.length; index++) {
                    checkbox[index].checked = false;
                }
            }
        }

        function submit_check_in() {
            var array_id = [];
            let all_checked = $(".checkbox-bookings");
            if (all_checked.length > 0) {
                for (let index = 0; index < all_checked.length; index++) {
                    if (all_checked[index].dataset.check > 0) {
                        if (all_checked[index].checked === false) {
                            array_id.push([2, all_checked[index].value]);
                        }
                    } else if (all_checked[index].dataset.check == 0) {
                        if (all_checked[index].checked === true) {
                            array_id.push([1, all_checked[index].value]);
                        }
                    }
                }
               
                if (array_id) {
                    var formData = new FormData();
                    formData.append('action', 'create');
                    formData.append('array_id', JSON.stringify(array_id));
                    $.ajax({
                        url: "pages/order-boat/function/create-check.php",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            } else {
                return false;
            }
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function download_image() {
            var img_name = document.getElementById('name_img').value;
            var node = document.getElementById('div-checkin-image');
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
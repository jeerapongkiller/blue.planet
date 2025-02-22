<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $main_description; ?>">
    <meta name="keywords" content="<?php echo $main_keywords; ?>">
    <meta name="author" content="<?php echo $main_author; ?>">
    <title>Driver Order -
        <?php echo $main_title; ?>
    </title>
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

        table.mange td {
            border: none;
            padding: 0;
        }

        table.mange {
            margin: 0;
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
            var jqFormManage = $('#manage-search-form'),
                jqFormDriver = $('#driver-car-search-form'),
                dragArea = $('#multiple-list-group-a'),
                picker = $('#dob'),
                dtPicker = $('#dob-bootstrap-val'),
                select = $('.select2'),
                flatpickr = $('.flatpickr-input'),
                horizontalWizard = document.querySelector('.horizontal-wizard-example');

            //Numeral
            $('.numeral-mask').toArray().forEach(function(field) {
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            });

            if (flatpickr.length) {
                flatpickr.flatpickr({
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

            if (dragArea.length) {
                dragula([document.getElementById('multiple-list-group-a'), document.getElementById('multiple-list-group-b')])
                    .on('drag', function(el) {
                        // add 'is-moving' class to element being dragged
                    })
                    .on('dragend', function(el) {
                        // remove 'is-moving' class from element after dragging has stopped
                        check_quantity();
                    });
            }

            // Ajax Search
            // --------------------------------------------------------------------
            jqFormManage.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/order-pickup/function/search-manage.php",
                    type: "POST",
                    data: serializedData + "&action=search",
                    success: function(response) {
                        if (response != 'false') {
                            $("#multiple-list-group-a").html(response);
                            check_quantity();
                        }
                    }
                });
                e.preventDefault();
            });

            jqFormDriver.on("submit", function(e) {
                var serializedData = $(this).serialize();
                $.ajax({
                    url: "pages/order-pickup/function/search-driver.php",
                    type: "POST",
                    data: serializedData + "&action=search",
                    success: function(response) {
                        if (response != 'false') {
                            $("#div-driver-car-search").html(response);
                        }
                    }
                });
                e.preventDefault();
            });

            fun_search_period_driver();
            check_quantity();
        });

        function modal_order_driver(order_id, date, date_text, data_head, data_body) {
            // get data
            document.getElementById('order_id').value = order_id;
            document.getElementById('edit_cars').value = data_head['car_id'];
            // document.getElementById('edit_drivers').value = data_head['driver_id'];
            document.getElementById('edit_guides').value = data_head['guide_id'];
            document.getElementById('edit_car_name').value = data_head['car_name'];
            // document.getElementById('edit_driver_name').value = data_head['driver_name'];
            document.getElementById('edit_guide_name').value = data_head['guide_name'];
            document.getElementById('edit_price').value = data_head['price'];
            document.getElementById('edit_percent').value = data_head['percent'];
            document.getElementById('edit_note').value = data_head['note'];

            var head_list = document.getElementById('head-date-text');
            var list_group = document.getElementById('multiple-list-group-d');
            head_list.innerHTML = date_text;
            // text.innerHTML = data_head['driver_name'] + ' - ' + data_head['car_name'];

            // multiple-list-group-d
            $('#input-def-btr').find('input').remove();
            $('#multiple-list-group-d').find('li').remove();
            for (let index = 0; index < data_body['btr_id'].length; index++) {
                var color_head = data_body['transfer_type'][index] == 'Join' ? 'bg-light-info' : 'bg-light-warning';
                var color_text = data_body['transfer_type'][index] == 'Join' ? 'text-info' : 'text-warning';
                var li = document.createElement('li');
                li.className = "list-group-item draggable";
                li.dataset.booking = data_body['btr_id'][index];
                li.dataset.adult = data_body['adult'][index];
                li.dataset.child = data_body['child'][index];
                li.dataset.infant = data_body['infant'][index];
                li.dataset.foc = data_body['foc'][index];
                li.innerHTML = '<div class="card">' +
                    '<div class="card-img-top ' + color_head + '">' +
                    '<h5 class="' + color_text + ' text-darken-4 pt-1 pl-1">' + data_body['book_full'][index] + '</h5>' +
                    '</div>' +
                    '<div class="card-body">' +
                    '<div class="row">' +
                    '<div class="col-sm-6">' +
                    '<table>' +
                    '<tr>' +
                    '<td class="align-top text-nowrap"><span class="text-success">Program:</span></td>' +
                    '<td class="align-top">' + data_body['product_name'][index] + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="align-top text-nowrap"><span class="text-success">Pickup:</span></td>' +
                    '<td class="align-top">' + data_body['pickup_name'][index] + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="align-top text-nowrap"><span class="text-success">Hotel:</span></td>' +
                    '<td class="align-top">' + data_body['hotel_pickup'][index] + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="align-top text-nowrap"><span class="text-success">Room no.</span></td>' +
                    '<td class="align-top">' + data_body['room_no'][index] + '</td>' +
                    '</tr>' +
                    '</table>' +
                    '</div>' +
                    '<div class="col-sm-6">' +
                    '<div class="badge badge-light-warning mr-50"><h6 class="m-0 text-warning"> AD: ' + data_body['adult'][index] + '</h6></div><div class="badge badge-light-warning mr-50"><h6 class="m-0 text-warning"> CHD: ' + data_body['child'][index] + ' </h6></div><div class="badge badge-light-warning mr-50"><h6 class="m-0 text-warning"> INF:  ' + data_body['infant'][index] + '</h6></div><div class="badge badge-light-warning mr-50"><h6 class="m-0 text-warning"> FOC:  ' + data_body['foc'][index] + '</h6></div>' +
                    '<table>' +
                    '<tr>' +
                    '<td class="align-top text-nowrap"><span class="text-success">Pickup Time:</span></td>' +
                    '<td class="align-top">' + data_body['pickup_time'][index] + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="align-top text-nowrap"><span class="text-success">Type:</span></td>' +
                    '<td class="align-top">' + data_body['transfer_type'][index] + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td class="align-top text-nowrap"><span class="text-success">Note:</span></td>' +
                    '<td class="align-top">' + data_body['note'][index] + '</td>' +
                    '</tr>' +
                    '</table>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                list_group.append(li);
                $('#input-def-btr').append("<input type=\"hidden\" id=\"def-btr-id\" name=\"def-btr-id[]\" value=\"" + data_body['btr_id'][index] + "\">");
            }

            // multiple-list-group-c
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('search_manage_period', 'custom');
            formData.append('search_travel_manage', date);
            $.ajax({
                url: "pages/order-pickup/function/search-manage.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    $('#multiple-list-group-c').html(response);
                }
            });

            $('#edit_cars').each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this
                    .select2({
                        placeholder: 'Select ...',
                        dropdownParent: $this.parent(),
                        'val': data_head['car_id'] ? data_head['car_id'] : 0
                    })
                    .change(function() {
                        $(this).valid();
                    })
            });

            // $('#edit_drivers').each(function() {
            //     var $this = $(this);
            //     $this.wrap('<div class="position-relative"></div>');
            //     $this
            //         .select2({
            //             placeholder: 'Select ...',
            //             dropdownParent: $this.parent(),
            //             'val': data_head['driver_id'] ? data_head['driver_id'] : 0
            //         })
            //         .change(function() {
            //             $(this).valid();
            //         })
            // });

            $('#edit_guides').each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this
                    .select2({
                        placeholder: 'Select ...',
                        dropdownParent: $this.parent(),
                        'val': data_head['guide_id'] ? data_head['guide_id'] : 0
                    })
                    .change(function() {
                        $(this).valid();
                    })
            });
        }

        function fun_search_period_driver() {
            var search_period = document.getElementById('search_period_driver').value;
            document.getElementById('div-travel-driver').hidden = search_period == 'custom' ? false : true;

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
            let currentDate = search_period == 'custom' ? document.getElementById('search_travel_manage').value : `${year}-${month}-${day}`;

            $('#date_travel_driver').flatpickr({
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

        }

        function add_cars() {
            var count = document.getElementById("multiple-list-group-b").getElementsByTagName('li');
            if (count.length > 0) {
                for (let index = 0; index < count.length; index++) {
                    console.log(count[index].getAttribute('data-value'));
                }
            }
        }

        function add_manage_booking() {
            const bt = [];
            const before_id = [];
            var return_car = true;
            var order_id = document.getElementById('order_id');
            var manage_id = document.getElementById("manage_id");
            var action = manage_id.value > 0 ? 'edit' : 'add';
            var position = manage_id.value > 0 ? 'edit-manage.php' : 'add-manage.php';
            var cars = document.getElementById("cars");
            var note = document.getElementById("note");
            var car_outside = document.getElementById("car_name");
            var guides = document.getElementById("guides");
            var guide_name = document.getElementById("guide_name");
            var price = document.getElementById("price");
            var percent = document.getElementById("percent");
            var date_travel = document.getElementById("search_travel_manage");
            let category = cars.options[cars.selectedIndex].getAttribute("data-category-id");
            var count = document.getElementById("multiple-list-group-b").getElementsByTagName('li');
            var before_bt_id = document.getElementsByName('before_bt_id[]');
            return_car = (cars.value !== '') ? (cars.value === 'outside') ? (car_outside.value !== '') ? true : false : true : false;

            if ((return_car == false) || (count.length === 0)) {
                Swal.fire({
                    title: "Please try again.",
                    icon: "error",
                });
                return false;
            }

            if (count.length > 0) {
                for (let index = 0; index < count.length; index++) {
                    bt.push(count[index].getAttribute('data-booking'));
                }
            }

            if (before_bt_id.length > 0) {
                for (let index = 0; index < before_bt_id.length; index++) {
                    before_id.push(before_bt_id[index].value);
                }
            }

            var formData = new FormData();
            formData.append('action', action);
            formData.append('order_id', manage_id.value);
            formData.append('cars', cars.value);
            formData.append('category', category);
            formData.append('car_outside', car_outside.value);
            formData.append('guides', guides.value);
            formData.append('guide_name', guide_name.value);
            formData.append('price', price.value);
            formData.append('percent', percent.value);
            formData.append('note', note.value);
            formData.append('date_travel', date_travel.value);
            formData.append('bt_id', JSON.stringify(bt));
            formData.append('before_id', JSON.stringify(before_id));
            $.ajax({
                url: "pages/order-pickup/function/" + position,
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
                                <?php if (!empty($_GET['date'])) { ?>
                                    var url = `${window.location}`;
                                    url = url.split("&")[0];
                                    window.location.href = url + '&date=' + date_travel.value;
                                <?php } else { ?>
                                    window.location.href = window.location + '&date=' + date_travel.value;
                                <?php } ?>
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

        function edit_manage_booking(type) {
            const btr = [];
            const def_btr = [];
            var edit_cars = document.getElementById('edit_cars').value;
            // var edit_drivers = document.getElementById('edit_drivers').value;
            var edit_guides = document.getElementById('edit_guides').value;
            var edit_car_name = document.getElementById('edit_car_name').value;
            // var edit_driver_name = document.getElementById('edit_driver_name').value;
            var edit_guide_name = document.getElementById('edit_guide_name').value;
            var edit_price = document.getElementById('edit_price').value;
            var edit_percent = document.getElementById('edit_percent').value;
            var edit_note = document.getElementById('edit_note').value;
            var date_travel = document.getElementById('date_travel_driver');
            var order_id = document.getElementById('order_id');
            var def_btr_id = document.getElementsByName('def-btr-id[]');
            var count = document.getElementById("multiple-list-group-d").getElementsByTagName('li');
            if (count.length > 0) {
                for (let index = 0; index < count.length; index++) {
                    btr.push(count[index].getAttribute('data-booking'));
                }
            }

            if (def_btr_id.length > 0) {
                for (let index = 0; index < def_btr_id.length; index++) {
                    def_btr.push(def_btr_id[index].value);
                }
            }

            var formData = new FormData();
            formData.append('action', 'edit');
            formData.append('type', type);
            formData.append('order_id', order_id.value);
            formData.append('cars', edit_cars);
            // formData.append('drivers', edit_drivers);
            formData.append('guides', edit_guides);
            formData.append('car_name', edit_car_name);
            // formData.append('driver_name', edit_driver_name);
            formData.append('guide_name', edit_guide_name);
            formData.append('price', edit_price);
            formData.append('percent', edit_percent);
            formData.append('note', edit_note);
            formData.append('def_btr', JSON.stringify(def_btr));
            formData.append('btr_id', JSON.stringify(btr));
            $.ajax({
                url: "pages/order-pickup/function/edit-manage.php",
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
                                <?php if (!empty($_GET['date'])) { ?>
                                    var url = `${window.location}`;
                                    url = url.split("&")[0];
                                    window.location.href = url + '&date=' + date_travel.value;
                                <?php } else { ?>
                                    window.location.href = window.location + '&date=' + date_travel.value;
                                <?php } ?>
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

        function deleteManage() {
            const btr = [];
            const def_btr = [];
            var date_travel = document.getElementById('date_travel_driver');
            var order_id = document.getElementById('order_id');
            var def_btr_id = document.getElementsByName('def-btr-id[]');
            var count = document.getElementById("multiple-list-group-d").getElementsByTagName('li');

            if (count.length > 0) {
                for (let index = 0; index < count.length; index++) {
                    btr.push(count[index].getAttribute('data-booking'));
                }
            }

            if (def_btr_id.length > 0) {
                for (let index = 0; index < def_btr_id.length; index++) {
                    def_btr.push(def_btr_id[index].value);
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
                    var formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('order_id', order_id.value);
                    formData.append('def_btr', JSON.stringify(def_btr));
                    formData.append('btr_id', JSON.stringify(btr));
                    $.ajax({
                        url: "pages/order-pickup/function/delete-manage.php",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: formData,
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
                                    <?php if (!empty($_GET['date'])) { ?>
                                        var url = `${window.location}`;
                                        url = url.split("&")[0];
                                        window.location.href = url + '&date=' + date_travel.value;
                                    <?php } else { ?>
                                        window.location.href = window.location + '&date=' + date_travel.value;
                                    <?php } ?>
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

        function check_outside(type) {
            // if (type == 'driver') {
            //     var drivers = document.getElementById('drivers').value
            //     document.getElementById('div-driver').hidden = drivers == 'outside' ? false : true;
            // }
            if (type == 'car') {
                var car = document.getElementById('cars').value
                document.getElementById('div-car').hidden = car == 'outside' ? false : true;
            }
            if (type == 'guide') {
                var guides = document.getElementById('guides').value
                document.getElementById('div-guide').hidden = guides == 'outside' ? false : true;
            }
        }

        function modal_manage_transfer() {
            // get data
            var date_travel = document.getElementById('search_travel_manage');
            var manage_id = document.getElementById("manage_id");
            // var manage_return = document.getElementById("manage_pickup").checked == true ? 1 : 2;

            // multiple-list-group-c
            var formData = new FormData();
            formData.append('action', 'search');
            formData.append('date_travel', date_travel.value);
            formData.append('manage_id', manage_id.value);
            formData.append('manage_return', 1);
            $.ajax({
                url: "pages/order-pickup/function/search-manage-transfer.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    $('#manage_id').html(response);
                }
            });
        }

        function add_header_transfer() {
            var manage_id = document.getElementById("manage_id");
            var date_travel = document.getElementById('search_travel_manage');
            // var manage_return = document.getElementById("manage_pickup").checked == true ? 1 : 2;

            if (manage_id.value > 0) {
                var formData = new FormData();
                formData.append('action', 'search');
                formData.append('manage_id', manage_id.value);
                formData.append('search_travel_manage', date_travel.value);
                formData.append('manage_return', 0);
                formData.append('search_product', 'all');
                $.ajax({
                    url: "pages/order-pickup/function/search-manage.php",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        $('#multiple-list-group-b').html(response);
                        check_quantity();
                    }
                });
            }

            let cars = document.getElementById("cars");
            let car_outside = document.getElementById("car_name");
            let car_name = cars.value !== 'outside' ? cars.options[cars.selectedIndex].getAttribute("data-name") : car_outside.value;
            let category_name = cars.value !== 'outside' ? cars.options[cars.selectedIndex].getAttribute("data-category") : '';
            // let drivers = document.getElementById("drivers");
            // let driver_outside = document.getElementById("driver_name");
            // let driver_name = drivers.value !== 'outside' ? drivers.options[drivers.selectedIndex].getAttribute("data-name") : driver_outside.value;
            let guides = document.getElementById("guides");
            let guide_outside = document.getElementById("guide_name");
            let guide_name = guides.value !== 'outside' ? guides.options[guides.selectedIndex].getAttribute("data-name") : guide_outside.value;

            var text = "";
            text = (car_name !== null) ? car_name : '';
            // text += ((driver_name == null) == false) ? text != '' ? " - " + driver_name : driver_name : '';
            text += ((guide_name == null) == false) ? text != '' ? " - " + guide_name : guide_name : '';
            document.getElementById('driver-car-text').innerHTML = text;

            $('#modal-manage-transfer').modal('hide');
        }

        function check_quantity() {
            var count_a = document.getElementById("multiple-list-group-a").getElementsByTagName('li');
            if (count_a.length > 0) {
                var booking = 0;
                var total = 0;
                var ad = 0;
                var chd = 0;
                var inf = 0;
                var foc = 0;
                for (let index = 0; index < count_a.length; index++) {
                    ad = Number(ad) + Number(count_a[index].getAttribute('data-adult'));
                    chd = Number(chd) + Number(count_a[index].getAttribute('data-child'));
                    inf = Number(inf) + Number(count_a[index].getAttribute('data-infant'));
                    foc = Number(foc) + Number(count_a[index].getAttribute('data-foc'));
                }
                document.getElementById('text_list_book').innerHTML = 'BOOKING : ' + count_a.length;
                document.getElementById('text_total_book').innerHTML = 'TOTAL : ' + Number(ad + chd + inf + foc);
                document.getElementById('text_ad_book').innerHTML = 'AD : ' + ad;
                document.getElementById('text_chd_book').innerHTML = 'CHD : ' + chd;
                document.getElementById('text_inf_book').innerHTML = 'INF : ' + inf;
                document.getElementById('text_foc_book').innerHTML = 'FOC : ' + foc;
            } else {
                document.getElementById('text_list_book').innerHTML = 'BOOKING : 0';
                document.getElementById('text_total_book').innerHTML = 'TOTAL : 0';
                document.getElementById('text_ad_book').innerHTML = 'AD : 0';
                document.getElementById('text_chd_book').innerHTML = 'CHD : 0';
                document.getElementById('text_inf_book').innerHTML = 'INF : 0';
                document.getElementById('text_foc_book').innerHTML = 'FOC : 0';
            }

            var count_b = document.getElementById("multiple-list-group-b").getElementsByTagName('li');
            if (count_b.length > 0) {
                booking = 0;
                total = 0;
                ad = 0;
                chd = 0;
                inf = 0;
                foc = 0;
                for (let index = 0; index < count_b.length; index++) {
                    ad = Number(ad) + Number(count_b[index].getAttribute('data-adult'));
                    chd = Number(chd) + Number(count_b[index].getAttribute('data-child'));
                    inf = Number(inf) + Number(count_b[index].getAttribute('data-infant'));
                    foc = Number(foc) + Number(count_b[index].getAttribute('data-foc'));
                }
                document.getElementById('text_list_mange').innerHTML = 'BOOKING : ' + count_b.length;
                document.getElementById('text_total_mange').innerHTML = 'TOTAL : ' + Number(ad + chd + inf + foc);
                document.getElementById('text_ad_mange').innerHTML = 'AD : ' + ad;
                document.getElementById('text_chd_mange').innerHTML = 'CHD : ' + chd;
                document.getElementById('text_inf_mange').innerHTML = 'INF : ' + inf;
                document.getElementById('text_foc_mange').innerHTML = 'FOC : ' + foc;
            } else {
                document.getElementById('text_list_mange').innerHTML = 'BOOKING : 0';
                document.getElementById('text_total_mange').innerHTML = 'TOTAL : 0';
                document.getElementById('text_ad_mange').innerHTML = 'AD : 0';
                document.getElementById('text_chd_mange').innerHTML = 'CHD : 0';
                document.getElementById('text_inf_mange').innerHTML = 'INF : 0';
                document.getElementById('text_foc_mange').innerHTML = 'FOC : 0';
            }
        }

        function check_manage() {
            var manage_id = document.getElementById('manage_id').value;
            var car_id = $('#manage_id').find(':selected').attr('data-car');
            var guide_id = $('#manage_id').find(':selected').attr('data-guide');
            var outside_driver = $('#manage_id').find(':selected').attr('data-outside_driver');
            var outside_car = $('#manage_id').find(':selected').attr('data-outside_car');
            var outside_guide = $('#manage_id').find(':selected').attr('data-outside_guide');
            document.getElementById('delete_manage').disabled = manage_id > 0 ? false : true;

            $("#cars").val(car_id).trigger("change");
            $("#guides").val(guide_id).trigger("change");
            $("#car_name").val(outside_car);
            $("#guide_name").val(outside_guide);
        }

        function delete_header_transfer() {
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
                        url: "pages/order-pickup/function/delete-manage.php",
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
<?php
require_once 'controllers/Order.php';

$today = date("Y-m-d");
$orderObj = new Order();
$get_date = !empty($_GET['date']) ? $_GET['date'] : $today;
?>

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">จัดรถส่ง (Drop Off)</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">

                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Sortable lists section start -->
            <section id="sortable-lists">
                <div class="bs-stepper horizontal-wizard-example">
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#booking-manage">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">1</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">จัดรถ</span>
                                    <span class="bs-stepper-subtitle">Booking ที่ยังไม่ได้จัดรถ</span>
                                </span>
                            </button>
                        </div>
                        <div class="step" data-target="#booking-job">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">รถที่จัดแล้ว/แก้ใข</span>
                                    <span class="bs-stepper-subtitle">Booking ที่จัดรถแล้ว / แก้ใขรถที่ถูดจัด</span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="bs-stepper-content p-0">
                        <!-- Management Car -->
                        <div id="booking-manage" class="content">
                            <div class="content-header">
                                <h5 class="pt-1 pl-2 pb-0">Search Filter</h5>
                                <form id="manage-search-form" name="manage-search-form" method="post" enctype="multipart/form-data">
                                    <div class="d-flex align-items-center mx-50 row pt-0 pb-0">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="search_manage_period">Period</label>
                                                <select class="form-control select2" id="search_manage_period" name="search_manage_period" onchange="fun_search_period_manage();">
                                                    <option value="today">Today</option>
                                                    <option value="tomorrow">Tomorrow</option>
                                                    <option value="custom" <?php echo !empty($_GET['date']) ? 'selected' : ''; ?>>Custom</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12" id="div-travel-manage" hidden>
                                            <div class="form-group">
                                                <label class="form-label" for="date_travel_manage">Travel Date
                                                    (Form)</label></br>
                                                <input type="text" class="form-control" id="date_travel_manage" name="date_travel_manage" value="<?php echo $get_date; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="search_product">Program</label>
                                                <select class="form-control select2" id="search_product" name="search_product">
                                                    <option value="all">All</option>
                                                    <?php
                                                    $products = $orderObj->showlistproduct();
                                                    foreach ($products as $product) {
                                                    ?>
                                                        <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="search_zone">Zone (โซน)</label>
                                                <select class="form-control select2" id="search_zone" name="search_zone">
                                                    <option value="all">All</option>
                                                    <?php
                                                    $zones = $orderObj->showlistzones();
                                                    foreach ($zones as $zone) {
                                                    ?>
                                                        <option value="<?php echo $zone['id']; ?>"><?php echo $zone['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="search_transfer_type">Transfer Type</label>
                                                <select class="form-control select2" id="search_transfer_type" name="search_transfer_type">
                                                    <option value="all">All</option>
                                                    <option value="1">Join</option>
                                                    <option value="2">Private</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr class="pb-0 pt-0">
                            <div class="card-body pt-0">
                                <!-- <p class="card-text">Drag and drop items of more than one list. Add same group to group prop</p> -->
                                <div class="row">
                                    <!-- Group 1 -->
                                    <div class="col-md-6 col-sm-12">
                                        <?php
                                        $first_bt = [];
                                        # --- get data --- #
                                        $orders = $orderObj->showlisttransfers('manage', 2, 0, 'today', $get_date, 'all', 'all', 'all', 'all');
                                        if (!empty($orders)) {
                                            foreach ($orders as $order) {
                                                if (in_array($order['bt_id'], $first_bt) == false) {
                                                    $first_bt[] = $order['bt_id'];
                                                    $bo_id[] = !empty($order['id']) ? $order['id'] : 0;
                                                    $bt_id[] = !empty($order['bt_id']) ? $order['bt_id'] : 0;
                                                    $manage_order_id[] = !empty($order['order_id']) ? $order['order_id'] : 0;
                                                    $manage_order_retrun[] = !empty($order['order_retrun']) ? $order['order_retrun'] : 0;
                                                    $book_full[] = !empty($order['book_full']) ? $order['book_full'] : '';
                                                    $product_name[] = !empty(!empty($order['product_name'])) ? $order['product_name'] : '';
                                                    $adult[] = !empty($order['bpr_adult']) ? $order['bpr_adult'] : '0';
                                                    $child[] = !empty($order['bpr_child']) ? $order['bpr_child'] : '0';
                                                    $infant[] = !empty($order['bpr_infant']) ? $order['bpr_infant'] : '0';
                                                    $foc[] = !empty($order['bpr_foc']) ? $order['bpr_foc'] : '0';
                                                    $pickup_name[] = !empty($order['pickup_name']) ? $order['pickup_name'] : '';
                                                    $hotel_pickup[] = empty($order['hotel_pickup']) ? !empty($order['hotel_name_th']) ? $order['hotel_name_th'] : 'ไม่ได้ระบุ' : $order['hotel_pickup'];
                                                    $room_no[] = !empty($order['room_no']) ? $order['room_no'] : 'ไม่ได้ระบุ';
                                                    $start_pickup[] = !empty($order['start_pickup']) ? date('H:i', strtotime($order['start_pickup'])) : '';
                                                    $end_pickup[] = !empty($order['end_pickup']) ? date('H:i', strtotime($order['end_pickup'])) : '';
                                                    $bt_note[] = !empty($order['bt_note']) ? $order['bt_note'] : '';
                                                    $transfer_type[] = !empty($order['transfer_type']) ? $order['transfer_type'] == 2 ? !empty($order['carc_name']) ? 'Private ' . ' (' . $order['carc_name'] . ')' : 'Private' : 'Join' : '';
                                                }
                                            }
                                        }
                                        ?>
                                        <div>
                                            <div class="badge badge-light-info mr-50">
                                                <h6 class="m-0 text-info" id="text_list_book">BOOKING : 0</h6>
                                            </div>
                                            <div class="badge badge-light-info mr-50">
                                                <h6 class="m-0 text-info" id="text_total_book">TOTAL : 0</h6>
                                            </div>
                                            <div class="badge badge-light-info mr-50">
                                                <h6 class="m-0 text-info" id="text_ad_book">AD : 0</h6>
                                            </div>
                                            <div class="badge badge-light-info mr-50">
                                                <h6 class="m-0 text-info" id="text_chd_book">CHD : 0</h6>
                                            </div>
                                            <div class="badge badge-light-info mr-50">
                                                <h6 class="m-0 text-info" id="text_inf_book">INF : 0</h6>
                                            </div>
                                            <div class="badge badge-light-info mr-50">
                                                <h6 class="m-0 text-info" id="text_foc_book">FOC : 0</h6>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                            <div class="card-header pt-1 pb-50 pl-1">
                                                <h5>Booking List </h5>
                                            </div>
                                            <div class="card-body pt-1 bg-light-secondary">
                                                <ul class="list-group list-group-flush" id="multiple-list-group-a">
                                                    <?php
                                                    if (!empty($bt_id)) {
                                                        for ($i = 0; $i < count($bt_id); $i++) {
                                                            $bg_light = $transfer_type[$i] == 'Join' ? 'bg-light-info' : 'bg-light-warning';
                                                            $text_light = $transfer_type[$i] == 'Join' ? 'text-info' : 'text-warning';
                                                            if (($manage_order_id[$i] == 0) && ($manage_order_retrun[$i] != 1)) {
                                                    ?>
                                                                <li class="list-group-item draggable mt-1" data-booking="<?php echo $bt_id[$i]; ?>" data-adult="<?php echo $adult[$i]; ?>" data-child="<?php echo $child[$i]; ?>" data-infant="<?php echo $infant[$i]; ?>" data-foc="<?php echo $foc[$i]; ?>">
                                                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5 mb-0">
                                                                        <div class="card-header card-img-top <?php echo $bg_light; ?> p-50">
                                                                            <h5 class="<?php echo $text_light; ?> text-darken-4 mb-0"><?php echo $book_full[$i]; ?> </h5>
                                                                            <h5 class="<?php echo $text_light; ?> text-darken-4 mb-0 text-right"><?php echo $transfer_type[$i]; ?></h5>
                                                                        </div>
                                                                        <div class="card-body pb-50">
                                                                            <table class="w-100">
                                                                                <tr>
                                                                                    <td width="60%" rowspan="2">
                                                                                        <dl class="row mt-1 mb-0">
                                                                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Program : </dt>
                                                                                            <dd class="col-sm-8 mb-0"><?php echo $product_name[$i]; ?></dd>
                                                                                        </dl>
                                                                                        <dl class="row mt-50 mb-0">
                                                                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Pickup : </dt>
                                                                                            <dd class="col-sm-8 mb-0"><?php echo $pickup_name[$i]; ?></dd>
                                                                                        </dl>
                                                                                        <dl class="row mt-50 mb-0">
                                                                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Hotel : </dt>
                                                                                            <dd class="col-sm-8 mb-0"><?php echo $hotel_pickup[$i]; ?></dd>
                                                                                        </dl>
                                                                                        <dl class="row mt-50 mb-0">
                                                                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Room No : </dt>
                                                                                            <dd class="col-sm-8 mb-0"><?php echo $room_no[$i]; ?></dd>
                                                                                        </dl>
                                                                                        <dl class="row mt-50 mb-0">
                                                                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Time : </dt>
                                                                                            <dd class="col-sm-8 mb-0"><?php echo $start_pickup[$i] . '-' . $end_pickup[$i]; ?></dd>
                                                                                        </dl>
                                                                                        <dl class="row mt-50 mb-0">
                                                                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Note : </dt>
                                                                                            <dd class="col-sm-8 mb-0"><?php echo nl2br($bt_note[$i]); ?></dd>
                                                                                        </dl>
                                                                                    </td>
                                                                                    <td height="30px">
                                                                                        <div class="text-center">
                                                                                            <div class="badge badge-light-warning mr-50 mt-1">
                                                                                                <h6 class="m-0 text-warning"> AD : <?php echo $adult[$i]; ?></h6>
                                                                                            </div>
                                                                                            <div class="badge badge-light-warning mr-50">
                                                                                                <h6 class="m-0 text-warning"> CHD : <?php echo $child[$i]; ?></h6>
                                                                                            </div>
                                                                                            <div class="badge badge-light-warning mr-50">
                                                                                                <h6 class="m-0 text-warning"> INF : <?php echo $infant[$i]; ?></h6>
                                                                                            </div>
                                                                                            <div class="badge badge-light-warning mr-50">
                                                                                                <h6 class="m-0 text-warning"> FOC : <?php echo $foc[$i]; ?></h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="text-center align-middle">
                                                                                        <div class="display-3 text-success"><?php echo $adult[$i] + $child[$i] + $infant[$i] + $foc[$i]; ?> <h5 class="d-inline-block">PAX</h5>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                    <?php
                                                            }
                                                        }
                                                    } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Group 2 -->
                                    <div class="col-md-6 col-sm-12">
                                        <div id="div-show"></div>
                                        <div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning" id="text_list_mange">BOOKING : 0</h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning" id="text_total_mange">TOTAL : 0</h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning" id="text_ad_mange">AD : 0</h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning" id="text_chd_mange">CHD : 0</h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning" id="text_inf_mange">INF : 0</h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning" id="text_foc_mange">FOC : 0</h6>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                            <div class="card-header pt-1 pb-50 pl-1">
                                                <h5>เปิดรถ : <span id="driver-car-text"></span></h5>
                                            </div>
                                            <div class="card-body pt-1 bg-light-secondary">
                                                <ul class="list-group list-group-flush" id="multiple-list-group-b">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-success waves-effect waves-float waves-light" data-toggle="modal" data-target="#modal-manage-transfer" onclick="modal_manage_transfer();">
                                                <span class="align-middle d-sm-inline-block d-none">เปิดรถ</span>
                                            </button>
                                            <button class="btn btn-primary btn-submit btn-page-block-spinner" onclick="add_manage_booking();">
                                                <span class="align-middle d-sm-inline-block d-none">Submit</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Job Driver -->
                        <div id="booking-job" class="content">
                            <!-- Search Filter Start -->
                            <div class="content-header">
                                <h5 class="pt-1 pl-2 pb-0">Search Filter</h5>
                                <form id="driver-car-search-form" name="driver-car-search-form" method="post" enctype="multipart/form-data">
                                    <div class="d-flex align-items-center mx-50 row pt-0 pb-0">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="search_period_driver">Period</label>
                                                <select class="form-control select2" id="search_period_driver" name="search_period_driver" onchange="fun_search_period_driver();">
                                                    <option value="today">Today</option>
                                                    <option value="tomorrow">Tomorrow</option>
                                                    <option value="custom" <?php echo !empty($_GET['date']) ? 'selected' : ''; ?>>Custom</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12" id="div-travel-driver" hidden>
                                            <div class="form-group">
                                                <label class="form-label" for="date_travel_driver">Travel Date
                                                    (Form)</label></br>
                                                <input type="text" class="form-control" id="date_travel_driver" name="date_travel_driver" value="<?php echo $get_date; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="search_car">Car</label>
                                                <select class="form-control select2" id="search_car" name="search_car">
                                                    <option value="all">All</option>
                                                    <?php
                                                    $cars = $orderObj->show_cars();
                                                    foreach ($cars as $car) {
                                                    ?>
                                                        <option value="<?php echo $car['id']; ?>"><?php echo $car['name'] . ' ' . $car['car_registration'] . ' - ' . $car['cateName']; ?>
                                                        <?php
                                                    }
                                                        ?>
                                                        <option value="outside">Outside Car</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="search_trans_type">Transfer Type</label>
                                                <select class="form-control select2" id="search_trans_type" name="search_trans_type">
                                                    <option value="all">All</option>
                                                    <option value="1">Join</option>
                                                    <option value="2">Private</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr class="pb-0 pt-0">
                            <div id="div-driver-car-search">
                                <div class="content-header">
                                    <div class="pl-1">
                                        <a href="./?pages=order-dropoff/print&action=print&date_travel_driver=<?php echo $get_date; ?>" target="_blank" class="btn btn-info">Print</a>
                                        <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="download_image();">Image</button></a>
                                        <a href="javascript:void(0);" class="btn btn-info disabled" hidden>Download as PDF</a>
                                    </div>
                                </div>
                                <hr class="pb-0 pt-0">
                                <?php
                                $first_bt_id = [];
                                $first_order = [];
                                $sum_programe = 0;
                                $sum_ad = 0;
                                $sum_chd = 0;
                                $sum_inf = 0;
                                $name_img = '';
                                # --- get data --- #
                                $orders = $orderObj->showlisttransfers('order', 2, 0, 'today', $get_date, 'all', 'all', 'all', 'all');
                                if (!empty($orders)) {
                                    foreach ($orders as $order) {
                                        if (in_array($order['bt_id'], $first_bt_id) == false) {
                                            $first_bt_id[] = $order['bt_id'];
                                            $order_bt_id[$order['order_id']][] = !empty($order['bt_id']) ? $order['bt_id'] : 0;
                                            $order_product_name[$order['order_id']][] = !empty($order['product_name']) ? $order['product_name'] : '';
                                            $order_agent_name[$order['order_id']][] = !empty($order['comp_name']) ? $order['comp_name'] : '';
                                            $order_cus_name[$order['order_id']][] = !empty($order['cus_name']) ? $order['cus_name'] : '';
                                            $order_adult[$order['order_id']][] = !empty($order['bt_adult']) ? $order['bt_adult'] : 0;
                                            $order_child[$order['order_id']][] = !empty($order['bt_child']) ? $order['bt_child'] : 0;
                                            $order_infant[$order['order_id']][] = !empty($order['bt_infant']) ? $order['bt_infant'] : 0;
                                            $order_foc[$order['order_id']][] = !empty($order['bt_foc']) ? $order['bt_foc'] : 0;
                                            $order_pickup[$order['order_id']][] = !empty($order['pickup_name']) ? $order['pickup_name'] : 'ไม่ได้ระบุ';
                                            $order_hotel_pickup[$order['order_id']][] = empty($order['hotel_pickup']) ? !empty($order['hotel_name_th']) ? $order['hotel_name_th'] : 'ไม่ได้ระบุ' : $order['hotel_pickup'];
                                            $order_pickup_time[$order['order_id']][] = !empty($order['start_pickup']) ? date('H:i', strtotime($order['start_pickup'])) . '-' . date('H:i', strtotime($order['end_pickup'])) : '';
                                            $order_voucher_no[$order['order_id']][] = !empty($order['voucher_no_agent']) ? $order['voucher_no_agent'] : '';
                                            $order_roomon[$order['order_id']][] = !empty($order['room_no']) ? $order['room_no'] : 'ไม่ได้ระบุ';
                                            $order_dropoff[$order['order_id']][] = !empty($order['dropoff_name']) ? $order['dropoff_name'] : 'ไม่ได้ระบุ';
                                            $order_hotel_dropoff[$order['order_id']][] = empty($order['hotel_dropoff']) ? !empty($order['dhotel_name_th']) ? $order['dhotel_name_th'] : 'ไม่ได้ระบุ' : $order['hotel_dropoff'];
                                            $order_payment[$order['order_id']][] = !empty($order['bopay_id']) && $order['bopay_id'] == 4 ? number_format($order['total_paid']) : '-';
                                            $order_bp_note[$order['order_id']][] = !empty($order['bp_note']) ? $order['bp_note'] : '';
                                            $order_bt_note[$order['order_id']][] = !empty($order['bt_note']) ? $order['bt_note'] : '';
                                            $order_transfer_type[$order['order_id']][] = !empty($order['transfer_type']) ? $order['transfer_type'] : 0;
                                            # --- set array body order --- #
                                            $order_body[$order['order_id']]['bt_id'][] = !empty($order['bt_id']) ? $order['bt_id'] : '';
                                            $order_body[$order['order_id']]['book_full'][] = !empty($order['book_full']) ? $order['book_full'] : '';
                                            $order_body[$order['order_id']]['product_name'][] = !empty($order['product_name']) ? $order['product_name'] : '';
                                            $order_body[$order['order_id']]['adult'][] = !empty($order['bt_adult']) ? $order['bt_adult'] : 0;
                                            $order_body[$order['order_id']]['child'][] = !empty($order['bt_child']) ? $order['bt_child'] : 0;
                                            $order_body[$order['order_id']]['infant'][] = !empty($order['bt_infant']) ? $order['bt_infant'] : 0;
                                            $order_body[$order['order_id']]['foc'][] = !empty($order['bt_foc']) ? $order['bt_foc'] : 0;
                                            $order_body[$order['order_id']]['pickup_name'][] = !empty($order['pickup_name']) ? $order['pickup_name'] : '';
                                            $order_body[$order['order_id']]['hotel_pickup'][] = empty($order['hotel_pickup']) ? !empty($order['hotel_name_th']) ? $order['hotel_name_th'] : 'ไม่ได้ระบุ' : $order['hotel_pickup'];
                                            $order_body[$order['order_id']]['room_no'][] = !empty($order['room_no']) ? $order['room_no'] : '';
                                            $order_body[$order['order_id']]['pickup_time'][] = !empty($order['start_pickup']) ? date('H:i', strtotime($order['start_pickup'])) . '-' . date('H:i', strtotime($order['end_pickup'])) : '';
                                            $order_body[$order['order_id']]['note'][] = !empty($order['bt_note']) ? $order['bt_note'] : '';
                                            $order_body[$order['order_id']]['transfer_type'][] = !empty($order['transfer_type']) ? $order['transfer_type'] == 2 ? !empty($order['carc_name']) ? 'Private ' . ' (' . $order['carc_name'] . ')' : 'Private' : 'Join' : '';
                                            # --- sum value --- #
                                            $name_img = 'Driver Order (All)';
                                            $sum_programe++;
                                            $sum_ad = $order['bt_adult'] + $sum_ad;
                                            $sum_chd = $order['bt_child'] + $sum_chd;
                                            $sum_inf = $order['bt_infant'] + $sum_inf;
                                            $sum_foc = $order['bt_foc'] + $sum_foc;
                                        }

                                        if (in_array($order['order_id'], $first_order) == false && !empty($order['order_id'])) {
                                            $first_order[] = $order['order_id'];
                                            $order_id[] = !empty($order['order_id']) ? $order['order_id'] : 0;
                                            $order_driver_name[] = empty($order['order_driver_id']) ? !empty($order['order_driver_name']) ? $order['order_driver_name'] : '' : $order['driver_fname'] . ' ' . $order['driver_lname'] . ' (' . $order['driver_telephone'] . ')';
                                            $order_car_name[] = empty($order['order_car_id']) ? !empty($order['order_car_name']) ? $order['order_car_name'] : '' : $order['car_name'] . ' ' . $order['car_registration']  . ' - ' . $order['carte_name'];
                                            $order_guide_name[] = empty($order['order_guide_id']) ? !empty($order['order_guide_name']) ? $order['order_guide_name'] : '' : $order['guide_name'];
                                            $order_percent[] = !empty($order['order_percent']) ? $order['order_percent'] : 0;
                                            $order_price[] = !empty($order['order_price']) ? $order['order_price'] : 0;
                                            $order_note[] = !empty($order['order_note']) ? $order['order_note'] : '';
                                            # --- set array head order --- #
                                            $order_array[$order['order_id']]['id'] = !empty($order['order_id']) ? $order['order_id'] : 0;
                                            $order_array[$order['order_id']]['car_id'] = !empty($order['order_car_id']) ? $order['order_car_id'] : 0;
                                            $order_array[$order['order_id']]['driver_id'] = !empty($order['order_driver_id']) ? $order['order_driver_id'] : 0;
                                            $order_array[$order['order_id']]['guide_id'] = !empty($order['order_guide_id']) ? $order['order_guide_id'] : 0;
                                            $order_array[$order['order_id']]['car_name'] = !empty($order['order_car_name']) ? $order['order_car_name'] : '';
                                            $order_array[$order['order_id']]['driver_name'] = !empty($order['order_driver_name']) ? $order['order_driver_name'] : '';
                                            $order_array[$order['order_id']]['guide_name'] = !empty($order['order_guide_name']) ? $order['order_guide_name'] : '';
                                            $order_array[$order['order_id']]['price'] = !empty($order['order_price']) ? $order['order_price'] : '';
                                            $order_array[$order['order_id']]['percent'] = !empty($order['order_percent']) ? $order['order_percent'] : '';
                                            $order_array[$order['order_id']]['note'] = !empty($order['order_note']) ? $order['order_note'] : '';
                                        }
                                    }
                                }
                                ?>
                                <div id="div-driver-job-image" style="background-color: #FFF;">
                                    <!-- Header starts -->
                                    <div class="card-body pb-0">
                                        <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0 mb-1">
                                            <div>
                                                <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="150"></span>
                                            </div>
                                            <div>
                                                <span style="color: #000;">
                                                    <?php echo $main_document; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div class="text-center card-text">
                                            <h4 class="font-weight-bolder">ใบจัดรถขาส่ง (Drop Off)</h4>
                                            <div class="badge badge-pill badge-light-danger">
                                                <h5 class="m-0 pl-1 pr-1 text-danger"><?php echo date('j F Y', strtotime($get_date)); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    </br>
                                    <!-- Header ends -->
                                    <!-- Body starts -->
                                    <?php
                                    if (!empty($order_id)) {
                                        for ($i = 0; $i < count($order_id); $i++) {
                                    ?>
                                            <div class="card-body pb-50 pt-0">
                                                <div class="row card-text align-items-center">
                                                    <div class="col-md-9 text-left">
                                                        <?php if (!empty($order_car_name[$i])) { ?>
                                                            <div class="avatar bg-light-warning bg-darken-4">
                                                                <div class="avatar-content">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-car-front-fill" viewBox="0 0 16 16">
                                                                        <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679c.033.161.049.325.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.807.807 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2H6ZM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17 1.247 0 3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        <?php echo $order_car_name[$i];
                                                        } ?>

                                                        <?php if (!empty($order_driver_name[$i])) { ?>
                                                            <div class="avatar bg-light-warning bg-darken-4 ml-2">
                                                                <div class="avatar-content">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        <?php echo $order_driver_name[$i];
                                                        } ?>

                                                        <?php if (!empty($order_guide_name[$i])) { ?>
                                                            <div class="avatar bg-light-warning bg-darken-4 ml-2">
                                                                <div class="avatar-content">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        <?php echo $order_guide_name[$i];
                                                        } ?>

                                                        <?php if (!empty($order_price[$i])) { ?>
                                                            <div class="avatar bg-light-warning bg-darken-4 ml-2">
                                                                <div class="avatar-content">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        <?php echo number_format($order_price[$i]);
                                                        } ?>

                                                        <?php if (!empty($order_percent[$i])) { ?>
                                                            <div class="avatar bg-light-warning bg-darken-4 ml-2">
                                                                <div class="avatar-content">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-percent" viewBox="0 0 16 16">
                                                                        <path d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0zM4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        <?php echo $order_percent[$i];
                                                        } ?>
                                                    </div>
                                                    <?php if (!empty($order_note[$i])) { ?>
                                                        <div class="col-md-4 text-left">
                                                            <?php echo nl2br($order_note[$i]); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead class="bg-info bg-darken-2 text-white">
                                                        <tr>
                                                            <th class="text-center">Pickup</th>
                                                            <th class="text-center">Room</th>
                                                            <th class="text-center">Pick Up Time</th>
                                                            <th class="text-center">Voucher No.</th>
                                                            <th class="text-center">Programe</th>
                                                            <th class="text-center">CUSTOMER'S NAME</th>
                                                            <th class="text-center">AD</th>
                                                            <th class="text-center">CHD</th>
                                                            <th class="text-center">INF</th>
                                                            <th class="text-center">FOC</th>
                                                            <th class="text-center">Dropoff</th>
                                                            <th class="text-center">Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (!empty($order_bt_id[$order_id[$i]])) {
                                                            for ($a = 0; $a < count($order_bt_id[$order_id[$i]]); $a++) {
                                                                $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                                                        ?>
                                                                <tr class="<?php echo $class_tr; ?>">
                                                                    <td>
                                                                        <table class="mange">
                                                                            <tr>
                                                                                <td class=" text-success pr-1">Zone: </td>
                                                                                <td><?php echo $order_pickup[$order_id[$i]][$a]; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class=" text-success pr-1">Hotel: </td>
                                                                                <td><?php echo $order_hotel_pickup[$order_id[$i]][$a]; ?></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td class="text-center"><?php echo $order_roomon[$order_id[$i]][$a]; ?></td>
                                                                    <td class="text-center text-nowrap"><?php echo $order_pickup_time[$order_id[$i]][$a]; ?></td>
                                                                    <td class="text-center"><?php echo $order_voucher_no[$order_id[$i]][$a]; ?></td>
                                                                    <td><?php echo $order_product_name[$order_id[$i]][$a]; ?></td>
                                                                    <td><?php echo $order_cus_name[$order_id[$i]][$a]; ?></td>
                                                                    <td class="text-center"><?php echo $order_adult[$order_id[$i]][$a]; ?></td>
                                                                    <td class="text-center"><?php echo $order_child[$order_id[$i]][$a]; ?></td>
                                                                    <td class="text-center"><?php echo $order_infant[$order_id[$i]][$a]; ?></td>
                                                                    <td class="text-center"><?php echo $order_foc[$order_id[$i]][$a]; ?></td>
                                                                    <td>
                                                                        <table class="mange">
                                                                            <tr>
                                                                                <td class=" text-success pr-1">Zone: </td>
                                                                                <td><?php echo $order_dropoff[$order_id[$i]][$a]; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class=" text-success pr-1">Hotel: </td>
                                                                                <td><?php echo $order_hotel_dropoff[$order_id[$i]][$a]; ?></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td class="text-center"><?php echo $order_transfer_type[$order_id[$i]][$a] != 0 ? $order_transfer_type[$order_id[$i]][$a] == 1 ? 'Join' : 'Private' : ''; ?></td>
                                                                </tr>
                                                                <tr class="<?php echo $class_tr; ?>">
                                                                    <td colspan="6"><?php echo '<span class="text-danger">Note (Transfer) : </span>' . $order_bt_note[$order_id[$i]][$a]; ?></td>
                                                                    <td colspan="6"><?php echo '<span class="text-danger">Note (Programe) : </span>' . $order_bp_note[$order_id[$i]][$a]; ?></td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                                </br>
                                            </div>
                                            </br>
                                        <?php } ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="bg-danger bg-lighten-5 text-danger">
                                                    <tr>
                                                        <!-- <th class="text-center">PROGRAME</th> -->
                                                        <th class="text-center">ADULT</th>
                                                        <th class="text-center">CHILD</th>
                                                        <th class="text-center">INFANT</th>
                                                        <th class="text-center">FOC</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <!-- <td class="text-center"><?php echo $sum_programe; ?></td> -->
                                                        <td class="text-center"><?php echo $sum_ad; ?></td>
                                                        <td class="text-center"><?php echo $sum_chd; ?></td>
                                                        <td class="text-center"><?php echo $sum_inf; ?></td>
                                                        <td class="text-center"><?php echo $sum_foc; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>
                                    <!-- Body ends -->
                                    <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Sortable lists section end -->

            <!-- Start Form Modal -->
            <!------------------------------------------------------------------>
            <div class="modal-size-lg d-inline-block">
                <div class="modal fade text-left" id="modal-manage-transfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17">Add Car</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="show-div-cus"></div>
                                <form id="customer-form" onsubmit="return false;">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="manage_id">รถที่เปิดแล้ว</label>
                                                <select class="form-control select2" id="manage_id" name="manage_id" onchange="check_manage();">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="cars">Car</label>
                                                <select class="form-control select2" id="cars" name="cars" onchange="check_outside('car');">
                                                    <option value="0">Please Select Car...</option>
                                                    <?php
                                                    $cars = $orderObj->show_cars();
                                                    foreach ($cars as $car) {
                                                    ?>
                                                        <option value="<?php echo $car['id']; ?>" data-name="<?php echo $car['name'] . ' - ' . $car['car_registration']; ?>" data-category-id="<?php echo $car['cateID']; ?>" data-category="<?php echo $car['cateName']; ?>"><?php echo $car['name'] . ' ' . $car['car_registration'] . ' - ' . $car['cateName']; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                    <option value="outside">Outside Car</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="guides">Guide (Tour Leader)</label>
                                                <select class="form-control select2" id="guides" name="guides" onchange="check_outside('guide');">
                                                    <option value="0">Please Select Guide...</option>
                                                    <?php
                                                    $guides = $orderObj->show_guides();
                                                    foreach ($guides as $guide) {
                                                    ?>
                                                        <option value="<?php echo $guide['id']; ?>" data-name="<?php echo $guide['name']; ?>"><?php echo $guide['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    <option value="outside">Outside Guide</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12" id="div-car" hidden>
                                            <div class="form-group">
                                                <label class="form-label" for="car_name">Outside Car </label></br>
                                                <input type="text" class="form-control" id="car_name" name="car_name" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12" id="div-guide" hidden>
                                            <div class="form-group">
                                                <label class="form-label" for="guide_name">Outside Guide </label></br>
                                                <input type="text" class="form-control" id="guide_name" name="guide_name" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="price">ค่ารถ </label></br>
                                                <input type="text" class="form-control numeral-mask" id="price" name="price" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="percent">หัก % </label></br>
                                                <input type="text" class="form-control numeral-mask" id="percent" name="percent" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="note">Note</label></br>
                                                <textarea name="note" id="note" class="form-control" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr />
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-danger" id="delete_manage" name="delete" disabled onclick="delete_header_transfer();">Delete</button>
                                    <button type="button" class="btn btn-primary" name="submit" value="Submit" onclick="add_header_transfer();">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
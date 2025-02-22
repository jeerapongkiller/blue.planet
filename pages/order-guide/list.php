<?php
require_once 'controllers/Order.php';

$orderObj = new Order();

$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime(" +1 day"));
// $today = '2025-01-16';
// $tomorrow = '2025-01-17';
$get_date = !empty($_GET['date_travel_form']) ? $_GET['date_travel_form'] : $today; // $tomorrow->format("Y-m-d")
$search_boat = !empty($_GET['search_boat']) ? $_GET['search_boat'] : 'all';
$search_guide = !empty($_GET['search_guide']) ? $_GET['search_guide'] : 'all';
$search_status = $_GET['search_status'] != "" ? $_GET['search_status'] : 'all';
$search_agent = $_GET['search_agent'] != "" ? $_GET['search_agent'] : 'all';
$search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
$search_voucher_no = $_GET['voucher_no'] != "" ? $_GET['voucher_no'] : '';
$refcode = $_GET['refcode'] != "" ? $_GET['refcode'] : '';
$name = $_GET['name'] != "" ? $_GET['name'] : '';

$href = "./?pages=order-guide/print";
$href .= "&date_travel=" . $get_date;
$href .= "&search_boat=" . $search_boat;
$href .= "&search_guide=" . $search_guide;
$href .= "&search_status=" . $search_status;
$href .= "&search_agent=" . $search_agent;
$href .= "&search_product=" . $search_product;
$href .= "&search_voucher_no=" . $search_voucher_no;
$href .= "&refcode=" . $refcode;
$href .= "&name=" . $name;
$href .= "&action=print";

function check_in($var)
{
    return ($var > 0);
}
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php echo ($today == $get_date) ? 'active' : ''; ?>" id="today-tab" data-toggle="tab" href="#today" aria-controls="today" role="tab" aria-selected="true" onclick="search_report('<?php echo $today; ?>');">Today</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo ($tomorrow == $get_date) ? 'active' : ''; ?>" id="tomorrow-tab" data-toggle="tab" href="#tomorrow" aria-controls="tomorrow" role="tab" aria-selected="false" onclick="search_report('<?php echo $tomorrow; ?>');">Tomorrow</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo ($today != $get_date && $tomorrow != $get_date) ? 'active' : ''; ?>" id="customh-tab" data-toggle="tab" href="#custom" aria-controls="custom" role="tab" aria-selected="true">Custom</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?php echo ($today == $get_date) ? 'active' : ''; ?>" id="today" aria-labelledby="today-tab" role="tabpanel">

                            </div>
                            <div class="tab-pane <?php echo ($tomorrow == $get_date) ? 'active' : ''; ?>" id="tomorrow" aria-labelledby="tomorrow-tab" role="tabpanel">

                            </div>
                            <div class="tab-pane <?php echo ($today != $get_date && $tomorrow != $get_date) ? 'active' : ''; ?>" id="custom" aria-labelledby="custom-tab" role="tabpanel">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <!-- order job list start -->
            <section class="app-user-list">
                <!-- list section start -->
                <div class="card">
                    <!-- order job filter end -->
                    <div class="content-header">
                        <h5 class="pt-1 pl-2 pb-0">Search Filter</h5>
                        <form id="order-guide-search-form" name="order-guide-search-form" method="get" enctype="multipart/form-data">
                            <input type="hidden" name="pages" value="<?php echo $_GET['pages']; ?>">
                            <div class="d-flex align-items-center mx-50 row pt-0 pb-2">
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="search_status">Status</label>
                                        <select class="form-control select2" id="search_status" name="search_status">
                                            <option value="all">All</option>
                                            <?php
                                            $bookstype = $orderObj->showliststatus();
                                            foreach ($bookstype as $booktype) {
                                                $selected = $search_status == $booktype['id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $booktype['id']; ?>" <?php echo $selected; ?>><?php echo $booktype['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="search_agent">Agent</label>
                                        <select class="form-control select2" id="search_agent" name="search_agent">
                                            <option value="all">All</option>
                                            <?php
                                            $agents = $orderObj->showlistagent();
                                            foreach ($agents as $agent) {
                                                $selected = $search_agent == $agent['id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $agent['id']; ?>" <?php echo $selected; ?>><?php echo $agent['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="search_product">Programe</label>
                                        <select class="form-control select2" id="search_product" name="search_product">
                                            <option value="all">All</option>
                                            <?php
                                            $products = $orderObj->showlistproduct();
                                            foreach ($products as $product) {
                                                $selected = $search_product == $product['id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $product['id']; ?>" <?php echo $selected; ?>><?php echo $product['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="search_boat">เรือ</label>
                                        <select class="form-control select2" id="search_boat" name="search_boat">
                                            <option value="all">All</option>
                                            <?php
                                            $boats = $orderObj->show_boats();
                                            foreach ($boats as $boat) {
                                                $selected = $search_boat == $boat['id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $boat['id']; ?>" <?php echo $selected; ?>><?php echo $boat['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="search_guide">ไกด์</label>
                                        <select class="form-control select2" id="search_guide" name="search_guide">
                                            <option value="all">All</option>
                                            <?php
                                            $guides = $orderObj->show_guides();
                                            foreach ($guides as $guide) {
                                                $selected = $search_guide == $guide['id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $guide['id']; ?>" <?php echo $selected; ?>><?php echo $guide['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="date_travel_form">วันที่เที่ยว (Travel Date)</label></br>
                                        <input type="text" class="form-control date-picker" id="date_travel_form" name="date_travel_form" value="<?php echo $get_date; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="refcode">Booking No #</label>
                                        <input type="text" class="form-control" id="refcode" name="refcode" value="<?php echo $refcode; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="voucher_no">Voucher No #</label>
                                        <input type="text" class="form-control" id="voucher_no" name="voucher_no" value="<?php echo $search_voucher_no; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Customer Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr class="pb-0 pt-0">
                    <div id="order-guide-search-table">
                        <?php
                        # --- get data --- #
                        $first_order = array();
                        $first_bo = array();
                        $first_cus = array();
                        $first_ext = array();
                        $first_bpr = array();
                        $first_pay = array();
                        $first_bomanage = array();
                        $sum_programe = 0;
                        $sum_ad = 0;
                        $sum_chd = 0;
                        $sum_inf = 0;
                        # --- get data --- #
                        $orders = $orderObj->showlistboats('guide', 0, $get_date, $search_boat, $search_guide, $search_status, $search_agent, $search_product, $search_voucher_no, $refcode, $name, '');
                        if (!empty($orders)) {
                            foreach ($orders as $order) {
                                if ((in_array($order['mange_id'], $first_order) == false) && !empty($order['mange_id'])) {
                                    $first_order[] = $order['mange_id'];
                                    $mange_id[] = !empty($order['mange_id']) ? $order['mange_id'] : 0;
                                    $order_boat_id[] = !empty($order['boat_id']) ? $order['boat_id'] : '';
                                    $order_boat_name[] = empty($order['boat_id']) ? !empty($order['orboat_boat_name']) ? $order['orboat_boat_name'] : '' : $order['boat_name'];
                                    $order_boat_refcode[] = !empty($order['boat_refcode']) ? $order['boat_refcode'] : '';
                                    $order_capt_id[] = !empty($order['capt_id']) ? $order['capt_id'] : 0;
                                    $order_counter[] = !empty($order['manage_counter']) ? $order['manage_counter'] : '';
                                    $order_guide_id[] = !empty($order['guide_id']) ? $order['guide_id'] : 0;
                                    $order_guide_name[] = !empty($order['guide_id']) ? $order['guide_name'] : '';
                                    $order_note[] = !empty($order['orboat_note']) ? $order['orboat_note'] : '';
                                    $order_crew_name[] = !empty($order['crew_id']) ? $order['crew_name'] : '';
                                    $order_price[] = !empty($order['orboat_price']) ? $order['orboat_price'] : '';
                                    $color_hex[] = !empty($order['color_hex']) ? $order['color_hex'] : '';
                                    $color_name[] = !empty($order['color_name_th']) ? $order['color_name_th'] : '';
                                    $text_color[] = !empty($order['text_color']) ? $order['text_color'] : '';
                                }

                                if ((in_array($order['id'], $first_bo) == false)  && !empty($order['mange_id'])) {
                                    $first_bo[] = $order['id'];
                                    $bo_id[$order['mange_id']][] = !empty($order['id']) ? $order['id'] : 0;
                                    $check_id[$order['mange_id']][] = !empty($order['check_id']) ? $order['check_id'] : 0;
                                    $book_full[$order['mange_id']][] = !empty($order['book_full']) ? $order['book_full'] : '';
                                    $agent[$order['mange_id']][] = !empty($order['comp_name']) ? $order['comp_name'] : '';
                                    $voucher_no[$order['mange_id']][] = !empty($order['voucher_no_agent']) ? $order['voucher_no_agent'] : '';
                                    $pickup_time[$order['mange_id']][] = $order['start_pickup'] != '00:00:00' ? $order['end_pickup'] != '00:00:00' ? date('H:i', strtotime($order['start_pickup'])) . '-' . date('H:i', strtotime($order['end_pickup'])) : date('H:i', strtotime($order['start_pickup'])) : '-';
                                    $room_no[$order['mange_id']][] = !empty($order['room_no']) ? $order['room_no'] : '-';
                                    $hotel_pickup[$order['mange_id']][] = !empty($order['pickup_name']) ? $order['pickup_name'] : $order['outside'];
                                    $zone_pickup[$order['mange_id']][] = !empty($order['zonep_name']) ? $order['zonep_name'] : '';
                                    $hotel_dropoff[$order['mange_id']][] = !empty($order['dropoff_name']) ? $order['dropoff_name'] : $order['outside_dropoff'];
                                    $zone_dropoff[$order['mange_id']][] = !empty($order['zoned_name']) ? ' (' . $order['zoned_name'] . ')' : '';
                                    $bp_note[$order['mange_id']][] = !empty($order['bp_note']) ? $order['bp_note'] : '';
                                    $product_name[$order['mange_id']][] = !empty($order['product_name']) ? $order['product_name'] : '';
                                    $booking_type[$order['mange_id']][] = !empty($order['bp_private_type']) && $order['bp_private_type'] == 2 ? 'Private' : 'Join';
                                    // $adult[$order['mange_id']][] = !empty($order['bpr_adult']) ? $order['bpr_adult'] : 0;
                                    // $child[$order['mange_id']][] = !empty($order['bpr_child']) ? $order['bpr_child'] : 0;
                                    // $infant[$order['mange_id']][] = !empty($order['bpr_infant']) ? $order['bpr_infant'] : 0;
                                    // $foc[$order['mange_id']][] = !empty($order['bpr_foc']) ? $order['bpr_foc'] : 0;
                                    // $rate_adult[$order['mange_id']][] = !empty($order['rate_adult']) ? $order['rate_adult'] : 0;
                                    // $rate_child[$order['mange_id']][] = !empty($order['rate_child']) ? $order['rate_child'] : 0;
                                    $car_name[$order['mange_id']][] = !empty($order['car_id']) ? $order['car_name'] : '';
                                    $start_pickup[$order['mange_id']][] = !empty($order['start_pickup']) ? date('H:i', strtotime($order['start_pickup'])) : '00:00:00';
                                    $pickup_type[$order['mange_id']][] = !empty($order['pickup_type']) ? $order['pickup_type'] : 0;
                                    $total[$order['mange_id']][] = $order['booktye_id'] == 1 ? ($order['bpr_adult'] * $order['rate_adult']) + ($order['bpr_child'] * $order['rate_child']) + ($order['rate_infant'] * $order['rate_infant']) : $order['rate_private'];
                                    $language[$order['id']] = !empty($order['lang_name']) ? $order['lang_name'] : '';
                                }

                                # --- get value rates --- #
                                if ((in_array($order['bpr_id'], $first_bpr) == false) && !empty($order['bpr_id'])) {
                                    $first_bpr[] = $order['bpr_id'];
                                    $bpr_id[$order['id']][] = !empty($order['bpr_id']) ? $order['bpr_id'] : 0;
                                    $category_id[$order['id']][] = !empty($order['category_id']) ? $order['category_id'] : 0;
                                    $category_name[$order['id']][] = !empty($order['category_name']) ? $order['category_name'] : '';
                                    $category_cus[$order['id']][] = !empty($order['category_cus']) ? $order['category_cus'] : 0;
                                    $adult[$order['id']][] = !empty($order['bpr_adult']) ? $order['bpr_adult'] : 0;
                                    $child[$order['id']][] = !empty($order['bpr_child']) ? $order['bpr_child'] : 0;
                                    $infant[$order['id']][] = !empty($order['bpr_infant']) ? $order['bpr_infant'] : 0;
                                    $foc[$order['id']][] = !empty($order['bpr_foc']) ? $order['bpr_foc'] : 0;
                                    $rate_adult[$order['id']][] = !empty($order['rate_adult']) ? $order['rate_adult'] : 0;
                                    $rate_child[$order['id']][] = !empty($order['rate_child']) ? $order['rate_child'] : 0;
                                    $rate_infant[$order['id']][] = !empty($order['rate_infant']) ? $order['rate_infant'] : 0;
                                    $rate_total[$order['id']][] = !empty($order['rate_total']) ? $order['rate_total'] : 0;
                                    $rate_private[$order['id']][] = !empty($order['rate_private']) ? $order['rate_private'] : 0;
                                }

                                $bopay_name[$order['id']] = !empty($order['bopay_name']) ? $order['bopay_name'] : '';

                                if (in_array($order['cus_id'], $first_cus) == false) {
                                    $first_cus[] = $order['cus_id'];
                                    $cus_id[$order['id']][] = !empty($order['cus_id']) ? $order['cus_id'] : 0;
                                    $cus_name[$order['id']][] = !empty($order['cus_name']) ? $order['cus_name'] : '';
                                    $telephone[$order['id']][] = !empty($order['telephone']) ? $order['telephone'] : '';
                                    $cus_id_card[$order['id']][] = !empty($order['id_card']) ? $order['id_card'] : '';
                                    $nation_name[$order['id']][] = !empty($order['nation_name']) ? ' (' . $order['nation_name'] . ')' : '';
                                }

                                # --- get value booking extra chang --- #
                                if ((in_array($order['bec_id'], $first_ext) == false) && !empty($order['bec_id'])) {
                                    $first_ext[] = $order['bec_id'];
                                    $bec_id[$order['id']][] = !empty($order['bec_id']) ? $order['bec_id'] : 0;
                                    $extra_id[$order['id']][] = !empty($order['extra_id']) ? $order['extra_id'] : 0;
                                    $extra_name[$order['id']][] = !empty($order['extra_name']) ? $order['extra_name'] : '';
                                    $bec_type[$order['id']][] = !empty($order['bec_type']) ? $order['bec_type'] : 0;
                                    $bec_adult[$order['id']][] = !empty($order['bec_adult']) ? $order['bec_adult'] : 0;
                                    $bec_child[$order['id']][] = !empty($order['bec_child']) ? $order['bec_child'] : 0;
                                    $bec_infant[$order['id']][] = !empty($order['bec_infant']) ? $order['bec_infant'] : 0;
                                    $bec_privates[$order['id']][] = !empty($order['bec_privates']) ? $order['bec_privates'] : 0;
                                    $bec_rate_adult[$order['id']][] = !empty($order['bec_rate_adult']) ? $order['bec_rate_adult'] : 0;
                                    $bec_rate_child[$order['id']][] = !empty($order['bec_rate_child']) ? $order['bec_rate_child'] : 0;
                                    $bec_rate_infant[$order['id']][] = !empty($order['bec_rate_infant']) ? $order['bec_rate_infant'] : 0;
                                    $bec_rate_private[$order['id']][] = !empty($order['bec_rate_private']) ? $order['bec_rate_private'] : 0;
                                    $bec_rate_total[$order['id']][] = $order['bec_type'] > 0 ? $order['bec_type'] == 1 ? (($order['bec_adult'] * $order['bec_rate_adult']) + ($order['bec_child'] * $order['bec_rate_child']) + ($order['bec_infant'] * $order['bec_rate_infant'])) : ($order['bec_privates'] * $order['bec_rate_private']) : 0;
                                    $bec_extar_unit[$order['id']][] = $order['bec_type'] > 0 ? $order['bec_type'] == 1 ? ($order['bec_adult'] + $order['bec_child'] + $order['bec_infant']) . ' คน' : $order['bec_privates'] . ' ' . $order['extra_unit'] : '';
                                    $bec_name[$order['id']][] = !empty($order['extra_id']) ? $order['extra_name'] : $order['bec_name'];
                                }

                                # --- in array get value booking payment --- #
                                if ((in_array($order['bopa_id'], $first_pay) == false) && !empty($order['bopa_id'])) {
                                    $first_pay[] = $order['bopa_id'];
                                    if ($order['bopay_id'] == 4) {
                                        $cot_id[$order['id']][] = !empty($order['bopa_id']) ? $order['bopa_id'] : 0;
                                        $cot_name[$order['id']] = !empty($order['bopay_name']) ? $order['bopay_name'] . ' (' . number_format($order['total_paid']) . ')' : '';
                                        $cot_class[$order['id']] = !empty($order['bopay_name_class']) ? $order['bopay_name_class'] : '';
                                        $cot[$order['id']][] = !empty($order['total_paid']) ? $order['total_paid'] : 0;
                                    }
                                }

                                if (in_array($order['bomanage_id'], $first_bomanage) == false) {
                                    $first_managet[] = $order['bomanage_id'];
                                    $retrun_t = !empty($order['pickup']) ? 1 : 2;
                                    $managet['bomanage_id'][$order['id']][$retrun_t] = !empty($order['bomanage_id']) ? $order['bomanage_id'] : 0;
                                    $managet['id'][$order['id']][$retrun_t] = !empty($order['manget_id']) ? $order['manget_id'] : 0;
                                    $managet['car'][$order['id']][$retrun_t] = !empty($order['car_name']) ? $order['car_name'] : '';
                                    $managet['driver'][$order['id']][$retrun_t] = !empty($order['driver_name']) ? $order['driver_name'] : '';
                                    $managet['pickup'][$order['id']][] = !empty($order['pickup']) ? $order['pickup'] : 0;
                                    $managet['dropoff'][$order['id']][] = !empty($order['dropoff']) ? $order['dropoff'] : 0;
                                }
                            }
                            $name_img = 'Job Guide [' . date('j F Y', strtotime($get_date)) . ']';
                        }
                        ?>
                        <div class="content-header">
                            <div class="pl-1 pt-0 pb-0">
                                <a href="<?php echo $href; ?>" target="_blank" class="btn btn-info">Print</a>
                                <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="download_image();">Image</button></a>
                                <a href="javascript:void(0);" class="btn btn-info disabled" hidden>Download as PDF</a>
                            </div>
                        </div>
                        <hr class="pb-0 pt-0">
                        <div id="order-guide-image-table" style="background-color: #FFF;">
                            <!-- Header starts -->
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing">
                                    <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="50"></span>
                                    <span style="color: #000;">
                                    บริษัท บลู แพลนเน็ต ฮอลิเดย์ จํากัด </br>
                                    124/343 หมู่ที่ 5 ตำบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000
                                    </span>
                                </div>
                                <div class="text-center card-text">
                                    <h4 class="font-weight-bolder">ใบไกด์ - Daily Guide Report</h4>
                                    <div class="badge badge-pill badge-light-danger">
                                        <h5 class="m-0 pl-1 pr-1 text-danger"><?php echo date('j F Y', strtotime($get_date)); ?></h5>
                                    </div>
                                </div>
                            </div>
                            </br>
                            <!-- Header ends -->
                            <!-- Body starts -->
                            <div id="div-guide-list">
                                <?php
                                if (!empty($mange_id)) {
                                    for ($i = 0; $i < count($mange_id); $i++) {
                                        $total_no = 0;
                                        if (!empty($bo_id[$mange_id[$i]]) && !empty($check_id[$mange_id[$i]])) {
                                            $checkall = count($bo_id[$mange_id[$i]]) == count(array_filter($check_id[$mange_id[$i]], "check_in")) ? 'checked' : '';
                                        }
                                ?>
                                        <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1">
                                            <div class="col-4 text-left text-bold h4"></div>
                                            <div class="col-4 text-center text-bold h4"><?php echo $order_boat_name[$i]; ?></div>
                                            <div class="col-4 text-right mb-50"></div>
                                        </div>

                                        <table class="table table-striped text-uppercase table-vouchure-t2">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th colspan="6">ไกด์ : <?php echo $order_guide_name[$i]; ?></th>
                                                    <th colspan="7">เคาน์เตอร์ : <?php echo $order_counter[$i]; ?></th>
                                                    <th colspan="4" style="background-color: <?php echo $color_hex[$i]; ?>; <?php echo $text_color[$i] != '' ? 'color: ' . $text_color[$i] . ';' : ''; ?>">
                                                        สี : <?php echo $color_name[$i]; ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center" width="1%">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input dt-checkboxes" type="checkbox" id="checkall<?php echo $mange_id[$i]; ?>" onclick="checkbox(<?php echo $mange_id[$i]; ?>);" <?php echo !empty($checkall) ? $checkall : ''; ?> />
                                                            <label class="custom-control-label" for="checkall<?php echo $mange_id[$i]; ?>"></label>
                                                        </div>
                                                    </th>
                                                    <th width="5%">เวลารับ</th>
                                                    <th width="5%">Driver</th>
                                                    <th width="20%">โปรแกรม</th>
                                                    <th width="15%">เอเยนต์</th>
                                                    <th width="15%">ชื่อลูกค้า</th>
                                                    <th>ภาษา (ไกด์)</th>
                                                    <th width="5%">V/C</th>
                                                    <th width="15%">โรงแรม</th>
                                                    <th width="5%">โซน</th>
                                                    <th width="9%">ห้อง</th>
                                                    <th class="text-center" width="1%">A</th>
                                                    <th class="text-center" width="1%">C</th>
                                                    <th class="text-center" width="1%">Inf</th>
                                                    <th class="text-center" width="1%">FOC</th>
                                                    <!-- <th class="text-center" width="1%">รวม</th> -->
                                                    <th width="5%">COT</th>
                                                    <th width="5%">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total_tourist = 0;
                                                $total_adult = 0;
                                                $total_child = 0;
                                                $total_infant = 0;
                                                $total_foc = 0;
                                                if (!empty($bo_id[$mange_id[$i]])) {
                                                    for ($a = 0; $a < count($bo_id[$mange_id[$i]]); $a++) {
                                                        $id = $bo_id[$mange_id[$i]][$a];
                                                        $total_tourist = $total_tourist + array_sum($adult[$id]) + array_sum($child[$id]) + array_sum($infant[$id]) + array_sum($foc[$id]);
                                                        $total_adult = $total_adult + array_sum($adult[$id]);
                                                        $total_child = $total_child + array_sum($child[$id]);
                                                        $total_infant = $total_infant + array_sum($infant[$id]);
                                                        $total_foc = $total_foc + array_sum($foc[$id]);
                                                ?>
                                                        <tr>
                                                            <td class="text-center">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input class="custom-control-input dt-checkboxes checkbox-<?php echo $mange_id[$i]; ?>" type="checkbox" data-check="<?php echo $check_id[$mange_id[$i]][$a]; ?>" data-mange="<?php echo $mange_id[$i]; ?>" id="checkbox<?php echo $id; ?>" value="<?php echo $id; ?>" onclick="submit_check_in('only', this);" <?php echo $check_id[$mange_id[$i]][$a] > 0 ? 'checked' : ''; ?> />
                                                                    <label class="custom-control-label" for="checkbox<?php echo $id; ?>"></label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center"><?php echo $pickup_time[$mange_id[$i]][$a]; ?></td>
                                                            <td><?php echo (!empty($managet['car'][$id][1])) ? $managet['car'][$id][1] : '';
                                                                echo !empty($managet['driver'][$id][1]) ? $managet['driver'][$id][1] : ''; ?></td>
                                                            <td><?php echo $product_name[$mange_id[$i]][$a];
                                                                if (!empty($category_name[$id])) {
                                                                    echo ' (';
                                                                    for ($c = 0; $c < count($category_name[$id]); $c++) {
                                                                        echo $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                                                                    }
                                                                }
                                                                echo ')'; ?></td>
                                                            <td><?php echo $agent[$mange_id[$i]][$a]; ?></td>
                                                            <td><?php echo !empty($telephone[$bo_id[$mange_id[$i]][$a]][0]) ? $cus_name[$bo_id[$mange_id[$i]][$a]][0] . ' <br>(' . $telephone[$bo_id[$mange_id[$i]][$a]][0] . ')' . $nation_name[$bo_id[$mange_id[$i]][$a]][0] : $cus_name[$bo_id[$mange_id[$i]][$a]][0] . ' ' . $nation_name[$bo_id[$mange_id[$i]][$a]][0]; ?></td>
                                                            <td class="text-nowrap"><?php echo !empty($language[$id]) ? $language[$id] : ''; ?></td>
                                                            <td><?php echo !empty($voucher_no[$mange_id[$i]][$a]) ? $voucher_no[$mange_id[$i]][$a] : $book_full[$mange_id[$i]][$a]; ?></td>
                                                            <td style="padding: 5px;"><?php echo ($pickup_type[$mange_id[$i]][$a] == 1) ? (!empty($hotel_pickup[$mange_id[$i]][$a])) ? $hotel_pickup[$mange_id[$i]][$a] : '' : 'เดินทางมาเอง'; ?></td>
                                                            <td style="padding: 5px;"><?php echo ($pickup_type[$mange_id[$i]][$a] == 1) ? (!empty($zone_pickup[$mange_id[$i]][$a])) ? $zone_pickup[$mange_id[$i]][$a] : '' : 'เดินทางมาเอง'; ?></td>
                                                            <td><?php echo $room_no[$mange_id[$i]][$a]; ?></td>
                                                            <td class="text-center"><?php echo array_sum($adult[$id]); ?></td>
                                                            <td class="text-center"><?php echo array_sum($child[$id]); ?></td>
                                                            <td class="text-center"><?php echo array_sum($infant[$id]); ?></td>
                                                            <td class="text-center"><?php echo array_sum($foc[$id]); ?></td>
                                                            <td class="text-center"><?php echo !empty($bec_rate_total[$id]) ? number_format($total[$mange_id[$i]][$a] + array_sum($bec_rate_total[$id])) : number_format($total[$mange_id[$i]][$a]); ?></td>
                                                            <td><b class="text-info">
                                                                    <?php if (!empty($bec_id[$id])) {
                                                                        for ($e = 0; $e < count($bec_name[$id]); $e++) {
                                                                            echo $e == 0 ? $bec_name[$id][$e] : ' : ' . $bec_name[$id][$e];
                                                                        }
                                                                    }
                                                                    echo !empty($bp_note[$mange_id[$i]][$a]) ? ' / ' . $bp_note[$mange_id[$i]][$a] : ''; ?>
                                                                </b>
                                                            </td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>

                                        <div class="text-center mt-1 pb-2">
                                            <h4>
                                                <div class="badge badge-pill badge-light-warning">
                                                    <b class="text-danger">TOTAL <?php echo $total_tourist; ?></b> |
                                                    Adult : <?php echo $total_adult; ?>
                                                    Child : <?php echo $total_child; ?>
                                                    Infant : <?php echo $total_infant; ?>
                                                    FOC : <?php echo $total_foc; ?>
                                                </div>
                                            </h4>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                            <!-- Body ends -->
                            <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
                        </div>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- order job list ends -->

        </div>
    </div>
</div>
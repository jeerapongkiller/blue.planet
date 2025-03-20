<?php
require_once 'controllers/Order.php';

$manageObj = new Order();
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime(" +1 day"));
// $today = '2025-01-16';
// $tomorrow = '2025-01-17';
$get_date = !empty($_GET['date_travel_booking']) ? $_GET['date_travel_booking'] : $today; // $tomorrow->format("Y-m-d")
$search_boat = !empty($_GET['search_boat']) ? $_GET['search_boat'] : 'all';
// $search_guide = !empty($_GET['search_guide']) ? $_GET['search_guide'] : 'all';
$search_status = $_GET['search_status'] != "" ? $_GET['search_status'] : 'all';
$search_agent = $_GET['search_agent'] != "" ? $_GET['search_agent'] : 'all';
$search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
$search_voucher_no = $_GET['voucher_no'] != "" ? $_GET['voucher_no'] : '';
$refcode = $_GET['refcode'] != "" ? $_GET['refcode'] : '';
$name = $_GET['name'] != "" ? $_GET['name'] : '';

$href = "&date_travel=" . $get_date;
$href .= "&search_boat=" . $search_boat;
// $href .= "&search_guide=" . $search_guide;
$href .= "&search_status=" . $search_status;
$href .= "&search_agent=" . $search_agent;
$href .= "&search_product=" . $search_product;
$href .= "&search_voucher_no=" . $search_voucher_no;
$href .= "&refcode=" . $refcode;
$href .= "&name=" . $name;
# --- show list boats booking --- #
$first_booking = array();
$first_prod = array();
$first_cus = array();
$first_program = array();
$first_ext = array();
$first_bomanage = array();
$first_bpr = array();
$first_bo = [];
$first_trans = [];
$bookings = $manageObj->showlistboats('list', 0, $get_date, $search_boat, $search_guide, $search_status, $search_agent, $search_product, $search_voucher_no, $refcode, $name, '');
# --- Check products --- #
if (!empty($bookings)) {
    foreach ($bookings as $booking) {
        # --- get value Programe --- #
        if (in_array($booking['product_id'], $first_prod) == false) {
            $first_prod[] = $booking['product_id'];
            $programe_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
            $programe_name[] = !empty($booking['product_name']) ? $booking['product_name'] : '';
            $programe_type[] = !empty($booking['pg_type_name']) ? $booking['pg_type_name'] : '';
            $programe_pier[] = !empty($booking['pier_name']) ? $booking['pier_name'] : '';
        }
        # --- get value booking --- #
        if (in_array($booking['id'], $first_booking) == false) {
            $first_booking[] = $booking['id'];
            $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
            $status_by_name[$booking['id']] = !empty($booking['status_by']) ? $booking['stabyFname'] . ' ' . $booking['stabyLname'] : '';
            $status[$booking['id']] = '<span class="badge badge-pill ' . $booking['booksta_class'] . ' text-capitalized"> ' . $booking['booksta_name'] . ' </span>';
            $cate_transfer[$booking['id']] = !empty($booking['category_transfer']) ? $booking['category_transfer'] : 0;
            $hotel_name[$booking['id']] = !empty($booking['pickup_name']) ? $booking['pickup_name'] : '';
            $zone_pickup[$booking['id']] = !empty($booking['zonep_name']) ? ' (' . $booking['zonep_name'] . ')' : '';
            $dropoff_name[$booking['id']] = !empty($booking['dropoff_name']) ? $booking['dropoff_name'] : '';
            $zone_dropoff[$booking['id']] = !empty($booking['zoned_name']) ? ' (' . $booking['zoned_name'] . ')' : '';
            $room_no[$booking['id']] = !empty($booking['room_no']) ? $booking['room_no'] : '';
            $start_pickup[$booking['id']] = !empty($booking['start_pickup']) && $booking['start_pickup'] != '00:00' ? $booking['start_pickup'] : '00:00';
            $outside[$booking['id']] = !empty($booking['outside']) ? $booking['outside'] : '';
            $outside_dropoff[$booking['id']] = !empty($booking['outside_dropoff']) ? $booking['outside_dropoff'] : '';
            $pickup_type[$booking['id']] = !empty($booking['pickup_type']) ? $booking['pickup_type'] : 0;
            $sender[$booking['id']] = !empty($booking['sender']) ? $booking['sender'] : '';
            $note[$booking['id']] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
            $bp_id[$booking['id']] = !empty($booking['bp_id']) ? $booking['bp_id'] : 0;
            $cot[$booking['id']] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
            $book_full[$booking['id']] = !empty($booking['book_full']) ? $booking['book_full'] : '';
            $voucher_no[$booking['id']] = !empty(!empty($booking['voucher_no_agent'])) ? $booking['voucher_no_agent'] : '';
            $travel_date[$booking['id']] = !empty(!empty($booking['travel_date'])) ? $booking['travel_date'] : '0000-00-00';
            $product_name[$booking['id']] = !empty(!empty($booking['product_name'])) ? $booking['product_name'] : '';
            $agent_name[$booking['id']] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
            $mange_id[$booking['id']] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
            $bo_mange_id[$booking['id']] = !empty($booking['boman_id']) ? $booking['boman_id'] : 0;
            $boat_id[$booking['id']] = !empty($booking['boat_id']) ? $booking['boat_id'] : '';
            $boat_name[$booking['id']] = !empty($booking['boat_name']) ? $booking['boat_name'] : '';
            $color_id[$booking['id']] = !empty($booking['color_id']) ? $booking['color_id'] : '';
            $language[$booking['id']] = !empty(!empty($booking['lang_name'])) ? $booking['lang_name'] : '';
            # --- array programe --- #
            $check_mange[$booking['product_id']][] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
            $prod_adult[$booking['product_id']][] = !empty($booking['bpr_adult']) && $booking['mange_id'] == 0 ? $booking['bpr_adult'] : 0;
            $prod_child[$booking['product_id']][] = !empty($booking['bpr_child']) && $booking['mange_id'] == 0 ? $booking['bpr_child'] : 0;
            $prod_infant[$booking['product_id']][] = !empty($booking['bpr_infant']) && $booking['mange_id'] == 0 ? $booking['bpr_infant'] : 0;
            $prod_foc[$booking['product_id']][] = !empty($booking['bpr_foc']) && $booking['mange_id'] == 0 ? $booking['bpr_foc'] : 0;
        }
        # --- get value customer --- #
        if (in_array($booking['cus_id'], $first_cus) == false) {
            $first_cus[] = $booking['cus_id'];
            $cus_id[$booking['id']][] = !empty($booking['cus_id']) ? $booking['cus_id'] : 0;
            $cus_name[$booking['id']][] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
            $passport[$booking['id']][] = !empty($booking['id_card']) ? $booking['id_card'] : '';
            $birth_date[$booking['id']][] = !empty($booking['birth_date']) && $booking['birth_date'] != '0000-00-00' ? date('j F Y', strtotime($booking['birth_date'])) : '';
            $nation_name[$booking['id']][] = !empty($booking['nation_name']) ? $booking['nation_name'] : '';
        }

        if (in_array($booking['id'], $first_bo) == false) {
            $first_bo[] = $booking['id'];
            $book['id'][$booking['mange_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
            $book['voucher'][$booking['mange_id']][] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
            $book['book_full'][$booking['mange_id']][] = !empty($booking['book_full']) ? $booking['book_full'] : '';
            $book['sender'][$booking['mange_id']][] = !empty($booking['sender']) ? $booking['sender'] : '';
            $book['start_pickup'][$booking['mange_id']][] = !empty($booking['start_pickup']) ? date('H:i', strtotime($booking['start_pickup'])) : '';
            $book['end_pickup'][$booking['mange_id']][] = !empty($booking['end_pickup']) ? date('H:i', strtotime($booking['end_pickup'])) : '';
            $book['hotel'][$booking['mange_id']][] = !empty($booking['pickup_name']) ? $booking['pickup_name'] : '';
            $book['room_no'][$booking['mange_id']][] = !empty($booking['room_no']) ? $booking['room_no'] : '';
            $book['cus_name'][$booking['mange_id']][] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
            $book['telephone'][$booking['mange_id']][] = !empty($booking['telephone']) ? $booking['telephone'] : '';
            $book['comp_name'][$booking['mange_id']][] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
            $book['nation_name'][$booking['mange_id']][] = !empty($booking['nation_name']) ? ' (' . $booking['nation_name'] . ')' : '';
            // $book['adult'][$booking['mange_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
            // $book['child'][$booking['mange_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
            // $book['infant'][$booking['mange_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
            // $book['foc'][$booking['mange_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
            // $book['rate_adult'][$booking['mange_id']][] = !empty($booking['rate_adult']) ? $booking['rate_adult'] : 0;
            // $book['rate_child'][$booking['mange_id']][] = !empty($booking['rate_child']) ? $booking['rate_child'] : 0;
            // $book['rate_infant'][$booking['mange_id']][] = !empty($booking['rate_infant']) ? $booking['rate_infant'] : 0;
            // $book['rate_private'][$booking['mange_id']][] = !empty($booking['rate_private']) ? $booking['rate_private'] : 0;
            $book['discount'][$booking['mange_id']][] = !empty(!empty($booking['bp_discount'])) ? $booking['bp_discount'] : 0;
            $book['note'][$booking['mange_id']][] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
            $book['cot'][$booking['mange_id']][] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
            $book['total'][$booking['mange_id']][] = $booking['booktye_id'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) + ($booking['rate_infant'] * $booking['rate_infant']) : $booking['rate_private'];
            $book['bo_mange_id'][$booking['mange_id']][] = !empty($booking['boman_id']) ? $booking['boman_id'] : 0;
        }
        # --- get value booking rates --- #
        if ((in_array($booking['bpr_id'], $first_bpr) == false) && !empty($booking['bpr_id'])) {
            $first_bpr[] = $booking['bpr_id'];
            $bpr_id[$booking['id']][] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
            $category_id[$booking['id']][] = !empty($booking['category_id']) ? $booking['category_id'] : 0;
            $category_name[$booking['id']][] = !empty($booking['category_name']) ? $booking['category_name'] : 0;
            $category_cus[$booking['id']][] = !empty($booking['category_cus']) ? $booking['category_cus'] : 0;
            $adult[$booking['id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
            $child[$booking['id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
            $infant[$booking['id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
            $foc[$booking['id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
        }
        # --- get value booking extra chang --- #
        if ((in_array($booking['bec_id'], $first_ext) == false) && !empty($booking['bec_id'])) {
            $first_ext[] = $booking['bec_id'];
            $bec_id[$booking['id']][] = !empty($booking['bec_id']) ? $booking['bec_id'] : 0;
            $bec_name[$booking['id']][] = !empty($booking['bec_name']) ? $booking['bec_name'] : $booking['extra_name'];
            $bec_type[$booking['id']][] = !empty($booking['bec_type']) ? $booking['bec_type'] : 0;
            $bec_adult[$booking['id']][] = !empty($booking['bec_adult']) ? $booking['bec_adult'] : 0;
            $bec_child[$booking['id']][] = !empty($booking['bec_child']) ? $booking['bec_child'] : 0;
            $bec_infant[$booking['id']][] = !empty($booking['bec_infant']) ? $booking['bec_infant'] : 0;
            $bec_privates[$booking['id']][] = !empty($booking['bec_privates']) ? $booking['bec_privates'] : 0;
            $bec_rate_adult[$booking['id']][] = !empty($booking['bec_rate_adult']) ? $booking['bec_rate_adult'] : 0;
            $bec_rate_child[$booking['id']][] = !empty($booking['bec_rate_child']) ? $booking['bec_rate_child'] : 0;
            $bec_rate_infant[$booking['id']][] = !empty($booking['bec_rate_infant']) ? $booking['bec_rate_infant'] : 0;
            $bec_rate_private[$booking['id']][] = !empty($booking['bec_rate_private']) ? $booking['bec_rate_private'] : 0;
            $bec_rate_total[$booking['id']][] = $booking['bec_type'] > 0 ? $booking['bec_type'] == 1 ? (($booking['bec_adult'] * $booking['bec_rate_adult']) + ($booking['bec_child'] * $booking['bec_rate_child']) + ($booking['bec_infant'] * $booking['bec_rate_infant'])) : ($booking['bec_privates'] * $booking['bec_rate_private']) : 0;
        }

        if (!empty($booking['cus_name'])) {
            $customers[$booking['mange_id']]['id'][] = !empty($booking['cus_id']) ? $booking['cus_id'] : 0;
            $customers[$booking['mange_id']]['age'][] = !empty($booking['cus_age']) ? $booking['cus_age'] : 0;
            $customers[$booking['mange_id']]['nation_id'][] = !empty($booking['nation_id']) ? $booking['nation_id'] : 0;
            $customers[$booking['mange_id']]['age_name'][] = !empty($booking['cus_age']) ? $booking['cus_age'] != 1 ? $booking['cus_age'] != 2 ? $booking['cus_age'] != 3 ? $booking['cus_age'] == 4 ? 'FOC' : '' : 'Infant' : 'Children' : 'Adult' : '';
            $customers[$booking['mange_id']]['name'][] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
            $customers[$booking['mange_id']]['passport'][] = !empty($booking['id_card']) ? $booking['id_card'] : '';
            $customers[$booking['mange_id']]['birth'][] = !empty($booking['birth_date']) && $booking['birth_date'] != '0000-00-00' ? date('j F Y', strtotime($booking['birth_date'])) : '';
            $customers[$booking['mange_id']]['nation'][] = !empty($booking['nation_name']) ? $booking['nation_name'] : '';
            $customers[$booking['mange_id']]['voucher_no'][] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
        }

        if (in_array($booking['bomanage_id'], $first_bomanage) == false) {
            $first_managet[] = $booking['bomanage_id'];
            $retrun_t = !empty($booking['pickup']) ? 1 : 2;
            $managet['bomanage_id'][$booking['id']][$retrun_t] = !empty($booking['bomanage_id']) ? $booking['bomanage_id'] : 0;
            $managet['id'][$booking['id']][$retrun_t] = !empty($booking['manget_id']) ? $booking['manget_id'] : 0;
            $managet['car'][$booking['id']][$retrun_t] = !empty($booking['car_name']) ? $booking['car_name'] : '';
            $managet['driver'][$booking['id']][$retrun_t] = !empty($booking['driver_name']) ? $booking['driver_name'] : '';
            $managet['pickup'][$booking['id']][] = !empty($booking['pickup']) ? $booking['pickup'] : 0;
            $managet['dropoff'][$booking['id']][] = !empty($booking['dropoff']) ? $booking['dropoff'] : 0;
        }
    }
}
# --- show list boats manage --- #
$first_manage = array();
$manages = $manageObj->show_manage_boat($get_date, $search_boat);
if (!empty($manages)) {
    foreach ($manages as $manage) {
        if (in_array($manage['id'], $first_manage) == false) {
            $first_manage[] = $manage['id'];
            $mange['id'][] = !empty($manage['id']) ? $manage['id'] : 0;
            $mange['color_id'][] = !empty($manage['color_id']) ? $manage['color_id'] : 0;
            $mange['color_name'][] = !empty($manage['color_name_th']) ? $manage['color_name_th'] : '';
            $mange['text_color'][] = !empty($manage['text_color']) ? $manage['text_color'] : '';
            $mange['color_hex'][] = !empty($manage['color_hex']) ? $manage['color_hex'] : '';
            $mange['time'][] = !empty($manage['time']) ? date('H:i', strtotime($manage['time'])) : '00:00';
            $mange['boat_id'][] = !empty($manage['boat_id']) ? $manage['boat_id'] : 0;
            $mange['boat_name'][] = !empty($manage['boat_id']) ? !empty($manage['boat_name']) ? $manage['boat_name'] : '' : $manage['outside_boat'];
            $mange['counter'][] = !empty($manage['counter']) ? $manage['counter'] : '';
            $mange['guide_id'][] = !empty($manage['guide_id']) ? $manage['guide_id'] : 0;
            $mange['guide_name'][] = !empty($manage['guide_name']) ? $manage['guide_name'] : '';
            $mange['captain_id'][] = !empty($manage['captain_id']) ? $manage['captain_id'] : 0;
            $mange['captain_name'][] = !empty($manage['captain_id']) ?  $manage['captain_name'] : '';
            $mange['crewf_id'][] = !empty($manage['crewf_id']) ? $manage['crewf_id'] : 0;
            $mange['crews_id'][] = !empty($manage['crews_id']) ? $manage['crews_id'] : 0;
            $mange['crewf_name'][] = !empty($manage['crewf_id']) ? $manage['crewf_name'] : '';
            $mange['crews_name'][] = !empty($manage['crews_id']) ? $manage['crews_name'] : '';
            $mange['product_id'][] = !empty($manage['product_id']) ? $manage['product_id'] : 0;
            $mange['product_name'][] = !empty($manage['product_name']) ? $manage['product_name'] : '';
            $mange['booktye_name'][] = !empty($manage['booktye_name']) ? $manage['booktye_name'] : '';
            $mange['pier_name'][] = !empty($manage['pier_name']) ? $manage['pier_name'] : '';
            $mange['note'][] = !empty($manage['note']) ? $manage['note'] : '';
            $mange['outside_boat'][] = !empty($manage['outside_boat']) ? $manage['outside_boat'] : '';

            $arr_boat['mange_id'][] = !empty($manage['id']) ? $manage['id'] : 0;
            $arr_boat['id'][] = !empty($manage['boat_id']) ? $manage['boat_id'] : 0;
            $arr_boat['boat_id'][] = !empty($manage['boat_id']) ? $manage['boat_id'] : 0;
            $arr_boat['name'][] = !empty($manage['boat_id']) ? !empty($manage['boat_name']) ? $manage['boat_name'] : '' : $manage['outside_boat'];
            $arr_boat['refcode'][] = !empty($manage['boat_refcode']) ? $manage['boat_refcode'] : '';
        }
    }
}
# --- show list programe --- #
$programed = $manageObj->show_manage_programe($get_date);
if (!empty($programed)) {
    foreach ($programed as $program) {
        if (in_array($program['id'], $first_program) == false) {
            $first_program[] = $program['id'];
            $programed_id[] = !empty($program['id']) ? $program['id'] : 0;
        }
    }
}
?>

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Manage Boat</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                </div>
            </div>
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
            <section id="sortable-lists">
                <!-- bookings filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="booking-search-form" name="booking-search-form" method="get" enctype="multipart/form-data">
                        <input type="hidden" name="pages" value="<?php echo $_GET['pages']; ?>">
                        <div class="d-flex align-items-center mx-50 row pt-0 pb-0">
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="search_status">Status</label>
                                    <select class="form-control select2" id="search_status" name="search_status">
                                        <option value="all">All</option>
                                        <?php
                                        $bookstype = $manageObj->showliststatus();
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
                                        $agents = $manageObj->showlistagent();
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
                                        $products = $manageObj->showlistproduct();
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
                                        $boats = $manageObj->show_boats();
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
                                <div class="form-group">
                                    <label class="form-label" for="date_travel_booking">วันที่เที่ยว (Travel Date)</label></br>
                                    <input type="text" class="form-control date-picker" id="date_travel_booking" name="date_travel_booking" value="<?php echo $get_date; ?>" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="card-body pt-0 p-50">
                        <a href='./?pages=order-boat/print<?php echo $href; ?>&action=print' target="_blank"><button class="btn btn-info" id="print-btn">Print</button></a>
                        <button type="button" class="btn btn-info waves-effect waves-float waves-light btn-page-block-spinner" onclick="download_image();">Image</button>
                        <a href='./?pages=order-boat/excel<?php echo $href; ?>&action=boat' target="_blank"><button class="btn btn-info waves-effect waves-float waves-light btn-page-block-spinner">Excel</button></a>
                    </div>
                    <div id="div-boat-job-image" style="background-color: #FFF;">
                        <!-- Header starts -->
                        <div class="card-body pb-0">
                            <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing text-black">
                                <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="50"></span>
                                <span style="color: #000;">
                                    บริษัท บลู แพลนเน็ต ฮอลิเดย์ จํากัด </br>
                                    124/343 หมู่ที่ 5 ตำบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000
                                </span>
                            </div>
                            <div class="text-center card-text">
                                <h4 class="font-weight-bolder text-black">ใบจัดเรือ</h4>
                                <div class="badge badge-pill badge-light-danger">
                                    <h5 class="m-0 pl-1 pr-1 text-danger"><?php echo date('j F Y', strtotime($get_date)); ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Header ends -->
                        <!-- Body starts -->
                        <?php
                        if (!empty($mange['id'])) {
                            for ($i = 0; $i < count($mange['id']); $i++) {

                        ?>
                                <textarea id="<?php echo 'customers' . $mange['id'][$i]; ?>" hidden><?php echo json_encode($customers[$mange['id'][$i]], true); ?></textarea>
                                <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1 text-black">
                                    <div class="col-4 text-left h4"></div>
                                    <div class="col-4 text-center font-weight-bolder h4 text-black"><?php echo $mange['boat_name'][$i]; ?></div>
                                    <div class="col-4 text-right mb-50"><button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-dark waves-effect btn-page-block-spinner" data-toggle="modal" data-target="#modal-customers" onclick="modal_customers(<?php echo $mange['id'][$i]; ?>, '<?php echo date('j F Y', strtotime($get_date)); ?>', '<?php echo $mange['boat_name'][$i]; ?>');">รายชื่อลูกค้า</button></div>
                                </div>

                                <table class="table table-striped text-uppercase table-vouchure-t2 text-black" style="font-size: 16px;" width="100%">
                                    <thead class="bg-light">
                                        <tr>
                                            <th colspan="5">ไกด์ : <?php echo $mange['guide_name'][$i]; ?></th>
                                            <th colspan="5">เคาน์เตอร์ : <?php echo $mange['counter'][$i]; ?></th>
                                            <th colspan="5" style="background-color: <?php echo $mange['color_hex'][$i]; ?>; <?php echo $mange['text_color'][$i] != '' ? 'color: ' . $mange['text_color'][$i] . ';' : ''; ?>">
                                                สี : <?php echo $mange['color_name'][$i]; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th width="4%">เวลารับ</th>
                                            <th width="4%">Driver</th>
                                            <th width="10%">โปรแกรม</th>
                                            <th width="10%">เอเยนต์</th>
                                            <th width="6%">ชื่อลูกค้า</th>
                                            <th width="4%">ภาษา (ไกด์)</th>
                                            <th width="3%">V/C</th>
                                            <th width="15%">โรงแรม</th>
                                            <th class="text-center" width="1%">A</th>
                                            <th class="text-center" width="1%">C</th>
                                            <th class="text-center" width="1%">Inf</th>
                                            <th class="text-center" width="1%">FOC</th>
                                            <!-- <th class="text-center">รวม</th> -->
                                            <th width="5%">COT</th>
                                            <th width="15%">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_tourist = 0;
                                        $total_adult = 0;
                                        $total_child = 0;
                                        $total_infant = 0;
                                        $total_foc = 0;
                                        if (!empty($book['id'][$mange['id'][$i]])) {
                                            for ($a = 0; $a < count($book['id'][$mange['id'][$i]]); $a++) {
                                                $id = $book['id'][$mange['id'][$i]][$a];
                                                $total_tourist = $total_tourist + array_sum($adult[$id]) + array_sum($child[$id]) + array_sum($infant[$id]) + array_sum($foc[$id]);
                                                $total_adult = $total_adult + array_sum($adult[$id]);
                                                $total_child = $total_child + array_sum($child[$id]);
                                                $total_infant = $total_infant + array_sum($infant[$id]);
                                                $total_foc = $total_foc + array_sum($foc[$id]);
                                        ?>
                                                <tr>
                                                    <td><?php echo $book['start_pickup'][$mange['id'][$i]][$a] != '00:00' ? $book['start_pickup'][$mange['id'][$i]][$a] . ' - ' . $book['end_pickup'][$mange['id'][$i]][$a] : ''; ?></td>
                                                    <td style="padding: 5px;">
                                                        <?php echo (!empty($managet['car'][$id][1])) ? '<b>Pickup : </b>' . $managet['car'][$id][1] : '';
                                                        echo (!empty($managet['driver'][$id][1])) ? $managet['driver'][$id][1] : '';  ?>
                                                    </td>
                                                    <td style="padding: 5px;"><?php echo $product_name[$id] . '<br>';
                                                        if (!empty($category_name[$id])) {
                                                            echo ' (';
                                                            for ($c = 0; $c < count($category_name[$id]); $c++) {
                                                                echo $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                                                            }
                                                        }
                                                        echo ')'; ?></td>
                                                    <td><?php echo $book['comp_name'][$mange['id'][$i]][$a]; ?></td>
                                                    <td class="wrapword"><?php echo !empty($book['telephone'][$mange['id'][$i]][$a]) ? $book['cus_name'][$mange['id'][$i]][$a] . ' <br>(' . $book['telephone'][$mange['id'][$i]][$a] . ') ' . $book['nation_name'][$mange['id'][$i]][$a] : $book['cus_name'][$mange['id'][$i]][$a]; ?></td>
                                                    <td><?php echo !empty($language[$id]) ? $language[$id] : ''; ?></td>
                                                    <td><?php echo !empty($book['voucher'][$mange['id'][$i]][$a]) ? $book['voucher'][$mange['id'][$i]][$a] : $book['book_full'][$mange['id'][$i]][$a]; ?></td>
                                                    <td class="font-weight-bolder text-danger wrapword"><?php echo (!empty($hotel_name[$id])) ? $hotel_name[$id] : $outside[$id]; ?></td>
                                                    <td class="text-center"><?php echo array_sum($adult[$id]); ?></td>
                                                    <td class="text-center"><?php echo array_sum($child[$id]); ?></td>
                                                    <td class="text-center"><?php echo array_sum($infant[$id]); ?></td>
                                                    <td class="text-center"><?php echo array_sum($foc[$id]); ?></td>
                                                    <td class="text-nowrap"><b class="text-danger"><?php echo $book['cot'][$mange['id'][$i]][$a] > 0 ? number_format($book['cot'][$mange['id'][$i]][$a]) : ''; ?></b></td>
                                                    <td class="wrapword"><b class="text-info">
                                                            <?php if (!empty($bec_id[$id])) {
                                                                for ($e = 0; $e < count($bec_name[$id]); $e++) {
                                                                    echo $e == 0 ? $bec_name[$id][$e] : ' : ' . $bec_name[$id][$e];
                                                                }
                                                            }
                                                            echo !empty($book['note'][$mange['id'][$i]][$a]) ? ' / ' . $book['note'][$mange['id'][$i]][$a] : ''; ?>
                                                        </b>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="15" style="padding: 10px;"><b>Remark : </b><?php echo $mange['note'][$i]; ?></td>
                                            </tr>
                                        <?php } ?>
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
                        <input type="hidden" id="name_img" name="name_img" value="<?php echo 'ใบจัดเรือ - ' . date('j F Y', strtotime($get_date)); ?>">
                        <!-- Body ends -->
                    </div>
                </div>
                <!-- bookings filter end -->
            </section>

            <div class="modal-size-xl d-inline-block">
                <div class="modal fade text-left" id="modal-customers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17">รายชื่อลูกค้า</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="div-park-job-image" style="background-color: #FFF !important;">
                                <div class="table-responsive">
                                    <div class="text-center mb-50">
                                        <div class="badge-light-orange"><b id="text-travel-customer">Travel date</b></div>
                                    </div>
                                    <div class="text-center mb-50">
                                        <div class="badge-light-sky"><b id="text-boat">เรือ</b></div>
                                        <div class="badge-light-purple"><b id="text-prak">อุทยาน</b></div>
                                    </div>
                                    <table class="table table-bordered table-striped table-vouchure-t2" style="table-layout: inherit; width: 100%; overflow: hidden; text-overflow: ellipsis;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-center" width="10%">A/C/I/F</th>
                                                <th class="text-center" width="45%">ชื่อ</th>
                                                <th class="text-center" width="10%">V/C</th>
                                                <th class="text-center" width="15%">สัญชาติ</th>
                                                <th class="text-center" width="15%">Birth Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-tbody-customers">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <input type="hidden" id="customer_img" value="ใบงานอุทยาน">
                                <div>
                                    <button type="button" class="btn btn-success btn-page-block-spinner" onclick="submit_customer();" hidden>Submit</button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-info btn-page-block-spinner" onclick="download_image('customers');">Image</button>
                                    <a href='./?pages=order-boat/print&date_travel=<?php echo $get_date; ?>&action=customer' target="_blank" id="print-customer"><button class="btn btn-warning">Print</button></a>
                                    <a href='./?pages=order-boat/excel&date_travel=<?php echo $get_date; ?>&action=customer' target="_blank" id="excel-customer"><button class="btn btn-success">Excel</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php
require_once 'controllers/Order.php';

$bookObj = new Order();
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime(" +1 day"));
// $today = '2025-01-16';
// $tomorrow = '2025-01-17';
$get_date = !empty($_GET['date_travel_booking']) ? $_GET['date_travel_booking'] : $today; // $tomorrow->format("Y-m-d")
$search_boat = !empty($_GET['search_boat']) ? $_GET['search_boat'] : 'all';
$search_status = $_GET['search_status'] != "" ? $_GET['search_status'] : 'all';
$search_agent = $_GET['search_agent'] != "" ? $_GET['search_agent'] : 'all';
$search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
$search_island = $_GET['search_island'] != "" ? $_GET['search_island'] : 'all';
$search_voucher_no = $_GET['voucher_no'] != "" ? $_GET['voucher_no'] : '';
$refcode = $_GET['refcode'] != "" ? $_GET['refcode'] : '';
# --- show list boats booking --- #
$first_booking = array();
$first_prod = array();
$first_bpr = array();
$first_cus = array();
$first_program = array();
$first_ext = array();
$first_bomanage = array();
$first_bo = [];
$first_trans = [];
$bookings = $bookObj->showlistboats('list', 0, $get_date, $search_boat, 'all', $search_status, $search_agent, $search_island, $search_product, $search_voucher_no, $refcode, '');
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
            $book_id[$booking['product_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
            $status_by_name[$booking['id']] = !empty($booking['status_by']) ? $booking['stabyFname'] . ' ' . $booking['stabyLname'] : '';
            $status[$booking['id']] = '<span class="badge badge-pill ' . $booking['booksta_class'] . ' text-capitalized"> ' . $booking['booksta_name'] . ' </span>';
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
            $language[$booking['id']] = !empty($booking['lang_name']) ? $booking['lang_name'] : '';
            $darken[$booking['id']] = !empty($booking['island_darken']) ? $booking['island_darken'] : '';
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
            $book['nation_name'][$booking['mange_id']][] = !empty($booking['nation_name']) ? ' (' . $booking['nation_name'] . ')' : '';
            $book['comp_name'][$booking['mange_id']][] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
            $book['rate_adult'][$booking['mange_id']][] = !empty($booking['rate_adult']) ? $booking['rate_adult'] : 0;
            $book['rate_child'][$booking['mange_id']][] = !empty($booking['rate_child']) ? $booking['rate_child'] : 0;
            $book['rate_infant'][$booking['mange_id']][] = !empty($booking['rate_infant']) ? $booking['rate_infant'] : 0;
            $book['rate_private'][$booking['mange_id']][] = !empty($booking['rate_private']) ? $booking['rate_private'] : 0;
            $book['discount'][$booking['mange_id']][] = !empty(!empty($booking['bp_discount'])) ? $booking['bp_discount'] : 0;
            $book['note'][$booking['mange_id']][] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
            $book['cot'][$booking['mange_id']][] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
            $book['total'][$booking['mange_id']][] = $booking['booktye_id'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) + ($booking['rate_infant'] * $booking['rate_infant']) : $booking['rate_private'];
            $book['bo_mange_id'][$booking['mange_id']][] = !empty($booking['boman_id']) ? $booking['boman_id'] : 0;
        }

        # --- get value rates --- #
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
            $rate_adult[$booking['id']][] = !empty($booking['rate_adult']) ? $booking['rate_adult'] : 0;
            $rate_child[$booking['id']][] = !empty($booking['rate_child']) ? $booking['rate_child'] : 0;
            $rate_infant[$booking['id']][] = !empty($booking['rate_infant']) ? $booking['rate_infant'] : 0;
            $rate_total[$booking['id']][] = !empty($booking['rate_total']) ? $booking['rate_total'] : 0;
            $rate_private[$booking['id']][] = !empty($booking['rate_private']) ? $booking['rate_private'] : 0;
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
$manages = $bookObj->show_manage_boat($get_date, $search_boat);
if (!empty($manages)) {
    foreach ($manages as $manage) {
        if (in_array($manage['id'], $first_manage) == false) {
            $first_manage[] = $manage['id'];
            $mange['id'][] = !empty($manage['id']) ? $manage['id'] : 0;
            $mange['color_id'][] = !empty($manage['color_id']) ? $manage['color_id'] : 0;
            $mange['color_name'][] = !empty($manage['color_name_th']) ? $manage['color_name_th'] : '';
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
$programed = $bookObj->show_manage_programe($get_date);
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
                                        $bookstype = $bookObj->showliststatus();
                                        foreach ($bookstype as $booktype) {
                                            $selected = $search_status == $booktype['id'] ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $booktype['id']; ?>" <?php echo $selected; ?>><?php echo $booktype['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="search_agent">Agent</label>
                                    <select class="form-control select2" id="search_agent" name="search_agent">
                                        <option value="all">All</option>
                                        <?php
                                        $agents = $bookObj->showlistagent();
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
                                        $products = $bookObj->showlistproduct();
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
                                    <label for="search_island">Island</label>
                                    <select class="form-control select2" id="search_island" name="search_island">
                                        <option value="all">All</option>
                                        <?php
                                        $islands = $bookObj->showisland();
                                        foreach ($islands as $island) {
                                            $selected = $search_island == $island['id'] ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $island['id']; ?>" <?php echo $selected; ?>><?php echo $island['name']; ?></option>
                                        <?php
                                        }
                                        ?>
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
                            <!-- <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Customer Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php // echo $name; 
                                                                                                            ?>" />
                                </div>
                            </div> -->
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="date_travel_booking">วันที่เที่ยว (Travel Date)</label></br>
                                    <input type="text" class="form-control date-picker" id="date_travel_booking" name="date_travel_booking" value="<?php echo $get_date; ?>" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" class="btn btn-success waves-effect waves-float waves-light btn-page-block-spinner" data-toggle="modal" data-target="#modal-boat" onclick="modal_boat('<?php echo date('j F Y', strtotime($get_date)); ?>', 0, 0);"><i data-feather='plus'></i> เปิดเรือ</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="shadow-none">
                        <div class="card-header pt-1 pb-50 pl-1" style="background-color: #C9C4F9 !important">
                            <h4>บุ๊คกิ้งที่จัดเรือแล้ว</h4>
                        </div>
                        <div class="card-body p-0" style="background-color: #DEDBFB !important;">
                            <textarea id="array_boat" hidden><?php echo json_encode($arr_boat, true); ?></textarea>
                            <?php
                            if (!empty($mange['id'])) {
                                for ($i = 0; $i < count($mange['id']); $i++) {
                            ?>
                                    <input type="hidden" id="arr_mange<?php echo $mange['id'][$i]; ?>" value='<?php echo json_encode($mange, JSON_HEX_APOS, JSON_UNESCAPED_UNICODE); ?>'>
                                    <textarea id="<?php echo 'customers' . $mange['id'][$i]; ?>" hidden><?php echo json_encode($customers[$mange['id'][$i]], true); ?></textarea>
                                    <div class="card-body pt-0 p-50 bg-primary bg-lighten-5">
                                        <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75">
                                            <div class="col-4 text-left text-bold h4"></div>
                                            <div class="col-4 text-center text-bold h4"><?php echo $mange['boat_name'][$i]; ?></div>
                                            <div class="col-4 text-right mb-50">
                                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-dark waves-effect btn-page-block-spinner" data-toggle="modal" data-target="#modal-customers" onclick="modal_customers(<?php echo $mange['id'][$i]; ?>, '<?php echo date('j F Y', strtotime($get_date)); ?>', '<?php echo $mange['boat_name'][$i]; ?>');">รายชื่อลูกค้า</button>
                                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-page-block-spinner" data-toggle="modal" data-target="#modal-booking" onclick="search_booking('not', '<?php echo $get_date; ?>', <?php echo $mange['id'][$i]; ?>, <?php echo $mange['product_id'][$i]; ?>);">เพิ่ม Booking</button> <!--- <i data-feather='plus-circle'></i> --->
                                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-warning waves-effect btn-page-block-spinner" data-toggle="modal" data-target="#modal-boat" onclick="modal_boat('<?php echo date('j F Y', strtotime($get_date)); ?>', <?php echo $mange['id'][$i]; ?>, <?php echo $i; ?>)">แก้ใขเรือ</button> <!--- <i data-feather='plus-circle'></i> --->
                                            </div>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead <?php echo !empty($darken[$book['id'][$mange['id'][$i]][0]]) ? 'bgcolor="#' . $darken[$book['id'][$mange['id'][$i]][0]] . '" style="color: #FFF"' : 'class="bg-light"'; ?>>
                                                <tr>
                                                    <th colspan="3">เวลา : <?php echo $mange['time'][$i]; ?></th>
                                                    <th colspan="6">ไกด์ : <?php echo $mange['guide_name'][$i]; ?></th>
                                                    <th colspan="5">เคาน์เตอร์ : <?php echo $mange['counter'][$i]; ?></th>
                                                    <th colspan="2" style="background-color: <?php echo $mange['color_hex'][$i]; ?>;">
                                                        สี : <?php echo $mange['color_name'][$i]; ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Driver</th>
                                                    <th>Time</th>
                                                    <th width="22%">Programe</th>
                                                    <th>Client</th>
                                                    <th>ภาษา (ไกด์)</th>
                                                    <th>โรงแรม</th>
                                                    <th>โซน</th>
                                                    <th class="text-center cell-fit">A</th>
                                                    <th class="text-center cell-fit">C</th>
                                                    <th class="text-center cell-fit">Inf</th>
                                                    <th class="text-center cell-fit">FOC</th>
                                                    <th>AGENT</th>
                                                    <th>SENDER</th>
                                                    <th>V/C</th>
                                                    <th>COT</th>
                                                    <th>Remark</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($book['id'][$mange['id'][$i]])) { ?>
                                                <tbody>
                                                    <?php
                                                    $total_tourist = 0;
                                                    $total_adult = 0;
                                                    $total_child = 0;
                                                    $total_infant = 0;
                                                    $total_foc = 0;
                                                    for ($a = 0; $a < count($book['id'][$mange['id'][$i]]); $a++) {
                                                        $id = $book['id'][$mange['id'][$i]][$a];
                                                        $total_tourist = $total_tourist + array_sum($adult[$id]) + array_sum($child[$id]) + array_sum($infant[$id]) + array_sum($foc[$id]);
                                                        $total_adult = $total_adult + array_sum($adult[$id]);
                                                        $total_child = $total_child + array_sum($child[$id]);
                                                        $total_infant = $total_infant + array_sum($infant[$id]);
                                                        $total_foc = $total_foc + array_sum($foc[$id]); ?>
                                                        <a href="javascripy:void(0);">
                                                            <tr class="<?php echo ($a % 2 == 1) ? 'table-active' : 'bg-white'; ?>">
                                                                <td style="padding: 5px;" class="cell-fit">
                                                                    <?php echo (!empty($managet['car'][$id][1])) ? '<b>Pickup : </b>' . $managet['car'][$id][1] : '';
                                                                    echo (!empty($managet['driver'][$id][1])) ? $managet['driver'][$id][1] : '';  ?>
                                                                </td>
                                                                <td><?php echo $book['start_pickup'][$mange['id'][$i]][$a] != '00:00' ? $book['start_pickup'][$mange['id'][$i]][$a] . ' - ' . $book['end_pickup'][$mange['id'][$i]][$a] : ''; ?></td>
                                                                <td><?php echo $product_name[$id];
                                                                    if (!empty($category_name[$id])) {
                                                                        echo ' (';
                                                                        for ($c = 0; $c < count($category_name[$id]); $c++) {
                                                                            echo $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                                                                        }
                                                                    }
                                                                    echo ')'; ?></td>
                                                                <td><?php echo !empty($book['nation_name'][$mange['id'][$i]][$a]) ? $book['cus_name'][$mange['id'][$i]][$a] . $book['nation_name'][$mange['id'][$i]][$a] : $book['cus_name'][$mange['id'][$i]][$a]; ?></td>
                                                                <td class="text-nowrap"><?php echo !empty($language[$id]) ? $language[$id] : ''; ?></td>
                                                                <td class="cell-fit"><?php echo ($pickup_type[$id] == 1) ? (!empty($hotel_name[$id])) ? $hotel_name[$id] : $outside[$id] : 'เดินทางมาเอง'; ?></td>
                                                                <td><?php echo (!empty($zone_pickup[$id])) ? $zone_pickup[$id] : ''; ?></td>
                                                                <td class="text-center"><?php echo array_sum($adult[$id]); ?></td>
                                                                <td class="text-center"><?php echo array_sum($child[$id]); ?></td>
                                                                <td class="text-center"><?php echo array_sum($infant[$id]); ?></td>
                                                                <td class="text-center"><?php echo array_sum($foc[$id]); ?></td>
                                                                <td><?php echo $book['comp_name'][$mange['id'][$i]][$a]; ?></td>
                                                                <td><?php echo $book['sender'][$mange['id'][$i]][$a]; ?></td>
                                                                <td><?php echo !empty($book['voucher'][$mange['id'][$i]][$a]) ? $book['voucher'][$mange['id'][$i]][$a] : $book['book_full'][$mange['id'][$i]][$a]; ?></td>
                                                                <td class="text-nowrap"><b class="text-danger"><?php echo $cot[$id] > 0 ? number_format($cot[$id]) : ''; ?></b></td>
                                                                <td><b class="text-info">
                                                                        <?php if ($bec_id[$id]) {
                                                                            for ($e = 0; $e < count($bec_name[$id]); $e++) {
                                                                                echo $e == 0 ? $bec_name[$id][$e] : ' : ' . $bec_name[$id][$e];
                                                                            }
                                                                        }
                                                                        echo !empty($book['note'][$mange['id'][$i]][$a]) ? ' / ' . $book['note'][$mange['id'][$i]][$a] : ''; ?>
                                                                    </b>
                                                                </td>
                                                            </tr>
                                                        </a>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="<?php echo ($a % 2 == 1) ? 'table-active' : 'bg-white'; ?>">
                                                        <td colspan="16" style="padding: 5px;"><b>Remark : </b><?php echo $mange['note'][$i]; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="16" class="text-center h5">Total: <?php echo $total_tourist; ?> | <?php echo $total_adult; ?> <?php echo $total_child; ?> <?php echo $total_infant; ?> <?php echo $total_foc; ?></td>
                                                    </tr>
                                                </tfoot>
                                            <?php } ?>
                                        </table>
                                    </div>
                            <?php
                                }
                            } ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="shadow-none">
                        <div class="card-header pt-1 pb-50 pl-1" style="background-color: #FFD3A9 !important">
                            <h4>บุ๊คกิ้งที่ยังไม่ได้จัดเรือ</h4>
                        </div>
                        <div class="card-body p-0" style="background-color: #FFE0C3 !important">
                            <?php if (!empty($bo_id) && !empty($programe_id)) {
                                if (in_array(0, $mange_id) == true) {
                                    for ($p = 0; $p < count($programe_id); $p++) { ?>
                                        <div class="card-body pt-0 p-50 bg-warning bg-lighten-5">
                                            <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75">
                                                <div class="col-lg-12 col-xl-12 text-center text-bold h4"><?php echo $programe_name[$p]; ?></div>
                                            </div>
                                            <table class="table table-bordered">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th width="4%" class="cell-fit text-center">STATUS</th>
                                                        <th>Category</th>
                                                        <th width="5%" class="text-nowrap">TIME</th>
                                                        <th class="text-nowrap">Name</th>
                                                        <th>ภาษา (ไกด์)</th>
                                                        <th>โรงแรม</th>
                                                        <th>โซน</th>
                                                        <th width="1%">A</th>
                                                        <th width="1%">C</th>
                                                        <th width="1%">INF</th>
                                                        <th width="1%">FOC</th>
                                                        <th class="text-nowrap">AGENT</th>
                                                        <th width="10%" class="text-nowrap">V/C</th>
                                                        <th width="5%" class="text-nowrap">COT</th>
                                                        <th width="13%">REMARKE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $total_tourist = 0;
                                                    $total_adult = 0;
                                                    $total_child = 0;
                                                    $total_infant = 0;
                                                    $total_foc = 0;
                                                    for ($i = 0; $i < count($book_id[$programe_id[$p]]); $i++) {
                                                        if (empty($mange_id[$book_id[$programe_id[$p]][$i]])) {
                                                            $id = $book_id[$programe_id[$p]][$i];
                                                            $total_tourist += !empty($adult[$id]) ? array_sum($adult[$id]) : 0;
                                                            $total_tourist += !empty($child[$id]) ? array_sum($child[$id]) : 0;
                                                            $total_tourist += !empty($infant[$id]) ? array_sum($infant[$id]) : 0;
                                                            $total_tourist += !empty($foc[$id]) ? array_sum($foc[$id]) : 0;

                                                            $total_adult += !empty($adult[$id]) ? array_sum($adult[$id]) : 0;
                                                            $total_child += !empty($child[$id]) ? array_sum($child[$id]) : 0;
                                                            $total_infant += !empty($infant[$id]) ? array_sum($infant[$id]) : 0;
                                                            $total_foc += !empty($foc[$id]) ? array_sum($foc[$id]) : 0;
                                                    ?>
                                                            <tr class="<?php echo ($i % 2 == 1) ? 'table-active' : 'bg-white'; ?>">
                                                                <!-- <td><a href="javascript:void(0);" data-toggle="modal" data-target="#edit_manage_boat" onclick="modal_manage_boat(0, <?php echo $id; ?>, 0, 0);"><span class="badge badge-light-danger">ไม่มีการจัดเรือ</span></a></td> -->
                                                                <td><?php echo $status[$id]; ?></td>
                                                                <td><?php // echo $product_name[$id];
                                                                    if (!empty($category_name[$id])) {
                                                                        echo ' (';
                                                                        for ($c = 0; $c < count($category_name[$id]); $c++) {
                                                                            echo $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                                                                        }
                                                                    }
                                                                    echo ')'; ?>
                                                                </td>
                                                                <td><?php echo !empty($start_pickup[$id]) ? date("H:i", strtotime($start_pickup[$id])) : '00:00'; ?></td>
                                                                <td><?php echo !empty($cus_name[$id][0]) ? !empty($nation_name[$id][0]) ? $cus_name[$id][0] . ' ' . $nation_name[$id][0] : $cus_name[$id][0] . ' ' . $nation_name[$id][0] : ''; ?></td>
                                                                <td class="text-nowrap"><?php echo !empty($language[$id]) ? $language[$id] : ''; ?></td>
                                                                <td class="cell-fit"><?php echo ($pickup_type[$id] == 1) ? (!empty($hotel_name[$id])) ? $hotel_name[$id] : $outside[$id]  : 'เดินทางมาเอง'; ?></td>
                                                                <td><?php echo (!empty($zone_pickup[$id])) ? $zone_pickup[$id] : ''; ?></td>
                                                                <td class="text-center"><?php echo !empty($adult[$id]) ? array_sum($adult[$id]) : 0; ?></td>
                                                                <td class="text-center"><?php echo !empty($child[$id]) ? array_sum($child[$id]) : 0; ?></td>
                                                                <td class="text-center"><?php echo !empty($infant[$id]) ? array_sum($infant[$id]) : 0; ?></td>
                                                                <td class="text-center"><?php echo !empty($foc[$id]) ? array_sum($foc[$id]) : 0; ?></td>
                                                                <td><?php echo $agent_name[$id]; ?></a></td>
                                                                <td><?php echo !empty($voucher_no[$id]) ? $voucher_no[$id] : $book_full[$id]; ?></td>
                                                                <td class="text-nowrap"><?php echo number_format($cot[$id]); ?></td>
                                                                <td><b class="text-info">
                                                                        <?php if ($bec_id[$id]) {
                                                                            for ($e = 0; $e < count($bec_name[$id]); $e++) {
                                                                                echo $e == 0 ? $bec_name[$id][$e] : ' : ' . $bec_name[$id][$e];
                                                                            }
                                                                        }
                                                                        echo !empty($note[$id]) ? ' / ' . $note[$id] : ''; ?>
                                                                    </b>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="17" class="text-center h5">Total: <?php echo $total_tourist; ?> | <?php echo $total_adult; ?> <?php echo $total_child; ?> <?php echo $total_infant; ?> <?php echo $total_foc; ?></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                            <?php }
                                }
                            } ?>
                        </div>
                    </div>
                </div>
                <!-- bookings filter end -->
            </section>

            <!-- Start Form Modal -->
            <!------------------------------------------------------------------>
            <!-- action boat -->
            <div class="modal-size-xl d-inline-block">
                <div class="modal fade text-left" id="modal-boat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17">เปิดเรือ</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="show-div-cus"></div>
                                <!-- <form id="open-boat-form" onsubmit="return false;"> -->
                                <form id="boat-form" name="boat-form" action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" id="manage_id" name="manage_id" value="">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label>วันที่เที่ยว</label><br>
                                                <span id="text-travel-date"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group" id="frm-boats">
                                                <label for="boats">เรือ</label>
                                                <select class="form-control select2" id="boats" name="boats" onchange="check_outside('boats');">
                                                </select>
                                            </div>
                                            <div class="form-group" id="frm-boats-outside" hidden>
                                                <label class="form-label" for="outside_boat">เรือนอก </label></br>
                                                <div class="input-group input-group-merge mb-2">
                                                    <input type="text" class="form-control" id="outside_boat" name="outside_boat" value="" />
                                                    <div class="input-group-append" onclick="check_outside('outside_boat');">
                                                        <span class="input-group-text cursor-pointer"><i data-feather='x'></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group" id="frm-guide">
                                                <label for="guides">ไกด์</label>
                                                <select class="form-control select2" id="guides" name="guides" onchange="check_outside('guides');">
                                                    <option value="">กรุญาเลือกไกด์...</option>
                                                    <option value="outside">กรอกข้อมูลเพิ่มเติม</option>
                                                    <?php
                                                    $guides = $bookObj->show_guides();
                                                    foreach ($guides as $guide) {
                                                    ?>
                                                        <option value="<?php echo $guide['id']; ?>" data-name="<?php echo $guide['name']; ?>"><?php echo $guide['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group" id="frm-guide-outside" hidden>
                                                <label class="form-label" for="outside_guide">ไกด์นอก </label></br>
                                                <div class="input-group input-group-merge mb-2">
                                                    <input type="text" class="form-control" id="outside_guide" name="outside_guide" value="" />
                                                    <div class="input-group-append" onclick="check_outside('outside_guide');">
                                                        <span class="input-group-text cursor-pointer"><i data-feather='x'></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12" id="div-time">
                                            <div class="form-group">
                                                <label for="time">Time (เวลาขึ้นเรือ)</label>
                                                <input type="text" id="time" name="time" class="form-control time-mask" placeholder="HH:MM" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12" id="div-colors">
                                            <div class="form-group">
                                                <label for="color">สี </label>
                                                <select class="form-control select2" id="color" name="color" onchange="chang_color('create');">
                                                    <option value=""></option>
                                                    <?php
                                                    $colors = $bookObj->show_color();
                                                    foreach ($colors as $color) {
                                                    ?>
                                                        <option value="<?php echo $color['id']; ?>" data-color="<?php echo $color['hex_code']; ?>"><?php echo $color['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-12" id="div-hex">
                                            <div class="avatar mt-2" id="div-color">
                                                <div style="width: 40px; height: 40px;"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="note">Note</label></br>
                                                <textarea name="note" id="note" class="form-control" cols="30" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="counter">เคาน์เตอร์</label>
                                                <input type="text" class="form-control" id="counter" name="counter" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-danger" id="delete_manage" onclick="delete_boat();">Delete</button>
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- create booking manage boat -->
            <div class="modal-size-xl d-inline-block">
                <div class="modal fade text-left" id="modal-booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17">เลือก Booking</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive" id="div-manage-boooking">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- edit booking manage boat -->
            <div class="modal fade text-left" id="edit_manage_boat" tabindex="-1" aria-labelledby="myModalLabel18" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel18">แก้ใขเรือ</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="edit-manage-form" name="edit-manage-form" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="bo_mange_id" name="bo_mange_id" value="">
                            <input type="hidden" id="brfore_manage_id" name="brfore_manage_id" value="">
                            <input type="hidden" id="edit_bo_id" name="edit_bo_id" value="">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="edit_manage">เรือ</label>
                                            <select class="form-control select2" id="edit_manage" name="edit_manage">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- create customers -->
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
                                    <table class="table table-bordered table-striped table-vouchure-t2" style="table-layout: inherit; width: 100%; overflow: hidden; text-overflow: ellipsis; font-size: 22px !important;">
                                        <thead>
                                            <tr bgcolor="#FFCEC7">
                                                <th colspan="7" class="text-center"><h4 class="m-0 text-black" id="text-travel-customer">Travel date</h4></th>
                                            </tr>
                                            <tr bgcolor="#FFCEC7">
                                                <th colspan="4" class="text-center"><h4 class="m-0 text-black" id="text-boat">เรือ</h4></th>
                                                <th colspan="3" class="text-center"><h4 class="m-0 text-black" id="text-prak">อุทยาน</h4></th>
                                            </tr>
                                            <tr bgcolor="#DE2400" style="color: #FFF;">
                                                <th class="text-center" width="5%" style="font-size: 18px !important;">ลำดับ</th>
                                                <th class="text-center" width="20%" style="font-size: 18px !important;">ชื่อ</th>
                                                <th class="text-center" width="15%" style="font-size: 18px !important;">V/C</th>
                                                <th class="text-center" width="15%" style="font-size: 18px !important;">เซ็นชื่อ</th>
                                                <th class="text-center" width="15%" style="font-size: 18px !important;">ID Passport/ ID Card</th>
                                                <th class="text-center" width="10%" style="font-size: 18px !important;">สัญชาติ</th>
                                                <th class="text-center" width="10%" style="font-size: 18px !important;">Birth Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-tbody-customers" class="text-black">
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
            <!------------------------------------------------------------------>
            <!-- End Form Modal -->

        </div>
    </div>
<?php
require_once 'controllers/Order.php';

$orderObj = new Order();

$today = date("Y-m-d");
$get_date = !empty($_GET['date']) ? $_GET['date'] : $today;
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- order job list start -->
            <section class="app-user-list">
                <!-- list section start -->
                <div class="card">
                    <!-- order job filter end -->
                    <div class="content-header">
                        <h5 class="pt-1 pl-2 pb-0">Search Filter</h5>
                        <form id="order-job-search-form" name="order-job-search-form" method="post" enctype="multipart/form-data">
                            <div class="d-flex align-items-center mx-50 row pt-0 pb-2">
                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="search_period">Period</label>
                                        <select class="form-control select2" id="search_period" name="search_period" onchange="fun_search_period();">
                                            <option value="custom">Custom</option>
                                            <option value="today">Today</option>
                                            <option value="tomorrow">Tomorrow</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12" id="div_custom_form">
                                    <div class="form-group">
                                        <label class="form-label" for="date_travel_form">Travel Date (Form)</label></br>
                                        <input type="text" class="form-control" id="date_travel_form" name="date_travel_form" value="<?php echo $today; ?>" />
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
                                <div class="col-md-2 col-12">
                                    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr class="pb-0 pt-0">
                    <div id="order-job-search-table">
                        <?php
                        # --- get data --- #
                        $first_order = array();
                        $first_bo = array();
                        $first_cus = array();
                        $sum_programe = 0;
                        $sum_ad = 0;
                        $sum_chd = 0;
                        $sum_inf = 0;
                        # --- get data --- #
                        $orders = $orderObj->showlistboat('job', 'custom', $get_date, 'all', 'all', 'all', 'all', 'all');
                        if (!empty($orders)) {
                            foreach ($orders as $order) {
                                if ((in_array($order['orboat_id'], $first_order) == false)) {
                                    $first_order[] = $order['orboat_id'];
                                    $orboat_id[] = !empty($order['orboat_id']) ? $order['orboat_id'] : 0;
                                    $order_boat_id[] = !empty($order['boat_id']) ? $order['boat_id'] : '';
                                    $order_boat_name[] = empty($order['boat_id']) ? !empty($order['orboat_boat_name']) ? $order['orboat_boat_name'] : '' : $order['boat_name'];
                                    $order_boat_refcode[] = !empty($order['boat_refcode']) ? $order['boat_refcode'] : '';
                                    $order_capt_id[] = !empty($order['capt_id']) ? $order['capt_id'] : '';
                                    $order_capt_name[] = empty($order['capt_id']) ? !empty($order['orboat_captain_name']) ? $order['orboat_captain_name'] : '' : $order['capt_fname'] . ' ' . $order['capt_lname'] . ' ' . $order['capt_lname'] . ' (' . $order['capt_telephone'] . ')';
                                    $order_guide_id[] = !empty($order['guide_id']) ? $order['guide_id'] : '';
                                    $order_guide_name[] = empty($order['guide_id']) ? !empty($order['orboat_guide_name']) ? $order['orboat_guide_name'] : '' : $order['guide_name'] . ' (' . $order['guide_telephone'] . ')';
                                    $order_note[] = !empty($order['orboat_note']) ? $order['orboat_note'] : '';
                                    $order_fcrew_name[] = !empty($order['fcrew_id']) ? $order['fcrew_fname'] . ' ' . $order['fcrew_lname'] : '';
                                    $order_screw_name[] = !empty($order['screw_id']) ? $order['screw_fname'] . ' ' . $order['screw_lname'] : '';
                                    $order_price[] = !empty($order['orboat_price']) ? $order['orboat_price'] : '';
                                    $orboat_color[] = !empty($order['orboat_color']) ? $order['orboat_color'] : '';
                                    # --- order park --- #
                                    $orpark_id[] = !empty($order['orpark_id']) ? $order['orpark_id'] : 0;
                                    $array_orpark[$order['orpark_id']]['adult_eng'][] = !empty($order['adult_eng']) ? $order['adult_eng'] : 0;
                                    $array_orpark[$order['orpark_id']]['child_eng'][] = !empty($order['child_eng']) ? $order['child_eng'] : 0;
                                    $array_orpark[$order['orpark_id']]['adult_th'][] = !empty($order['adult_th']) ? $order['adult_th'] : 0;
                                    $array_orpark[$order['orpark_id']]['child_th'][] = !empty($order['child_th']) ? $order['child_th'] : 0;
                                    $array_orpark[$order['orpark_id']]['orpark_total'][] = !empty($order['orpark_total']) ? $order['orpark_total'] : 0;
                                    $array_orpark[$order['orpark_id']]['orpark_note'][] = !empty($order['orpark_note']) ? $order['orpark_note'] : '';
                                    $array_orpark[$order['orpark_id']]['orpark_park'][] = !empty($order['orpark_park']) ? $order['orpark_park'] : 0;
                                }

                                if (in_array($order['id'], $first_bo) == false) {
                                    $first_bo[] = $order['id'];
                                    $bo_id[$order['orboat_id']][] = !empty($order['id']) ? $order['id'] : 0;
                                    $park_id[$order['orboat_id']][] = !empty($order['park_id']) ? $order['park_id'] : 0;
                                    $pickup_time[$order['orboat_id']][] = $order['start_pickup'] != '00:00:00' ? $order['end_pickup'] != '00:00:00' ? date('H:i', strtotime($order['start_pickup'])) . '-' . date('H:i', strtotime($order['end_pickup'])) : date('H:i', strtotime($order['start_pickup'])) : '-';
                                    $room_no[$order['orboat_id']][] = !empty($order['room_no']) ? $order['room_no'] : '-';
                                    $hotel_name[$order['orboat_id']][] = empty($order['hotel_pickup_id']) ? !empty($order['hotel_pickup']) ? $order['hotel_pickup'] : '-' : $order['hotel_pickup_name'];
                                    $bp_note[$order['orboat_id']][] = !empty($order['bp_note']) ? $order['bp_note'] : '';
                                    $product_name[$order['orboat_id']][] = !empty($order['product_name']) ? $order['product_name'] : '';
                                    $booking_type[$order['orboat_id']][] = !empty($order['bp_private_type']) && $order['bp_private_type'] == 2 ? 'Private' : 'Join';
                                    $company_name[$order['orboat_id']][] = !empty($order['comp_name']) ? $order['comp_name'] : '';
                                    $voucher[$order['orboat_id']][] = !empty($order['voucher_no_agent']) ? $order['voucher_no_agent'] : '';
                                    $sender[$order['orboat_id']][] = !empty($order['sender']) ? $order['sender'] : '';
                                    $adult[$order['orboat_id']][] = !empty($order['bpr_adult']) ? $order['bpr_adult'] : 0;
                                    $child[$order['orboat_id']][] = !empty($order['bpr_child']) ? $order['bpr_child'] : 0;
                                    $infant[$order['orboat_id']][] = !empty($order['bpr_infant']) ? $order['bpr_infant'] : 0;
                                    $cus_name[$order['orboat_id']][] = !empty($order['cus_name']) ? $order['cus_name'] : '';
                                    $car_registration[$order['orboat_id']][] = !empty($order['car_registration']) ? $order['car_registration'] : '';
                                    $driver_name[$order['orboat_id']][] = !empty($order['driver_fname']) ? $order['driver_fname'] . ' ' . $order['driver_lname'] : '';
                                    $boker_name[$order['orboat_id']][] = !empty($order['booker_fname']) ? $order['booker_fname'] . ' ' . $order['booker_lname'] : '';
                                    $book_date[$order['orboat_id']][] = !empty($order['created_at']) ? date('j F Y', strtotime($order['created_at'])) : '';
                                    $bopay_id[$order['orboat_id']][] = !empty($order['bopay_id']) ? $order['bopay_id'] : 0;
                                    $bopay_name[$order['orboat_id']][] = !empty($order['bopay_name']) ? $order['bopay_name'] : '';
                                    $total_paid[$order['orboat_id']][] = !empty($order['total_paid']) ? $order['total_paid'] : '';
                                    $total = $order['rate_total'];
                                    $total = $order['transfer_type'] == 1 ? $total + ($order['bt_adult'] * $order['btr_rate_adult']) : $total;
                                    $total = $order['transfer_type'] == 1 ? $total + ($order['bpr_child'] * $order['btr_rate_child']) : $total;
                                    $total = $order['transfer_type'] == 1 ? $total + ($order['bpr_infant'] * $order['btr_rate_infant']) : $total;
                                    $total = $order['transfer_type'] == 2 ? $orderObj->sumbtrprivate($order['bt_id'])['sum_rate_private'] + $total : $total;
                                    $total = $orderObj->sumbectotal($order['id'])['sum_rate_total'] + $total;
                                    $total = !empty($order['discount']) ? $total - $order['discount'] : $total;
                                    $array_total[$order['orboat_id']][] = $total;
                                }

                                if (in_array($order['cus_id'], $first_cus) == false) {
                                    $first_cus[] = $order['cus_id'];
                                    $cus_id[$order['id']][] = !empty($order['cus_id']) ? $order['cus_id'] : 0;
                                    if (!empty($order['nationality_id']) && $order['nationality_id'] == 182) {
                                        $ad_th[$order['id']][] = !empty($order['cus_age']) && $order['cus_age'] == 1 ? 1 : 0;
                                        $chd_th[$order['id']][] = !empty($order['cus_age']) && $order['cus_age'] == 2 ? 1 : 0;
                                    } elseif (!empty($order['nationality_id']) && $order['nationality_id'] != 182) {
                                        $ad_eng[$order['id']][] = !empty($order['cus_age']) && $order['cus_age'] == 1 ? 1 : 0;
                                        $chd_eng[$order['id']][] = !empty($order['cus_age']) && $order['cus_age'] == 2 ? 1 : 0;
                                    }
                                    # --- array customers --- #
                                    $customers[$order['id']]['cus_name'][] = !empty($order['cus_name']) ? $order['cus_name'] : '-';
                                    $customers[$order['id']]['nation_name'][] = !empty($order['nation_name']) ? $order['nation_name'] : '-';
                                    $customers[$order['id']]['cus_age'][] = !empty($order['cus_age']) ? $order['cus_age'] != 1 ? $order['cus_age'] == 2 ? 'เด็ก' : '-' : 'ผู้ใหญ่' : '-';
                                    $customers[$order['id']]['id_card'][] = !empty($order['id_card']) ? $order['id_card'] : '-';
                                    $customers[$order['id']]['telephone'][] = !empty($order['telephone']) ? $order['telephone'] : '-';
                                    $customers[$order['id']]['birth_date'][] = !empty($order['birth_date']) && $order['birth_date'] != '0000-00-00' ? date('j F Y', strtotime($order['birth_date'])) : '-';
                                }
                            }
                            $name_img = 'Job Order [' . date('j F Y', strtotime($date_travel_boat)) . ']';
                        }
                        ?>
                        <div class="content-header">
                            <div class="pl-1 pt-0 pb-0">
                                <a href="./?pages=order-job/print&action=print&search_period=custom&search_product=all&<?php echo 'date_travel_form=' . $get_date; ?>" target="_blank" class="btn btn-info">Print</a>
                                <!-- <a href="./?pages=order-job/excel" class="btn btn-info" target="_blank">Excel</a> -->
                                <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="download_image();">Image</button></a>
                                <a href="javascript:void(0);" class="btn btn-info disabled" hidden>Download as PDF</a>
                            </div>
                        </div>
                        <?php
                        if (!empty($orboat_id)) {
                            for ($i = 0; $i < count($orboat_id); $i++) {
                                for ($a = 0; $a < count($bo_id[$orboat_id[$i]]); $a++) { ?>
                                    <!--- input nationality --->
                                    <input type="hidden" class="nationality<?php echo $orboat_id[$i]; ?>" data-ad_eng="<?php echo !empty($ad_eng[$bo_id[$orboat_id[$i]][$a]]) ? array_sum($ad_eng[$bo_id[$orboat_id[$i]][$a]]) : 0; ?>" data-chd_eng="<?php echo !empty($chd_eng[$bo_id[$orboat_id[$i]][$a]]) ? array_sum($chd_eng[$bo_id[$orboat_id[$i]][$a]]) : 0; ?>" data-ad_th="<?php echo !empty($ad_th[$bo_id[$orboat_id[$i]][$a]]) ? array_sum($ad_th[$bo_id[$orboat_id[$i]][$a]]) : 0; ?>" data-chd_th="<?php echo !empty($chd_th[$bo_id[$orboat_id[$i]][$a]]) ? array_sum($chd_th[$bo_id[$orboat_id[$i]][$a]]) : 0; ?>" />
                                    <!--- input customers --->
                                    <input type="hidden" class="customers<?php echo $orboat_id[$i]; ?>" value='<?php echo json_encode($customers[$bo_id[$orboat_id[$i]][$a]]); ?>' />
                        <?php }
                            }
                        }
                        ?>
                        <hr class="pb-0 pt-0">
                        <div id="order-job-image-table" style="background-color: #FFF;">
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
                                    <h4 class="font-weight-bolder">ใบงาน</h4>
                                    <div class="badge badge-pill badge-light-danger">
                                        <h5 class="m-0 pl-1 pr-1 text-danger"><?php echo date('j F Y', strtotime($get_date)); ?></h5>
                                    </div>
                                </div>
                            </div>
                            </br>
                            <!-- Header ends -->
                            <!-- Body starts -->
                            <?php
                            if (!empty($orboat_id)) {
                                $ad_no = 0;
                                $chd_no = 0;
                                $inf_no = 0;
                                for ($i = 0; $i < count($orboat_id); $i++) {
                                    $total_no = 0;
                                    switch ($orboat_color[$i]) {
                                        case 'blue':
                                            $bg_color = 'rgba(0, 0, 255, 0.12)';
                                            $color = '#0000FF';
                                            break;
                                        case 'red':
                                            $bg_color = 'rgba(255, 0, 0, 0.12)';
                                            $color = '#FF0000';
                                            break;
                                        case 'yellow':
                                            $bg_color = 'rgba(255, 255, 0, 0.12)';
                                            $color = '#FFFF00';
                                            break;
                                        case 'brown':
                                            $bg_color = 'rgba(139, 69, 19, 0.12)';
                                            $color = '#8B4513';
                                            break;
                                        case 'purple':
                                            $bg_color = 'rgba(128, 0, 128, 0.12)';
                                            $color = '#800080';
                                            break;
                                        case 'pink':
                                            $bg_color = 'rgba(255, 105, 180, 0.12)';
                                            $color = '#FF69B4';
                                            break;
                                        case 'orange':
                                            $bg_color = 'rgba(255, 165, 0, 0.12)';
                                            $color = '#FFA500';
                                            break;
                                        case 'green':
                                            $bg_color = 'rgba(0, 128, 0, 0.12)';
                                            $color = '#008000';
                                            break;
                                        case 'deepskyblue':
                                            $bg_color = 'rgba(30, 144, 255, 0.12)';
                                            $color = '#1E90FF';
                                            break;
                                    }
                            ?>
                                    <div class="card-body pb-0 pt-0">
                                        <div class="row card-text align-items-center">
                                            <div class="col-md-9 text-left">
                                                <?php if (!empty($product_name[$orboat_id[$i]][0])) { ?>
                                                    <div class="avatar" style="background: <?php echo $bg_color; ?>;">
                                                        <div class="avatar-content">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="<?php echo $color; ?>" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php echo $product_name[$orboat_id[$i]][0] . ' (' . $booking_type[$orboat_id[$i]][0] . ')';
                                                } ?>

                                                <?php if (!empty($order_boat_name[$i])) { ?>
                                                    <div class="avatar ml-2" style="background: <?php echo $bg_color; ?>;">
                                                        <div class="avatar-content">
                                                            <svg fill="<?php echo $color; ?>" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                <g id="SVGRepo_iconCarrier">
                                                                    <title>ionicons-v5-h</title>
                                                                    <path d="M477.77,246.42c-2.13-6-7.23-9.55-12.56-11.95L432,221.38V92a20,20,0,0,0-20-20H336V40a16,16,0,0,0-16-16H192a16,16,0,0,0-16,16V72H100A20,20,0,0,0,80,92V221.46L46.92,234.52c-5.33,2.4-10.58,6-12.72,12s-3.16,11.81-1,19L84.25,415.7h1.06c34.12,0,64-17.41,85.31-43.82C191.94,398.29,221.8,414,255.92,414s64-15.76,85.31-42.17c21.32,26.41,51.18,43.87,85.3,43.87h1.06l51.25-150.17C481,259.53,479.91,252.43,477.77,246.42ZM256,152,112,208.83V108a4,4,0,0,1,4-4H396a4,4,0,0,1,4,4V208.76Z"></path>
                                                                    <path d="M345.22,407c-52.25,36.26-126.35,36.25-178.6,0,0,0-45.64,63-94.64,63l13.33,1c29.86,0,58.65-11.73,85.31-25.59a185.33,185.33,0,0,0,170.6,0c26.66,13.87,55.45,25.6,85.31,25.6l13.33-1C392.21,470,345.22,407,345.22,407Z"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php echo $order_boat_name[$i] . ' (' . $order_boat_refcode[$i] . ')';
                                                } ?>

                                                <?php if (!empty($order_capt_name[$i])) { ?>
                                                    <div class="avatar ml-2" style="background: <?php echo $bg_color; ?>;">
                                                        <div class="avatar-content">
                                                            <svg width="20" height="20" fill="<?php echo $color; ?>" viewBox="0 0 512 512" enable-background="new 0 0 512 512" id="pilot_x5F_captain" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#000000">
                                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                <g id="SVGRepo_iconCarrier">
                                                                    <path d="M256,317.615l8.79-6.02l20.507-14.045v-22.95c19.198-9.237,33.347-27.276,37.257-48.879h7.027 c11.118,0,20.13-9.013,20.13-20.13v-1.759c0-11.118-9.012-20.131-20.13-20.131h-5.923v-12.896c-28.72,9.248-59.02,9.92-67.049,9.92 c-1.049,0-1.715-0.011-1.951-0.016c-28.922,0-50.432-3.382-66.316-7.915v10.906h-6.077c-11.118,0-20.13,9.013-20.13,20.131v1.759 c0,11.117,9.012,20.13,20.13,20.13h7.182c3.91,21.603,18.059,39.642,37.257,48.879v22.95L256,317.615z M285.297,193.471 c3.637,0,6.585,2.948,6.585,6.585c0,3.636-2.948,6.584-6.585,6.584c-3.636,0-6.584-2.948-6.584-6.584 C278.713,196.419,281.661,193.471,285.297,193.471z M226.703,193.471c3.637,0,6.584,2.948,6.584,6.585 c0,3.636-2.947,6.584-6.584,6.584s-6.585-2.948-6.585-6.584C220.118,196.419,223.066,193.471,226.703,193.471z M222.047,228.832 c0-2.021,1.639-3.659,3.659-3.659h60.588c2.021,0,3.659,1.639,3.659,3.659c0,18.752-15.201,33.953-33.953,33.953 S222.047,247.584,222.047,228.832z"></path>
                                                                    <path d="M400.512,468.354c0,0-6.155-53.659-21.646-102.091c-6.369-19.912-20.064-36.658-38.297-46.888 c-6.063-3.402-12.786-7.008-19.752-10.451l-1.14,2.678l-38.837,91.285l-10.784-58.322c-0.621-3.359-3.553-5.799-6.97-5.799h-14.171 c-3.418,0-6.35,2.439-6.971,5.799l-10.784,58.322l-38.837-91.285l-1.14-2.678c-6.966,3.443-13.689,7.049-19.752,10.451 c-18.232,10.229-31.927,26.976-38.296,46.888c-15.492,48.432-21.647,102.091-21.647,102.091H256H400.512z M303.15,397.908h14.964 c2.448,0,4.555,1.527,5.572,3.755c2.629,5.753,11.043,6.353,11.043,6.353s8.413-0.6,11.042-6.353 c1.019-2.228,3.124-3.755,5.572-3.755h14.965c2.065,0,3.226,2.377,1.955,4.006l-6.856,8.785c-1.581,2.027-4.009,3.213-6.58,3.213 h-5.378c-2.79,0-5.499,0.933-7.697,2.65l-4.641,3.629c-1.399,1.094-3.365,1.094-4.765,0l-4.641-3.629 c-2.198-1.718-4.907-2.65-7.696-2.65h-5.379c-2.57,0-4.998-1.186-6.58-3.213l-6.855-8.785 C299.925,400.285,301.085,397.908,303.15,397.908z"></path>
                                                                    <path d="M143.276,137.223c23.124-6.964,65.557-17.577,109.965-17.818v-0.013c0.257,0,0.515,0.006,0.771,0.006 c0.255,0,0.508-0.006,0.763-0.006v0.013c45.037,0.237,88.071,10.868,111.494,17.834c0.546-1.368,0.979-2.705,1.308-4 c2.218-8.713-1.692-17.883-8.916-21.446c-6.514-3.214-17.772-11.682-34.817-33.71c-0.298-0.385-0.597-0.767-0.896-1.145 c-35.22-44.389-101.124-44.389-136.344,0c-0.3,0.378-0.599,0.76-0.896,1.145c-17.045,22.028-28.304,30.496-34.818,33.71 c-7.224,3.563-11.133,12.733-8.916,21.446C142.302,134.528,142.732,135.859,143.276,137.223z M220.779,72.507h16.109 c2.636,0,4.902,1.906,5.998,4.686c2.831,7.178,11.889,7.926,11.889,7.926s9.058-0.748,11.888-7.926 c1.096-2.779,3.362-4.686,5.999-4.686h16.108c2.224,0,3.473,2.966,2.105,4.997l-7.381,10.964c-1.703,2.528-4.316,4.007-7.084,4.007 h-5.79c-3.003,0-5.92,1.165-8.285,3.309l-4.996,4.527c-1.507,1.365-3.622,1.365-5.129,0l-4.996-4.527 c-2.366-2.144-5.283-3.309-8.286-3.309h-5.79c-2.768,0-5.381-1.479-7.084-4.007l-7.381-10.964 C217.307,75.473,218.556,72.507,220.779,72.507z"></path>
                                                                    <path d="M323.658,141.508c-0.637-0.072-1.287-0.144-1.936-0.216c-18.74-2.073-42.207-3.857-67.71-3.893 c-40.928,0.058-76.562,4.734-95.41,7.771c3.486,3.35,12.166,10.066,29.739,15.548c14.951,4.664,36.321,8.426,66.434,8.426 c0.576,0.008,37.126,0.533,68.883-10.568c9.563-3.343,18.682-7.74,26.262-13.527C343.068,143.971,334.151,142.7,323.658,141.508z"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php echo $order_capt_name[$i];
                                                } ?>

                                                <?php if (!empty($order_guide_name[$i])) { ?>
                                                    <div class="avatar ml-2" style="background: <?php echo $bg_color; ?>;">
                                                        <div class="avatar-content">
                                                            <svg viewBox="0 -2 24 24" id="meteor-icon-kit__solid-guide" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                <g id="SVGRepo_iconCarrier">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17 0C16.4477 0 16 0.44772 16 1V19C16 19.5523 16.4477 20 17 20C17.5523 20 18 19.5523 18 19V8.7808L23.2425 7.47014C23.6877 7.35885 24 6.95887 24 6.5V1C24 0.44772 23.5523 0 23 0H17z" fill="<?php echo $color; ?>"></path>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 11C9.20914 11 11 9.2091 11 7C11 4.79086 9.20914 3 7 3C4.79086 3 3 4.79086 3 7C3 9.2091 4.79086 11 7 11z" fill="<?php echo $color; ?>"></path>
                                                                    <path d="M1 20C0.447715 20 0 19.5523 0 19V17C0 14.2386 2.23858 12 5 12H9C11.7614 12 14 14.2386 14 17V19C14 19.5523 13.5523 20 13 20C7.15968 20 2.82301 20 1 20z" fill="<?php echo $color; ?>"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php echo $order_guide_name[$i];
                                                } ?>

                                                <?php if (!empty($order_fcrew_name[$i])) { ?>
                                                    <div class="avatar ml-2" style="background: <?php echo $bg_color; ?>;">
                                                        <div class="avatar-content">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="<?php echo $color; ?>" class="bi bi-1-circle-fill" viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002H7.971L6.072 5.385v1.271l1.834-1.318h.065V12h1.312V4.002Z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php echo $order_fcrew_name[$i];
                                                } ?>

                                                <?php if (!empty($order_screw_name[$i])) { ?>
                                                    <div class="avatar ml-2" style="background: <?php echo $bg_color; ?>;">
                                                        <div class="avatar-content">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="<?php echo $color; ?>" class="bi bi-2-circle-fill" viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM6.646 6.24c0-.691.493-1.306 1.336-1.306.756 0 1.313.492 1.313 1.236 0 .697-.469 1.23-.902 1.705l-2.971 3.293V12h5.344v-1.107H7.268v-.077l1.974-2.22.096-.107c.688-.763 1.287-1.428 1.287-2.43 0-1.266-1.031-2.215-2.613-2.215-1.758 0-2.637 1.19-2.637 2.402v.065h1.271v-.07Z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                <?php echo $order_screw_name[$i];
                                                } ?>
                                            </div>

                                            <div class="col-md-3 text-right">
                                                <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm waves-effect round text-nowrap" data-toggle="modal" data-target="#modal-customer" onclick="modal_customer(<?php echo $orboat_id[$i]; ?>);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                                                        <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z" />
                                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                    </svg>
                                                    <span class="text-primary darken-2">รายชื่อ</span>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm waves-effect round text-nowrap" data-toggle="modal" data-target="#modal-park" onclick='modal_park(<?php echo $park_id[$orboat_id[$i]][0]; ?>, <?php echo $orboat_id[$i]; ?>, <?php echo $orpark_id[$i]; ?>, <?php echo !empty($orpark_id[$i]) ? json_encode($array_orpark[$orpark_id[$i]]) : ""; ?>)'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411z" />
                                                    </svg>
                                                    <span class="text-primary darken-2">ค่าอุทยาน</span>
                                                </a>
                                            </div>

                                            <?php if (!empty($order_note[$i])) { ?>
                                                <div class="col-md-12 mt-50 pl-0">
                                                    <?php echo nl2br($order_note[$i]); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-white" style="background: <?php echo $color; ?>;">
                                                <tr>
                                                    <th class="text-center" width="10%">VOUCHER</th>
                                                    <th class="text-center" width="10%">AGENT</th>
                                                    <th class="text-center" width="10%">SENDER</th>
                                                    <th class="text-center" width="10%">CUSTOMER'S NAME</th>
                                                    <th class="text-center" width="5%">AD</th>
                                                    <th class="text-center" width="5%">CHD</th>
                                                    <th class="text-center" width="5%">INF</th>
                                                    <th class="text-center" width="10%">HOTEL</th>
                                                    <th class="text-center" width="10%">ROOM</th>
                                                    <th class="text-center" width="10%">TIME</th>
                                                    <th class="text-center" width="10%">CAR</th>
                                                    <th class="text-center" width="10%">REMARK</th>
                                                    <th class="text-center" width="15%">PAYMENT</th>
                                                    <th class="text-center" width="15%">TOTAL</th>
                                                    <th class="text-center" width="15%">Confirmed</th>
                                                    <th class="text-center" width="15%">Booking Date</th>
                                                    <!-- <th class="text-center" width="15%">Balance</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $check_bo = 0;
                                                for ($a = 0; $a < count($bo_id[$orboat_id[$i]]); $a++) {
                                                    $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                                                    $href = 'href="./?pages=booking/edit&id=' . $bo_id[$orboat_id[$i]][$a] . '" style="color:#6E6B7B"';
                                                ?>
                                                    <tr class="<?php echo $class_tr; ?>">
                                                        <td class="text-nowrap text-center" width="10%">
                                                            <a <?php echo $href; ?>><?php echo $voucher[$orboat_id[$i]][$a]; ?></a>
                                                        </td>
                                                        <td class="text-nowrap" width="10%"><a <?php echo $href; ?>><?php echo $company_name[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-nowrap" width="10%"><a <?php echo $href; ?>><?php echo $sender[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-nowrap" width="10%"><a <?php echo $href; ?>><?php echo $cus_name[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-center" width="5%"><a <?php echo $href; ?>><?php echo $adult[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-center" width="5%"><a <?php echo $href; ?>><?php echo $child[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-center" width="5%"><a <?php echo $href; ?>><?php echo $infant[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td width="10%"><a <?php echo $href; ?>><?php echo $hotel_name[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-center" width="10%"><a <?php echo $href; ?>><?php echo $room_no[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-nowrap" width="10%"><a <?php echo $href; ?>><?php echo $pickup_time[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td width="10%"><a <?php echo $href; ?>><?php echo $car_registration[$orboat_id[$i]][$a] . '<br> (' . $driver_name[$orboat_id[$i]][$a] . ')'; ?></a></td>
                                                        <td width="10%"><a <?php echo $href; ?>><?php echo $bp_note[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-center" width="10%"><a <?php echo $href; ?>><?php echo $bopay_id[$orboat_id[$i]][$a] == 4 || $bopay_id[$orboat_id[$i]][$a] == 5 ? $bopay_name[$orboat_id[$i]][$a] . '</br>(' . number_format($total_paid[$orboat_id[$i]][$a]) . ')' : $bopay_name[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-center" width="10%"><a <?php echo $href; ?>><?php echo number_format($array_total[$orboat_id[$i]][$a]); ?></a></td>
                                                        <td class="text-center" width="10%"><a <?php echo $href; ?>><?php echo $boker_name[$orboat_id[$i]][$a]; ?></a></td>
                                                        <td class="text-center" width="10%"><a <?php echo $href; ?>><?php echo $book_date[$orboat_id[$i]][$a]; ?></a></td>
                                                        <!-- <td class="text-center" width="10%"><a <?php echo $href; ?>><?php echo $bopay_id[$orboat_id[$i]][$a] == 4 || $bopay_id[$orboat_id[$i]][$a] == 5 ? number_format($array_total[$orboat_id[$i]][$a] - $total_paid[$orboat_id[$i]][$a]) : number_format($array_total[$orboat_id[$i]][$a]); ?></a></td> -->
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="text-center" colspan="6">Adult </br>
                                                        <h4 class="mb-0 text-primary"><?php echo !empty($adult[$orboat_id[$i]]) ? array_sum($adult[$orboat_id[$i]]) : 0; ?></h4>
                                                    </td>
                                                    <td class="text-center" colspan="5">Child </br>
                                                        <h4 class="mb-0 text-primary"><?php echo !empty($child[$orboat_id[$i]]) ? array_sum($child[$orboat_id[$i]]) : 0; ?></h4>
                                                    </td>
                                                    <td class="text-center" colspan="5">Infant </br>
                                                        <h4 class="mb-0 text-primary"><?php echo !empty($infant[$orboat_id[$i]]) ? array_sum($infant[$orboat_id[$i]]) : 0; ?></h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </br>
                                    </div>
                                <?php
                                    $ad_no = !empty($adult[$orboat_id[$i]]) ? $ad_no + array_sum($adult[$orboat_id[$i]]) : $ad_no;
                                    $chd_no = !empty($child[$orboat_id[$i]]) ? $chd_no + array_sum($child[$orboat_id[$i]]) : $chd_no;
                                    $inf_no = !empty($infant[$orboat_id[$i]]) ? $inf_no + array_sum($infant[$orboat_id[$i]]) : $inf_no;
                                } ?>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr class="bg-danger bg-lighten-5 text-danger">
                                            <td class="text-center text-bold h3 text-danger" rowspan="2" width="20%">รวมทั้งหมด</td>
                                            <td class="text-center text-bold">ADULT</td>
                                            <td class="text-center text-bold">CHILD</td>
                                            <td class="text-center text-bold">INFANT</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center text-primary text-bold h4"><?php echo $ad_no; ?></td>
                                            <td class="text-center text-primary text-bold h4"><?php echo $chd_no; ?></td>
                                            <td class="text-center text-primary text-bold h4"><?php echo $inf_no; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            <?php } ?>
                            <!-- Body ends -->
                            <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
                        </div>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- order job list ends -->

            <!-- Start Form Modal -->
            <!------------------------------------------------------------------>
            <div class="modal-size-lg d-inline-block">
                <div class="modal fade text-left" id="modal-park" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17">ค่าอุทยาน</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="show-div-park"></div>
                                <form id="order-park-form" name="order-park-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" id="orboat_park_id" name="orboat_park_id" value="">
                                    <input type="hidden" id="orboat_id" name="orboat_id" value="">
                                    <input type="hidden" id="action_park" name="action_park" value="">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group" hidden>
                                                <label for="parks">อุทยาน</label>
                                                <select class="form-control select2" id="parks" name="parks" onchange="check_parks();">
                                                    <option value="0">กรุญาเลือกอุทยาน...</option>
                                                    <?php
                                                    $parks = $orderObj->show_park();
                                                    foreach ($parks as $park) {
                                                    ?>
                                                        <option value="<?php echo $park['id']; ?>" data-name="<?php echo $park['name']; ?>" data-adult-eng="<?php echo $park['rate_adult_eng']; ?>" data-child-eng="<?php echo $park['rate_child_eng']; ?>" data-adult-th="<?php echo $park['rate_adult_th']; ?>" data-child-th="<?php echo $park['rate_child_th']; ?>"><?php echo $park['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">อุทยาน</label></br>
                                                <h6 id="parks_text"></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="rate_adult_eng">ผู้ใหญ่ (ราคาชาวต่างชาติ)</label></br>
                                                <input type="hidden" class="form-control numeral-mask" id="rate_adult_eng" name="rate_adult_eng" value="0" oninput="calculator_parks();" />
                                                <h6 id="adult_eng"></h6>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-1">
                                            <h5 class="mt-3"> X <span id="adult_eng"></span></h5>
                                        </div> -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="rate_child_eng">เด็ก (ราคาชาวต่างชาติ)</label></br>
                                                <input type="hidden" class="form-control numeral-mask" id="rate_child_eng" name="rate_child_eng" value="0" oninput="calculator_parks();" />
                                                <h6 id="child_eng"></h6>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-1">
                                            <h5 class="mt-3"> X <span id="child_eng"></span></h5>
                                        </div> -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="rate_adult_th">เด็ก (ราคาชาวไทย)</label></br>
                                                <input type="hidden" class="form-control numeral-mask" id="rate_adult_th" name="rate_adult_th" value="0" oninput="calculator_parks();" />
                                                <h6 id="adult_th"></h6>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-1">
                                            <h5 class="mt-3"> X <span id="adult_th"></span></h5>
                                        </div> -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="rate_child_th">เด็ก (ราคาชาวไทย)</label></br>
                                                <input type="hidden" class="form-control numeral-mask" id="rate_child_th" name="rate_child_th" value="0" oninput="calculator_parks();" />
                                                <h6 id="child_th"></h6>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-1">
                                            <h5 class="mt-3"> X <span id="child_th"></span></h5>
                                        </div> -->
                                        <!-- <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="note">Note</label></br>
                                                <textarea name="note" id="note" class="form-control" cols="30" rows="3"></textarea>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="total_park">รวมทั้งหมด</label></br>
                                                <input type="hidden" class="form-control numeral-mask" id="total_park" name="total_park" value="0" readonly />
                                                <h5 class="text-primary" id="park_total"></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <hr />
                                    <div class="d-flex justify-content-between">
                                        <div></div>
                                        <div>
                                            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        </div>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-size-img d-inline-block">
                <div class="modal fade text-left" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-img" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17">รายชื่อ</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="bg-info bg-darken-2 text-white">
                                            <tr>
                                                <th class="text-center"></th>
                                                <th class="text-center">หมายเลขพาสปอร์ต</th>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">ว/ด/ป เกิด</th>
                                                <th class="text-center">สัญชาติ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-customer">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
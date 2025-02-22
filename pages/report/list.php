<?php

use Mpdf\Tag\Em;

require_once 'controllers/Report.php';

$repObj = new Report();
$today = date("Y-m-d");
$times = date("H:i:s");

function diff_date($today, $diff_date)
{
    $diff_inv = array();
    $date1 = date_create($today);
    $date2 = date_create($diff_date);
    $diff = date_diff($date1, $date2);
    $diff_inv['day'] =  $diff->format("%R%a");
    $diff_inv['num'] =  $diff->format("%a");

    return $diff_inv;
}
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>

        <div class="content-body">
            <!-- Vertical Wizard -->
            <section class="horizontal-wizard">
                <div class="bs-stepper horizontal-wizard-example">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="content-header">
                                <h5 class="pt-1 pl-2 pb-0">Search Filter</h5>
                                <form id="report-search-form" name="report-search-form" method="post" enctype="multipart/form-data">
                                    <div class="d-flex align-items-center mx-50 row pt-0 pb-0">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="search_status">Status</label>
                                                <select class="form-control select2" id="search_status" name="search_status[]" multiple>
                                                    <?php
                                                    $bookstype = $repObj->showbookingstatus();
                                                    foreach ($bookstype as $booktype) {
                                                        $select = $booktype['id'] != 3 ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $booktype['id']; ?>" <?php echo $select; ?>><?php echo $booktype['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="search_travel">Travel Date</label>
                                                <input type="text" class="form-control flatpickr-range" id="search_travel" name="search_travel" value="<?php echo $today; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="search_agent">Agents</label>
                                                <select class="form-control select2" id="search_agent" name="search_agent">
                                                    <option value="all">All</option>
                                                    <?php
                                                    $agents = $repObj->showlistagent();
                                                    foreach ($agents as $agent) {
                                                    ?>
                                                        <option value="<?php echo $agent['id']; ?>" data-name="<?php echo $agent['name']; ?>" data-address="<?php echo $agent['address']; ?>" data-telephone="<?php echo $agent['telephone']; ?>" data-tat="<?php echo $agent['tat_license']; ?>"><?php echo $agent['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="search_product">Program</label>
                                                <select class="form-control select2" id="search_product" name="search_product">
                                                    <option value="all">All</option>
                                                    <?php
                                                    $products = $repObj->showlistproduct();
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
                        </div>
                    </div>
                    <hr>
                    <div id="stepper-report-search">
                        <?php
                        $inv_no = 0;
                        $no_rec = 0;
                        $balance = 0;
                        $count_boboat = 0;
                        $count_bot = 0;
                        $paid = 0;
                        $not_issued = 0;
                        $issued_inv = 0;
                        $first_book = array();
                        $first_agent = array();
                        $first_prod = array();
                        $first_bpr = array();
                        $first_bot = array();
                        $first_boboat = array();
                        $first_pay = array();
                        $first_extar = array();
                        $bookings = $repObj->showlist('all', '0000-00-00', '0000-00-00', 'all', 'all');
                        foreach ($bookings as $booking) {
                            # --- get value booking --- #
                            if (in_array($booking['id'], $first_book) == false) {
                                $first_book[] = $booking['id'];
                                # --- get value booking --- #
                                $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
                                $status[] = '<span class="badge badge-pill ' . $booking['booksta_class'] . ' text-capitalized"> ' . $booking['booksta_name'] . ' </span>';
                                $rec_id[] = !empty($booking['rec_id']) ? $booking['rec_id'] : 0;
                                $book_full[] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                                $voucher_no_agent[] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
                                $inv_full[] = !empty($booking['inv_full']) ? $booking['inv_full'] : '';
                                $travel_date[] = !empty($booking['travel_date']) ? $booking['travel_date'] : '0000-00-00';
                                // $payment[] = !empty($booking['bopay_name']) ? !empty($booking['bopa_id']) ? '<span class="badge badge-pill badge-light-success text-capitalized"> ' . $booking['bopay_name'] . '<br> ชำระเงินแล้ว </span>' : '<span class="badge badge-pill ' . $booking['bookpay_name_class'] . ' text-capitalized"> ' . $booking['bopay_name'] . ' </span>' : '<span class="badge badge-pill badge-light-primary text-capitalized"> ไม่ได้ระบุ </span></br>';
                                // $payment_paid[] = !empty($booking['payment_paid']) ? $booking['payment_paid'] : 0;
                                // $inv_status[] = (diff_date($today, $booking['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">ครบกำหนดชำระในอีก ' . diff_date($today, $booking['rec_date'])['num'] . ' วัน</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">เกินกำหนดชำระ</span>';
                                $bo_status[] = !empty($booking['booksta_id']) ? $booking['booksta_id'] : 0;
                                $sender[] = !empty($booking['sender']) ? $booking['sender'] : '';
                                # --- get value booking products --- #
                                // $adult[] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                                // $child[] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                                // $infant[] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                                // $foc[] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                                $discount[] = !empty($booking['discount']) ? $booking['discount'] : 0;
                                $array_discount[$booking['id']] = !empty($booking['discount']) ? $booking['discount'] : 0;
                                $comp_discount[$booking['comp_id']] = !empty($booking['discount']) ? $booking['discount'] : 0;
                                # --- get value booking products --- #
                                $hotel_pickup_name[] = !empty($booking['hotel_pickup_name']) ? $booking['hotel_pickup_name'] : '';
                                $hotel_dropoff_name[] = !empty($booking['hotel_dropoff_name']) ? $booking['hotel_dropoff_name'] : '';
                                # --- get value customers --- #
                                $cus_name[] = !empty($booking['cus_name']) && $booking['cus_head'] == 1 ? $booking['cus_name'] : '';
                                # --- calculate amount booking --- #
                                // $total = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];
                                // $total = $booking['rate_total'];
                                // $total = ($booking['transfer_type'] == 1) ? $total + ($booking['bt_adult'] * $booking['btr_rate_adult']) + ($booking['bt_child'] * $booking['btr_rate_child']) + ($booking['bt_infant'] * $booking['btr_rate_infant']) : $total;
                                // $total = ($booking['transfer_type'] == 2) ? $repObj->sumbtrprivate($booking['bt_id'])['sum_rate_private'] + $total : $total;
                                // $total = $repObj->sumbectotal($booking['id'])['sum_rate_total'] + $total;

                                // $amount = $total;
                                // $array_total[] = !empty($booking['discount']) ? $total - $booking['discount'] : $total;
                                // if ($booking['vat_id'] == 1) {
                                //     $vat_total = $total * 100 / 107;
                                //     $vat_cut = $vat_total;
                                //     $vat_total = $total - $vat_total;
                                //     $withholding_total = $booking['withholding'] > 0 ? ($vat_cut * $booking['withholding']) / 100 : 0;
                                //     $amount = $total - $withholding_total;
                                // } elseif ($booking['vat_id'] == 2) {
                                //     $vat_total = ($total * 7) / 100;
                                //     $total = $total + $vat_total;
                                //     $withholding_total = $booking['withholding'] > 0 ? ($total - $vat_total) * $booking['withholding'] / 100 : 0;
                                //     $amount = $total - $withholding_total;
                                // }
                                // $array_amount[$booking['id']] = !empty($booking['discount']) ? $total - $booking['discount'] : $total;

                                $inv_no = !empty($booking['inv_id']) ? $inv_no + 1 : $inv_no;
                                // $over_due = (diff_date($today, $booking['rec_date'])['day'] <= 0) && !empty($booking['inv_id']) && empty($booking['rec_id']) ? $over_due + 1 : $over_due;
                                // $no_rec = !empty($booking['rec_id']) ? $no_rec + 1 : $no_rec;
                                // $balance = !empty($booking['rec_id']) ? $balance + $total : $balance;
                                // $bo_rec[] = !empty($booking['rec_id']) ? $total : 0;
                                // $revenue[] = $total;
                                # --- Agent --- #
                                $comp_id[] = !empty($booking['comp_id']) ? $booking['comp_id'] : 0;
                                $comp_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';

                                // $comp_amount[$booking['comp_id']][] = !empty($booking['discount']) ? $total - $booking['discount'] : $total;
                                // $comp_revenue[$booking['comp_id']][] = !empty($booking['rec_id']) ? !empty($booking['discount']) ? $total - $booking['discount'] : $total : 0;

                                // $comp_adult[$booking['comp_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                                // $comp_child[$booking['comp_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                                // $comp_infant[$booking['comp_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                                // $comp_foc[$booking['comp_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                                // $comp_sum[$booking['comp_id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
                                # --- Programe --- #
                                $prod_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                                $product_name[$booking['product_id']] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                                // $category_name[$booking['product_id']] = !empty($booking['category_name']) ? $booking['category_name'] : '';
                                // $product_adult[$booking['product_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                                // $product_child[$booking['product_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                                // $product_infant[$booking['product_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                                // $product_foc[$booking['product_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                                # --- order boat --- #
                                if (!empty(!empty($booking['orboat_id'])) && !empty($booking['orboat_id']) > 0) {
                                    // $total_park = 0;
                                    // $park_name[$booking['park_id']] = !empty($booking['park_name']) ? $booking['park_name'] : '';
                                    // $orboat_id[$booking['orboat_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                                    // $orboat_travel[$booking['orboat_id']] = !empty($booking['orboat_travel']) ? $booking['orboat_travel'] : 0;
                                    // $park_id[$booking['orboat_id']] = !empty($booking['park_id']) ? $booking['park_id'] : 0;
                                    // $park_adult_eng[$booking['orboat_id']] = !empty($booking['adult_eng']) ? $booking['adult_eng'] : 0;
                                    // $park_child_eng[$booking['orboat_id']] = !empty($booking['child_eng']) ? $booking['child_eng'] : 0;
                                    // $park_adult_th[$booking['orboat_id']] = !empty($booking['adult_th']) ? $booking['adult_th'] : 0;
                                    // $park_child_th[$booking['orboat_id']] = !empty($booking['child_th']) ? $booking['child_th'] : 0;
                                    # --- Boat --- #
                                    $boat_id[$booking['orboat_id']][] = !empty($booking['boat_id']) ? $booking['boat_id'] : 0;
                                    $boat_color[$booking['orboat_id']] = !empty($booking['orboat_color']) ? $booking['orboat_color'] : 0;
                                    $boat_name[$booking['boat_id']] = !empty($booking['boat_name']) ? $booking['boat_name'] : '';
                                    $boat_order_id[$booking['orboat_id']][] = !empty($booking['boat_id']) ? $booking['boat_id'] : 0;
                                    $boat_product[$booking['orboat_id']] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                                    // $boat_adult[$booking['orboat_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                                    // $boat_child[$booking['orboat_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                                    // $boat_infant[$booking['orboat_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                                    // $bpr_foc[$booking['orboat_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                                }
                                # --- order car --- #
                                if (!empty(!empty($booking['ortran_id'])) && !empty($booking['ortran_id']) > 0) {
                                    $ortran_id[$booking['ortran_id']] = !empty($booking['ortran_id']) ? $booking['ortran_id'] : 0;
                                    $ortran_retrun[$booking['ortran_id']] = !empty($booking['ortran_retrun']) ? $booking['ortran_retrun'] : 0;
                                    $car_name[$booking['ortran_id']] = !empty($booking['car_name']) ? $booking['car_name'] : '';
                                    $car_registration[$booking['ortran_id']] = !empty($booking['license']) ? $booking['license'] : '';
                                    $driver_name[$booking['ortran_id']] = !empty($booking['driver_name']) ? $booking['driver_name'] : '';
                                    $ortran_product[$booking['ortran_id']] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                                    $ortran_travel[$booking['ortran_id']] = !empty($booking['ortran_travel']) ? $booking['ortran_travel'] : 0;
                                    $bt_id[$booking['ortran_id']][] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                                    $car_adult[$booking['ortran_id']][] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
                                    $car_child[$booking['ortran_id']][] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
                                    $car_infant[$booking['ortran_id']][] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
                                    $car_foc[$booking['ortran_id']][] = !empty($booking['bt_foc']) ? $booking['bt_foc'] : 0;
                                }
                                # --- Park --- #
                                $bo_park[] = !empty($booking['park_id']) ? $booking['park_id'] : 0;
                            }
                            # --- get value booking rates --- #
                            if ((in_array($booking['bpr_id'], $first_bpr) == false) && !empty($booking['bpr_id'])) {
                                $first_bpr[] = $booking['bpr_id'];
                                $bpr_id[$booking['id']][] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
                                $category_id[$booking['id']][] = !empty($booking['category_id']) ? $booking['category_id'] : 0;
                                $category_name[$booking['id']][] = !empty($booking['category_name']) ? $booking['category_name'] : '';
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
                                $tourist[$booking['id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
                                $total[$booking['id']][] = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];
                                $array_total[] = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];
                                $array_amount[$booking['id']][] = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];

                                $comp_adult[$booking['comp_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                                $comp_child[$booking['comp_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                                $comp_infant[$booking['comp_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                                $comp_foc[$booking['comp_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                                $comp_sum[$booking['comp_id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
                                $comp_amount[$booking['comp_id']][] = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];
                                $comp_revenue[$booking['comp_id']][] = !empty($booking['rec_id']) ? $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'] : 0;

                                $product_adult[$booking['product_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                                $product_child[$booking['product_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                                $product_infant[$booking['product_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                                $product_foc[$booking['product_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;

                                if (!empty(!empty($booking['orboat_id'])) && !empty($booking['orboat_id']) > 0) {
                                    $boat_adult[$booking['orboat_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                                    $boat_child[$booking['orboat_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                                    $boat_infant[$booking['orboat_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                                    $bpr_foc[$booking['orboat_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                                }
                            }
                            # --- get value agent company --- #
                            if (in_array($booking['comp_id'], $first_agent) == false) {
                                $first_agent[] = $booking['comp_id'];
                                $agent_id[] = !empty($booking['comp_id']) ? $booking['comp_id'] : 0;
                                $agent_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                                $agent_logo[] = !empty($booking['comp_logo']) ? $booking['comp_logo'] : '';
                            }
                            # --- get value booking products --- #
                            if (in_array($booking['product_id'], $first_prod) == false) {
                                $first_prod[] = $booking['product_id'];
                                $product_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                            }
                            # --- get value booking order transfer --- #
                            if (in_array($booking['bt_id'], $first_bot) == false && !empty($booking['ortran_id']) && !empty($booking['bt_id'])) {
                                $first_bot[] = $booking['bt_id'];
                                $bot_id[$booking['ortran_id']][] = $booking['bt_id'];
                                $count_bot++;
                            }
                            # --- get value booking order boat --- #
                            if (in_array($booking['boboat_id'], $first_boboat) == false && !empty($booking['orboat_id']) && !empty($booking['boboat_id'])) {
                                $first_boboat[] = $booking['boboat_id'];
                                $boboat_id[$booking['orboat_id']][] = $booking['boboat_id'];
                                $count_boboat++;
                            }
                            # --- get value booking payment --- #
                            if ((in_array($booking['bopa_id'], $first_pay) == false) && !empty($booking['bopa_id'])) {
                                # --- in array get value booking payment --- #
                                $first_pay[] = $booking['bopa_id'];
                                $bopay_id[$booking['id']] = !empty($booking['bopay_id']) ? $booking['bopay_id'] : 0;
                                $bopay_name[$booking['id']] = !empty($booking['bopay_name']) ? $booking['bopay_name'] : '';
                                $total_paid[$booking['id']] = !empty($booking['total_paid']) ? $booking['total_paid'] : '';
                                $bo_cot[$booking['id']] = !empty($booking['bopay_id']) && $booking['bopay_id'] == 4 ? !empty($booking['total_paid']) ? $booking['total_paid'] : 0 : 0;
                                $bo_dep[$booking['id']] = !empty($booking['bopay_id']) && $booking['bopay_id'] == 5 ? !empty($booking['total_paid']) ? $booking['total_paid'] : 0 : 0;
                                $bopay_name_class[$booking['id']] = !empty($booking['bopay_name_class']) ? $booking['bopay_name_class'] : '';
                                $bopay_paid_name[$booking['id']] = $booking['bopay_id'] == 4 || $booking['bopay_id'] == 5 ? $booking['bopay_name'] . '</br>(' . number_format($booking['total_paid']) . ')' : $booking['bopay_name'];

                                $pay_id[$booking['id']][] = !empty($booking['bopay_id']) ? $booking['bopay_id'] : 0;
                                $pay_name[$booking['id']][] = !empty($booking['bopay_name']) ? $booking['bopay_name'] : 0;
                            }
                            # --- get value booking --- #
                            if (in_array($booking['bec_id'], $first_extar) == false && (!empty($booking['extra_id']) || !empty($booking['bec_name']))) {
                                $first_extar[] = $booking['bec_id'];
                                $ext_total = $booking['bec_type'] == 1 ? ($booking['bec_adult'] * $booking['bec_rate_adult']) + ($booking['bec_child'] * $booking['bec_rate_child']) : ($booking['bec_privates'] * $booking['bec_rate_private']);
                                $extar_arr_total[] = $ext_total;
                                $extar_total[$booking['id']][] = $ext_total;
                                $extar_total_agent[$booking['comp_id']][] = $ext_total;
                            }
                        }
                        # ------ calculate booking paid ------ #
                        if (!empty($bopay_id)) {
                            foreach ($bopay_id as $x => $val) {
                                $paid_amount = !empty($array_discount[$x]) ? array_sum($array_amount[$x]) - $array_discount[$x] : array_sum($array_amount[$x]);

                                $not_issued = (!empty($pay_id[$x]) && (in_array(6, $pay_id[$x]) == false) && (in_array(3, $pay_id[$x]) == false)) ? !empty($extar_total[$x]) ? $not_issued + $paid_amount + array_sum($extar_total[$x]) : $not_issued + $paid_amount : $not_issued;

                                $issued_inv = (!empty($pay_id[$x]) && (in_array(6, $pay_id[$x]) == true) && (in_array(3, $pay_id[$x]) == false)) ? !empty($extar_total[$x]) ? $issued_inv + $paid_amount + array_sum($extar_total[$x]) : $issued_inv + $paid_amount : $issued_inv;

                                $paid = (!empty($pay_id[$x]) && (in_array(3, $pay_id[$x]) == true)) ? !empty($extar_total[$x]) ? $paid + $paid_amount + array_sum($extar_total[$x]) : $paid + $paid_amount : $paid;
                            }
                        }
                        ?>
                        <div class="bs-stepper-header p-1">
                            <div class="step" data-target="#report-booking">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">1</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Booking</span>
                                        <span class="bs-stepper-subtitle">Please fill out</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#report-agent">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">2</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Agent</span>
                                        <span class="bs-stepper-subtitle">Please fill out</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#report-programe">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">3</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Programe</span>
                                        <span class="bs-stepper-subtitle">Please fill out</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#report-transfer">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">4</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Transfer</span>
                                        <span class="bs-stepper-subtitle">Please fill out</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#report-boat">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">5</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Boat</span>
                                        <span class="bs-stepper-subtitle">Please fill out</span>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="bs-stepper-content p-0">
                            <!-- Report Booking Vertical -->
                            <div id="report-booking" class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="demo-inline-spacing pl-1">
                                            <a href="./?pages=report/print&action=print&type=booking" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-arrow-alt-circle-down mr-25"></i>
                                                Download
                                            </a>
                                            <a href="./?pages=report/excel&action=print&type=booking" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-file-excel mr-25"></i>
                                                Excel
                                            </a>
                                            <a href="javascript:void(0);" type="button" class="btn btn-success waves-effect waves-float waves-light" onclick="download_image('booking');">
                                                <i class="far fa-file-image mr-25"></i>
                                                Image
                                            </a>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-12 bg-white" id="image-report-booking">
                                        <h3 class="text-center pt-1">รายงาน <span class="text-warning font-weight-bolder">Booking</span></h3>
                                        <h5 class="text-center">เอเยนต์ทั้งหมด โปรแกรมทั้งหมด</h5>
                                        <input type="hidden" id="name-img-booking" value="<?php echo "รายงานบุ๊คกิ้ง-" . date("dmY-Hs"); ?>">
                                        <div class="card-body statistics-body">
                                            <div class="row">
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-danger mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0"><?php echo !empty($bo_id) ? count($bo_id) : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Booking ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-primary mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-primary"><?php echo !empty($extar_arr_total) ? number_format(array_sum($array_total) + array_sum($extar_arr_total) - array_sum($discount)) : number_format(array_sum($array_total) - array_sum($discount)); ?> THB</h4>
                                                            <p class="card-text font-small-3 mb-0">ยอดขายทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="media">
                                                        <div class="avatar bg-light-success mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-success"><?php echo !empty($paid) ? number_format($paid) . ' THB' : '0 THB'; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">รับเงินทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="media">
                                                        <div class="avatar bg-light-warning mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-warning"><?php echo number_format(array_sum($bo_cot)) . ' THB'; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">แบ่งเป็น Cash On Tour</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-info mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-info"><?php echo !empty($not_issued) ? number_format($not_issued) . ' THB' : '0 THB'; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">ค้างจ่ายที่ยังไม่ได้ออก Invoice</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="media">
                                                        <div class="avatar bg-light-danger mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-danger"><?php echo !empty($issued_inv) ? number_format($issued_inv) . ' THB' : '0 THB'; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">ค้างจ่าย</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2 mb-xl-0">
                                                    <div class="media">
                                                        <div class="avatar bg-light-success mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0"><?php echo !empty(array_count_values($bo_status)[1]) ? array_count_values($bo_status)[1] : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Confirm</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2 mb-xl-0">
                                                    <div class="media">
                                                        <div class="avatar bg-light-danger mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0"><?php echo (!empty(array_count_values($bo_status)[3])) ? array_count_values($bo_status)[3] : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Cancel</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2 mb-xl-0">
                                                    <div class="media">
                                                        <div class="avatar bg-light-secondary mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0"><?php echo (!empty(array_count_values($bo_status)[4])) ? array_count_values($bo_status)[4] : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">No Show</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-striped text-uppercase table-vouchure-t2">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Payment</th>
                                                    <th>Voucher No.</th>
                                                    <th>Agent</th>
                                                    <th>Travel Date</th>
                                                    <th>Programe</th>
                                                    <th>Pax</th>
                                                    <th>Hotel </br><small>(Pickup)</small></th>
                                                    <th>Customer</th>
                                                    <th>Booker</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0; $i < count($bo_id); $i++) { ?>
                                                    <tr>
                                                        <td><?php echo $status[$i]; ?></td>
                                                        <td><?php echo !empty($bopay_id[$bo_id[$i]]) ? '<span class="badge badge-pill ' . $bopay_name_class[$bo_id[$i]] . ' text-capitalized"> ' . $bopay_paid_name[$bo_id[$i]] . ' </span>' : '<span class="badge badge-pill badge-light-primary text-capitalized"> ไม่ได้ระบุ </span>'; ?></td>
                                                        <td><?php echo !empty($voucher_no_agent[$i]) ? $voucher_no_agent[$i] : $book_full[$i]; ?></td>
                                                        <td><?php echo $comp_name[$i]; ?></td>
                                                        <td class="text-nowrap"><?php echo (!empty($travel_date[$i])) ? date('j F Y', strtotime($travel_date[$i])) : ''; ?></td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder text-primary"><?php echo $product_name[$prod_id[$i]]; ?></span>
                                                                <span class="font-small-3"><?php if ($category_name[$bo_id[$i]]) {
                                                                    for ($b=0; $b < count($category_name[$bo_id[$i]]); $b++) { 
                                                                        echo $b==0 ? $category_name[$bo_id[$i]][$b] : ', ' . $category_name[$bo_id[$i]][$b];
                                                                    }
                                                                } ?></span>
                                                            </div>
                                                        </td>
                                                        <td><?php echo !empty($tourist[$bo_id[$i]]) ? array_sum($tourist[$bo_id[$i]]) : '-'; ?></td>
                                                        <td><?php echo $hotel_pickup_name[$i]; ?></td>
                                                        <td><?php echo $cus_name[$i]; ?></td>
                                                        <td><?php echo $sender[$i]; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Report Agent Vertical -->
                            <div id="report-agent" class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="demo-inline-spacing pl-1">
                                            <a href="./?pages=report/print&action=print&type=agent" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-arrow-alt-circle-down mr-25"></i>
                                                Download
                                            </a>
                                            <a href="./?pages=report/excel&action=print&type=agent" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-file-excel mr-25"></i>
                                                Excel
                                            </a>
                                            <a href="javascript:void(0);" type="button" class="btn btn-success waves-effect waves-float waves-light" onclick="download_image('agent');">
                                                <i class="far fa-file-image mr-25"></i>
                                                Image
                                            </a>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-12 bg-white" id="image-report-agent">
                                        <h3 class="text-center pt-1">รายงาน <span class="text-warning font-weight-bolder">Agent</span></h3>
                                        <h5 class="text-center">เอเยนต์ทั้งหมด โปรแกรมทั้งหมด</h5>
                                        <input type="hidden" id="name-img-agent" value="<?php echo "รายงานเอเยนต์-" . date("dmY-Hs"); ?>">
                                        <!-- <h4 class="card-title p-1 m-0">Booking</h4> -->
                                        <div class="card-body statistics-body pb-0">
                                            <div class="row">
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-success mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user font-medium-5">
                                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                                    <circle cx="12" cy="7" r="4"></circle>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0"><?php echo !empty($agent_id) ? count($agent_id) : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Agent ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-primary mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-primary"><?php echo !empty($comp_id) ? count($comp_id) : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Booking ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-striped text-uppercase table-vouchure-t2">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Agent</th>
                                                    <th class="text-center">Booking</th>
                                                    <th class="text-center">A</th>
                                                    <th class="text-center">C</th>
                                                    <th class="text-center">INF</th>
                                                    <th class="text-center">FOC</th>
                                                    <th class="text-center">TOTAL</th>
                                                    <th class="text-center">Amount</br><small>(THB)</small></th>
                                                    <th class="text-center">Income</br><small>(THB)</small></th>
                                                    <th class="text-center">Overdue</br><small>(THB)</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $amount_comp = 0;
                                                $revenue_comp = 0;
                                                for ($i = 0; $i < count($agent_id); $i++) {
                                                    $amount_comp = !empty($comp_amount[$agent_id[$i]]) ? !empty($extar_total_agent[$agent_id[$i]]) ? array_sum($comp_amount[$agent_id[$i]]) + array_sum($extar_total_agent[$agent_id[$i]]) - $comp_discount[$agent_id[$i]] : array_sum($comp_amount[$agent_id[$i]]) - $comp_discount[$agent_id[$i]] : 0;
                                                    $revenue_comp = !empty($comp_revenue[$agent_id[$i]]) ? (!empty($extar_total_agent[$agent_id[$i]]) && array_sum($comp_revenue[$agent_id[$i]]) > 0) ? array_sum($comp_revenue[$agent_id[$i]]) + array_sum($extar_total_agent[$agent_id[$i]]) - $comp_discount[$agent_id[$i]] : array_sum($comp_revenue[$agent_id[$i]]) - $comp_discount[$agent_id[$i]]  : 0
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <img src="storage/uploads/no-image.jpg" class="mr-75" height="40" width="40" alt="Angular">
                                                            <span class="font-weight-bolder text-primary"><?php echo $agent_name[$i]; ?></span>
                                                        </td>
                                                        <td class="text-center font-weight-bolder"><?php echo array_count_values($comp_id)[$agent_id[$i]] ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($comp_adult[$agent_id[$i]]) ? array_sum($comp_adult[$agent_id[$i]]) : 0; ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($comp_child[$agent_id[$i]]) ? array_sum($comp_child[$agent_id[$i]]) : 0; ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($comp_infant[$agent_id[$i]]) ? array_sum($comp_infant[$agent_id[$i]]) : 0; ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($comp_foc[$agent_id[$i]]) ? array_sum($comp_foc[$agent_id[$i]]) : 0; ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($comp_sum[$agent_id[$i]]) ? array_sum($comp_sum[$agent_id[$i]]) : 0; ?></td>
                                                        <td class="text-nowrap text-center font-weight-bolder">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25 text-warning"><?php echo number_format($amount_comp); ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap text-center font-weight-bolder">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25 text-success"><?php echo number_format($revenue_comp); ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap text-center font-weight-bolder">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25 text-danger"><?php echo number_format($amount_comp - $revenue_comp); ?></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Report Programe Vertical -->
                            <div id="report-programe" class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="demo-inline-spacing pl-1">
                                            <a href="./?pages=report/print&action=print&type=programe" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-arrow-alt-circle-down mr-25"></i>
                                                Download
                                            </a>
                                            <a href="./?pages=report/excel&action=print&type=programe" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-file-excel mr-25"></i>
                                                Excel
                                            </a>
                                            <a href="javascript:void(0);" type="button" class="btn btn-success waves-effect waves-float waves-light" onclick="download_image('programe');">
                                                <i class="far fa-file-image mr-25"></i>
                                                Image
                                            </a>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-12 bg-white" id="image-report-programe">
                                        <h3 class="text-center pt-1">รายงาน <span class="text-warning font-weight-bolder">Programe</span></h3>
                                        <h5 class="text-center">เอเยนต์ทั้งหมด โปรแกรมทั้งหมด</h5>
                                        <input type="hidden" id="name-img-programe" value="<?php echo "รายงานโปรแกรม-" . date("dmY-Hs"); ?>">
                                        <!-- <h4 class="card-title p-1 m-0">Booking</h4> -->
                                        <div class="card-body statistics-body pb-0">
                                            <div class="row">
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-success mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package font-medium-5">
                                                                    <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0"><?php echo !empty($product_id) ? count($product_id) : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Programe ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-primary mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-primary"><?php echo !empty($prod_id) ? count($prod_id) : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Booking ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-striped text-uppercase table-vouchure-t2">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Programe Name</th>
                                                    <th class="text-center">AD</th>
                                                    <th class="text-center">CHD</th>
                                                    <th class="text-center">INF</th>
                                                    <th class="text-center">FOC</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $age = array_count_values($prod_id);
                                                arsort($age);
                                                foreach ($age as $x => $x_value) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="font-weight-bolder text-primary"><?php echo $product_name[$x] ?></div>
                                                        </td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($product_adult[$x]) ? array_sum($product_adult[$x]) : 0; ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($product_child[$x]) ? array_sum($product_child[$x]) : 0; ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($product_infant[$x]) ? array_sum($product_infant[$x]) : 0; ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($product_foc[$x]) ? array_sum($product_foc[$x]) : 0; ?></td>
                                                        <td class="text-center font-weight-bolder"><?php echo !empty($product_adult[$x]) && !empty($product_child[$x]) && !empty($product_infant[$x]) && !empty($product_foc[$x]) ? array_sum($product_adult[$x]) + array_sum($product_child[$x]) + array_sum($product_infant[$x]) + array_sum($product_foc[$x]) : 0; ?></td>
                                                    </tr>
                                                <?php
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Report Transfer Vertical -->
                            <div id="report-transfer" class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="demo-inline-spacing pl-1">
                                            <a href="./?pages=report/print&action=print&type=transfer" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-arrow-alt-circle-down mr-25"></i>
                                                Download
                                            </a>
                                            <a href="./?pages=report/excel&action=print&type=transfer" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-file-excel mr-25"></i>
                                                Excel
                                            </a>
                                            <a href="javascript:void(0);" type="button" class="btn btn-success waves-effect waves-float waves-light" onclick="download_image('transfer');">
                                                <i class="far fa-file-image mr-25"></i>
                                                Image
                                            </a>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-12 bg-white" id="image-report-transfer">
                                        <h3 class="text-center pt-1">รายงาน <span class="text-warning font-weight-bolder">Transfer</span></h3>
                                        <h5 class="text-center">เอเยนต์ทั้งหมด โปรแกรมทั้งหมด</h5>
                                        <input type="hidden" id="name-img-transfer" value="<?php echo "รายงานรถ-" . date("dmY-Hs"); ?>">
                                        <!-- <h4 class="card-title p-1 m-0">Booking</h4> -->
                                        <div class="card-body statistics-body pb-0">
                                            <div class="row">
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-success mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck font-medium-5">
                                                                    <rect x="1" y="3" width="15" height="13"></rect>
                                                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0"><?php echo !empty($ortran_id) ? count($ortran_id) : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Car ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-primary mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-primary"><?php echo $count_bot; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Booking ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-striped text-uppercase table-vouchure-t2">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Car & Driver</th>
                                                    <th>Travel Date</th>
                                                    <th class="text-center">Booking</th>
                                                    <th class="text-center">A</th>
                                                    <th class="text-center">C</th>
                                                    <th class="text-center">Inf</th>
                                                    <th class="text-center">FOC</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($ortran_id)) {
                                                    foreach ($ortran_id as $x => $val) {  ?>
                                                        <tr>
                                                            <td>
                                                                <div class="font-weight-bolder text-primary"><?php echo !empty($car_name[$ortran_id[$x]]) ? !empty($driver_name[$ortran_id[$x]]) ? $car_name[$ortran_id[$x]] . ' / ' . $driver_name[$ortran_id[$x]] : $car_name[$ortran_id[$x]] : ''; ?></div>
                                                            </td>
                                                            <td><?php echo (!empty($ortran_travel[$ortran_id[$x]])) ? date('j F Y', strtotime($ortran_travel[$ortran_id[$x]])) : ''; ?></td>
                                                            <td class="text-center"><?php echo !empty($bot_id[$val]) ? count($bot_id[$val]) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($car_adult[$x]) ? array_sum($car_adult[$x]) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($car_child[$x]) ? array_sum($car_child[$x]) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($car_infant[$x]) ? array_sum($car_infant[$x]) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($car_foc[$x]) ? array_sum($car_foc[$x]) : 0; ?></td>
                                                            <td class="text-center"><?php echo array_sum($car_adult[$x]) + array_sum($car_child[$x]) + array_sum($car_infant[$x]) + array_sum($car_foc[$x]); ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Report Boat Vertical -->
                            <div id="report-boat" class="content">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="demo-inline-spacing pl-1">
                                            <a href="./?pages=report/print&action=print&type=boat" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-arrow-alt-circle-down mr-25"></i>
                                                Download
                                            </a>
                                            <a href="./?pages=report/excel&action=print&type=boat" target="_blank" class="btn btn-success waves-effect waves-float waves-light">
                                                <i class="far fa-file-excel mr-25"></i>
                                                Excel
                                            </a>
                                            <a href="javascript:void(0);" type="button" class="btn btn-success waves-effect waves-float waves-light" onclick="download_image('boat');">
                                                <i class="far fa-file-image mr-25"></i>
                                                Image
                                            </a>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-12 bg-white" id="image-report-boat">
                                        <h3 class="text-center pt-1">รายงาน <span class="text-warning font-weight-bolder">Boat</span></h3>
                                        <h5 class="text-center">เอเยนต์ทั้งหมด โปรแกรมทั้งหมด</h5>
                                        <input type="hidden" id="name-img-boat" value="<?php echo "รายงานเรือ-" . date("dmY-Hs"); ?>">
                                        <!-- <h4 class="card-title p-1 m-0">Booking</h4> -->
                                        <div class="card-body statistics-body pb-0">
                                            <div class="row">
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-success mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-navigation-2 font-medium-5">
                                                                    <polygon points="12 2 19 21 12 17 5 21 12 2"></polygon>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0"><?php echo !empty($orboat_id) ? count($orboat_id) : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Boat ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 mb-2">
                                                    <div class="media">
                                                        <div class="avatar bg-light-primary mr-2">
                                                            <div class="avatar-content m-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto">
                                                            <h4 class="font-weight-bolder mb-0 text-primary"><?php echo !empty($count_boboat) ? $count_boboat : 0; ?></h4>
                                                            <p class="card-text font-small-3 mb-0">Booking ทั้งหมด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-striped text-uppercase table-vouchure-t2">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Boat & Captain</th>
                                                    <th>Programe</th>
                                                    <th>Travel Date</th>
                                                    <th class="text-center">Booking</th>
                                                    <th class="text-center">A</th>
                                                    <th class="text-center">C</th>
                                                    <th class="text-center">Inf</th>
                                                    <th class="text-center">FOC</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($boat_order_id)) {
                                                    foreach ($boat_order_id as $x => $val) {
                                                        switch ($boat_color[$x]) {
                                                            case 'blue':
                                                                $hex_color = '#00cfe8';
                                                                break;
                                                            case 'red':
                                                                $hex_color = '#ea5455';
                                                                break;
                                                            case 'yellow':
                                                                $hex_color = '#ffc107';
                                                                break;
                                                            case 'brown':
                                                                $hex_color = '#8B4513';
                                                                break;
                                                            case 'purple':
                                                                $hex_color = '#7367f0';
                                                                break;
                                                            case 'pink':
                                                                $hex_color = '#d63384';
                                                                break;
                                                            case 'orange':
                                                                $hex_color = '#ff9f43';
                                                                break;
                                                            case 'green':
                                                                $hex_color = '#28c76f';
                                                                break;
                                                            case 'deepskyblue':
                                                                $hex_color = '#1E90FF';
                                                                break;
                                                        }
                                                ?>
                                                        <tr>
                                                            <td style="color: <?php echo $hex_color; ?>; font-weight: bold;"><?php echo $boat_name[$val[0]]; ?></span></td>
                                                            <td>
                                                                <div class="text-primary font-weight-bolder"><?php echo $product_name[$boat_product[$x]]; ?></div>
                                                            </td>
                                                            <td><?php echo (!empty($orboat_travel[$x])) ? date('j F Y', strtotime($orboat_travel[$x])) : ''; ?></td>
                                                            <td class="text-center"><?php echo count($boboat_id[$x]); ?></td>
                                                            <td class="text-center"><?php echo !empty($boat_adult[$x]) ? array_sum($boat_adult[$x]) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($boat_child[$x]) ? array_sum($boat_child[$x]) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($boat_infant[$x]) ? array_sum($boat_infant[$x]) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($boat_foc[$x]) ? array_sum($boat_foc[$x]) : 0; ?></td>
                                                            <td class="text-center"><?php echo array_sum($boat_adult[$x]) + array_sum($boat_child[$x]) + array_sum($boat_infant[$x]); ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Vertical Wizard -->
        </div>
    </div>
</div>
<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Report.php';

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

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $search_period = $_POST['search_period'] != "" ? $_POST['search_period'] : 'all';
    $search_travel_date = $_POST['search_travel_date'] != "" ? $_POST['search_travel_date'] : '0000-00-00';
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 'all';
    $search_product = $_POST['search_product'] != "" ? $_POST['search_product'] : 'all';
    $date_form = substr($search_travel_date, 0, 10) != '' ? substr($search_travel_date, 0, 10) : '0000-00-00';
    $date_to = substr($search_travel_date, 14, 10) != '' ? substr($search_travel_date, 14, 10) : $date_form;

    $inv_no = 0;
    $over_due = 0;
    $no_rec = 0;
    $balance = 0;
    $pay_not = 0;
    $pay_wait = 0;
    $pay_bill = 0;
    $pay_paid = 0;
    $pay_cot = 0;
    $first_book = array();
    $first_agent = array();
    $first_prod = array();
    $first_pay = array();
    $first_custo = array();
    $name_img = ($_POST['search_period'] != "" && $_POST['search_period'] != "all") ? !empty($date_to) ? 'รายงานตั้งแต่ ' . date("j F Y", strtotime($date_form)) . ' ถึง ' . date("j F Y", strtotime($date_to)) : 'รายงานของวันที่ ' . date("j F Y", strtotime($date_form)) : '';
    $name_img .= ($_POST['search_agent'] != "" && $_POST['search_agent'] != "all") ? ($name_img != '') ? ' ของเอเยนต์ ' . $repObj->get_value('name', 'companies', $search_agent)['name'] : 'รายงานทั้งหมดของเอเยนต์ ' . $repObj->get_value('name', 'companies', $search_agent)['name'] : '';
    $name_img .= ($_POST['search_product'] != "" && $_POST['search_product'] != "all") ? ($name_img != '') ? ' ของสินค้า ' . $repObj->get_value('name', 'products', $search_product)['name'] : 'รายงานทั้งหมดของสินค้า ' . $repObj->get_value('name', 'products', $search_product)['name'] : '';
    $name_img = $name_img != '' ? $name_img : 'รายงาน เอเยนต์ทั้งหมด สินค้าทั้งหมด';
    $bookings = $repObj->showlist($search_period, $date_form, $date_to, $search_agent, $search_product);

    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            if ($booking['booksta_id'] == 1) {
                if (in_array($booking['id'], $first_book) == false) {
                    $first_book[] = $booking['id'];
                    # --- get value booking --- #
                    $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
                    $book_status[] = !empty($booking['booksta_id']) ? $booking['booksta_id'] : 0;
                    $rec_id[] = !empty($booking['rec_id']) ? $booking['rec_id'] : 0;
                    $book_full[] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                    $voucher_no_agent[] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
                    $inv_full[] = !empty($booking['inv_full']) ? $booking['inv_full'] : '';
                    $travel_date[] = !empty($booking['travel_date']) ? $booking['travel_date'] : '0000-00-00';
                    $payment[] = !empty($booking['bookpay_name']) ? !empty($booking['paid_id']) ? '<span class="badge badge-pill badge-light-success text-capitalized"> ' . $booking['bookpay_name'] . '<br> ชำระเงินแล้ว </span>' : '<span class="badge badge-pill ' . $booking['bookpay_name_class'] . ' text-capitalized"> ' . $booking['bookpay_name'] . ' </span>' : '<span class="badge badge-pill badge-light-primary text-capitalized"> ไม่ได้ระบุ </span></br>';
                    $payment_paid[] = !empty($booking['payment_paid']) ? $booking['payment_paid'] : 0;
                    $inv_status[] = (diff_date($today, $booking['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">ครบกำหนดชำระในอีก ' . diff_date($today, $booking['rec_date'])['num'] . ' วัน</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">เกินกำหนดชำระ</span>';
                    $bo_status[] = !empty($booking['booksta_id']) ? $booking['booksta_id'] : 0;
                    # --- get value booking products --- #
                    $adult[] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                    $child[] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                    $infant[] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                    # --- get value customers --- #
                    $cus_name[] = !empty($booking['cus_name']) && $booking['cus_head'] == 1 ? $booking['cus_name'] : '';
                    # --- get value --- #
                    $total = $booking['rate_total'];
                    $total = ($booking['transfer_type'] == 1) ? $total + ($booking['bt_adult'] * $booking['btr_rate_adult']) + ($booking['bt_child'] * $booking['btr_rate_child']) + ($booking['bt_infant'] * $booking['btr_rate_infant']) : $total;
                    $total = ($booking['transfer_type'] == 2) ? $repObj->sumbtrprivate($booking['bt_id'])['sum_rate_private'] + $total : $total;
                    // $total = $repObj->sumbectotal($booking['id'])['sum_rate_total'] + $total;

                    $amount = $total;
                    $array_total[] = $total;
                    if ($booking['vat_id'] == 1) {
                        $vat_total = $total * 100 / 107;
                        $vat_cut = $vat_total;
                        $vat_total = $total - $vat_total;
                        $withholding_total = $booking['withholding'] > 0 ? ($vat_cut * $booking['withholding']) / 100 : 0;
                        $amount = $total - $withholding_total;
                    } elseif ($booking['vat_id'] == 2) {
                        $vat_total = ($total * 7) / 100;
                        $total = $total + $vat_total;
                        $withholding_total = $booking['withholding'] > 0 ? ($total - $vat_total) * $booking['withholding'] / 100 : 0;
                        $amount = $total - $withholding_total;
                    }
                    $array_amount[$booking['id']] = $amount;

                    $inv_no = !empty($booking['inv_id']) ? $inv_no + 1 : $inv_no;
                    $over_due = (diff_date($today, $booking['rec_date'])['day'] <= 0) && !empty($booking['inv_id']) && empty($booking['rec_id']) ? $over_due + 1 : $over_due;
                    $no_rec = !empty($booking['rec_id']) ? $no_rec + 1 : $no_rec;
                    $balance = !empty($booking['rec_id']) ? $balance + $total : $balance;
                    $bo_rec[] = !empty($booking['rec_id']) ? $total : 0;
                    $revenue[] = $total;
                    # --- Agent --- #
                    $comp_id[] = !empty($booking['comp_id']) ? $booking['comp_id'] : 0;
                    $comp_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                    $comp_amount[$booking['comp_id']][] = $amount;
                    $comp_revenue[$booking['comp_id']][] = !empty($booking['rec_id']) ? $total : 0;
                    $comp_adult[$booking['comp_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                    $comp_child[$booking['comp_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                    $comp_infant[$booking['comp_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                    # --- Programe --- #
                    $prod_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                    $product_name[$booking['product_id']] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                    $product_adult[$booking['product_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                    $product_child[$booking['product_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                    $product_infant[$booking['product_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                    # --- order boat --- #
                    if (!empty(!empty($booking['orboat_id'])) && !empty($booking['orboat_id']) > 0) {
                        $total_park = 0;
                        $park_name[$booking['park_id']] = !empty($booking['park_name']) ? $booking['park_name'] : '';
                        $orboat_id[$booking['orboat_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                        $park_id[$booking['orboat_id']] = !empty($booking['park_id']) ? $booking['park_id'] : 0;
                        $park_adult_eng[$booking['orboat_id']] = !empty($booking['adult_eng']) ? $booking['adult_eng'] : 0;
                        $park_child_eng[$booking['orboat_id']] = !empty($booking['child_eng']) ? $booking['child_eng'] : 0;
                        $park_adult_th[$booking['orboat_id']] = !empty($booking['adult_th']) ? $booking['adult_th'] : 0;
                        $park_child_th[$booking['orboat_id']] = !empty($booking['child_th']) ? $booking['child_th'] : 0;
                        # --- Boat --- #
                        $boat_id[$booking['orboat_id']][] = !empty($booking['boat_id']) ? $booking['boat_id'] : 0;
                        $boat_name[$booking['boat_id']] = !empty($booking['boat_name']) ? $booking['boat_name'] : '';
                        $boat_order_id[$booking['orboat_id']][] = !empty($booking['boat_id']) ? $booking['boat_id'] : 0;
                        $boat_product[$booking['orboat_id']] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                        $boat_adult[$booking['orboat_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                        $boat_child[$booking['orboat_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                        $boat_infant[$booking['orboat_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                    }
                    # --- order car --- #
                    if (!empty(!empty($booking['ortran_id'])) && !empty($booking['ortran_id']) > 0) {
                        $ortran_id[$booking['ortran_id']] = !empty($booking['ortran_id']) ? $booking['ortran_id'] : 0;
                        $ortran_car_id[$booking['ortran_id']] = !empty($booking['ortran_car_id']) ? $booking['ortran_car_id'] : 0;
                        $car_name[$booking['ortran_car_id']] = !empty($booking['car_name']) ? $booking['car_name'] : '';
                        $car_registration[$booking['ortran_car_id']] = !empty($booking['car_registration']) ? $booking['car_registration'] : $booking['ortran_car_name'];
                        $ortran_product[$booking['ortran_id']] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                        $bt_id[$booking['ortran_id']][] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                        $car_adult[$booking['ortran_id']][] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
                        $car_child[$booking['ortran_id']][] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
                        $car_infant[$booking['ortran_id']][] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
                    }
                    # --- Park --- #
                    $bo_park[] = !empty($booking['park_id']) ? $booking['park_id'] : 0;
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

                # --- get value booking customers --- #
                if (in_array($booking['cus_id'], $first_custo) == false) {
                    $first_custo[] = $booking['cus_id'];
                    $cus_id[$booking['id']][] = !empty($booking['cus_id']) ? $booking['cus_id'] : 0;
                    $cus_age[$booking['id']][] = !empty($booking['cus_age']) ? $booking['cus_age'] : 0;
                    $cus_nation[$booking['id']][] = !empty($booking['nationality_id']) ? $booking['nationality_id'] : 0;
                }
            } else {
                if (in_array($booking['id'], $secound_book) == false) {
                    $secound_book[] = $booking['id'];
                    $book_status[] = !empty($booking['booksta_id']) ? $booking['booksta_id'] : 0;
                }
            }
        }
        // print_r($boat_id);
        // echo '</br>';
        // print_r($park_id);
        // echo '</br>';

        # ------ calculate rate park ------ #
        foreach ($orboat_id as $x => $val) {
            $adult_eng = 0;
            $child_eng = 0;
            $adult_th = 0;
            $child_th = 0;
            for ($e = 0; $e < count($val); $e++) {
                if (!empty($cus_id[$val[$e]])) {
                    for ($f = 0; $f < count($cus_id[$val[$e]]); $f++) {
                        $adult_th = ($cus_nation[$val[$e]][$f] == 182 && $cus_age[$val[$e]][$f] == 1) ? $adult_th + 1 : $adult_th;
                        $child_th = ($cus_nation[$val[$e]][$f] == 182 && $cus_age[$val[$e]][$f] == 2) ? $child_th + 1 : $child_th;
                        $adult_eng = ($cus_nation[$val[$e]][$f] != 182 && $cus_nation[$val[$e]][$f] > 0 && $cus_age[$val[$e]][$f] == 1) ? $adult_eng + 1 : $adult_eng;
                        $child_eng = ($cus_nation[$val[$e]][$f] != 182 && $cus_nation[$val[$e]][$f] > 0 && $cus_age[$val[$e]][$f] == 2) ? $child_eng + 1 : $child_eng;
                    }
                }
            }
            $park_total[$park_id[$x]][] = ($adult_th * $park_adult_th[$x]) + ($child_th * $park_child_th[$x]) + ($adult_eng * $park_adult_eng[$x]) + ($child_eng * $park_child_eng[$x]);
        }
        # ------ calculate booking paid ------ #
        $bo_paid = 0;
        foreach ($bopay_id as $x => $val) {
            $bo_paid = $val == 3 ? $bo_paid + $array_amount[$x] : $bo_paid;
        }

?>
        <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>" />
        <input type="hidden" id="sum_adult" name="sum_adult" value="<?php echo array_sum($adult); ?>" />
        <input type="hidden" id="sum_child" name="sum_child" value="<?php echo array_sum($child); ?>" />
        <input type="hidden" id="sum_infant" name="sum_infant" value="<?php echo array_sum($infant); ?>" />
        <input type="hidden" id="sum_booking" name="sum_booking" value="<?php echo count($bo_id); ?>" />
        <input type="hidden" id="sum_rec" name="sum_rec" value="<?php echo $no_rec; ?>" />
        <input type="hidden" id="sum_notpaid" name="sum_notpaid" value="<?php echo count($bo_id) - $no_rec; ?>" />
        <input type="hidden" id="sum_total" name="sum_total" value="<?php echo array_sum($array_total); ?>" />
        <input type="hidden" id="sum_cot" name="sum_cot" value="<?php echo array_sum($payment_paid); ?>" />
        <input type="hidden" id="sum_overdue" name="sum_overdue" value="<?php echo $over_due; ?>" />
        <input type="hidden" id="sum_balance" name="sum_balance" value="<?php echo array_sum($array_total) - $balance; ?>" />
        <!-- Payments -->
        <input type="hidden" id="pay_not" name="pay_not" value="<?php echo $pay_not; ?>" />
        <input type="hidden" id="pay_wait" name="pay_wait" value="<?php echo $pay_wait; ?>" />
        <input type="hidden" id="pay_bill" name="pay_bill" value="<?php echo $pay_bill; ?>" />
        <input type="hidden" id="pay_paid" name="pay_paid" value="<?php echo $pay_paid; ?>" />
        <input type="hidden" id="pay_cot" name="pay_cot" value="<?php echo $pay_cot; ?>" />

        <div class="row match-height">
            <div class="col-12">
                <div class="row match-height">
                    <!-- Booking Card -->
                    <div class="col-12">
                        <div class="card card-statistics">
                            <div class="card-header p-1">
                                <h5 class="card-title">Booking</h5>
                            </div>
                            <div class="card-body statistics-body border-top">
                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <div class="media">
                                            <div class="avatar bg-light-danger mr-2">
                                                <div class="avatar-content">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0"><?php echo count($bo_id); ?></h4>
                                                <p class="card-text font-small-3 mb-0">Booking ทั้งหมด</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <div class="media">
                                            <div class="avatar bg-light-primary mr-2">
                                                <div class="avatar-content">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0 text-primary"><?php echo number_format(array_sum($array_total)) . ' THB'; ?></h4>
                                                <p class="card-text font-small-3 mb-0">ยอดขายทั้งหมด</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="media">
                                            <div class="avatar bg-light-success mr-2">
                                                <div class="avatar-content">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0 text-success"><?php echo number_format($bo_paid) . ' THB'; ?></h4>
                                                <p class="card-text font-small-3 mb-0">รับเงินทั้งหมด</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="media">
                                            <div class="avatar bg-light-warning mr-2">
                                                <div class="avatar-content">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
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
                                                <div class="avatar-content">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0 text-info"><?php echo number_format(array_sum($bo_dep)) . ' THB'; ?></h4>
                                                <p class="card-text font-small-3 mb-0">แบ่งเป็น Deposit</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="media">
                                            <div class="avatar bg-light-danger mr-2">
                                                <div class="avatar-content">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0 text-danger"><?php echo number_format(array_sum($array_total) - $bo_paid) . ' THB'; ?></h4>
                                                <p class="card-text font-small-3 mb-0">ค้างจ่าย</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Booking Card -->
                </div>
            </div>
        </div>

        <div class="row match-height">
            <!-- Status Card -->
            <div class="col-xl-12 col-md-12 col-12">
                <div class="card card-statistics">
                    <div class="card-header p-1">
                        <h4 class="card-title">Booking Status</h4>
                    </div>
                    <div class="card-body statistics-body border-top">
                        <div class="row">
                            <?php
                            $count_status = !empty($book_status) ? array_count_values($book_status) : '';
                            if (!empty($count_status)) {
                            ?>
                                <div class="col-4 mb-2 mb-xl-0">
                                    <div class="media">
                                        <div class="avatar bg-light-success mr-2">
                                            <div class="avatar-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto">
                                            <h4 class="font-weight-bolder mb-0"><?php echo $count_status[1]; ?></h4>
                                            <p class="card-text font-small-3 mb-0">Confirm</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 mb-2 mb-xl-0">
                                    <div class="media">
                                        <div class="avatar bg-light-danger mr-2">
                                            <div class="avatar-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto">
                                            <h4 class="font-weight-bolder mb-0"><?php echo $count_status[3]; ?></h4>
                                            <p class="card-text font-small-3 mb-0">Cancel</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 mb-2 mb-xl-0">
                                    <div class="media">
                                        <div class="avatar bg-light-secondary mr-2">
                                            <div class="avatar-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto">
                                            <h4 class="font-weight-bolder mb-0"><?php echo $count_status[4]; ?></h4>
                                            <p class="card-text font-small-3 mb-0">No Show</p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Status Card -->


        </div>

        <div class="row match-height">
            <!-- Customer no Card -->
            <div class="col-6">
                <div class="card">
                    <div class="card-header p-1">
                        <h5 class="card-title">จำนวนลูกค้า</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="row text-center mx-0">
                            <div class="col-6 border-top border-right py-1">
                                <p class="card-text text-muted mb-0">ทั้งหมด</p>
                                <h3 class="font-weight-bolder mb-0"><?php echo array_sum($adult) + array_sum($child) + array_sum($infant); ?></h3>
                            </div>
                            <div class="col-6 border-top border-right py-1">
                                <p class="card-text text-muted mb-0">Adult</p>
                                <h3 class="font-weight-bolder mb-0" id="text-sum-adult"></h3>
                            </div>
                            <div class="col-6 border-top border-right py-1">
                                <p class="card-text text-muted mb-0">Children</p>
                                <h3 class="font-weight-bolder mb-0" id="text-sum-child"></h3>
                            </div>
                            <div class="col-6 border-top py-1">
                                <p class="card-text text-muted mb-0">Infant</p>
                                <h3 class="font-weight-bolder mb-0" id="text-sum-infant"></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Customer no Card -->


            <!-- Statistics Card -->
            <div class="col-xl-6 col-md-6 col-6">
                <div class="card card-statistics">
                    <div class="card-header p-1">
                        <h4 class="card-title">INVOICE</h4>
                    </div>
                    <div class="card-body statistics-body border-top">
                        <div class="row">
                            <div class="col-6 mb-2 mb-xl-0">
                                <div class="media">
                                    <div class="avatar bg-light-success mr-2">
                                        <div class="avatar-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0"><?php echo $inv_no; ?></h4>
                                        <p class="card-text font-small-3 mb-0">Invoice ทั้งหมด</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-2 mb-xl-0">
                                <div class="media">
                                    <div class="avatar bg-light-danger mr-2">
                                        <div class="avatar-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0"><?php echo $over_due; ?></h4>
                                        <p class="card-text font-small-3 mb-0">Over Due</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics Card -->

            <!-- Park Card -->
            <!-- <div class="col-6">
                                <div class="card card-browser-states">
                                    <div class="card-header p-1">
                                        <h5 class="card-title">อุทยาน</h5>
                                    </div>
                                    <div class="card-body border-top pt-2">
                                        <?php
                                        if (!empty($park_id)) {
                                            foreach ($park_total as $x => $val) {
                                                if ($x > 0) {
                                        ?>
                                                    <div class="browser-states">
                                                        <div class="media">
                                                            <h6 class="align-self-center mb-0 font-weight-bolder"><?php echo $park_name[$x]; ?></h6>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="font-weight-bold text-body-heading mr-1 font-weight-bolder"><?php echo number_format(array_sum($val)); ?></div>
                                                            <div id="browser-state-chart-primary font-weight-bolder">THB</div>
                                                        </div>
                                                    </div>
                                        <?php }
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div> -->
            <!--/ Park Card -->
        </div>

        <div class="row match-height">
            <!-- Boat Table Card -->
            <div class="col-6">
                <div class="card card-boat-table">
                    <div class="card-header p-1">
                        <h5 class="card-title">Boats</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Boat Name</th>
                                        <th>Programe</th>
                                        <th>AD</th>
                                        <th>CHD</th>
                                        <th>INF</th>
                                        <th>รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($boat_order_id)) {
                                        foreach ($boat_order_id as $x => $val) { ?>
                                            <tr>
                                                <td><span class="font-weight-bolder"><?php echo $boat_name[$val[0]]; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo $product_name[$boat_product[$x]]; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo !empty($boat_adult[$x]) ? array_sum($boat_adult[$x]) : 0; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo !empty($boat_child[$x]) ? array_sum($boat_child[$x]) : 0; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo !empty($boat_infant[$x]) ? array_sum($boat_infant[$x]) : 0; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo array_sum($boat_adult[$x]) + array_sum($boat_child[$x]) + array_sum($boat_infant[$x]); ?></span></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Boat Table Card -->

            <!-- Car Table Card -->
            <div class="col-6">
                <div class="card card-car-table">
                    <div class="card-header p-1">
                        <h5 class="card-title">Cars</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Cars Name</th>
                                        <th>Programe</th>
                                        <th>AD</th>
                                        <th>CHD</th>
                                        <th>INF</th>
                                        <th>รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($ortran_id)) {
                                        foreach ($ortran_id as $x => $val) {  ?>
                                            <tr>
                                                <td><span class="font-weight-bolder"><?php echo !empty($car_registration[$ortran_car_id[$x]]) ? $car_registration[$ortran_car_id[$x]] : ''; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo !empty($ortran_product[$x]) ? $product_name[$ortran_product[$x]] : ''; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo !empty($car_adult[$x]) ? array_sum($car_adult[$x]) : 0; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo !empty($car_child[$x]) ? array_sum($car_child[$x]) : 0; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo !empty($car_infant[$x]) ? array_sum($car_infant[$x]) : 0; ?></span></td>
                                                <td><span class="font-weight-bolder"><?php echo array_sum($car_adult[$x]) + array_sum($car_child[$x]) + array_sum($car_infant[$x]); ?></span></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Car Table Card -->
        </div>

        <div class="row match-height">
            <!-- Company Table Card -->
            <div class="col-6">
                <div class="card card-company-table">
                    <div class="card-header p-1">
                        <h5 class="card-title">Agent</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Agent Name</th>
                                        <th>Booking No.</th>
                                        <th>AD</th>
                                        <th>CHD</th>
                                        <th>INF</th>
                                        <th>รวม</th>
                                        <th>รวม (THB)</th>
                                        <th>รายได้ (THB)</th>
                                        <th>ค้างจ่าย (THB)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < 10; $i++) {
                                        if ($agent_id[$i]) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar rounded avatar-lg">
                                                            <div class="avatar-content">
                                                                <?php if (!empty($agent_logo[$i])) { ?>
                                                                    <img src="<?php echo $hostPageUrl; ?>/uploads/companies/logo/<?php echo $agent_logo[$i]; ?>" alt="Toolbar svg" />
                                                                <?php } else { ?>
                                                                    <img src="<?php echo $hostPageUrl; ?>/uploads/no-image.jpg" alt="Toolbar svg" />
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="font-weight-bolder"><?php echo $agent_name[$i]; ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column font-weight-bolder"><?php echo array_count_values($comp_id)[$agent_id[$i]] ?></div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column font-weight-bolder"><?php echo !empty($comp_adult[$agent_id[$i]]) ? array_sum($comp_adult[$agent_id[$i]]) : 0; ?></div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column font-weight-bolder"><?php echo !empty($comp_child[$agent_id[$i]]) ? array_sum($comp_child[$agent_id[$i]]) : 0; ?></div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column font-weight-bolder"><?php echo !empty($comp_infant[$agent_id[$i]]) ? array_sum($comp_infant[$agent_id[$i]]) : 0; ?></div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column font-weight-bolder"><?php echo !empty($comp_adult[$agent_id[$i]]) && !empty($comp_adult[$agent_id[$i]]) && !empty($comp_adult[$agent_id[$i]]) ? array_sum($comp_adult[$agent_id[$i]]) + array_sum($comp_child[$agent_id[$i]]) + array_sum($comp_infant[$agent_id[$i]]) : 0; ?></div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column">
                                                        <span class="font-weight-bolder mb-25 text-primary"><?php echo number_format(array_sum($comp_amount[$agent_id[$i]])); ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column">
                                                        <span class="font-weight-bolder mb-25 text-success"><?php echo number_format(array_sum($comp_revenue[$agent_id[$i]])); ?></span>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column">
                                                        <span class="font-weight-bolder mb-25 text-danger"><?php echo number_format(array_sum($comp_amount[$agent_id[$i]]) - array_sum($comp_revenue[$agent_id[$i]])); ?></span>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Company Table Card -->

            <!-- Browser States Card -->
            <div class="col-6">
                <div class="card card-company-table">
                    <div class="card-header p-1">
                        <h5 class="card-title">Programe</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Programe Name</th>
                                        <th>จำนวน</th>
                                        <th>AD</th>
                                        <th>CHD</th>
                                        <th>INF</th>
                                        <th>รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $age = array_count_values($prod_id);
                                    arsort($age);
                                    foreach ($age as $x => $x_value) {
                                        // echo "Key=" . $x . ", Value=" . $x_value;
                                        // echo number_format($x_value / array_sum(array_count_values($prod_id)) * 100, 1)
                                    ?>
                                        <tr>
                                            <td><span class="font-weight-bolder"><?php echo $product_name[$x] ?></span></td>
                                            <td><span class="font-weight-bolder"><?php echo $x_value; ?></span></td>
                                            <td><span class="d-flex flex-column font-weight-bolder"><?php echo !empty($product_adult[$x]) ? array_sum($product_adult[$x]) : 0; ?></span></td>
                                            <td><span class="d-flex flex-column font-weight-bolder"><?php echo !empty($product_child[$x]) ? array_sum($product_child[$x]) : 0; ?></span></td>
                                            <td><span class="d-flex flex-column font-weight-bolder"><?php echo !empty($product_infant[$x]) ? array_sum($product_infant[$x]) : 0; ?></span></td>
                                            <td><span class="d-flex flex-column font-weight-bolder"><?php echo !empty($product_adult[$x]) && !empty($product_child[$x]) && !empty($product_infant[$x]) ? array_sum($product_adult[$x]) + array_sum($product_child[$x]) + array_sum($product_infant[$x]) : 0; ?></span></td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Browser States Card -->
        </div>
<?php
    }
} else {
    echo $invoices = false;
}

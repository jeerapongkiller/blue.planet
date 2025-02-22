<?php
require_once 'controllers/Order.php';

$orderObj = new Order();

if (isset($_GET['action']) && $_GET['action'] == "print") {
    // get value from ajax
    $search_period = $_GET['search_period'] != "" ? $_GET['search_period'] : 'all';
    $search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
    $date_travel_form = $_GET['date_travel_form'] != "" ? $_GET['date_travel_form'] : '0000-00-00';

    $search_product_name = $search_product != 'all' ? $orderObj->get_data('name', 'products', $search_product) : '';

    # --- get data --- #
    $first_order = array();
    $first_bo = array();
    $first_cus = array();
    $sum_programe = 0;
    $sum_ad = 0;
    $sum_chd = 0;
    $sum_inf = 0;
    $name_img = 'Job Order';
    $name_img .= $search_product != 'all' ? ' [' . $search_product_name . '] ' : '';
    $name_img .= $date_travel_form != '0000-00-00' ? ' [' . date('j F Y', strtotime($date_travel_form)) . '] ' : '';
    # --- get data --- #
    $orders = $orderObj->showlistboat('job', $search_period, $date_travel_form, $search_product, 'all', 'all', 'all');
    # --- Check products --- #
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
?>
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
        <!-- Header ends -->
        <div class="card-body pb-0 pt-0">
            <div class="text-center card-text">
                <h4 class="font-weight-bolder">ใบหน้างาน</h4>
                <h5 class="font-weight-bolder"><?php echo date('j F Y', strtotime($date_travel_form)); ?></h5>
            </div>
        </div>
        <br>
        <?php
        if (!empty($orboat_id)) {
            for ($i = 0; $i < count($orboat_id); $i++) {
                $total_no = 0;
        ?>
                <div class="card-body pb-0 pt-0 pl-0">
                    <b>Programe :</b> <?php echo $product_name[$orboat_id[$i]][0] . ' (' . $booking_type[$orboat_id[$i]][0] . ')'; ?>
                    <b class="pl-1">Boat :</b> <?php echo $order_boat_name[$i] . ' (' . $order_boat_refcode[$i] . ')'; ?>
                    <b class="pl-1">Captain :</b> <?php echo $order_capt_name[$i]; ?>
                    <b class="pl-1">Guide :</b> <?php echo $order_guide_name[$i]; ?>
                    <b class="pl-1">staff 1 :</b> <?php echo $order_fcrew_name[$i]; ?>
                    <b class="pl-1">staff 2 :</b> <?php echo $order_screw_name[$i]; ?>
                    <?php if (!empty($order_note[$i])) { ?>
                        <div class="col-md-12 mt-25 pl-0">
                            <b>Note :</b> <?php echo nl2br($order_note[$i]); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="table-responsive" id="order-job-search-table">
                    <table class="">
                        <thead>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $check_bo = 0;
                            for ($a = 0; $a < count($bo_id[$orboat_id[$i]]); $a++) {
                                $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                            ?>
                                <tr class="<?php echo $class_tr; ?>">
                                    <td class="text-nowrap text-center" width="10%">
                                        <a <?php echo $href; ?>><?php echo $voucher[$orboat_id[$i]][$a]; ?></a>
                                        <!--- input nationality --->
                                        <input type="hidden" class="nationality<?php echo $orboat_id[$i]; ?>" data-ad_eng="<?php echo !empty($ad_eng[$bo_id[$orboat_id[$i]][$a]]) ? array_sum($ad_eng[$bo_id[$orboat_id[$i]][$a]]) : 0; ?>" data-chd_eng="<?php echo !empty($chd_eng[$bo_id[$orboat_id[$i]][$a]]) ? array_sum($chd_eng[$bo_id[$orboat_id[$i]][$a]]) : 0; ?>" data-ad_th="<?php echo !empty($ad_th[$bo_id[$orboat_id[$i]][$a]]) ? array_sum($ad_th[$bo_id[$orboat_id[$i]][$a]]) : 0; ?>" data-chd_th="<?php echo !empty($chd_th[$bo_id[$orboat_id[$i]][$a]]) ? array_sum($chd_th[$bo_id[$orboat_id[$i]][$a]]) : 0; ?>" />
                                        <!--- input customers --->
                                        <input type="hidden" class="customers<?php echo $orboat_id[$i]; ?>" value='<?php echo json_encode($customers[$bo_id[$orboat_id[$i]][$a]]); ?>' />
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
                            <?php }  ?>
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
                <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
            <?php
                $ad_no = !empty($adult[$orboat_id[$i]]) ? $ad_no + array_sum($adult[$orboat_id[$i]]) : $ad_no;
                $chd_no = !empty($child[$orboat_id[$i]]) ? $chd_no + array_sum($child[$orboat_id[$i]]) : $chd_no;
                $inf_no = !empty($infant[$orboat_id[$i]]) ? $inf_no + array_sum($infant[$orboat_id[$i]]) : $inf_no;
            } ?>
            <div class="table-responsive">
                <table class="">
                    <tr>
                        <td style="background-color: #333; color: #FFF;" class="text-center text-bold h3" rowspan="2" width="20%">รวมทั้งหมด</td>
                        <td style="background-color: #333; color: #FFF;" class="text-center text-bold">ADULT</td>
                        <td style="background-color: #333; color: #FFF;" class="text-center text-bold">CHILD</td>
                        <td style="background-color: #333; color: #FFF;" class="text-center text-bold">INFANT</td>
                    </tr>
                    <tr>
                        <td class="text-center text-bold h4"><?php echo $ad_no; ?></td>
                        <td class="text-center text-bold h4"><?php echo $chd_no; ?></td>
                        <td class="text-center text-bold h4"><?php echo $inf_no; ?></td>
                    </tr>
                </table>
            </div>
        <?php } ?>
<?php }
} else {
    echo FALSE;
}

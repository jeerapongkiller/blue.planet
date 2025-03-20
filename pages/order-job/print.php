<?php
require_once 'controllers/Order.php';

$orderObj = new Order();

if (isset($_GET['action']) && $_GET['action'] == "print") {
    // get value from ajax
    $search_boat = $_GET['search_boat'] != "" ? $_GET['search_boat'] : 'all';
    $date_travel = $_GET['date_travel'] != "" ? $_GET['date_travel'] : '0000-00-00';
    $search_status = $_GET['search_status'] != "" ? $_GET['search_status'] : 'all';
    $search_agent = $_GET['search_agent'] != "" ? $_GET['search_agent'] : 'all';
    $search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
    $search_voucher_no = $_GET['search_voucher_no'] != "" ? $_GET['search_voucher_no'] : '';
    $refcode = $_GET['refcode'] != "" ? $_GET['refcode'] : '';
    $name = $_GET['name'] != "" ? $_GET['name'] : '';

    $search_boat_name = $search_boat != 'all' ? $orderObj->get_data('name', 'boats', $search_boat)['name'] : '';

    # --- get data --- #
    $first_order = array();
    $first_bo = array();
    $first_cus = array();
    $first_ext = array();
    $first_pay = array();
    $first_bpr = array();
    $first_bomanage = array();
    $sum_programe = 0;
    $sum_ad = 0;
    $sum_chd = 0;
    $sum_inf = 0;
    $name_img = 'Job Guide';
    $name_img .= $search_boat != 'all' ? ' [' . $search_boat_name . '] ' : '';
    $name_img .= $date_travel != '0000-00-00' ? ' [' . date('j F Y', strtotime($date_travel)) . '] ' : '';
    # --- get data --- #
    $orders = $orderObj->showlistboats('job', 0, $date_travel, $search_boat, 'all', $search_status, $search_agent, $search_product, $search_voucher_no, $refcode, $name, '');
    # --- Check products --- #
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
                $zone_pickup[$order['mange_id']][] = !empty($order['zonep_name']) ? ' (' . $order['zonep_name'] . ')' : '';
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
                $category_name[$order['id']][] = !empty($order['category_name']) ? $order['category_name'] : 0;
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
?>
        <!-- Header ends -->
        <div class="card-body pb-0 pt-0">
            <div class="row">
                <span class="col-6 brand-logo"><img src="app-assets/images/logo/logo-500.png" height="50"></span>
                <span class="col-6 text-right" style="color: #000;">
                    บริษัท บลู แพลนเน็ต ฮอลิเดย์ จํากัด </br>
                    124/343 หมู่ที่ 5 ตำบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000
                </span>
            </div>
            <div class="text-center card-text">
                <h4 class="font-weight-bolder">ใบงาน</h4>
                <h5 class="font-weight-bolder"><?php echo date('j F Y', strtotime($date_travel)); ?></h5>
            </div>
        </div>
        <?php
        if (!empty($mange_id)) {
            for ($i = 0; $i < count($mange_id); $i++) {
                $total_no = 0;
        ?>
                <div class="d-flex justify-content-between align-items-center header-actions mx-1 row pt-1">
                    <div class="col-4 text-left text-bold h4"></div>
                    <div class="col-4 text-center text-bold h4"><?php echo $order_boat_name[$i]; ?></div>
                    <div class="col-4 text-right mb-50"></div>
                </div>

                <div class="table-responsive" id="order-guide-search-table">
                    <table>
                        <thead>
                            <tr>
                                <td colspan="7">ไกด์ : <?php echo $order_guide_name[$i]; ?></td>
                                <td colspan="6">เคาน์เตอร์ : <?php echo $order_counter[$i]; ?></td>
                                <td colspan="4" style="background-color: <?php echo $color_hex[$i]; ?>; <?php echo $text_color[$i] != '' ? 'color: ' . $text_color[$i] . ';' : ''; ?>">
                                    สี : <?php echo $color_name[$i]; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" width="3%"></th>
                                <th class="text-center" width="1%"></th>
                                <th width="5%">เวลารับ</th>
                                <th width="5%">Driver</th>
                                <th width="20%">โปรแกรม</th>
                                <th width="13%">เอเยนต์</th>
                                <th width="14%">ชื่อลูกค้า</th>
                                <th>ภาษา (ไกด์)</th>
                                <th width="2%">V/C</th>
                                <th width="15%">โรงแรม</th>
                                <th width="10%">โซน</th>
                                <th width="5%">ห้อง</th>
                                <th class="text-center" width="1%">A</th>
                                <th class="text-center" width="1%">C</th>
                                <th class="text-center" width="1%">Inf</th>
                                <th class="text-center" width="1%">FOC</th>
                                <!-- <th class="text-center">รวม</th> -->
                                <th width="5%">COT</th>
                                <th width="8%">Remark</th>
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
                                    $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                                    $total_tourist = $total_tourist + array_sum($adult[$id]) + array_sum($child[$id]) + array_sum($infant[$id]) + array_sum($foc[$id]);
                                    $total_adult = $total_adult + array_sum($adult[$id]);
                                    $total_child = $total_child + array_sum($child[$id]);
                                    $total_infant = $total_infant + array_sum($infant[$id]);
                                    $total_foc = $total_foc + array_sum($foc[$id]);
                                    $text_hotel = '';
                                    $text_zone = '';
                                    if ($pickup_type[$mange_id[$i]][$a] == 1) {
                                        if (!empty($zone_pickup[$mange_id[$i]][$a])) {
                                            $text_zone = $zone_pickup[$mange_id[$i]][$a] != $zone_dropoff[$mange_id[$i]][$a] ? $zone_pickup[$mange_id[$i]][$a] . '<br>(D: ' . $zone_dropoff[$mange_id[$i]][$a] . ')' : $zone_pickup[$mange_id[$i]][$a];
                                        }
                                        if (!empty($hotel_pickup[$mange_id[$i]][$a])) {
                                            $text_hotel = $hotel_pickup[$mange_id[$i]][$a] != $hotel_dropoff[$mange_id[$i]][$a] ? $hotel_pickup[$mange_id[$i]][$a] . '<br>(D: ' . $hotel_dropoff[$mange_id[$i]][$a] . ')' : $hotel_pickup[$mange_id[$i]][$a];
                                        }
                                    } else {
                                        $text_hotel = 'เดินทางมาเอง';
                                        $text_zone = 'เดินทางมาเอง';
                                    }
                            ?>
                                    <tr class="<?php echo $class_tr; ?>">
                                        <td class="text-center"><?php echo $check_id[$mange_id[$i]][$a] > 0 ? '<i data-feather="check"></i>' : ''; ?></td>
                                        <td class="text-center"><?php echo $a + 1; ?></td>
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
                                        <td style="padding: 5px;"><?php echo $text_hotel; ?></td>
                                        <td style="padding: 5px;"><?php echo $text_zone; ?></td>
                                        <td><?php echo $room_no[$mange_id[$i]][$a]; ?></td>
                                        <td class="text-center"><?php echo array_sum($adult[$id]); ?></td>
                                        <td class="text-center"><?php echo array_sum($child[$id]); ?></td>
                                        <td class="text-center"><?php echo array_sum($infant[$id]); ?></td>
                                        <td class="text-center"><?php echo array_sum($foc[$id]); ?></td>
                                        <!-- <td class="text-center"><?php echo !empty($bec_rate_total[$id]) ? number_format($total[$mange_id[$i]][$a] + array_sum($bec_rate_total[$id])) : number_format($total[$mange_id[$i]][$a]); ?></td> -->
                                        <td class="text-nowrap"><b class="text-danger"><?php echo !empty($cot[$id]) ? array_sum($cot[$id]) : ''; ?></b></td>
                                        <td><b class="text-info">
                                                <?php if (!empty($bec_id[$id])) {
                                                    for ($e = 0; $e < count($bec_name[$id]); $e++) {
                                                        echo $e == 0 ? $bec_name[$id][$e] : ' : ' . $bec_name[$id][$e];
                                                        // if ($bec_type[$id][$e] == 1) {
                                                        //     echo 'A ' . $bec_adult[$id][$e] . ' X ' . $bec_rate_adult[$id][$e];
                                                        //     echo !empty($bec_child[$id][$e]) ? ' C ' . $bec_child[$id][$e] . ' X ' . $bec_rate_child[$id][$e] : '';
                                                        // } elseif ($bec_type[$id][$e] == 2) {
                                                        //     echo $bec_privates[$id][$e] . ' X ' . $bec_rate_total[$id][$e] . ' ';
                                                        // }
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
                    </br>
                </div>
                <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
<?php }
        }
    }
} else {
    echo FALSE;
}

<?php
require_once 'controllers/Order.php';

$today = date("Y-m-d");
$tomorrow = new DateTime('tomorrow');
$manageObj = new Order();

if (isset($_GET['action']) && $_GET['action'] == "print" && !empty($_GET['date_travel'])) {
    // get value from ajax
    $date_travel = $_GET['date_travel'] != "" ? $_GET['date_travel'] : '0000-00-00';
    $search_boat = $_GET['search_boat'] != "" ? $_GET['search_boat'] : 'all';
    $search_status = $_GET['search_status'] != "" ? $_GET['search_status'] : 'all';
    $search_agent = $_GET['search_agent'] != "" ? $_GET['search_agent'] : 'all';
    $search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
    $search_voucher_no = $_GET['search_voucher_no'] != "" ? $_GET['search_voucher_no'] : '';
    $refcode = $_GET['refcode'] != "" ? $_GET['refcode'] : '';
    $name = $_GET['name'] != "" ? $_GET['name'] : '';
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
    $bookings = $manageObj->showlistboats('list', 0, $date_travel, $search_boat, 'all', $search_status, $search_agent, $search_product, $search_voucher_no, $refcode, $name, '');
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
                // $category_name[$booking['id']] = !empty($booking['category_name']) ? $booking['category_name'] : '';
                // $adult[$booking['id']] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                // $child[$booking['id']] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                // $infant[$booking['id']] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                // $foc[$booking['id']] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
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
    $manages = $manageObj->show_manage_boat($date_travel, $search_boat);
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
                $mange['guide_name'][] = !empty($manage['guide_id']) ? $manage['guide_name'] : '';
                $mange['captain_id'][] = !empty($manage['captain_id']) ? $manage['captain_id'] : 0;
                $mange['captain_name'][] = !empty($manage['captain_id']) ?  $manage['captain_name'] : '';
                $mange['crewf_id'][] = !empty($manage['crewf_id']) ? $manage['crewf_id'] : 0;
                $mange['crews_id'][] = !empty($manage['crews_id']) ? $manage['crews_id'] : 0;
                $mange['crewf_name'][] = !empty($manage['crewf_id']) ? $manage['crewf_name'] : '';
                $mange['crews_name'][] = !empty($manage['crews_id']) ? $manage['crews_name'] : '';
                $mange['pier_name'][] = !empty($manage['pier_name']) ? $manage['pier_name'] : '';
                $mange['note'][] = !empty($manage['note']) ? $manage['note'] : '';
                $mange['outside_boat'][] = !empty($manage['outside_boat']) ? $manage['outside_boat'] : '';
                $mange['guide'][] = !empty($manage['guide']) ? $manage['guide'] : '';
            }
        }
?>
        <div id="div-boat-job-image" style="background-color: #FFF;">
            <!-- Header starts -->
            <div class="card-body pb-0">
                <div class="row">
                    <span class="col-6 brand-logo"><img src="app-assets/images/logo/logo-500.png" height="50"></span>
                    <span class="col-6 text-right" style="color: #000;">
                        บริษัท บลู แพลนเน็ต ฮอลิเดย์ จํากัด </br>
                        124/343 หมู่ที่ 5 ตำบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000
                    </span>
                </div>
                <div class="text-center card-text">
                    <h4 class="font-weight-bolder">ใบจัดเรือ</h4>
                    <div class="badge badge-pill badge-light-danger">
                        <h5 class="m-0 pl-1 pr-1 text-danger"><?php echo date('j F Y', strtotime($date_travel)); ?></h5>
                    </div>
                </div>
            </div>
            <!-- Header ends -->
            <!-- Body starts -->
            <?php
            if (!empty($mange['id'])) {
                for ($i = 0; $i < count($mange['id']); $i++) {
            ?>
                    <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1">
                        <div class="col-4 text-left text-bold h4"></div>
                        <div class="col-4 text-center text-bold h1"><?php echo $mange['boat_name'][$i]; ?></div>
                        <div class="col-4 text-right mb-50"></div>
                    </div>

                    <table class="tableprint">
                        <thead class="">
                            <tr>
                                <td colspan="6">ไกด์ : <?php echo $mange['guide_name'][$i]; ?></td>
                                <td colspan="6">เคาน์เตอร์ : <?php echo $mange['counter'][$i]; ?></td>
                                <td colspan="3" style="background-color: <?php echo $mange['color_hex'][$i]; ?>; <?php echo $mange['text_color'][$i] != '' ? 'color: ' . $mange['text_color'][$i] . ';' : ''; ?>">
                                    สี : <?php echo $mange['color_name'][$i]; ?>
                                </td>
                            </tr>
                            <tr>
                                <th width="5%">เวลารับ</th>
                                <th width="5%">Driver</th>
                                <th width="24%">โปรแกรม</th>
                                <th width="15%">เอเยนต์</th>
                                <th width="15%">ชื่อลูกค้า</th>
                                <th>ภาษา (ไกด์)</th>
                                <th width="5%">V/C</th>
                                <th>โรงแรม</th>
                                <th>โซน</th>
                                <th class="text-center" width="1%">A</th>
                                <th class="text-center" width="1%">C</th>
                                <th class="text-center" width="1%">Inf</th>
                                <th class="text-center" width="1%">FOC</th>
                                <!-- <th class="text-center">รวม</th> -->
                                <th width="5%">COT</th>
                                <th>Remark</th>
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
                                    $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                            ?>
                                    <tr class="<?php echo $class_tr; ?>">
                                        <td class="bg-primary bg-lighten-4"><?php echo $book['start_pickup'][$mange['id'][$i]][$a] != '00:00' ? $book['start_pickup'][$mange['id'][$i]][$a] . ' - ' . $book['end_pickup'][$mange['id'][$i]][$a] : ''; ?></td>
                                        <td style="padding: 5px;">
                                            <?php echo (!empty($managet['car'][$id][1])) ? '<b>Pickup : </b>' . $managet['car'][$id][1] : '';
                                            echo (!empty($managet['driver'][$id][1])) ? $managet['driver'][$id][1] : '';  ?>
                                        </td>
                                        <td><?php echo $product_name[$id];
                                            if (!empty($category_name[$id])) {
                                                echo ' (';
                                                for ($c = 0; $c < count($category_name[$id]); $c++) {
                                                    echo $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                                                }
                                            }
                                            echo ')'; ?></td>
                                        <td><?php echo $book['comp_name'][$mange['id'][$i]][$a]; ?></td>
                                        <td><?php echo !empty($book['telephone'][$mange['id'][$i]][$a]) ? $book['cus_name'][$mange['id'][$i]][$a] . ' <br>(' . $book['telephone'][$mange['id'][$i]][$a] . ') ' . $book['nation_name'][$mange['id'][$i]][$a] : $book['cus_name'][$mange['id'][$i]][$a] . $book['nation_name'][$mange['id'][$i]][$a]; ?></td>
                                        <td class="text-nowrap"><?php echo !empty($language[$id]) ? $language[$id] : ''; ?></td>
                                        <td><?php echo !empty($book['voucher'][$mange['id'][$i]][$a]) ? $book['voucher'][$mange['id'][$i]][$a] : $book['book_full'][$mange['id'][$i]][$a]; ?></td>
                                        <td class="cell-fit"><?php echo (!empty($hotel_name[$id])) ? $hotel_name[$id] : $outside[$id]; ?></td>
                                        <td class="cell-fit"><?php echo (!empty($zone_pickup[$id])) ? $zone_pickup[$id] : ''; ?></td>
                                        <td class="text-center bg-warning bg-lighten-3"><?php echo array_sum($adult[$id]); ?></td>
                                        <td class="text-center bg-info bg-lighten-3"><?php echo array_sum($child[$id]); ?></td>
                                        <td class="text-center bg-warning bg-lighten-3"><?php echo array_sum($infant[$id]); ?></td>
                                        <td class="text-center bg-info bg-lighten-3"><?php echo array_sum($foc[$id]); ?></td>
                                        <!-- <td class="text-center"><?php echo !empty($bec_rate_total[$id]) ? number_format($book['total'][$mange['id'][$i]][$a] + array_sum($bec_rate_total[$id])) : number_format($book['total'][$mange['id'][$i]][$a]); ?></td> -->
                                        <td class="text-nowrap"><b class="text-danger"><?php echo $book['cot'][$mange['id'][$i]][$a] > 0 ? number_format($book['cot'][$mange['id'][$i]][$a]) : ''; ?></b></td>
                                        <td><b class="text-info">
                                                <?php if (!empty($bec_id[$id])) {
                                                    for ($e = 0; $e < count($bec_name[$id]); $e++) {
                                                        echo $e == 0 ? $bec_name[$id][$e]  : ' : ' . $bec_name[$id][$e];
                                                    }
                                                }
                                                echo !empty($book['note'][$mange['id'][$i]][$a]) ? ' / ' . $book['note'][$mange['id'][$i]][$a] : ''; ?>
                                            </b></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="15" style="padding: 5px;"><b>Remark : </b><?php echo $mange['note'][$i]; ?></td>
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

                    <div class="pagebreak"></div>
            <?php }
            } ?>
            <input type="hidden" id="name_img" name="name_img" value="<?php echo 'ใบจัดเรือ - ' . date('j F Y', strtotime($date_travel)); ?>">
            <!-- Body ends -->
        </div>
    <?php
    }
} elseif (isset($_GET['action']) && $_GET['action'] == "check_in" && !empty($_GET['travel_date']) && !empty($_GET['manage_id'])) {
    // get value from ajax
    $manage_id = $_GET['manage_id'] != "" ? $_GET['manage_id'] : 0;
    $travel_date = $_GET['travel_date'] != "" ? $_GET['travel_date'] : '0000-00-00';

    # --- show list boats booking --- #
    $first_booking = array();
    $first_cus = array();
    $first_program = array();
    $first_ext = array();
    $first_bomanage = array();
    $first_bo = [];
    $first_trans = [];
    $bookings = $manageObj->showlistboats('list', 0, $travel_date, 'all', 'all', 'all', 'all', 'all', '', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            if ($booking['mange_id'] == $manage_id) {
                if (in_array($booking['id'], $first_bo) == false) {
                    $first_bo[] = $booking['id'];
                    $book['id'][$booking['mange_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                    $book['check'][$booking['mange_id']][] = !empty($booking['check_id']) ? $booking['check_id'] : 0;
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
                    $book['adult'][$booking['mange_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                    $book['child'][$booking['mange_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                    $book['infant'][$booking['mange_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                    $book['foc'][$booking['mange_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                    $book['rate_adult'][$booking['mange_id']][] = !empty($booking['rate_adult']) ? $booking['rate_adult'] : 0;
                    $book['rate_child'][$booking['mange_id']][] = !empty($booking['rate_child']) ? $booking['rate_child'] : 0;
                    $book['rate_infant'][$booking['mange_id']][] = !empty($booking['rate_infant']) ? $booking['rate_infant'] : 0;
                    $book['rate_private'][$booking['mange_id']][] = !empty($booking['rate_private']) ? $booking['rate_private'] : 0;
                    $book['discount'][$booking['mange_id']][] = !empty(!empty($booking['bp_discount'])) ? $booking['bp_discount'] : 0;
                    $book['note'][$booking['mange_id']][] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
                    $book['language'][$booking['mange_id']][] = !empty($booking['lang_name']) ? $booking['lang_name'] : '';
                    $book['cot'][$booking['mange_id']][] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
                    $book['total'][$booking['mange_id']][] = $booking['booktye_id'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) + ($booking['rate_infant'] * $booking['rate_infant']) : $booking['rate_private'];
                    $book['bo_mange_id'][$booking['mange_id']][] = !empty($booking['boman_id']) ? $booking['boman_id'] : 0;

                    $boat_name[$booking['mange_id']] = !empty($booking['boat_name']) ? $booking['boat_name'] : '';
                    $color_id[$booking['mange_id']] = !empty($booking['color_id']) ? $booking['color_id'] : '';
                    $color_name[$booking['mange_id']] = !empty($booking['color_name']) ? $booking['color_name'] : '';
                    $color_hex[$booking['mange_id']] = !empty($booking['color_hex']) ? $booking['color_hex'] : '';
                    $guide_name[$booking['mange_id']] = !empty($booking['guide_name']) ? $booking['guide_name'] : '';
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
                    $managet['pickup'][$booking['id']][] = !empty($booking['pickup']) ? $booking['pickup'] : 0;
                    $managet['dropoff'][$booking['id']][] = !empty($booking['dropoff']) ? $booking['dropoff'] : 0;
                }
            }
        }
    }
    ?>
    <div id="div-boat-job-image" style="background-color: #FFF;">
        <!-- Header starts -->
        <div class="card-body pb-0">
            <div class="row">
                <span class="col-6 brand-logo"><img src="app-assets/images/logo/logo-500.png" height="50"></span>
                <span class="col-6 text-right" style="color: #000;">
                    บริษัท บลู แพลนเน็ต ฮอลิเดย์ จํากัด </br>
                    124/343 หมู่ที่ 5 ตำบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000
                </span>
            </div>
            <div class="text-center card-text">
                <h4 class="font-weight-bolder">Check-In</h4>
                <div class="badge badge-pill badge-light-danger">
                    <h5 class="m-0 pl-1 pr-1 text-danger"><?php echo date('j F Y', strtotime($travel_date)); ?></h5>
                </div>
            </div>
        </div>
        <!-- Header ends -->
        <!-- Body starts -->
        <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1">
            <div class="col-4 text-left text-bold h4"></div>
            <div class="col-4 text-center text-bold h1"><?php echo $boat_name[$manage_id]; ?></div>
            <div class="col-4 text-right mb-50"></div>
        </div>

        <table class="tableprint">
            <thead class="">
                <tr>
                    <td colspan="10">ไกด์ : <?php echo $guide_name[$manage_id]; ?></td>
                    <td colspan="4" style="background-color: <?php echo $color_hex[$manage_id]; ?>;">
                        สี : <?php echo $color_name[$manage_id]; ?>
                    </td>
                </tr>
                <tr>
                    <th width="2%"></th>
                    <th width="5%">เวลารับ</th>
                    <th width="5%">Driver</th>
                    <th width="15%">เอเยนต์</th>
                    <th width="15%">ชื่อลูกค้า</th>
                    <th width="5%">V/C</th>
                    <th width="22%">โรงแรม</th>
                    <!-- <th width="5%">ห้อง</th> -->
                    <th class="text-center" width="1%">A</th>
                    <th class="text-center" width="1%">C</th>
                    <th class="text-center" width="1%">Inf</th>
                    <th class="text-center" width="1%">FOC</th>
                    <!-- <th class="text-center">รวม</th> -->
                    <th width="5%">COT</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_tourist = 0;
                $total_adult = 0;
                $total_child = 0;
                $total_infant = 0;
                $total_foc = 0;
                if (!empty($book['id'][$manage_id])) {
                    for ($a = 0; $a < count($book['id'][$manage_id]); $a++) {
                        $total_tourist = $total_tourist + $book['adult'][$manage_id][$a] + $book['child'][$manage_id][$a] + $book['infant'][$manage_id][$a] + $book['foc'][$manage_id][$a];
                        $total_adult = $total_adult + $book['adult'][$manage_id][$a];
                        $total_child = $total_child + $book['child'][$manage_id][$a];
                        $total_infant = $total_infant + $book['infant'][$manage_id][$a];
                        $total_foc = $total_foc + $book['foc'][$manage_id][$a];
                        $id = $book['id'][$manage_id][$a];
                        $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                ?>
                        <tr class="<?php echo $class_tr; ?>">
                            <td class="text-center"><?php echo $book['check'][$manage_id][$a] > 0 ? '<i data-feather="check"></i>' : ''; ?></td>
                            <td class="bg-primary bg-lighten-4"><?php echo $book['start_pickup'][$manage_id][$a] != '00:00' ? $book['start_pickup'][$manage_id][$a] . ' - ' . $book['end_pickup'][$manage_id][$a] : ''; ?></td>
                            <td style="padding: 5px;"><?php echo (!empty($managet['car'][$id][1])) ? $managet['car'][$id][1] : ''; ?></td>
                            <td><?php echo $book['comp_name'][$manage_id][$a]; ?></td>
                            <td><?php echo !empty($book['telephone'][$manage_id][$a]) ? $book['cus_name'][$manage_id][$a] . ' <br>(' . $book['telephone'][$manage_id][$a] . ') ' . $book['language'][$manage_id][$a] : $book['cus_name'][$manage_id][$a] . $book['language'][$manage_id][$a]; ?></td>
                            <td><?php echo !empty($book['voucher'][$manage_id][$a]) ? $book['voucher'][$manage_id][$a] : $book['book_full'][$manage_id][$a]; ?></td>
                            <td class="cell-fit"><?php echo (!empty($hotel_name[$id])) ? $hotel_name[$id] : $outside[$id]; ?></td>
                            <td class="cell-fit"><?php echo (!empty($zone_pickup[$id])) ? $zone_pickup[$id] : ''; ?></td>
                            <!-- <td style="padding: 5px;">
                                <?php if ($pickup_type[$id] == 1) {
                                    echo (!empty($hotel_name[$id])) ? '<b>Pickup : </b>' . $hotel_name[$id] . $zone_pickup[$id] . '</br>' : '<b>Pickup : </b>' . $outside[$id] . $zone_pickup[$id] . '</br>';
                                    echo (!empty($dropoff_name[$id])) ? '<b>Dropoff : </b>' . $dropoff_name[$id] . $zone_dropoff[$id] : '<b>Dropoff : </b>' . $outside_dropoff[$id]  . $zone_dropoff[$id];
                                } else {
                                    echo 'เดินทางมาเอง';
                                } ?>
                            </td>
                            <td><?php echo $book['room_no'][$manage_id][$a]; ?></td> -->
                            <td class="text-center bg-warning bg-lighten-3"><?php echo $book['adult'][$manage_id][$a]; ?></td>
                            <td class="text-center bg-info bg-lighten-3"><?php echo $book['child'][$manage_id][$a]; ?></td>
                            <td class="text-center bg-warning bg-lighten-3"><?php echo $book['infant'][$manage_id][$a]; ?></td>
                            <td class="text-center bg-info bg-lighten-3"><?php echo $book['foc'][$manage_id][$a]; ?></td>
                            <!-- <td class="text-center"><?php echo !empty($bec_rate_total[$id]) ? number_format($book['total'][$manage_id][$a] + array_sum($bec_rate_total[$id])) : number_format($book['total'][$manage_id][$a]); ?></td> -->
                            <td class="text-nowrap"><b class="text-danger"><?php echo $book['cot'][$manage_id][$a] > 0 ? number_format($book['cot'][$manage_id][$a]) : ''; ?></b></td>
                            <td><b class="text-info">
                                    <?php if (!empty($bec_id[$id])) {
                                        for ($e = 0; $e < count($bec_name[$id]); $e++) {
                                            echo $e == 0 ? $bec_name[$id][$e]  : ' : ' . $bec_name[$id][$e];
                                        }
                                    }
                                    echo !empty($book['note'][$manage_id][$a]) ? ' / ' . $book['note'][$manage_id][$a] : ''; ?>
                                </b></td>
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
        <input type="hidden" id="name_img" name="name_img" value="<?php echo 'ใบจัดเรือ - ' . date('j F Y', strtotime($travel_date)); ?>">
        <!-- Body ends -->
    </div>
    <?php
} elseif (isset($_GET['action']) && $_GET['action'] == "customer" && !empty($_GET['date_travel']) && !empty($_GET['manage_id'])) {
    // get value from ajax
    $manage_id = $_GET['manage_id'] != "" ? $_GET['manage_id'] : 0;
    $travel_date = $_GET['date_travel'] != "" ? $_GET['date_travel'] : '0000-00-00';

    # --- show list boats booking --- #
    $first_cus = array();
    $bookings = $manageObj->showlistboats('customer', $manage_id, $travel_date, 'all', 'all', 'all', 'all', 'all', '', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            if ($booking['mange_id'] == $manage_id) {

                $boat_name = !empty($booking['boat_name']) ? $booking['boat_name'] : 0;

                if (in_array($booking['cus_id'], $first_cus) == false) {
                    $first_cus[] = $booking['cus_id'];
                    $cus_id[] = !empty($booking['cus_id']) ? $booking['cus_id'] : 0;
                    $cus_age[] = !empty($booking['cus_age']) ? $booking['cus_age'] : 0;
                    $nation_id[] = !empty($booking['nation_id']) ? $booking['nation_id'] : 0;
                    $age_name[] = !empty($booking['cus_age']) ? $booking['cus_age'] != 1 ? $booking['cus_age'] != 2 ? $booking['cus_age'] != 3 ? $booking['cus_age'] == 4 ? 'FOC' : '' : 'Infant' : 'Children' : 'Adult' : '';
                    $cus_name[] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                    $id_card[] = !empty($booking['id_card']) ? $booking['id_card'] : '';
                    $birth_date[] = !empty($booking['birth_date']) && $booking['birth_date'] != '0000-00-00' ? date('j F Y', strtotime($booking['birth_date'])) : '';
                    $nation_name[] = !empty($booking['nation_name']) ? $booking['nation_name'] : '';
                    $voucher_no_agent[] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
                }
            }
        }
    ?>
        <div id="div-boat-job-image" style="background-color: #FFF;">
            <!-- Header starts -->
            <div class="card-body pb-0">
                <div class="row">
                    <span class="col-6 brand-logo"><img src="app-assets/images/logo/logo-500.png" height="50"></span>
                    <span class="col-6 text-right" style="color: #000;">
                        บริษัท บลู แพลนเน็ต ฮอลิเดย์ จํากัด </br>
                        124/343 หมู่ที่ 5 ตำบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000
                    </span>
                </div>
                <div class="text-center card-text">
                    <h4 class="font-weight-bolder">ใบจัดเรือ</h4>
                    <div class="badge badge-pill badge-light-danger">
                        <h5 class="m-0 pl-1 pr-1 text-danger"><?php echo date('j F Y', strtotime($travel_date)); ?></h5>
                    </div>
                </div>
            </div>
            <!-- Header ends -->
            <!-- Body starts -->
            <?php

            ?>
            <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1">
                <div class="col-4 text-left text-bold h4"></div>
                <div class="col-4 text-center text-bold h1"><?php echo $boat_name; ?></div>
                <div class="col-4 text-right mb-50"></div>
            </div>

            <table class="tableprint">
                <thead class="">
                    <tr>
                        <th class="text-center" width="15%">A/C/I/F</th>
                        <th class="text-center" width="45%">ชื่อ</th>
                        <th class="text-center" width="20%">V/C</th>
                        <th class="text-center" width="10%">สัญชาติ</th>
                        <th class="text-center" width="10%">Birth Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_tourist = 0;
                    $total_adult = 0;
                    $total_child = 0;
                    $total_infant = 0;
                    $total_foc = 0;
                    if (!empty($cus_id)) {
                        for ($i = 0; $i < count($cus_id); $i++) {
                            $total_adult = $cus_age[$i] == 1 ? $total_adult + 1 : $total_adult;
                            $total_child = $cus_age[$i] == 2 ? $total_child + 1 : $total_child;
                            $total_infant = $cus_age[$i] == 3 ? $total_infant + 1 : $total_infant;
                            $total_foc = $cus_age[$i] == 4 ? $total_foc + 1 : $total_foc;
                            $total_tourist = $total_tourist + 1;
                            $class_tr = ($i % 2 == 1) ? 'table-active' : '';
                    ?>
                            <tr class="<?php echo $class_tr; ?>">
                                <td class="text-center" width="15%"><?php echo $age_name[$i]; ?></td>
                                <td width="45%"><?php echo $cus_name[$i]; ?></td>
                                <td class="text-center" width="20%"><?php echo $voucher_no_agent[$i]; ?></td>
                                <td class="text-center" width="10%"><?php echo $nation_name[$i]; ?></td>
                                <td class="text-center" width="10%"><?php echo $birth_date[$i]; ?></td>
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


            <input type="hidden" id="name_img" name="name_img" value="<?php echo 'ใบจัดเรือ - ' . date('j F Y', strtotime($date_travel)); ?>">
            <!-- Body ends -->
        </div>
<?php
    }
}

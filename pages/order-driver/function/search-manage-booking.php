<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search" && isset($_POST['travel_date'])) {
    // get value from ajax
    $travel = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $head_name = !empty($_POST['car']) ? $_POST['car'] : '';
    $seat = !empty($_POST['seat']) ? $_POST['seat'] : 0;
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : 'all';
    $return = !empty($_POST['return']) ? $_POST['return'] : 1;
    $type = !empty($_POST['type']) ? $_POST['type'] : 'not';

    $first_bo = array();
    $first_bt = array();
    $first_prod = array();
    $first_manage_bt = array();
    $frist_bomange = array();
    $bookings = $manageObj->showlisttransfers('manage', 0, $travel, $product_id, 'all', 'all', 'all', 'all', 'all', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value Programe --- #
            if (in_array($booking['product_id'], $first_prod) == false) {
                $first_prod[] = $booking['product_id'];
                $programe_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                $programe_name[] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $programe_type[] = !empty($booking['pg_type_name']) ? $booking['pg_type_name'] : '';
            }
            # --- get value booking --- #
            if ((in_array($booking['id'], $first_bo) == false)) {
                $first_bo[] = $booking['id'];
                $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
                $bp_id[$booking['id']] = !empty($booking['bp_id']) ? $booking['bp_id'] : 0;
                $bt_id[$booking['id']] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                $travel_date[$booking['id']] = !empty(!empty($booking['travel_date'])) ? $booking['travel_date'] : '0000-00-00';
                $adult[$booking['id']] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
                $child[$booking['id']] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
                $infant[$booking['id']] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
                $foc[$booking['id']] = !empty($booking['bt_foc']) ? $booking['bt_foc'] : 0;
                $book_full[$booking['id']] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                $voucher_no[$booking['id']] = !empty(!empty($booking['voucher_no_agent'])) ? $booking['voucher_no_agent'] : '';
                $agent_name[$booking['id']] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                $cus_name[$booking['id']] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $nation_name[$booking['id']] = !empty($booking['nation_name']) ? ' (' . $booking['nation_name'] . ')' : '';
                $product[$booking['id']] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                $product_name[$booking['id']] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $category_name[$booking['id']] = !empty($booking['category_name']) ? $booking['category_name'] : '';
                $booktye_name[$booking['id']] = !empty($booking['booktye_name']) ? $booking['booktye_name'] : '';
                $hotel_name[$booking['id']] = !empty($booking['pickup_id']) ? $booking['pickup_name'] : $booking['outside'];
                $hotel_dropoff[$booking['id']] = !empty($booking['dropoff_id']) ? $booking['dropoff_name'] : $booking['outside_dropoff'];
                $note[$booking['id']] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
                $start_pickup[$booking['id']] = !empty($booking['start_pickup']) && $booking['start_pickup'] != '00:00' ? $booking['start_pickup'] : '00:00';
                $end_pickup[$booking['id']] = !empty($booking['end_pickup']) && $booking['end_pickup'] != '00:00' ? $booking['end_pickup'] : '00:00';
                $zone_name[$booking['id']] = !empty($booking['zonep_name']) ? $booking['zonep_name'] : '';
                $zone_dropoff[$booking['id']] = !empty($booking['zoned_name']) ? $booking['zoned_name'] : '';
                $cate_transfer[$booking['id']] = !empty($booking['category_transfer']) ? $booking['category_transfer'] : 0;
                $language[$booking['id']] = !empty($booking['lang_name']) ? ' (' . $booking['lang_name'] . ')' : '';
            }

            if (in_array($booking['bt_id'], $first_bt) == false) {
                $first_bt[] = $booking['bt_id'];
                $pickup_id[$booking['id']][1] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                $dropoff_id[$booking['id']][2] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                // $check_mange[$booking['product_id']][1][] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
                if (($booking['pickup_id'] != $booking['dropoff_id']) || ($booking['outside'] != $booking['outside_dropoff'])) {
                    $check_dropoff[$booking['product_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                }
            }

            if ($booking['mange_id'] > 0 && (in_array($booking['bomange_id'], $frist_bomange) == false)) {
                $frist_bomange[] = $booking['bomange_id'];
                $reteun = $booking['mange_pickup'] > 0 ? 1 : 2;
                $bomange_id[$reteun][$booking['id']][] = !empty($booking['bomange_id']) ? $booking['bomange_id'] : 0;
                $bomange_bo[$reteun][$booking['id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                $check_book[$reteun][] = !empty($booking['id']) ? $booking['id'] : 0;
                $check_mange[$reteun][$booking['product_id']][] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
                $manage_bt[$booking['mange_id']][] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                $manage_bo[$booking['mange_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                if ($booking['mange_id'] == $manage_id) {
                    $mange_id[$reteun] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
                }
            }
        }
?>
        <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75">
            <div class="col-lg-12 col-xl-12 text-center text-bold h4">
                <?php echo $head_name . ' - ' . date('j F Y', strtotime($travel)); ?>
            </div>
        </div>

        <div class="row border-top border-bottom text-center mx-0" hidden>
            <div class="col-3 border-right py-1">
                <p class="card-text text-muted mb-0">Booking ที่ไม่ได้เลือก</p>
                <h3 class="font-weight-bolder mb-0" id="booking-false"></h3>
            </div>
            <div class="col-3 border-right py-1">
                <p class="card-text text-muted mb-0">Total ที่ไม่ได้เลือก</p>
                <h3 class="font-weight-bolder mb-0" id="toc-false"></h3>
            </div>
            <div class="col-3 border-right py-1">
                <p class="card-text text-muted mb-0">Booking ที่เลือก</p>
                <h3 class="font-weight-bolder mb-0" id="booking-true"></h3>
            </div>
            <!-- <div class="col-3 py-1">
                <p class="card-text text-muted mb-0">Total ที่เลือก</p>
                <h3 class="font-weight-bolder mb-0"><span id="toc-true"></span>/<?php echo $seat; ?></h3>
            </div> -->
        </div>

        <div class="row border-top border-bottom text-center mx-0">
            <div class="col-4 border-right py-1">
                <p class="card-text text-muted mb-0 text-center">จำนวนคนที่เลือก</p>
                <h3 class="font-weight-bolder mb-0"><span id="toc-true"></span></h3>
            </div>
            <div class="col-2 border-right py-1">
                <p class="card-text text-muted mb-0">Adult</p>
                <h3 class="font-weight-bolder mb-0" id="adult-sum"></h3>
            </div>
            <div class="col-2 border-right py-1">
                <p class="card-text text-muted mb-0">Children</p>
                <h3 class="font-weight-bolder mb-0" id="child-sum"></h3>
            </div>
            <div class="col-2 border-right py-1">
                <p class="card-text text-muted mb-0">Infant</p>
                <h3 class="font-weight-bolder mb-0" id="infant-sum"></h3>
            </div>
            <div class="col-2 py-1">
                <p class="card-text text-muted mb-0">FOC</p>
                <h3 class="font-weight-bolder mb-0" id="foc-sum"></h3>
            </div>
        </div>
        <?php
        if (!empty($programe_id) && $return == 1) {
            for ($a = 0; $a < count($programe_id); $a++) {
        ?>
                <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75">
                    <div class="col-lg-12 col-xl-12 text-center text-bold h4"><?php echo $programe_name[$a]; ?></div>
                </div>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input dt-checkboxes" type="checkbox" id="<?php echo 'checkbo_all' . $programe_id[$a]; ?>" name="<?php echo 'checkbo_all' . $programe_id[$a]; ?>" onclick="checkbox('booking', <?php echo $programe_id[$a]; ?>);">
                                    <label class="custom-control-label" for="<?php echo 'checkbo_all' . $programe_id[$a]; ?>"></label>
                                </div>
                            </th>
                            <th>เวลารับ</th>
                            <th>Category</th>
                            <th>โซน</th>
                            <th>Hotel</th>
                            <th>Name</th>
                            <th class="cell-fit text-center">Total</th>
                            <th class="cell-fit text-center">A</th>
                            <th class="cell-fit text-center">C</th>
                            <th class="cell-fit text-center">INF</th>
                            <th class="cell-fit text-center">FOC</th>
                            <th class="text-nowrap">Agent</th>
                            <th class="text-nowrap">V/C</th>
                            <th>REMARKE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $prod_arr = array();
                        for ($b = 0; $b < count($bo_id); $b++) {
                            if (empty($bomange_bo[1][$bo_id[$b]])) {
                                $id = $bo_id[$b];
                                if ($product[$id] == $programe_id[$a]) {
                                    $text_hotel = '';
                                    $text_zone = '';
                                    if ($cate_transfer[$id] == 1) {
                                        if (!empty($zone_name[$id])) {
                                            $text_zone = $zone_name[$id] != $zone_dropoff[$id] ? $zone_name[$id] . '<br>(D: ' . $zone_dropoff[$id] . ')' : $zone_name[$id];
                                        }
                                        if (!empty($hotel_name[$id])) {
                                            $text_hotel = $hotel_name[$id] != $hotel_dropoff[$id] ? $hotel_name[$id] . '<br>(D: ' . $hotel_dropoff[$id] . ')' : $hotel_name[$id];
                                        }
                                    } else {
                                        $text_hotel = 'เดินทางมาเอง';
                                        $text_zone = 'เดินทางมาเอง';
                                    }
                        ?>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes checkbox-<?php echo $programe_id[$a]; ?> checkbox-book" type="checkbox" id="checkbox<?php echo $bt_id[$id]; ?>" name="bt_id[]" value="<?php echo $bt_id[$id]; ?>" onclick="sum_checkbox();">
                                                <label class="custom-control-label" for="checkbox<?php echo $bt_id[$id]; ?>"></label>
                                            </div>
                                        </td>
                                        <td><?php echo $start_pickup[$id] != '00:00' ? date('H:i', strtotime($start_pickup[$id])) . ' - ' . date('H:i', strtotime($end_pickup[$id])) : ''; ?></td>
                                        <td><span class="fw-bold"><?php echo $category_name[$id]; ?></span></td>
                                        <td><?php echo $text_zone; ?></td>
                                        <td><?php echo $text_hotel; ?></td>
                                        <td><span class="fw-bold"><?php echo $cus_name[$id] . $language[$id]; ?></span></td>
                                        <td class="text-center" id="toc-bookings<?php echo $bt_id[$id]; ?>"><?php echo $adult[$id] + $child[$id] + $infant[$id] + $foc[$id]; ?></td>
                                        <td class="text-center" id="adult<?php echo $bt_id[$id]; ?>"><?php echo $adult[$id]; ?></td>
                                        <td class="text-center" id="child<?php echo $bt_id[$id]; ?>"><?php echo $child[$id]; ?></td>
                                        <td class="text-center" id="infant<?php echo $bt_id[$id]; ?>"><?php echo $infant[$id]; ?></td>
                                        <td class="text-center" id="foc<?php echo $bt_id[$id]; ?>"><?php echo $foc[$id]; ?></td>
                                        <td><?php echo $agent_name[$id]; ?></td>
                                        <td><span class="fw-bold"><?php echo !empty($voucher_no[$id]) ? $voucher_no[$id] : $book_full[$id]; ?></span></td>
                                        <td><?php echo $note[$id]; ?></td>
                                    </tr>
                        <?php }
                            }
                        } ?>
                    </tbody>
                </table>
            <?php //}
            }
        } elseif (!empty($programe_id) && $return == 2) {
            for ($a = 0; $a < count($programe_id); $a++) {
            ?>
                <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75">
                    <div class="col-lg-12 col-xl-12 text-center text-bold h4"><?php echo $programe_name[$a]; ?></div>
                </div>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input dt-checkboxes" type="checkbox" id="<?php echo 'checkbo_all' . $programe_id[$a]; ?>" name="<?php echo 'checkbo_all' . $programe_id[$a]; ?>" onclick="checkbox('booking', <?php echo $programe_id[$a]; ?>);">
                                    <label class="custom-control-label" for="<?php echo 'checkbo_all' . $programe_id[$a]; ?>"></label>
                                </div>
                            </th>
                            <th>เวลารับ</th>
                            <th>Category</th>
                            <th>โซน</th>
                            <th>Hotel</th>
                            <th>Name</th>
                            <th class="cell-fit text-center">Total</th>
                            <th class="cell-fit text-center">A</th>
                            <th class="cell-fit text-center">C</th>
                            <th class="cell-fit text-center">INF</th>
                            <th class="cell-fit text-center">FOC</th>
                            <th class="text-nowrap">Agent</th>
                            <th class="text-nowrap">V/C</th>
                            <th>REMARKE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $prod_arr = array();
                        for ($b = 0; $b < count($check_dropoff[$programe_id[$a]]); $b++) {
                            $id = $check_dropoff[$programe_id[$a]][$b];
                            if (empty($bomange_bo[2][$id])) {
                                if ($product[$id] == $programe_id[$a]) {
                        ?>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes checkbox-<?php echo $programe_id[$a]; ?> checkbox-book" type="checkbox" id="checkbox<?php echo $bt_id[$id]; ?>" name="bt_id[]" value="<?php echo $bt_id[$id]; ?>" onclick="sum_checkbox();">
                                                <label class="custom-control-label" for="checkbox<?php echo $bt_id[$id]; ?>"></label>
                                            </div>
                                        </td>
                                        <td><?php echo $start_pickup[$id] != '00:00' ? date('H:i', strtotime($start_pickup[$id])) . ' - ' . date('H:i', strtotime($end_pickup[$id])) : ''; ?></td>
                                        <td><span class="fw-bold"><?php echo $category_name[$id]; ?></span></td>
                                        <td><?php echo $zone_name[$id]; ?></td>
                                        <td><?php echo $hotel_dropoff[$id]; ?></td>
                                        <td><span class="fw-bold"><?php echo $cus_name[$id] . $language[$id]; ?></span></td>
                                        <td class="text-center" id="toc-bookings<?php echo $bt_id[$id]; ?>"><?php echo $adult[$id] + $child[$id] + $infant[$id] + $foc[$id]; ?></td>
                                        <td class="text-center" id="adult<?php echo $bt_id[$id]; ?>"><?php echo $adult[$id]; ?></td>
                                        <td class="text-center" id="child<?php echo $bt_id[$id]; ?>"><?php echo $child[$id]; ?></td>
                                        <td class="text-center" id="infant<?php echo $bt_id[$id]; ?>"><?php echo $infant[$id]; ?></td>
                                        <td class="text-center" id="foc<?php echo $bt_id[$id]; ?>"><?php echo $foc[$id]; ?></td>
                                        <td><?php echo $agent_name[$id]; ?></td>
                                        <td><span class="fw-bold"><?php echo !empty($voucher_no[$id]) ? $voucher_no[$id] : $book_full[$id]; ?></span></td>
                                        <td><?php echo $note[$id]; ?></td>
                                    </tr>
                        <?php }
                            }
                        } ?>
                    </tbody>
                </table>
        <?php
            }
        } ?>
        <!----- Management Car ------>
        <?php if (!empty($mange_id[$return])) { ?>
            <div class="divider divider-dark">
                <div class="divider-text">
                    <h3 class="text-bold mb-0">จัดรถ</h3>
                </div>
            </div>
            <input type="hidden" id="before_managebt" name="before_managebt" value="<?php echo json_encode($manage_bt[$manage_id], true); ?>">
            <!-- <input type="hidden" id="before_managebt2" name="before_managebt2" value="<?php echo json_encode($before_bt2, true); ?>"> -->
            <table class="table" id="list-group">
                <thead class="table-dark">
                    <tr>
                        <th>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input dt-checkboxes" type="checkbox" id="checkmanage_all" name="checkmanage_all" onclick="checkbox('manage');" checked>
                                <label class="custom-control-label" for="checkmanage_all"></label>
                            </div>
                        </th>
                        <th>เวลารับ</th>
                        <th>Program</th>
                        <th>โซน</th>
                        <th>Hotel</th>
                        <th>Name</th>
                        <th class="cell-fit text-center">Total</th>
                        <th class="cell-fit text-center">A</th>
                        <th class="cell-fit text-center">C</th>
                        <th class="cell-fit text-center">INF</th>
                        <th class="cell-fit text-center">FOC</th>
                        <th class="text-nowrap">Agent</th>
                        <th class="text-nowrap">V/C</th>
                        <th>REMARKE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($c = 0; $c < count($manage_bt[$manage_id]); $c++) {
                        $id = $manage_bo[$manage_id][$c]; ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input dt-checkboxes checkbox-manage" type="checkbox" id="checkbox<?php echo $manage_bt[$manage_id][$c]; ?>" name="manage_bt[]" value="<?php echo $manage_bt[$manage_id][$c]; ?>" onclick="sum_checkbox();" checked>
                                    <label class="custom-control-label" for="checkbox<?php echo $manage_bt[$manage_id][$c]; ?>"><?php // echo $manage_bt[$manage_id][$c]; 
                                                                                                                                ?></label>
                                </div>
                            </td>
                            <td><?php echo $start_pickup[$id] != '00:00' ? date('H:i', strtotime($start_pickup[$id])) . ' - ' . date('H:i', strtotime($end_pickup[$id])) : ''; ?></td>
                            <td><span class="fw-bold"><?php echo $product_name[$id]; ?></span></td>
                            <td><?php echo $zone_name[$id]; ?></td>
                            <td><?php echo $return == 1 ? $hotel_name[$id] : $hotel_dropoff[$id]; ?></td>
                            <td><span class="fw-bold"><?php echo $cus_name[$id] . $language[$id]; ?></span></td>
                            <td class="text-center" id="toc-manage<?php echo $manage_bt[$manage_id][$c]; ?>"><?php echo $adult[$id] + $child[$id] + $infant[$id] + $foc[$id]; ?></td>
                            <td class="text-center" id="adult<?php echo $manage_bt[$manage_id][$c]; ?>"><?php echo $adult[$id]; ?></td>
                            <td class="text-center" id="child<?php echo $manage_bt[$manage_id][$c]; ?>"><?php echo $child[$id]; ?></td>
                            <td class="text-center" id="infant<?php echo $manage_bt[$manage_id][$c]; ?>"><?php echo $infant[$id]; ?></td>
                            <td class="text-center" id="foc<?php echo $manage_bt[$manage_id][$c]; ?>"><?php echo $foc[$id]; ?></td>
                            <td><?php echo $agent_name[$id]; ?></td>
                            <td><span class="fw-bold"><?php echo !empty($voucher_no[$id]) ? $voucher_no[$id] : $book_full[$id]; ?></span></td>
                            <td><?php echo $note[$id]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        <hr>
        <div class="d-flex justify-content-between">
            <span></span>
            <button type="submit" class="btn btn-primary" onclick="submit_booking_manage('<?php echo $type; ?>', <?php echo $return; ?>, <?php echo $manage_id; ?>);">Submit</button>
        </div>
<?php
    }
} else {
    echo false;
}
?>
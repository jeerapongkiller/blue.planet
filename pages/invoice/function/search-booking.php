<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Invoice.php';

$invObj = new Invoice();
$today = date("Y-m-d");

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['agent_id']) && !empty($_POST['travel_date'])) {
    // get value from ajax
    $agent_id = $_POST['agent_id'] != "" ? $_POST['agent_id'] : 0;
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';
    $search_product = !empty($_POST['search_product']) ? $_POST['search_product'] : 'all';
    $search_island = !empty($_POST['search_island']) ? $_POST['search_island'] : 'all';

    $first_booking = array();
    $first_extar = array();
    $first_bpr = array();
    $bookings = $invObj->showlist('bookings', $travel_date, $search_island, $search_product, $agent_id, 0);
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value booking --- #
            if (in_array($booking['id'], $first_booking) == false) {
                $first_booking[] = $booking['id'];
                $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
                $comp_id[] = !empty($booking['comp_id']) ? $booking['comp_id'] : 0;
                $agent_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                $status[] = !empty($booking['booksta_id']) ? $booking['booksta_id'] : 0;
                $status_name[] = !empty($booking['booksta_name']) ? '<span class="badge badge-pill ' . $booking['booksta_class'] . ' text-capitalized"> ' . $booking['booksta_name'] . ' </span>' : '';
                $agent_license[] = !empty($booking['tat_license']) ? $booking['tat_license'] : '';
                $agent_telephone[] = !empty($booking['comp_telephone']) ? $booking['comp_telephone'] : '';
                $agent_address[] = !empty($booking['comp_address']) ? $booking['comp_address'] : '';
                $color[] = !empty($booking['island_color']) ? $booking['island_color'] : '';
                $darken[] = !empty($booking['island_darken']) ? $booking['island_darken'] : '';
                // $color[] = '00D100';
                // $darken[] = '008000';
                $cot[] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
                $start_pickup[] = !empty($booking['start_pickup']) ? date('H:i', strtotime($booking['start_pickup'])) : '00:00:00';
                $end_pickup[] = !empty($booking['end_pickup']) ? date('H:i', strtotime($booking['end_pickup'])) : '00:00:00';
                $car_name[] = !empty($booking['car_name']) ? $booking['car_name'] : '';
                $cus_name[] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $book_full[] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                $voucher_no[] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
                $pickup_type[] = !empty($booking['pickup_type']) ? $booking['pickup_type'] : 0;
                $room_no[] = !empty($booking['room_no']) ? $booking['room_no'] : '-';
                $hotel_pickup[] = !empty($booking['pickup_name']) ? $booking['pickup_name'] : $booking['outside'];
                $zone_pickup[] = !empty($booking['zonep_name']) ? ' (' . $booking['zonep_name'] . ')' : '';
                $hotel_dropoff[] = !empty($booking['dropoff_name']) ? $booking['dropoff_name'] : $booking['outside_dropoff'];
                $zone_dropoff[] = !empty($booking['zoned_name']) ? ' (' . $booking['zoned_name'] . ')' : '';
                $bp_note[] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
                $product_name[] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $island_id[] = !empty($booking['island_id']) ? $booking['island_id'] : '';

                $arr_bo[$booking['id']]['id'] = !empty($booking['id']) ? $booking['id'] : 0;
                $arr_bo[$booking['id']]['status'] = !empty($booking['booksta_id']) ? $booking['booksta_id'] : 0;
                $arr_bo[$booking['id']]['status_name'] = !empty($booking['booksta_name']) ? '<b class="text-danger">(' . $booking['booksta_name'] . ')</b>' : '';
                $arr_bo[$booking['id']]['travel_date'] = !empty($booking['travel_date']) ? $booking['travel_date'] : '';
                $arr_bo[$booking['id']]['text_date'] = !empty($booking['travel_date']) ? date("d/m/Y", strtotime($booking['travel_date'])) : '';
                $arr_bo[$booking['id']]['cus_name'] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $arr_bo[$booking['id']]['product_name'] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $arr_bo[$booking['id']]['voucher_no'] = !empty($booking['voucher_no']) ? $booking['voucher_no'] : $booking['book_full'];
                $arr_bo[$booking['id']]['discount'] = !empty($booking['discount']) ? $booking['discount'] : '-';
                $arr_bo[$booking['id']]['cot'] = !empty($booking['total_paid']) ? $booking['total_paid'] : '-';
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

                $arr_rates[$booking['id']]['id'][] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
                $arr_rates[$booking['id']]['customer'][] = !empty($booking['category_cus']) ? $booking['category_cus'] : 0;
                $arr_rates[$booking['id']]['category_name'][] = !empty($booking['category_name']) ? $booking['category_name'] : 0;
                $arr_rates[$booking['id']]['adult'][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $arr_rates[$booking['id']]['child'][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $arr_rates[$booking['id']]['infant'][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $arr_rates[$booking['id']]['foc'][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                $arr_rates[$booking['id']]['rate_adult'][] = !empty($booking['rate_adult']) && $booking['bpr_adult'] > 0 ? $booking['rate_adult'] : '-';
                $arr_rates[$booking['id']]['rate_child'][] = !empty($booking['rate_child']) && $booking['bpr_child'] > 0 ? $booking['rate_child'] : '-';
                $arr_rates[$booking['id']]['total'][] = ($booking['booktye_id'] > 0) ? ($booking['booktye_id'] == 1) ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_private'] : $booking['rate_total'];
            }
            # --- get value booking --- #
            if (in_array($booking['bec_id'], $first_extar) == false && !empty($booking['bec_id'])) {
                $first_extar[] = $booking['bec_id'];

                $bec_id[$booking['id']][] = !empty($booking['bec_id']) ? $booking['bec_id'] : 0;
                $extra_id[$booking['id']][] = !empty($booking['extra_id']) ? $booking['extra_id'] : 0;
                $extra_name[$booking['id']][] = !empty($booking['extra_name']) ? $booking['extra_name'] : '';
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
                $bec_extar_unit[$booking['id']][] = $booking['bec_type'] > 0 ? $booking['bec_type'] == 1 ? ($booking['bec_adult'] + $booking['bec_child'] + $booking['bec_infant']) . ' คน' : $booking['bec_privates'] . ' ' . $booking['extra_unit'] : '';
                $bec_name[$booking['id']][] = !empty($booking['extra_id']) ? $booking['extra_name'] : $booking['bec_name'];

                $arr_extar[$booking['id']]['id'][] = !empty($booking['bec_id']) ? $booking['bec_id'] : 0;
                $arr_extar[$booking['id']]['name'][] = !empty($booking['extra_id']) ? $booking['extra_name'] : $booking['bec_name'];
                $arr_extar[$booking['id']]['adult'][] = !empty($booking['bec_adult']) ? $booking['bec_adult'] : $booking['bec_privates'];
                $arr_extar[$booking['id']]['child'][] = !empty($booking['bec_child']) ? $booking['bec_child'] : '-';
                $arr_extar[$booking['id']]['rate_adult'][] = !empty($booking['bec_rate_adult']) && $booking['bec_adult'] > 0 ? $booking['bec_rate_adult'] : '-';
                $arr_extar[$booking['id']]['rate_child'][] = !empty($booking['bec_rate_child']) && $booking['bec_child'] > 0 ? $booking['bec_rate_child'] : '-';
                $arr_extar[$booking['id']]['privates'][] = !empty($booking['bec_privates']) ? $booking['bec_privates'] : '-';
                $arr_extar[$booking['id']]['rate_private'][] = !empty($booking['bec_rate_private']) && $booking['bec_privates'] > 0 ? $booking['bec_rate_private'] : '-';
                $arr_extar[$booking['id']]['total'][] = $booking['bec_type'] == 1 ? ($booking['bec_adult'] * $booking['bec_rate_adult']) + ($booking['bec_child'] * $booking['bec_rate_child']) : ($booking['bec_privates'] * $booking['bec_rate_private']);
            }
        }
    }
?>
    <div class="modal-header">
        <h4 class="modal-title"><span class="text-success"><?php echo $agent_name[0]; ?></span> (<?php echo !empty(substr($travel_date, 14, 24)) ? date('j F Y', strtotime(substr($travel_date, 0, 10))) . ' - ' . date('j F Y', strtotime(substr($travel_date, 14, 24))) : date('j F Y', strtotime($travel_date)); ?>)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" id="order-agent-image-table" style="background-color: #fff;">

        <div class="text-center mt-1 mb-1">
            <h4>
                <div class="badge badge-pill badge-light-warning">
                    <b class="text-danger"><?php echo $agent_name[0]; ?></b> <span class="text-danger">(<?php echo !empty(substr($travel_date, 14, 24)) ? date('j F Y', strtotime(substr($travel_date, 0, 10))) . ' - ' . date('j F Y', strtotime(substr($travel_date, 14, 24))) : date('j F Y', strtotime($travel_date)); ?>)</span>
                </div>
            </h4>
        </div>

        <input type="hidden" id="agent_value" name="agent_value" value="<?php echo $comp_id[0]; ?>"
            data-name="<?php echo $agent_name[0]; ?>"
            data-license="<?php echo $agent_license[0]; ?>"
            data-telephone="<?php echo $agent_telephone[0]; ?>"
            data-address="<?php echo $agent_address[0]; ?>">
        <textarea id="array_booking" hidden><?php echo !empty($arr_bo) ? json_encode($arr_bo, true) : ''; ?></textarea>
        <textarea id="array_rates" hidden><?php echo !empty($arr_rates) ? json_encode($arr_rates, true) : ''; ?></textarea>
        <textarea id="array_extar" hidden><?php echo !empty($arr_extar) ? json_encode($arr_extar, true) : ''; ?></textarea>

        <table class="table table-striped text-uppercase table-vouchure-t2">
            <thead class="bg-light">
                <tr>
                    <th width="1%">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input dt-checkboxes" type="checkbox" id="checkbo_all" name="checkbo_all" onclick="checkbox('booking');">
                            <label class="custom-control-label" for="checkbo_all"></label>
                        </div>
                    </th>
                    <th width="4%">Status</th>
                    <th width="14%">โปรแกรม</th>
                    <th width="15%">ชื่อลูกค้า</th>
                    <th width="5%">V/C</th>
                    <th width="15%">โรงแรม</th>
                    <th width="5%">ห้อง</th>
                    <th class="text-center" width="1%">A</th>
                    <th class="text-center" width="1%">C</th>
                    <th class="text-center" width="1%">Inf</th>
                    <th class="text-center" width="1%">FOC</th>
                    <th width="5%">COT</th>
                    <th width="7%">AMOUNT</th>
                    <th width="8%">Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_tourist = 0;
                $total_adult = 0;
                $total_child = 0;
                $total_infant = 0;
                $total_foc = 0;
                if (!empty($bo_id)) {
                    $total = 0;
                    for ($i = 0; $i < count($bo_id); $i++) {
                        $id = $bo_id[$i];
                        $total_tourist = $total_tourist + array_sum($adult[$id]) + array_sum($child[$id]) + array_sum($infant[$id]) + array_sum($foc[$id]);
                        $total_adult = $total_adult + array_sum($adult[$id]);
                        $total_child = $total_child + array_sum($child[$id]);
                        $total_infant = $total_infant + array_sum($infant[$id]);
                        $total_foc = $total_foc + array_sum($foc[$id]);
                        # -- calculator booking -- #
                        if (!empty($arr_rates[$id]['total'])) {
                            $total = !empty($cot[$i]) ? array_sum($arr_rates[$id]['total']) - $cot[$i] : array_sum($arr_rates[$id]['total']); // booking
                            $total = !empty($arr_extar[$id]['total']) ? $total + array_sum($arr_extar[$id]['total']) : $total; // extar charge
                        }
                ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input dt-checkboxes checkbox-bookings" type="checkbox" id="checkbox<?php echo $bo_id[$i]; ?>" name="bo_id[]"
                                        value="<?php echo $bo_id[$i]; ?>"
                                        data-color="<?php echo $color[$i]; ?>"
                                        data-darken="<?php echo $darken[$i]; ?>"
                                        data-island="<?php echo $island_id[$i]; ?>">
                                    <label class="custom-control-label" for="checkbox<?php echo $bo_id[$i]; ?>"></label>
                                </div>
                            </td>
                            <td><?php echo $status_name[$i]; ?></td>
                            <td><?php echo $product_name[$i];
                                if (!empty($category_name[$id])) {
                                    echo ' (';
                                    for ($c = 0; $c < count($category_name[$id]); $c++) {
                                        echo $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                                    }
                                }
                                echo ')'; ?></td>
                            <td><?php echo $cus_name[$i]; ?></td>
                            <td><?php echo !empty($voucher_no[$i]) ? $voucher_no[$i] : $book_full[$i]; ?></td>
                            <td style="padding: 5px;">
                                <?php if ($pickup_type[$i] == 1) {
                                    echo (!empty($hotel_pickup[$i])) ? '<b>Pickup : </b>' . $hotel_pickup[$i] . $zone_pickup[$i] : '';
                                    echo (!empty($hotel_dropoff[$i])) ? '</br><b>Dropoff : </b>' . $hotel_dropoff[$i] . $zone_dropoff[$i] : '';
                                } else {
                                    echo 'เดินทางมาเอง';
                                } ?>
                            </td>
                            <td><?php echo $room_no[$i]; ?></td>
                            <td class="text-center"><?php echo array_sum($adult[$id]); ?></td>
                            <td class="text-center"><?php echo array_sum($child[$id]); ?></td>
                            <td class="text-center"><?php echo array_sum($infant[$id]); ?></td>
                            <td class="text-center"><?php echo array_sum($foc[$id]); ?></td>
                            <td class="text-nowrap"><b class="text-danger"><?php echo !empty($cot[$i]) ? number_format($cot[$i]) : ''; ?></b></td>
                            <td class="text-center"><?php echo number_format($total, 2);  ?></td>
                            <td><b class="text-info">
                                    <?php if (!empty($bec_id[$bo_id[$i]])) {
                                        for ($e = 0; $e < count($bec_name[$bo_id[$i]]); $e++) {
                                            echo $bec_name[$bo_id[$i]][$e] . ' : ';
                                            if ($bec_type[$bo_id[$i]][$e] == 1) {
                                                echo 'A ' . $bec_adult[$bo_id[$i]][$e] . ' X ' . $bec_rate_adult[$bo_id[$i]][$e];
                                                echo !empty($bec_child[$bo_id[$i]][$e]) ? ' C ' . $bec_child[$bo_id[$i]][$e] . ' X ' . $bec_rate_child[$bo_id[$i]][$e] : '';
                                            } elseif ($bec_type[$bo_id[$i]][$e] == 2) {
                                                echo $bec_privates[$bo_id[$i]][$e] . ' X ' . $bec_rate_total[$bo_id[$i]][$e] . ' ';
                                            }
                                        }
                                    }
                                    echo !empty($bp_note[$i]) ? ' / ' . $bp_note[$i] : ''; ?>
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
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-dismiss="modal" data-toggle="modal" data-target="#modal-invoice" onclick="modal_invoice();">Submit</button>
    </div>
<?php
} else {
    echo false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$orderObj = new Order();
$today = date("Y-m-d");

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $search_period = $_POST['search_period'] != "" ? $_POST['search_period'] : 'all';
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 'all';
    $search_product = $_POST['search_product'] != "" ? $_POST['search_product'] : 'all';
    $date_travel_form = $_POST['date_travel_form'] != "" ? $_POST['date_travel_form'] : '0000-00-00';
    // $date_travel_to = $_POST['date_travel_to'] != "" ? $_POST['date_travel_to'] : '0000-00-00';

    $first_agent = array();
    $first_bo = array();
    $first_btr = array();
    $first_ext = array();
    $first_pay = array();
    $first_bomanage = array();
    # --- get data --- #
    $orders = $orderObj->showlistorderagent($search_period, $search_agent, $search_product, $date_travel_form);
    # --- Check products --- #
    if (!empty($orders)) {
        foreach ($orders as $order) {
            if (in_array($order['id'], $first_bo) == false) {
                $first_bo[] = $order['id'];
                # --- Booking --- #
                $bo_id[$order['comp_id']][] = !empty($order['id']) ? $order['id'] : 0;
                $bo_type[$order['comp_id']][] = !empty($order['booktye_id']) ? $order['booktye_id'] : 0;
                $voucher[$order['comp_id']][] = !empty($order['voucher_no_agent']) ? $order['voucher_no_agent'] : '';
                $book_full[$order['comp_id']][] = !empty($order['book_full']) ? $order['book_full'] : '';
                $travel_date[$order['comp_id']][] = !empty(!empty($order['travel_date'])) ? $order['travel_date'] : '0000-00-00';
                $product_name[$order['comp_id']][] = !empty(!empty($order['product_name'])) ? $order['product_name'] : '';
                $cus_name[$order['comp_id']][] = !empty($order['cus_name']) ? $order['cus_name'] : 'ไม่ได้ระบุ';
                $sender[$order['comp_id']][] = !empty($order['sender']) ? $order['sender'] : 'ไม่ได้ระบุ';
                $adult[$order['comp_id']][] = !empty($order['bpr_adult']) ? $order['bpr_adult'] : '0';
                $child[$order['comp_id']][] = !empty($order['bpr_child']) ? $order['bpr_child'] : '0';
                $infant[$order['comp_id']][] = !empty($order['bpr_infant']) ? $order['bpr_infant'] : '0';
                $foc[$order['comp_id']][] = !empty($order['bpr_foc']) ? $order['bpr_foc'] : '0';
                $rate_adult[$order['comp_id']][] = !empty($order['rate_adult']) ? $order['rate_adult'] : '0';
                $rate_child[$order['comp_id']][] = !empty($order['rate_child']) ? $order['rate_child'] : '0';
                $rate_infant[$order['comp_id']][] = !empty($order['rate_infant']) ? $order['rate_infant'] : '0';
                $rate_total[$order['comp_id']][] = !empty($order['rate_total']) ? $order['rate_total'] : '0';
                $payment_id[$order['comp_id']][] = !empty($order['bopay_id']) ? $order['bopay_id'] : '0';
                $payment_paid[$order['comp_id']][] = !empty($order['total_paid']) ? $order['total_paid'] : '0';
                $payment_name[$order['comp_id']][] = !empty($order['bopay_name']) ? $order['bopay_id'] == 4 || $order['bopay_id'] == 5 ? $order['bopay_name'] . ' (' . number_format($order['total_paid']) . ')' : $order['bopay_name'] : 'ไม่ได้ระบุ';
                // $payment_name[$order['comp_id']][] = $order['bopay_name'];
                $payment_name_class[$order['comp_id']][] = !empty($order['bopay_name_class']) ? $order['bopay_name_class'] : '';
                $bp_note[$order['comp_id']][] = !empty($order['bp_note']) ? $order['bp_note'] : '';
                # --- Transfer --- #
                $transfer_type[$order['comp_id']][] = !empty($order['transfer_type']) && $order['transfer_type'] == 2 ? 'Private' : 'Join';
                $pickup_name[$order['comp_id']][] = !empty($order['pickup_name']) ? ' (' . $order['pickup_name'] . ')' : '';
                $hotel_pickup[$order['comp_id']][] = !empty($order['hotel_pickup_id']) ? !empty($order['hotel_pickup_id']) ? $order['hotel_pickup_name'] : 'ไม่ได้ระบุ' : $order['hotel_pickup'];
                $room_no[$order['comp_id']][] = !empty($order['room_no']) ? $order['room_no'] : 'ไม่ได้ระบุ';
                $start_pickup[$order['comp_id']][] = !empty($order['start_pickup']) ? date('H:i', strtotime($order['start_pickup'])) : '';
                $end_pickup[$order['comp_id']][] = !empty($order['end_pickup']) ? date('H:i', strtotime($order['end_pickup'])) : '';
                $dropoff_name[$order['comp_id']][] = !empty($order['dropoff_name']) ? ' (' . $order['dropoff_name'] . ')' : '';
                $order_dropoff[$order['comp_id']][] = !empty($order['dropoff_name']) ? $order['dropoff_name'] : 'ไม่ได้ระบุ';
                $hotel_dropoff[$order['comp_id']][] = !empty($order['hotel_dropoff_id']) ? !empty($order['hotel_dropoff_id']) ? $order['hotel_dropoff_name'] : 'ไม่ได้ระบุ' : $order['hotel_dropoff'];
                $bt_adult[$order['comp_id']][] = !empty($order['bt_adult']) ? $order['bt_adult'] : '0';
                $bt_child[$order['comp_id']][] = !empty($order['bt_child']) ? $order['bt_child'] : '0';
                $bt_infant[$order['comp_id']][] = !empty($order['bt_infant']) ? $order['bt_infant'] : '0';
                $btr_rate_adult[$order['comp_id']][] = !empty($order['btr_rate_adult']) ? $order['btr_rate_adult'] : '0';
                $btr_rate_child[$order['comp_id']][] = !empty($order['btr_rate_child']) ? $order['btr_rate_child'] : '0';
                $btr_rate_infant[$order['comp_id']][] = !empty($order['btr_rate_infant']) ? $order['btr_rate_infant'] : '0';
                $bt_note[$order['comp_id']][] = !empty($order['bt_note']) ? $order['bt_note'] : '';
                $car_name[$order['comp_id']][] = !empty($order['car_name']) ? $order['car_name'] : '';
                $boat_name[$order['comp_id']][] = !empty($order['boat_name']) ? $order['boat_name'] : '';
                # --- SUMMARY --- #
                $discount[$order['comp_id']][] = !empty($order['discount']) ? $order['discount'] : 0;
                # --- Extar --- #
                $bec_id[$order['comp_id']][] = !empty($order['bec_id']) ? $order['bec_id'] : 0;
                $bec_name[$order['comp_id']][] = !empty($order['bec_name']) ? $order['bec_name'] : '';
                $bec_total[$order['comp_id']][] = !empty($order['bec_total']) ? $order['bec_total'] : 0;

                $pickup_type[$order['comp_id']][] = !empty($order['pickup_type']) ? $order['pickup_type'] : 0;
            }

            if ((in_array($order['btr_id'], $first_btr) == false) && ($order['transfer_type'] == 2) && !empty($order['btr_id'])) {
                $first_btr[] = $order['btr_id'];
                $btr_id[$order['id']][] = !empty($order['btr_id']) ? $order['btr_id'] : 0;
                $cars_category[$order['id']][] = !empty($order['cars_category']) ? $order['cars_category'] : 0;
                $car_name[$order['id']][] = !empty($order['carc_name']) ? $order['carc_name'] : 0;
                $rate_private[$order['id']][] = !empty($order['rate_private']) ? $order['rate_private'] : 0;
            }

            if (in_array($order['comp_id'], $first_agent) == false) {
                $first_agent[] = $order['comp_id'];
                $agent_id[] = !empty($order['comp_id']) ? $order['comp_id'] : '';
                $agent_name[] = !empty($order['comp_name']) ? $order['comp_name'] : '';
            }

            if ((in_array($order['bec_id'], $first_ext) == false) && !empty($order['bec_id'])) {
                $first_ext[] = $order['bec_id'];
                $extar['bec_id'][$order['id']][] = !empty($order['bec_id']) ? $order['bec_id'] : 0;
                $extar['bec_name'][$order['id']][] = !empty($order['bec_name']) ? $order['bec_name'] : '';
                $extar['extra_id'][$order['id']][] = !empty($order['extra_id']) ? $order['extra_id'] : 0;
                $extar['extra_name'][$order['id']][] = !empty($order['extra_name']) ? $order['extra_name'] : '';
                $extar['bec_type'][$order['id']][] = !empty($order['bec_type']) ? $order['bec_type'] : 0;
                $extar['bec_adult'][$order['id']][] = !empty($order['bec_adult']) ? $order['bec_adult'] : 0;
                $extar['bec_child'][$order['id']][] = !empty($order['bec_child']) ? $order['bec_child'] : 0;
                $extar['bec_infant'][$order['id']][] = !empty($order['bec_infant']) ? $order['bec_infant'] : 0;
                $extar['bec_privates'][$order['id']][] = !empty($order['bec_privates']) ? $order['bec_privates'] : 0;
                $extar['bec_rate_adult'][$order['id']][] = !empty($order['bec_rate_adult']) ? $order['bec_rate_adult'] : 0;
                $extar['bec_rate_child'][$order['id']][] = !empty($order['bec_rate_child']) ? $order['bec_rate_child'] : 0;
                $extar['bec_rate_infant'][$order['id']][] = !empty($order['bec_rate_infant']) ? $order['bec_rate_infant'] : 0;
                $extar['bec_rate_private'][$order['id']][] = !empty($order['bec_rate_private']) ? $order['bec_rate_private'] : 0;
                // $extar['bec_rate_total'][$order['id']][] = $order['bec_type'] > 0 ? $order['bec_type'] == 1 ? (($order['bec_adult'] * $order['bec_rate_adult']) + ($order['bec_child'] * $order['bec_rate_child']) + ($order['bec_infant'] * $order['bec_rate_infant'])) : ($order['bec_privates'] * $order['bec_rate_private']) : 0;
                $extar['bec_rate_total'][$order['id']][] = $orderObj->sumbectotal($order['id'])['sum_rate_total'];
            }

            if ((in_array($order['bopa_id'], $first_pay) == false) && !empty($order['bopa_id'])) {
                # --- in array get value booking payment --- #
                $first_pay[] = $order['bopa_id'];
                $payments['bopa_id'][$order['id']][] = !empty($order['bopa_id']) ? $order['bopa_id'] : 0;
                $payments['bopay_id'][$order['id']][] = !empty($order['bopay_id']) ? $order['bopay_id'] : 0;
                $payments['bopay_name'][$order['id']][] = !empty($order['bopay_name']) ? $order['bopay_name'] : '';
                $payments['bopay_class'][$order['id']][] = !empty($order['bopay_name_class']) ? $order['bopay_name_class'] : '';
                $payments['total_paid'][$order['id']][] = !empty($order['total_paid']) ? $order['total_paid'] : 0;
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
                $managet['pickup'][$order['id']][] = !empty($order['pickup']) ? $order['pickup'] : 0;
                $managet['dropoff'][$order['id']][] = !empty($order['dropoff']) ? $order['dropoff'] : 0;
            }
        }
        $name_img = 'Re Confirm Agent ' . $order['comp_name'];
?>
        <div class="content-header">
            <div class="pl-1">
                <a href="./?pages=order-agent/print&action=print&search_period=<?php echo $search_period; ?>&search_agent=<?php echo $search_agent; ?>&search_product=<?php echo $search_product; ?>&date_travel_form=<?php echo $date_travel_form; ?>" target="_blank" class="btn btn-info">Print</a>
                <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="download_image();">Image</button></a>
                <a href="javascript:void(0);" class="btn btn-info disabled" hidden>Download as PDF</a>
            </div>
        </div>
        <hr class="pb-0 pt-0">
        <div id="order-agent-image-table" style="background-color: #FFFFFF;">
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
            <div class="card-body pb-50">
                <div class="text-center card-text">
                    <h4 class="font-weight-bolder">RE CONFIRM AGENT</h4>
                </div>
            </div>
            <?php
            $count_agent = !empty($agent_id) ? count($agent_id) : 0;
            for ($i = 0; $i < $count_agent; $i++) {
            ?>
                <div class="pb-1">
                    <div class="text-center card-text">
                        <div class="badge badge-pill badge-light-warning">
                            <h5 class="m-0 pl-1 pr-1 text-warning"><?php echo $agent_name[$i]; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" id="order-job-search-table">
                    <table class="table table-striped text-uppercase table-vouchure-t2">
                        <thead class="bg-light">
                            <tr>
                                <th>Hotel</th>
                                <th>Pickup Time</th>
                                <th>Programe</th>
                                <th>Travel</th>
                                <th>Client</th>
                                <th class="text-center">A</th>
                                <th class="text-center">C</th>
                                <th class="text-center">Inf</th>
                                <th class="text-center">FOC</th>
                                <th>SENDER</th>
                                <th>V/C</th>
                                <th>COT</th>
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
                            $count_bo = !empty($bo_id[$agent_id[$i]]) ? count($bo_id[$agent_id[$i]]) : 0;
                            for ($a = 0; $a < $count_bo; $a++) {
                                $id = $bo_id[$agent_id[$i]][$a];
                                $total_tourist = $total_tourist + $adult[$agent_id[$i]][$a] + $child[$agent_id[$i]][$a] + $infant[$agent_id[$i]][$a] + $foc[$agent_id[$i]][$a];
                                $total_adult = $total_adult + $adult[$agent_id[$i]][$a];
                                $total_child = $total_child + $child[$agent_id[$i]][$a];
                                $total_infant = $total_infant + $infant[$agent_id[$i]][$a];
                                $total_foc = $total_foc + $foc[$agent_id[$i]][$a];
                            ?>
                                <tr>
                                    <td style="padding: 5px;">
                                        <?php if ($pickup_type[$agent_id[$i]][$a] == 1) {
                                            echo (!empty($hotel_pickup[$agent_id[$i]][$a])) ? '<b>Pickup : </b>' . $hotel_pickup[$agent_id[$i]][$a] . $pickup_name[$agent_id[$i]][$a] : '';
                                            echo (!empty($hotel_dropoff[$agent_id[$i]][$a])) ? '</br><b>Dropoff : </b>' . $hotel_dropoff[$agent_id[$i]][$a] . $dropoff_name[$agent_id[$i]][$a] : '';
                                        } else {
                                            echo 'เดินทางมาเอง';
                                        } ?>
                                    </td>
                                    <td><?php echo $start_pickup[$agent_id[$i]][$a]; ?></td>
                                    <td><?php echo $product_name[$agent_id[$i]][$a]; ?></td>
                                    <td><?php echo date('j F Y', strtotime($travel_date[$agent_id[$i]][$a])); ?></td>
                                    <td><?php echo $cus_name[$agent_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $adult[$agent_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $child[$agent_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $infant[$agent_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $foc[$agent_id[$i]][$a]; ?></td>
                                    <td><?php echo $sender[$agent_id[$i]][$a]; ?></td>
                                    <td><?php echo $voucher[$agent_id[$i]][$a]; ?></td>
                                    <td><?php echo !empty($cot[$bo_id[$agent_id[$i]][$a]]) ? number_format(array_sum($cot[$bo_id[$agent_id[$i]][$a]])) : 0; ?></td>
                                    <td><?php echo $bp_note[$agent_id[$i]][$a]; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="text-center mt-1 pb-2">
                        <h4>
                            <div class="badge badge-pill badge-light-warning">
                                <b class="text-danger">TOTAL <?php echo $total_tourist; ?></b> | <?php echo $total_adult; ?> <?php echo $total_child; ?> <?php echo $total_infant; ?> <?php echo $total_foc; ?>
                            </div>
                        </h4>
                    </div>

                    </br>
                </div>
            <?php } ?>
        </div>
        <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
    <?php } ?>
<?php
} else {
    echo FALSE;
}

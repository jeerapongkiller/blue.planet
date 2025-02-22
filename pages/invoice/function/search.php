<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Invoice.php';

$invObj = new Invoice();
$today = date("Y-m-d");
$times = date("H:i:s");

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $search_period = !empty($_POST['search_period']) ? $_POST['search_period'] : 'custom';
    $search_travel = !empty($_POST['search_travel']) ? $_POST['search_travel'] : '0000-00-00';
    $search_travel_form = !empty(substr($_POST['search_travel'], 0, 10)) ? substr($_POST['search_travel'], 0, 10) : '0000-00-00';
    $search_travel_to = !empty(substr($_POST['search_travel'], 14, 24)) ? substr($_POST['search_travel'], 14, 24) : $search_travel_form;
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 0;

    $total = 0;
    $first_book = array();
    $first_btr = array();
    $first_pay = array();
    $first_ext = array();
    $bookings = $invObj->showlistbookings($search_travel != '0000-00-00' ? $search_period : 'all', $search_travel_form, $search_travel_to, $search_agent);
    # --- Check products --- #
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            if (empty($booking['inv_id']) || (!empty($booking['inv_id']) && $booking['inv_deleted'] == 1)) {
                # --- get value booking transfer rate !transfer_type == 2! --- #
                if ((in_array($booking['btr_id'], $first_btr) == false) && ($booking['transfer_type'] == 2) && !empty($booking['btr_id'])) {
                    $first_btr[] = $booking['btr_id'];
                    $array_transfer[$booking['id']]['cars_category'][] = !empty($booking['cars_category']) ? $booking['cars_category'] : 0;
                    $array_transfer[$booking['id']]['rate_private'][] = !empty($booking['rate_private']) ? $booking['rate_private'] : 0;
                }

                if (in_array($booking['id'], $first_book) == false) {
                    $first_book[] = $booking['id'];
                    # --- get value booking --- #
                    $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
                    $book_full[] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                    $discount[] = !empty($booking['discount']) ? $booking['discount'] : 0;
                    $voucher_no_agent[] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
                    $book_type_name[] = !empty(!empty($booking['booking_type_id'])) ? $booking['booktye_name'] : '';
                    $book_status_name[] = !empty(!empty($booking['booksta_name'])) ? $booking['booksta_name'] : 0;
                    $payment_name[] = !empty(!empty($booking['bookpay_name'])) ? $booking['bookpay_name'] : 0;
                    $bo_type[] = !empty(!empty($booking['booking_type_id'])) ? $booking['booking_type_id'] : 0;
                    $status[] = '<span class="badge badge-pill ' . $booking['booksta_class'] . ' text-capitalized"> ' . $booking['booksta_name'] . ' </span>';
                    # --- get value booking products --- #
                    $bp_id[] = !empty($booking['bp_id']) ? $booking['bp_id'] : 0;
                    $product_name[] = !empty($booking['product_name']) ? $booking['product_name'] : 0;
                    $travel_date[] = !empty($booking['travel_date']) ? $booking['travel_date'] : '0000-00-00';
                    $adult[] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                    $child[] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                    $infant[] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                    $private_type[] = !empty($booking['bp_private_type']) ? $booking['bp_private_type'] : 0;
                    # --- get value booking product rate --- #
                    $bpr_id[] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
                    $rate_adult[] = !empty($booking['rate_adult']) ? $booking['rate_adult'] : 0;
                    $rate_child[] = !empty($booking['rate_child']) ? $booking['rate_child'] : 0;
                    $rate_infant[] = !empty($booking['rate_infant']) ? $booking['rate_infant'] : 0;
                    $rate_total[] = !empty($booking['rate_total']) ? $booking['rate_total'] : 0;
                    # --- get value booking transfer --- #
                    $bt_id[] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                    $bt_adult[] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
                    $bt_child[] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
                    $bt_infant[] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
                    $start_pickup[] = !empty($booking['start_pickup']) ? $booking['start_pickup'] : '00:00';
                    $end_pickup[] = !empty($booking['end_pickup']) ? $booking['end_pickup'] : '00:00';
                    $hotel_pickup[] = !empty($booking['hotel_pickup_id']) ? $booking['hotel_pickup_name'] : $booking['hotel_pickup'];
                    $hotel_dropoff[] = !empty($booking['hotel_dropoff_id']) ? $booking['hotel_dropoff_name'] : $booking['hotel_dropoff'];
                    $room_no[] = !empty($booking['room_no']) ? $booking['room_no'] : '';
                    $transfer_type[] = !empty($booking['transfer_type']) ? $booking['transfer_type'] : 0;
                    $pickup_type[] = !empty($booking['pickup_type']) ? $booking['pickup_type'] : 0;
                    $pickup_id[] = !empty($booking['pickup_id']) ? $booking['pickup_id'] : 0;
                    $pickup_name[] = !empty($booking['pickup_name']) ? $booking['pickup_name'] : '';
                    $array_transfer[$booking['id']]['bt_adult'] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
                    $array_transfer[$booking['id']]['bt_child'] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
                    $array_transfer[$booking['id']]['bt_infant'] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
                    $array_transfer[$booking['id']]['btr_rate_adult'] = !empty($booking['btr_rate_adult']) && $booking['transfer_type'] == 1 ? $booking['btr_rate_adult'] : 0;
                    $array_transfer[$booking['id']]['btr_rate_child'] = !empty($booking['btr_rate_child']) && $booking['transfer_type'] == 1 ? $booking['btr_rate_child'] : 0;
                    $array_transfer[$booking['id']]['btr_rate_infant'] = !empty($booking['btr_rate_infant']) && $booking['transfer_type'] == 1 ? $booking['btr_rate_infant'] : 0;
                    # --- get value booking transfer rate --- #
                    $btr_id[] = !empty($booking['btr_id']) ? $booking['btr_id'] : 0;
                    $btr_rate_adult[] = !empty($booking['btr_rate_adult']) ? $booking['btr_rate_adult'] : 0;
                    $btr_rate_child[] = !empty($booking['btr_rate_child']) ? $booking['btr_rate_child'] : 0;
                    $btr_rate_infant[] = !empty($booking['btr_rate_infant']) ? $booking['btr_rate_infant'] : 0;
                    # --- get value customers --- #
                    $cus_id[] = !empty($booking['cus_id']) && $booking['cus_head'] == 1 ? $booking['cus_id'] : 0;
                    $cus_name[] = !empty($booking['cus_name']) && $booking['cus_head'] == 1 ? $booking['cus_name'] : '';
                    $cus_whatsapp['whatsapp'][] = !empty($booking['whatsapp']) && $booking['cus_head'] == 1 ? $booking['whatsapp'] : '';
                }
                # --- get value booking extra chang --- #
                if ((in_array($booking['bec_id'], $first_ext) == false) && !empty($booking['bec_id'])) {
                    $first_ext[] = $booking['bec_id'];
                    $bec_id[$booking['id']][] = !empty($booking['bec_id']) ? $booking['bec_id'] : 0;
                    $extra_name[$booking['id']][] = !empty($booking['extra_name']) ? $booking['extra_name'] : '';
                    $bec_name[$booking['id']][] = !empty($booking['bec_name']) ? $booking['bec_name'] : '';
                    $bec_type[$booking['id']][] = !empty($booking['bec_type']) ? $booking['bec_type'] : 0;
                    $bec_adult[$booking['id']][] = !empty($booking['bec_adult']) ? $booking['bec_adult'] : 0;
                    $bec_child[$booking['id']][] = !empty($booking['bec_child']) ? $booking['bec_child'] : 0;
                    $bec_infant[$booking['id']][] = !empty($booking['bec_infant']) ? $booking['bec_infant'] : 0;
                    $bec_privates[$booking['id']][] = !empty($booking['bec_privates']) ? $booking['bec_privates'] : 0;
                    $bec_rate_adult[$booking['id']][] = !empty($booking['bec_rate_adult']) ? $booking['bec_rate_adult'] : 0;
                    $bec_rate_child[$booking['id']][] = !empty($booking['bec_rate_child']) ? $booking['bec_rate_child'] : 0;
                    $bec_rate_infant[$booking['id']][] = !empty($booking['bec_rate_infant']) ? $booking['bec_rate_infant'] : 0;
                    $bec_rate_private[$booking['id']][] = !empty($booking['bec_rate_private']) ? $booking['bec_rate_private'] : 0;
                    # --- get value array booking extra charge --- #
                    $array_extra[$booking['id']]['bec_id'][] = !empty($booking['bec_id']) ? $booking['bec_id'] : '';
                    $array_extra[$booking['id']]['extra_name'][] = !empty($booking['extra_name']) ? $booking['extra_name'] : '';
                    $array_extra[$booking['id']]['bec_name'][] = !empty($booking['bec_name']) ? $booking['bec_name'] : '';
                    $array_extra[$booking['id']]['bec_type'][] = !empty($booking['bec_type']) ? $booking['bec_type'] : 0;
                    $array_extra[$booking['id']]['bec_adult'][] = !empty($booking['bec_adult']) ? $booking['bec_adult'] : 0;
                    $array_extra[$booking['id']]['bec_child'][] = !empty($booking['bec_child']) ? $booking['bec_child'] : 0;
                    $array_extra[$booking['id']]['bec_infant'][] = !empty($booking['bec_infant']) ? $booking['bec_infant'] : 0;
                    $array_extra[$booking['id']]['bec_privates'][] = !empty($booking['bec_privates']) ? $booking['bec_privates'] : 0;
                    $array_extra[$booking['id']]['bec_rate_adult'][] = !empty($booking['bec_rate_adult']) ? $booking['bec_rate_adult'] : 0;
                    $array_extra[$booking['id']]['bec_rate_child'][] = !empty($booking['bec_rate_child']) ? $booking['bec_rate_child'] : 0;
                    $array_extra[$booking['id']]['bec_rate_infant'][] = !empty($booking['bec_rate_infant']) ? $booking['bec_rate_infant'] : 0;
                    $array_extra[$booking['id']]['bec_rate_private'][] = !empty($booking['bec_rate_private']) ? $booking['bec_rate_private'] : 0;
                }
                # --- get value booking payment --- #
                if ((in_array($booking['bopa_id'], $first_pay) == false) && !empty($booking['bopa_id'])) {
                    $first_pay[] = $booking['bopa_id'];
                    $bopa_id[$booking['id']][] = !empty($booking['bopa_id']) ? $booking['bopa_id'] : 0;
                    $bopae_id[$booking['id']][] = !empty($booking['bopae_id']) ? $booking['bopae_id'] : 0;
                    $bopay_id[$booking['id']] = !empty($booking['bopay_id']) ? $booking['bopay_id'] : 0;
                    $bopay_name[$booking['id']] = !empty($booking['bopay_name']) ? $booking['bopay_name'] : '';
                    $bopay_text[$booking['id']] = $booking['bopay_id'] == 4 || $booking['bopay_id'] == 5 ? $booking['bopay_name'] . ' </br>(' . number_format($booking['total_paid']) . ')' : $booking['bopay_name'];
                    $total_paid[$booking['id']] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
                    $bopay_name_class[$booking['id']] = !empty($booking['bopay_name_class']) ? $booking['bopay_name_class'] : '';
                }
            }
        }
    }
?>
    <table class="booking-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <?php if ($search_agent != 'all' && $search_agent > 0) { ?>
                    <th class="cell-fit"></th>
                <?php } ?>
                <th class="cell-fit">STATUS</th>
                <th class="cell-fit">PAYMENT</th>
                <th>BOKING NO.</th>
                <th>AGENT VOUCHER NO.</th>
                <th>TRAVEL DATE</th>
                <th>PROGRAM</th>
                <th>Booking Type</th>
                <th class="cell-fit">AMOUNT</th>
            </tr>
        </thead>
        <?php if (!empty($bookings)) { ?>
            <tbody>
                <?php for ($i = 0; $i < count($bo_id); $i++) {
                    if (!empty($bopay_id[$bo_id[$i]]) && ($bopay_id[$bo_id[$i]] == 2 || $bopay_id[$bo_id[$i]] == 4 || $bopay_id[$bo_id[$i]] == 5)) {
                        # --- get value total --- #
                        $total = $rate_total[$i];
                        $total = $transfer_type[$i] == 1 ? $total + ($bt_adult[$i] * $btr_rate_adult[$i]) : $total;
                        $total = $transfer_type[$i] == 1 ? $total + ($bt_child[$i] * $btr_rate_child[$i]) : $total;
                        $total = $transfer_type[$i] == 1 ? $total + ($bt_infant[$i] * $btr_rate_infant[$i]) : $total;
                        $total = $transfer_type[$i] == 2 ? $invObj->sumbtrprivate($bt_id[$i])['sum_rate_private'] + $total : $total;
                        if (!empty($bec_id[$bo_id[$i]])) {
                            for ($a = 0; $a < count($bec_id[$bo_id[$i]]); $a++) {
                                $total = $bec_type[$bo_id[$i]][$a] == 1 ? $total + ($bec_adult[$bo_id[$i]][$a] * $bec_rate_adult[$bo_id[$i]][$a]) + ($bec_child[$bo_id[$i]][$a] * $bec_rate_child[$bo_id[$i]][$a]) + ($bec_infant[$bo_id[$i]][$a] * $bec_rate_infant[$bo_id[$i]][$a]) : $total;
                                $total = $bec_type[$bo_id[$i]][$a] == 2 ? $total + ($bec_privates[$bo_id[$i]][$a] * $bec_rate_private[$bo_id[$i]][$a]) : $total;
                            }
                        }
                        $bo_sum = $total;
                        $total = $total - $discount[$i];
                        $total = ($bopay_id[$bo_id[$i]] == 4 || $bopay_id[$bo_id[$i]] == 5) && (!empty($bopae_id[$bo_id[$i]])) ? $total - $total_paid[$bo_id[$i]] : $total;
                        $href = 'href="./?pages=booking/edit&id=' . $bo_id[$i] . '&search_travel=' . $search_travel . '&search_agent=' . $search_agent . '" style="color:#6E6B7B"';
                ?>
                        <tr>
                            <?php if ($search_agent != 'all' && $search_agent > 0) { ?>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input dt-checkboxes" type="checkbox" id="checkbox<?php echo $bo_id[$i]; ?>" name="bo_id[]" value="<?php echo $bo_id[$i]; ?>"
                                            data-bo_type="<?php echo $bo_type[$i]; ?>"
                                            data-bo_type_name="<?php echo $book_type_name[$i]; ?>"
                                            data-voucher="<?php echo $voucher_no_agent[$i]; ?>"
                                            data-payment_id="<?php echo $bopay_id[$bo_id[$i]]; ?>"
                                            data-payment_name="<?php echo $bopay_name[$bo_id[$i]]; ?>"
                                            data-total_paid="<?php echo $total_paid[$bo_id[$i]]; ?>"
                                            data-book_full="<?php echo $book_full[$i]; ?>"
                                            data-programe_name="<?php echo $product_name[$i]; ?>"
                                            data-travel_date="<?php echo date('j F Y', strtotime($travel_date[$i])); ?>"
                                            data-cus_name="<?php echo $cus_name[$i]; ?>"
                                            data-adult="<?php echo $adult[$i]; ?>"
                                            data-child="<?php echo $child[$i]; ?>"
                                            data-infant="<?php echo $infant[$i]; ?>"
                                            data-room_no="<?php echo $room_no[$i]; ?>"
                                            data-hotel_pickup="<?php echo $hotel_pickup[$i]; ?>"
                                            data-pickup_time="<?php echo date("H:i", strtotime($start_pickup[$i])) . ' - ' . date("H:i", strtotime($end_pickup[$i])) . ' น.'; ?>"
                                            data-rate_adult="<?php echo $rate_adult[$i]; ?>"
                                            data-rate_child="<?php echo $rate_child[$i]; ?>"
                                            data-rate_infant="<?php echo $rate_infant[$i]; ?>"
                                            data-rate_total="<?php echo $rate_total[$i]; ?>"
                                            data-discount="<?php echo $discount[$i]; ?>"
                                            data-total="<?php echo $bo_sum; ?>"
                                            data-transfer_type="<?php echo $transfer_type[$i]; ?>"
                                            data-transfer='<?php echo json_encode($array_transfer[$bo_id[$i]]); ?>'
                                            data-extra='<?php echo !empty($array_extra[$bo_id[$i]]) ? json_encode($array_extra[$bo_id[$i]]) : ''; ?>' />
                                        <label class="custom-control-label" for="checkbox<?php echo $bo_id[$i]; ?>"></label>
                                    </div>
                                </td>
                            <?php } ?>
                            <td><a <?php echo $href; ?>><?php echo $status[$i]; ?></a></td>
                            <td><a <?php echo $href; ?>><?php echo '<span class="badge badge-pill ' . $bopay_name_class[$bo_id[$i]] . ' text-capitalized"> ' . $bopay_text[$bo_id[$i]] . ' </span>'; ?></a></td>
                            <td><a <?php echo $href; ?>><?php echo $book_full[$i]; ?></a></td>
                            <td><a <?php echo $href; ?>><?php echo $voucher_no_agent[$i]; ?></a></td>
                            <td><a <?php echo $href; ?>><?php echo date("j F Y", strtotime($travel_date[$i])); ?></a></td>
                            <td><a <?php echo $href; ?>><?php echo $product_name[$i]; ?></a></td>
                            <td><a <?php echo $href; ?>><?php echo $bo_type[$i] == 1 ? 'Join' : 'Private'; ?></a></td>
                            <td class="text-right"><a <?php echo $href; ?>><?php echo number_format($total); ?></a></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $bookings = false;
}

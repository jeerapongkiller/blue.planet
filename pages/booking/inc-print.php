<?php
$id = $_GET['id'];
$bookings = $bookObj->get_data($id);
# --- get value booking --- #
if ($bookings[0]['id'] > 0) {
    $total_sum = 0;
    $total_product = 0;
    $data_send_email = array();
    $bo_id = !empty($bookings[0]['id']) ? $bookings[0]['id'] : 0;
    $book_full = !empty($bookings[0]['book_full']) ? $bookings[0]['book_full'] : '';
    $book_date = !empty(!empty($bookings[0]['booking_date'])) ? $bookings[0]['booking_date'] : '0000-00-00';
    $book_time = !empty(!empty($bookings[0]['booking_time'])) ? $bookings[0]['booking_time'] : '00:00:00';
    $voucher_no_agent = !empty($bookings[0]['voucher_no_agent']) ? $bookings[0]['voucher_no_agent'] : '';
    $discount = !empty($bookings[0]['discount']) ? $bookings[0]['discount'] : 0;
    $booker_id = !empty($bookings[0]['booker_id']) ? $bookings[0]['booker_id'] : 0;
    $booker_name = !empty($bookings[0]['booker_id']) ? $bookings[0]['booker_fname'] . ' ' . $bookings[0]['booker_lname'] : '';
    $sender = !empty($bookings[0]['sender']) ? $bookings[0]['sender'] : '';
    $agent_id = !empty($bookings[0]['company_id']) ? $bookings[0]['company_id'] : 0;
    $agent_name = !empty($bookings[0]['comp_name']) ? $bookings[0]['comp_name'] : '';
    $agent_license = !empty($bookings[0]['tat_license']) ? $bookings[0]['tat_license'] : '';
    $agent_telephone = !empty($bookings[0]['comp_telephone']) ? $bookings[0]['comp_telephone'] : '';
    $agent_address = !empty($bookings[0]['comp_address']) ? $bookings[0]['comp_address'] : '';
    $book_type = !empty(!empty($bookings[0]['booking_type_id'])) ? $bookings[0]['booking_type_id'] : 0;
    $book_type_name = !empty(!empty($bookings[0]['booking_type_id'])) ? $bookings[0]['booktye_name'] : '';
    $book_status = !empty(!empty($bookings[0]['booking_status_id'])) ? $bookings[0]['booking_status_id'] : 0;
    $book_status_name = !empty(!empty($bookings[0]['booksta_name'])) ? $bookings[0]['booksta_name'] : 0;
    $confirm_id = !empty($bookings[0]['confirm_id']) ? $bookings[0]['confirm_id'] : 0;
    $booking_day = date('j F Y', strtotime($bookings[0]['created_at']));
    $created_at = date('j F Y H:i', strtotime($bookings[0]['created_at']));
    $guests_type = $agent_id == 0 ? 'Supplier' : 'Agent';
    # --- get value manage boat and transfer --- #
    $mange_transfer_id = !empty($bookings[0]['bomange_id']) ? $bookings[0]['bomange_id'] : 0;
    $mange_transfer = !empty($bookings[0]['manget_id']) ? $bookings[0]['manget_id'] : 0;
    $mange_boat_id = !empty($bookings[0]['boman_id']) ? $bookings[0]['boman_id'] : 0;
    $mange_boat = !empty($bookings[0]['mange_id']) ? $bookings[0]['mange_id'] : 0;
    # --- get value booking products --- #
    $bp_id = !empty($bookings[0]['bp_id']) ? $bookings[0]['bp_id'] : 0;
    $product_id = !empty($bookings[0]['product_id']) ? $bookings[0]['product_id'] : 0;
    $product_name = !empty($bookings[0]['product_name']) ? $bookings[0]['product_name'] : 0;
    $category_id = !empty($bookings[0]['category_id']) ? $bookings[0]['category_id'] : 0;
    $category_name = !empty($bookings[0]['category_name']) ? $bookings[0]['category_name'] : 0;
    $travel_date = !empty($bookings[0]['travel_date']) ? $bookings[0]['travel_date'] : '0000-00-00';
    $prod_rate_id = !empty($bookings[0]['pror_id']) ? $bookings[0]['pror_id'] : 0;
    $lang_id = !empty($bookings[0]['lang_id']) ? $bookings[0]['lang_id'] : 0;
    $lang_name = !empty($bookings[0]['lang_name']) ? $bookings[0]['lang_name'] : '';
    $bp_note = !empty($bookings[0]['bp_note']) ? $bookings[0]['bp_note'] : '';
    $private_type = !empty($bookings[0]['bp_private_type']) ? $bookings[0]['bp_private_type'] : 0;
    # --- get value booking product rate --- #

    # --- get value booking transfer --- #
    $bt_id = !empty($bookings[0]['bt_id']) ? $bookings[0]['bt_id'] : 0;
    $bt_adult = !empty($bookings[0]['bt_adult']) ? $bookings[0]['bt_adult'] : 0;
    $bt_child = !empty($bookings[0]['bt_child']) ? $bookings[0]['bt_child'] : 0;
    $bt_infant = !empty($bookings[0]['bt_infant']) ? $bookings[0]['bt_infant'] : 0;
    $bt_foc = !empty($bookings[0]['bt_foc']) ? $bookings[0]['bt_foc'] : 0;
    $start_pickup = !empty($bookings[0]['start_pickup']) ? $bookings[0]['start_pickup'] : '00:00:00';
    $end_pickup = !empty($bookings[0]['end_pickup']) ? $bookings[0]['end_pickup'] : '00:00:00';
    $hotel_pickup_id = !empty($bookings[0]['hotel_pickup_id']) ? $bookings[0]['hotel_pickup_id'] : 0;
    $hotel_pickup_name = !empty($bookings[0]['hotel_pickup_name']) ? $bookings[0]['hotel_pickup_name'] : '';
    $hotel_dropoff_id = !empty($bookings[0]['hotel_dropoff_id']) ? $bookings[0]['hotel_dropoff_id'] : 0;
    $hotel_dropoff_name = !empty($bookings[0]['hotel_dropoff_name']) ? $bookings[0]['hotel_dropoff_name'] : '';
    $hotel_pickup_outside = !empty($bookings[0]['hotel_pickup']) ? $bookings[0]['hotel_pickup'] : '';
    $hotel_dropoff_outside = !empty($bookings[0]['hotel_dropoff']) ? $bookings[0]['hotel_dropoff'] : '';
    $room_no = !empty($bookings[0]['room_no']) ? $bookings[0]['room_no'] : '';
    $bt_note = !empty($bookings[0]['bt_note']) ? $bookings[0]['bt_note'] : '';
    $transfer_type = !empty($bookings[0]['transfer_type']) ? $bookings[0]['transfer_type'] : 0;
    $pickup_type = !empty($bookings[0]['pickup_type']) ? $bookings[0]['pickup_type'] : 0;
    $pickup_id = !empty($bookings[0]['pickup_id']) ? $bookings[0]['pickup_id'] : 0;
    $pickup_name = !empty($bookings[0]['pickup_name']) ? $bookings[0]['pickup_name'] : '';
    $dropoff_id = !empty($bookings[0]['dropoff_id']) ? $bookings[0]['dropoff_id'] : 0;
    $dropoff_name = !empty($bookings[0]['dropoff_name']) ? $bookings[0]['dropoff_name'] : '';
    # --- get value booking transfer rate !transfer_type == 1! --- #
    $btr_id = !empty($bookings[0]['btr_id']) ? $bookings[0]['btr_id'] : 0;
    if ($transfer_type == 1) {
        $btr_rate_adult = !empty($bookings[0]['btr_rate_adult']) ? $bookings[0]['btr_rate_adult'] : 0;
        $btr_rate_child = !empty($bookings[0]['btr_rate_child']) ? $bookings[0]['btr_rate_child'] : 0;
        $btr_rate_infant = !empty($bookings[0]['btr_rate_infant']) ? $bookings[0]['btr_rate_infant'] : 0;
        $total_sum = $total_sum + ($bt_adult * $btr_rate_adult) + ($bt_child * $btr_rate_child) + ($bt_infant * $btr_rate_infant);
        $total_product = $total_product + ($bt_adult * $btr_rate_adult) + ($bt_child * $btr_rate_child) + ($bt_infant * $btr_rate_infant);
    } elseif ($transfer_type == 2) {
        $btr_rate_private = !empty($bookings[0]['btr_rate_private']) ? $bookings[0]['btr_rate_private'] : 0;
        $total_sum = $btr_rate_private + $total_sum;
        $total_product = $btr_rate_private + $total_product;
    }
    # --- get value Invoice --- #
    $inv_id = !empty($bookings[0]['inv_id']) ? $bookings[0]['inv_id'] : 0;
    $inv_date = !empty($bookings[0]['inv_date']) ? $bookings[0]['inv_date'] : '0000-00-00';
    $rec_date = !empty($bookings[0]['rec_date']) ? $bookings[0]['rec_date'] : '0000-00-00';
    $withholding = !empty($bookings[0]['withholding']) ? $bookings[0]['withholding'] : 0;
    $branche_id = !empty($bookings[0]['branche_id']) ? $bookings[0]['branche_id'] : 0;
    $vat_id = !empty($bookings[0]['vat_id']) ? $bookings[0]['vat_id'] : 0;
    $currency_id = !empty($bookings[0]['currency_id']) ? $bookings[0]['currency_id'] : 0;
    $inv_bank_account = !empty($bookings[0]['inv_bank_account']) ? $bookings[0]['inv_bank_account'] : '';
    $inv_note = !empty($bookings[0]['inv_note']) ? $bookings[0]['inv_note'] : '';
    $inv_full = !empty($bookings[0]['inv_full']) ? $bookings[0]['inv_full'] : '';
    # --- get value in array !foreach! --- #
    $first_cus = array();
    $first_bpr = array();
    $first_ext = array();
    $first_pay = array();
    foreach ($bookings as $booking) {
        # --- get value rates --- #
        if ((in_array($booking['bpr_id'], $first_bpr) == false) && !empty($booking['bpr_id'])) {
            $first_bpr[] = $booking['bpr_id'];
            $rates['id'][] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
            // $rates['category'][] = !empty($booking['category_id']) ? $booking['category_id'] : 0;
            $rates['name'][] = !empty($booking['category_name']) ? $booking['category_name'] : 0;
            $rates['customer'][] = !empty($booking['category_cus']) ? $booking['category_cus'] : 0;
            $rates['adult'][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
            $rates['child'][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
            $rates['infant'][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
            $rates['foc'][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
            $rates['rate_adult'][] = !empty($booking['rate_adult']) ? $booking['rate_adult'] : 0;
            $rates['rate_child'][] = !empty($booking['rate_child']) ? $booking['rate_child'] : 0;
            $rates['rate_infant'][] = !empty($booking['rate_infant']) ? $booking['rate_infant'] : 0;
            $rates['rate_total'][] = !empty($booking['rate_total']) ? $booking['rate_total'] : 0;
            $rates['rate_private'][] = !empty($booking['rate_private']) ? $booking['rate_private'] : 0;
        }
        # --- get value customers --- #
        if ((in_array($booking['cus_id'], $first_cus) == false) && !empty($booking['cus_id'])) {
            $first_cus[] = $booking['cus_id'];
            $customers['cus_id'][] = !empty($booking['cus_id']) ? $booking['cus_id'] : 0;
            $customers['cus_age'][] = !empty($booking['cus_age']) ? $booking['cus_age'] : 0;
            $customers['name'][] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
            $customers['birth_date'][] = !empty($booking['birth_date']) ? $booking['birth_date'] : '0000-00-00';
            $customers['id_card'][] = !empty($booking['id_card']) ? $booking['id_card'] : '';
            $customers['telephone'][] = !empty($booking['telephone']) ? $booking['telephone'] : '';
            $customers['address'][] = !empty($booking['cus_address']) ? $booking['cus_address'] : '';
            $customers['head'][] = !empty($booking['cus_head']) ? $booking['cus_head'] : 0;
            $customers['nationality'][] = !empty($booking['nationality_id']) ? $booking['nationality_id'] : 0;
            $customers['cus_type'][] = !empty($booking['cus_type']) ? $booking['cus_type'] : 0;
            $customers['nation_name'][] = !empty($booking['nation_name']) ? $booking['nation_name'] : '';
        }
        # --- get value booking Extra charge --- #
        if ((in_array($booking['bec_id'], $first_ext) == false) && !empty($booking['bec_id'])) {
            $first_ext[] = $booking['bec_id'];
            $extar['bec_id'][] = !empty($booking['bec_id']) ? $booking['bec_id'] : 0;
            $extar['bec_name'][] = !empty($booking['bec_name']) ? $booking['bec_name'] : '';
            $extar['extra_id'][] = !empty($booking['extra_id']) ? $booking['extra_id'] : 0;
            $extar['extra_name'][] = !empty($booking['extra_name']) ? $booking['extra_name'] : '';
            $extar['bec_type'][] = !empty($booking['bec_type']) ? $booking['bec_type'] : 0;
            $extar['bec_adult'][] = !empty($booking['bec_adult']) ? $booking['bec_adult'] : 0;
            $extar['bec_child'][] = !empty($booking['bec_child']) ? $booking['bec_child'] : 0;
            $extar['bec_infant'][] = !empty($booking['bec_infant']) ? $booking['bec_infant'] : 0;
            $extar['bec_privates'][] = !empty($booking['bec_privates']) ? $booking['bec_privates'] : 0;
            $extar['bec_rate_adult'][] = !empty($booking['bec_rate_adult']) ? $booking['bec_rate_adult'] : 0;
            $extar['bec_rate_child'][] = !empty($booking['bec_rate_child']) ? $booking['bec_rate_child'] : 0;
            $extar['bec_rate_infant'][] = !empty($booking['bec_rate_infant']) ? $booking['bec_rate_infant'] : 0;
            $extar['bec_rate_private'][] = !empty($booking['bec_rate_private']) ? $booking['bec_rate_private'] : 0;
            $extar['bec_rate_total'][] = $booking['bec_type'] > 0 ? $booking['bec_type'] == 1 ? (($booking['bec_adult'] * $booking['bec_rate_adult']) + ($booking['bec_child'] * $booking['bec_rate_child']) + ($booking['bec_infant'] * $booking['bec_rate_infant'])) : ($booking['bec_privates'] * $booking['bec_rate_private']) : 0;
            $total_sum = $booking['bec_type'] > 0 ? $booking['bec_type'] == 1 ? $total_sum + (($booking['bec_adult'] * $booking['bec_rate_adult']) + ($booking['bec_child'] * $booking['bec_rate_child']) + ($booking['bec_infant'] * $booking['bec_rate_infant'])) : $total_sum + ($booking['bec_privates'] * $booking['bec_rate_private']) : $total_sum;
        }
        # --- get value booking payment --- #
        if ((in_array($booking['bopa_id'], $first_pay) == false) && !empty($booking['bopa_id'])) {
            # --- in array get value booking payment --- #
            $first_pay[] = $booking['bopa_id'];
            $payments['bopa_id'][] = !empty($booking['bopa_id']) ? $booking['bopa_id'] : 0;
            $payments['bopay_id'][] = !empty($booking['bopay_id']) ? $booking['bopay_id'] : 0;
            $payments['bopay_name'][] = !empty($booking['bopay_name']) ? $booking['bopay_name'] : '';
            $payments['payment_type_id'][] = !empty($booking['payment_type_id']) ? $booking['payment_type_id'] : 0;
            $payments['bank_account_id'][] = !empty($booking['bank_account_id']) ? $booking['bank_account_id'] : 0;
            $payments['date_paid'][] = !empty($booking['date_paid']) ? $booking['date_paid'] : '0000-00-00';
            $payments['total_paid'][] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
            $payments['card_no'][] = !empty($booking['card_no']) ? $booking['card_no'] : '';
            $payments['bopa_photo'][] = !empty($booking['bopa_photo']) ? $booking['bopa_photo'] : '';
            $payments['bopa_note'][] = !empty($booking['bopa_note']) ? $booking['bopa_note'] : '';
            if ($booking['bopay_id'] == 4) {
                $cot_id = !empty($booking['bopa_id']) ? $booking['bopa_id'] : 0;
                $cot = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
            }
        }
        $payment_name = !empty($booking['bopay_name']) ? $booking['bopay_name'] : '';
    }
    $total_sum = ($book_type > 0) ? ($book_type == 1) ?  array_sum($rates['rate_total']) + $total_product + $total_sum : array_sum($rates['rate_private']) + $total_product + $total_sum : $total_product + $total_sum;
    $total_product = ($book_type > 0) ? ($book_type == 1) ?  array_sum($rates['rate_total']) + $total_product : array_sum($rates['rate_private']) + $total_product : $total_product;
    $product_total = ($adult * $rate_adult) + ($child * $rate_child) + ($infant * $rate_infant);
    $payment_total = !empty($cot) ? $cot : 0;
    $transfer_total = ($transfer_type == 1) ? ($bt_adult * $btr_rate_adult) + ($bt_child * $btr_rate_child) + ($bt_infant * $btr_rate_infant) : $btr_rate_private;
    $extar_total = !empty($extar['bec_rate_total']) ? array_sum($extar['bec_rate_total']) : 0;
}
if (!empty($bookings[0]['bp_id'])) {
?>
    <div id="div-inc-print" style="background-color: #fff;">
        <div class="content-body invoice-print">
            <div class="p-3">
                <div class="text-center">
                    <!-- <img src="https://phuketsolution.com/demo/vuexy/img/logo-sawanu.webp" alt="logo" width="255">  -->
                    <img src="app-assets/images/logo/logo-500.png" width="150">
                </div>
                <div class="alert alert-<?php echo ($book_status == 3 || $book_status == 4) ? 'danger' : 'warning'; ?> mb-2 mt-2" role="alert">
                    <h6 class="alert-heading text-center text-uppercase p-1">Booking <?php echo ($book_status == 3 || $book_status == 4) ? 'Canceled' : 'Comfirmation'; ?></h6>
                </div>
                <table class="mb-3">
                    <tbody>
                        <tr>
                            <td class="pr-3"><b>Booking Number: </b></td>
                            <td><?php echo $book_full; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Booking By: </b></td>
                            <td><?php echo $booker_name; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Agency Name: </b></td>
                            <td><?php echo $agent_name; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Booking Day: </b></td>
                            <td><?php echo $booking_day; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Agenct voucher Ref: </b></td>
                            <td><?php echo $voucher_no_agent; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Programe: </b></td>
                            <td><?php echo $product_name; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Travel Date: </b></td>
                            <td><?php echo date('j F Y', strtotime($travel_date)); ?></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered mb-2">
                    <tr>
                        <th rowspan="2"></th>
                        <th colspan="2" class="text-center">Adult </th>
                        <th colspan="2" class="text-center">Child <small>(4-11 yrs old)</small></th>
                        <th colspan="2" class="text-center">Infant <small>(1-3 yrs old)</small></th>
                        <th colspan="2" class="text-center">FOC / Private</th>
                    </tr>
                    <tr>
                        <th class="text-center">จํานวน</th>
                        <th class="text-center">ราคาต่อหน่วย</th>
                        <th class="text-center">จํานวน</th>
                        <th class="text-center">ราคาต่อหน่วย</th>
                        <th class="text-center">จํานวน</th>
                        <th class="text-center">ราคาต่อหน่วย</th>
                        <th class="text-center">จํานวน</th>
                        <th class="text-center">ราคาต่อหน่วย</th>
                    </tr>
                    <?php 
                    if ($rates['id']) {
                        for ($i = 0; $i < count($rates['id']); $i++) { ?>
                            <tr>
                                <td class="text-center">Number of Passengers (<?php echo $rates['name'][$i]; ?>):</td>
                                <td class="text-center"><?php echo $rates['adult'][$i] > 0 ? $rates['adult'][$i] : '-'; ?></td>
                                <td class="text-center"><?php echo $rates['rate_adult'][$i] > 0 ? number_format($rates['rate_adult'][$i]) : '-'; ?></td>
                                <td class="text-center"><?php echo $rates['child'][$i] > 0 ?$rates['child'][$i] : '-'; ?></td>
                                <td class="text-center"><?php echo $rates['child'][$i] > 0 ? number_format($rates['rate_child'][$i]) : '-'; ?></td>
                                <td class="text-center"><?php echo $rates['infant'][$i] > 0 ? $rates['infant'][$i] : '-'; ?></td>
                                <td class="text-center"><?php echo $rates['infant'][$i] > 0 ? number_format($rates['rate_infant'][$i]) : '-'; ?></td>
                                <td class="text-center"><?php echo $rates['foc'][$i] > 0 ? $rates['foc'][$i] : '-'; ?></td>
                                <td class="text-center">-</td>
                            </tr>
                    <?php }
                    } ?>
                    <!-- Extra Chang -->
                    <?php if (!empty($extar)) {
                        for ($i = 0; $i < count($extar['bec_id']); $i++) {
                    ?>
                            <tr>
                                <td class="text-center"><?php echo !empty($extar['extra_id'][$i]) ? $extar['extra_name'][$i] : $extar['bec_name'][$i]; ?>:</td>
                                <td class="text-center"><?php echo ($extar['bec_type'][$i] == 1 && $extar['bec_adult'][$i] > 0) ? $extar['bec_adult'][$i] : '-'; ?></td>
                                <td class="text-center"><?php echo ($extar['bec_type'][$i] == 1 && $extar['bec_adult'][$i] > 0) ? number_format($extar['bec_rate_adult'][$i]) : '-'; ?></td>
                                <td class="text-center"><?php echo ($extar['bec_type'][$i] == 1 && $extar['bec_child'][$i] > 0) ? $extar['bec_child'][$i] : '-'; ?></td>
                                <td class="text-center"><?php echo ($extar['bec_type'][$i] == 1 && $extar['bec_child'][$i] > 0) ? number_format($extar['bec_rate_child'][$i]) : '-'; ?></td>
                                <td class="text-center"><?php echo ($extar['bec_type'][$i] == 1 && $extar['bec_infant'][$i] > 0) ? $extar['bec_infant'][$i] : '-'; ?></td>
                                <td class="text-center"><?php echo ($extar['bec_type'][$i] == 1 && $extar['bec_infant'][$i] > 0) ? number_format($extar['bec_rate_infant'][$i]) : '-'; ?></td>
                                <td class="text-center"><?php echo ($extar['bec_type'][$i] == 2 && $extar['bec_privates'][$i] > 0) ? $extar['bec_privates'][$i] : '-'; ?></td>
                                <td class="text-center"><?php echo ($extar['bec_type'][$i] == 2 && $extar['bec_privates'][$i] > 0) ? number_format($extar['bec_rate_privates'][$i]) : '-'; ?></td>
                            </tr>
                    <?php }
                    } ?>
                </table>

                <table class="mb-3">
                    <?php $position_cus = !empty($customers['head']) ? array_search(1, $customers['head'], true) : ''; ?>
                    <tbody>
                        <tr>
                            <td class="pr-3"><b>Main Passenger Name: </b></td>
                            <td><?php echo !empty($customers['name'][$position_cus]) ? $customers['name'][$position_cus] : ''; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Phone Number: </b></td>
                            <td><?php echo !empty($customers['telephone'][$position_cus]) ? $customers['telephone'][$position_cus] : ''; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Nationality: </b></td>
                            <td><?php echo !empty($customers['nation_name'][$position_cus]) ? $customers['nation_name'][$position_cus] : ''; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Guide Languages: </b></td>
                            <td><?php echo !empty($lang_name) ? $lang_name : ''; ?></td>
                        </tr>
                        <!-- <tr>
                            <td class="pr-3">Passenger Remarks: </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="pr-3">Additional Services: </td>
                            <td></td>
                        </tr> -->
                    </tbody>
                </table>

                <table class="table mb-3">
                    <thead>
                        <tr>
                            <th class="py-1"><span class="pr-1">Payment:</span> Pay before travel</th>
                            <th class="py-1"><span class="pr-1">Discount:</span> <?php echo !empty($discount) ? number_format($discount, 2) : '-'; ?> THB</th>
                            <th class="py-1"><span class="pr-1">Cash on tour:</span> <?php echo !empty($cot) ? number_format($cot, 2) : '-'; ?> THB</th>
                            <th class="py-1"><span class="pr-1">Amount:</span> <?php echo !empty($total_sum) ? number_format($total_sum - ($cot + $discount), 2) : '-'; ?> THB</th>
                        </tr>
                    </thead>
                </table>

                <b>Pick-up & Drop-off Information</b>

                <table class="mb-3">
                    <tbody>
                        <tr>
                            <td class="pr-3"><b>Pick-up Time: </b></td>
                            <td><?php echo date("H:i", strtotime($start_pickup)) . ' - ' . date("H:i", strtotime($end_pickup)); ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Room Number: </b></td>
                            <td><?php echo !empty($room_no) ? $room_no : '-'; ?></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Pick-up Location: </b></td>
                            <td><?php echo !empty($hotel_pickup_outside) ? $hotel_pickup_outside : '';
                                echo !empty($pickup_name) ? ' (' . $pickup_name . ')' : ''; ?></b></td>
                        </tr>
                        <tr>
                            <td class="pr-3"><b>Drop-off Location: </b></td>
                            <td><?php echo !empty($hotel_dropoff_outside) ? $hotel_dropoff_outside : '';
                                echo !empty($dropoff_name) ? ' (' . $dropoff_name . ')' : ''; ?></td>
                        </tr>
                    </tbody>
                </table>

                <hr class="my-2" />

                <div class="row align-items-center">
                    <div class="col-sm-9">
                        <p class="mb-2">
                            <b>บัญชี :</b> บูรพา จงศิริวัฒนากูล 885-2965-797 ธนาคารไทยพาณิชย์ (SCB)
                            <!-- TOGETHER TRAVEL CO.,LTD. <br>
                            Email: togethertravel56@gmail.com <br>
                            Tel: 0969977779, 0958497779 <br> -->
                            <!-- www.sawanutravel.com <br>
                            Email: contact@sawanutravel.com <br>
                            Tel: +66-65-716-1670, +66-65-716-1620 <br> -->
                            <?php //echo $main_document; 
                            ?>
                        </p>
                        <!-- <ol class="pl-1 m-0 mb-1">
                            <li>游客务必准时在酒店大堂等候司机（不是房间，也不是餐厅），如果迟到导致未能参加行程，费用不退。</li>
                            <li>司机到达酒店以后，只等候5分钟，如果客人迟到没有赶上车，只能自行打车前往码头。（需在指定时间内抵达）</li>
                            <li>不需要带护照（手机里面有护照首页的照片即可）</li>
                            <li>出行当天，无论任何理由取消，将100%收取费用。</li>
                            特别备注：请每位客人准备好该行程的付款截图，低于限价会要求现场补足差价，没有付款截图禁止登船。
                        </ol>
                        <ol class="pl-1 m-0">
                            <li>Tourists must wait for the driver on time in the hotel lobby (not in the room or restaurant) If you are late and miss the scheduled trip, no refund will be given.</li>
                            <li>After the driver arrives at the hotel, he will wait for only 5 minutes. If the guest is late and misses the vehicle, they can only take a taxi to the port (must arrive within the specified time)</li>
                            <li>There is no need to bring your passport (just have a photo of the first page of your passport on your phone)</li>
                            <li>On the day of the trip, a 100% cancellation fee will be charged regardless of the reason. Special</li>
                            Note: Each guest must prepare a screenshot of the payment for the itinerary. If the price is lower than the specified limit, the price difference will be charged on-site. No boarding will be allowed without the payment screenshot.
                        </ol> -->
                    </div>
                    <div class="col-sm-3 text-sm-right">

                    </div>
                </div>

                <hr class="my-2" />

                <p class="text-center"><?php echo $booker_name . ' ' . $created_at; ?></p>
            </div>

        </div>

    </div>
<?php  } ?>
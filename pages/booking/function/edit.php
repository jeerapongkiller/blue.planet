<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['bo_id']) && $_POST['bo_id'] > 0) {
    # --- setting system --- #
    $open_rates = !empty('open_rates') ? $_POST['open_rates'] : 0;
    # --- get value booking form --- #
    $bo_id = !empty($_POST['bo_id']) ? $_POST['bo_id'] : 0;
    $book_status = !empty($_POST['book_status']) ? $_POST['book_status'] : 0;
    $book_type = !empty($_POST['booking_type_id']) ? $_POST['booking_type_id'] : 0;
    $agent = !empty($_POST['agent']) ? $_POST['agent'] : 0;
    $voucher_no = !empty($_POST['voucher_no_agent']) ? $_POST['voucher_no_agent'] : '';
    $sender = !empty($_POST['sender']) ? $_POST['sender'] : '';
    $cot_id = !empty($_POST['cot_id']) ? $_POST['cot_id'] : 0;
    $cot = !empty($_POST['cot']) ? preg_replace('(,)', '', $_POST['cot']) : 0;
    $discount = !empty($_POST['discount']) ? preg_replace('(,)', '', $_POST['discount']) : 0;
    $rates_charge = !empty($_POST['rates_charge']) ? preg_replace('(,)', '', $_POST['rates_charge']) : 0;
    $confirm_id = !empty($_POST['confirm_id']) ? $_POST['confirm_id'] : 0;
    # --- get value booking management form --- #
    $mange_transfer_id = !empty($_POST['mange_transfer_id']) ? $_POST['mange_transfer_id'] : 0;
    $mange_transfer = !empty($_POST['mange_transfer']) ? $_POST['mange_transfer'] : 0;
    $mange_boat_id = !empty($_POST['mange_boat_id']) ? $_POST['mange_boat_id'] : 0;
    $mange_boat = !empty($_POST['mange_boat']) ? $_POST['mange_boat'] : 0;
    # --- get value booking product form --- #
    $bp_id = !empty($_POST['bp_id']) ? $_POST['bp_id'] : 0;
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';
    $before_travel = !empty($_POST['travel']) ? $_POST['travel'] : '0000-00-00';
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : 0;
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : 0;
    $adult = !empty($_POST['adult']) ? $_POST['adult'] : 0;
    $child = !empty($_POST['child']) ? $_POST['child'] : 0;
    $infant = !empty($_POST['infant']) ? $_POST['infant'] : 0;
    $foc = !empty($_POST['foc']) ? $_POST['foc'] : 0;
    $bp_note = !empty($_POST['bp_note']) ? $_POST['bp_note'] : '';
    $language_id = !empty($_POST['language_id']) ? $_POST['language_id'] : 0;
    # --- get value booking product rate form --- #
    $bpr_id = !empty($_POST['bpr_id']) ? $_POST['bpr_id'] : 0;
    $pror_id = !empty($_POST['pror_id']) ? $_POST['pror_id'] : 0;
    $rate_adult = !empty($_POST['rate_adult']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_adult']) : 0;
    $rate_child = !empty($_POST['rate_child']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_child']) : 0;
    $rate_infant = !empty($_POST['rate_infant']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_infant']) : 0;
    $rate_total = !empty($_POST['rate_total']) ? preg_replace('(,)', '', $_POST['rate_total']) : 0;
    # --- check status rates charge --- #
    if ($book_status == 4 || $book_status == 2) {
        $rate_total = $rates_charge;
        $rate_adult = 0;
        $rate_child = 0;
        $rate_infant = 0;
    }
    # --- get value booking product rate form (thai) --- #
    // $bpr_thai_id = !empty($_POST['bpr_thai_id']) ? $_POST['bpr_thai_id'] : 0;
    // $customer_thai = !empty($_POST['customer_thai']) ? $_POST['customer_thai'] : 0;
    // $category_id_thai = !empty($_POST['category_id_thai']) ? $_POST['category_id_thai'] : 0;
    // $pror_id_thai = !empty($_POST['pror_id_thai']) ? $_POST['pror_id_thai'] : 0;
    // $adult_thai = !empty($_POST['adult_thai']) ? $_POST['adult_thai'] : 0;
    // $child_thai = !empty($_POST['child_thai']) ? $_POST['child_thai'] : 0;
    // $infant_thai = !empty($_POST['infant_thai']) ? $_POST['infant_thai'] : 0;
    // $foc_thai = !empty($_POST['foc_thai']) ? $_POST['foc_thai'] : 0;
    // $rate_adult_thai = !empty($_POST['rate_adult_thai']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_adult_thai']) : 0;
    // $rate_child_thai = !empty($_POST['rate_child_thai']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_child_thai']) : 0;
    // $rate_infant_thai = !empty($_POST['rate_infant_thai']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_infant_thai']) : 0;
    // $rate_total_thai = !empty($_POST['rate_total_thai']) ? preg_replace('(,)', '', $_POST['rate_total_thai']) : 0;
    // $private_rates_thai = !empty($_POST['private_rates_thai']) ? preg_replace('(,)', '', $_POST['private_rates_thai']) : 0;
    // # --- get value booking product rate form (thai) --- #
    // $bpr_foreign_id = !empty($_POST['bpr_foreign_id']) ? $_POST['bpr_foreign_id'] : 0;
    // $customer_foreign = !empty($_POST['customer_foreign']) ? $_POST['customer_foreign'] : 0;
    // $category_id_foreign = !empty($_POST['category_id_foreign']) ? $_POST['category_id_foreign'] : 0;
    // $pror_id_foreign = !empty($_POST['pror_id_foreign']) ? $_POST['pror_id_foreign'] : 0;
    // $adult_foreign = !empty($_POST['adult_foreign']) ? $_POST['adult_foreign'] : 0;
    // $child_foreign = !empty($_POST['child_foreign']) ? $_POST['child_foreign'] : 0;
    // $infant_foreign = !empty($_POST['infant_foreign']) ? $_POST['infant_foreign'] : 0;
    // $foc_foreign = !empty($_POST['foc_foreign']) ? $_POST['foc_foreign'] : 0;
    // $rate_adult_foreign = !empty($_POST['rate_adult_foreign']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_adult_foreign']) : 0;
    // $rate_child_foreign = !empty($_POST['rate_child_foreign']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_child_foreign']) : 0;
    // $rate_infant_foreign = !empty($_POST['rate_infant_foreign']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_infant_foreign']) : 0;
    // $rate_total_foreign = !empty($_POST['rate_total_foreign']) ? preg_replace('(,)', '', $_POST['rate_total_foreign']) : 0;
    // $private_rates_foreign = !empty($_POST['private_rates_foreign']) ? preg_replace('(,)', '', $_POST['private_rates_foreign']) : 0;
    # --- get value customer form --- #
    $cus_id = !empty($_POST['cus_id']) ? $_POST['cus_id'] : 0;
    $cus_name = !empty($_POST['cus_name']) ? $_POST['cus_name'] : '';
    $cus_telephone = !empty($_POST['cus_telephone']) ? $_POST['cus_telephone'] : '';
    # --- get value Transfer from --- #
    $bt_id = !empty($_POST['bt_id']) ? $_POST['bt_id'] : 0;
    $pickup_type = !empty($_POST['pickup_type']) ? $_POST['pickup_type'] : 0;
    $transfer_type = !empty($_POST['transfer_type']) ? $_POST['transfer_type'] : 0;
    $tran_adult = !empty($_POST['tran_adult_pax']) ? $_POST['tran_adult_pax'] : 0;
    $tran_child = !empty($_POST['tran_child_pax']) ? $_POST['tran_child_pax'] : 0;
    $tran_infant = !empty($_POST['tran_infant_pax']) ? $_POST['tran_infant_pax'] : 0;
    $tran_foc = !empty($_POST['tran_foc_pax']) ? $_POST['tran_foc_pax'] : 0;
    $start_pickup = !empty($_POST['start_pickup']) ? $_POST['start_pickup'] : '00:00:00';
    $end_pickup = !empty($_POST['end_pickup']) ? $_POST['end_pickup'] : '00:00:00';
    $hotel_pickup = !empty($_POST['hotel_pickup']) ? $_POST['hotel_pickup'] : 0;
    $pickup = !empty($_POST['pickup']) ? $_POST['pickup'] : 0;
    $hotel_pickup_outside = !empty($_POST['hotel_pickup_outside']) ? $_POST['hotel_pickup_outside'] : '';
    $hotel_dropoff = empty($_POST['hotel_dropoff']) ? !empty($_POST['hotel_pickup']) ? $_POST['hotel_pickup'] : 0 : $_POST['hotel_dropoff'];
    $dropoff = empty($_POST['dropoff']) ? !empty($_POST['pickup']) ? $_POST['pickup'] : 0 : $_POST['dropoff'];
    $hotel_dropoff_outside = empty($_POST['hotel_dropoff_outside']) ? !empty($_POST['hotel_pickup_outside']) ? $_POST['hotel_pickup_outside'] : '' : $_POST['hotel_dropoff_outside'];
    $room_no = !empty($_POST['room_no']) ? $_POST['room_no'] : '';
    $trans_note = !empty($_POST['trans_note']) ? $_POST['trans_note'] : '';
    # --- get value rate transfer (Join) --- #
    $btr_id = !empty($_POST['btr_id']) ? $_POST['btr_id'] : 0;
    $tran_rate_adult = !empty($_POST['tran_adult']) && $transfer_type == 1 ? preg_replace('(,)', '', $_POST['tran_adult']) : 0;
    $tran_rate_child = !empty($_POST['tran_child']) && $transfer_type == 1 ? preg_replace('(,)', '', $_POST['tran_child']) : 0;
    $tran_rate_infant = !empty($_POST['tran_infant']) && $transfer_type == 1 ? preg_replace('(,)', '', $_POST['tran_infant']) : 0;
    $tran_total_price = !empty($_POST['tran_total_price']) ? preg_replace('(,)', '', $_POST['tran_total_price']) : 0;
    # --- get value rate transfer (Private) --- #
    $transfers = !empty($_POST['transfers']) ? $_POST['transfers'] : '';
    if ($transfers) {
        for ($i = 0; $i < count($transfers); $i++) {
            $array_btr_id[] = !empty($transfers[$i]['array_btr_id']) ? $transfers[$i]['array_btr_id'] : 0;
        }
    }
    $before_btr_id = !empty($_POST['before_btr_id']) ? $_POST['before_btr_id'] : '';
    # --- get value extra chang from --- #
    $extra_charge = !empty($_POST['extra-charge']) ? $_POST['extra-charge'] : '';
    $bec_id = array();
    if ($extra_charge) {
        for ($i = 0; $i < count($extra_charge); $i++) {
            $bec_id[] = !empty($extra_charge[$i]['bec_id']) ? $extra_charge[$i]['bec_id'] : 0;
        }
    }
    $before_bec_id = !empty($_POST['before_bec_id']) ? $_POST['before_bec_id'] : '';

    $customers = !empty($_POST['itinerary']) ? $_POST['itinerary'] : '';
    $before_cus_id = !empty($_POST['before_cus_id']) ? $_POST['before_cus_id'] : '';
    $cus_id = array();
    if ($customers) {
        for ($i = 0; $i < count($customers); $i++) {
            $cus_id[] = !empty($customers[$i]['cus_id']) ? $customers[$i]['cus_id'] : 0;
        }
    }

    if ($agent == 'outside' && !empty($_POST['agent_outside'])) {
        $agent_out_id = $bookObj->insert_agent($_POST['agent_outside']);
    }

    # --- update data ---- #
    $response = $bookObj->update_data($bo_id, $book_status, $voucher_no, $sender, ($agent == 'outside' && !empty($_POST['agent_outside'])) ? $agent_out_id : $agent, $book_type, $discount); // update data booking
    # --- update booking product ---- #
    $response = ($response > 0 && $response != false) ? $bookObj->update_booking_product($bp_id, $travel_date, $bp_note, $language_id, $product_id) : false; // update data booking product

    if ($bpr_id == 0) {
        $response = ($bp_id > 0 && $bp_id != FALSE) ? $bookObj->insert_booking_rate($adult, $child, $infant, $foc, $rate_adult, $rate_child, $rate_infant, $rate_total, 0, $category_id, $bp_id, $pror_id) : false; // insert booking products rate
    } else {
        $response = ($response > 0 && $response != false) ? $bookObj->update_booking_rate($bpr_id, $adult, $child, $infant, $foc, $rate_adult, $rate_child, $rate_infant, 0, $rate_total, $pror_id, $category_id) : false; // update data booking product rate
    }

    # --- update customer ---- #
    // if ($cus_id > 0) {
    //     $response = ($response > 0 && $response != false) ? $bookObj->update_customer($cus_id, $cus_name, '0000-00-00', '', $cus_telephone, 1, 1, 0) : false; // update data customers
    // } elseif ($cus_id == 0 && (!empty($cus_name))) {
    //     $response = ($response > 0 && $response != false) ? $bookObj->insert_customer($cus_name, '0000-00-00', '', $cus_telephone, $address = '', 1, 0, $email = '', 1, $bo_id, 0) : $response;
    // }

    # ---- update customer ---- #
    if ($customers) {
        for ($i = 0; $i < count($customers); $i++) {
            if (empty($customers[$i]['cus_id'])) {
                $response = ($response > 0 && $response != false && !empty($customers[$i]['cus_name'])) ? $bookObj->insert_customer($customers[$i]['cus_name'], $customers[$i]['cus_birth_date'], $customers[$i]['id_card'], $customers[$i]['cus_telephone'], $address = '', !empty($customers[$i]['cus_age']) ? $customers[$i]['cus_age'] : 0, 0, $email = '', !empty($customers[$i]['head']) ? $customers[$i]['head'] : 0, $bo_id, $customers[$i]['cus_nationality_id']) : $response; // insert data customers 
            } elseif ($customers[$i]['cus_id'] > 0 && !empty($customers[$i]['cus_name'])) {
                $response = ($response > 0 && $response != false) ? $bookObj->update_customer($customers[$i]['cus_id'], $customers[$i]['cus_name'], $customers[$i]['cus_birth_date'], $customers[$i]['id_card'], $customers[$i]['cus_telephone'], !empty($customers[$i]['cus_age']) ? $customers[$i]['cus_age'] : 0, $customers[$i]['head'], $customers[$i]['cus_nationality_id']) : $response; // update data customers
            } 
            // elseif ($customers[$i]['cus_id'] > 0 && empty($customers[$i]['cus_name'])) {
            //     $response = ($response > 0 && $response != false) ? $bookObj->delete_customer($customers[$i]['cus_id']) : $response; // delete data customers 
            // }
        }
        if (!empty($before_cus_id)) {
            for ($i=0; $i < count($before_cus_id); $i++) { 
                if (in_array($before_cus_id[$i], $cus_id) == false) {
                    $response = ($response > 0 && $response != false) ? $bookObj->delete_customer($before_cus_id[$i]) : $response; // delete data customers 
                }
            }
        }
    }

    // if ($customers) {
    //     for ($i = 0; $i < count($customers); $i++) {
    //         if ($customers[$i]['cus_id'] == '') {
    //             $response = ($response > 0 && $response != false && !empty($customers[$i]['cus_name'])) ? $bookObj->insert_customer($customers[$i]['cus_name'], $customers[$i]['cus_birth_date'], $customers[$i]['id_card'], $customers[$i]['cus_telephone'], $address = '', !empty($customers[$i]['cus_age']) ? $customers[$i]['cus_age'] : 0, !empty($customers[$i]['cus_type']) ? $customers[$i]['cus_type'] : 0, $email = '', $head = 0, $bo_id, !empty($customers[$i]['cus_nationality_id']) ? $customers[$i]['cus_nationality_id'] : 0) : $response; // insert data customers 
    //         } else {
    //             $response = ($response > 0 && $response != false && !empty($customers[$i]['cus_name'])) ? $bookObj->update_customer($customers[$i]['cus_id'], $customers[$i]['cus_name'], $customers[$i]['cus_birth_date'], $customers[$i]['id_card'], $customers[$i]['cus_telephone'], !empty($customers[$i]['cus_age']) ? $customers[$i]['cus_age'] : 0, !empty($customers[$i]['cus_type']) ? $customers[$i]['cus_type'] : 0, $customers[$i]['head'], !empty($customers[$i]['cus_nationality_id']) ? $customers[$i]['cus_nationality_id'] : 0) : $response; // update data customers
    //         }
    //     }
    // }
    # --- update booking transfer ---- #
    if ($bt_id > 0) {
        $response = ($response != false && $response > 0) ? $bookObj->update_booking_transfer($bt_id, $tran_adult, $tran_child, $tran_infant, $tran_foc, $start_pickup, $end_pickup, $hotel_pickup_outside, empty($hotel_dropoff_outside) ? $hotel_pickup_outside : $hotel_dropoff_outside, $room_no, $trans_note, $pickup, $dropoff, $hotel_pickup, !empty($hotel_dropoff) ? $hotel_dropoff : $hotel_pickup, $transfer_type, $pickup_type, 0) : false; // update booking transfer
    } elseif ($bt_id == 0) {
        $response = ($response > 0 && $response != false) ? $bookObj->insert_booking_transfer($tran_adult, $tran_child, $tran_infant, $tran_foc, $start_pickup, $end_pickup, $hotel_pickup_outside, empty($hotel_dropoff_outside) ? $hotel_pickup_outside : $hotel_dropoff_outside, $room_no, $trans_note, $pickup, $dropoff, $hotel_pickup, !empty($hotel_dropoff) ? $hotel_dropoff : $hotel_pickup, $transfer_type, $pickup_type, $bp_id, 0) : false; // insert booking transfer
    }
    # --- update booking transfer rates ---- #
    if ($btr_id > 0) {
        $response = ($response != false && $response > 0) ? $bookObj->update_transfer_rate($btr_id, $tran_rate_adult, $tran_rate_child, $tran_rate_infant, $tran_total_price, $cars_category = 0) : false; // update data booking transfer rate (join)
    } elseif ($btr_id == 0) {
        $response = ($response > 0 && $response != false) ? $bookObj->insert_transfer_rate($tran_rate_adult, $tran_rate_child, $tran_rate_infant, $tran_total_price, $bt_id, $cars_category = 0) : false; // insert booking transfer rate (join)
    }
    # --- update booking paid ---- #
    if ($cot_id == 0 && $cot > 0) {
        $response = ($response > 0 && $response != false) ? $bookObj->insert_booking_paid($bo_id, '0000-00-00', $cot, '', '', 0, 0, 4, $fileArray = []) : $response; // insert booking payment (paid)
    } else {
        $response = ($response > 0 && $response != false) ? $bookObj->update_booking_paid($cot_id, '0000-00-00', $cot, '', '', 0, 0, $cot > 0 ? 4 : 2, $fileArray = []) : $response; // update booking extra charge
    }
    # --- update booking extar charge ---- #
    if ($before_bec_id) {
        for ($i = 0; $i < count($before_bec_id); $i++) {
            if (!in_array($before_bec_id[$i], $bec_id)) {
                $response = ($response > 0 && $response != false) ? $bookObj->delete_booking_extra($before_bec_id[$i]) : false; // delete data customers 
            }
        }
    }

    if ($extra_charge) {
        for ($i = 0; $i < count($extra_charge); $i++) {
            $bec_id = !empty($extra_charge[$i]['bec_id']) ? $extra_charge[$i]['bec_id'] : 0;
            $extra = !empty($extra_charge[$i]['extra_charge']) ? $extra_charge[$i]['extra_charge'] : 0;
            $extra_name = !empty($extra_charge[$i]['extc_name']) ? $extra_charge[$i]['extc_name'] : '';
            $extra_type = !empty($extra_charge[$i]['extra_type']) ? $extra_charge[$i]['extra_type'] : 0;
            $extra_adult = !empty($extra_charge[$i]['extra_adult']) ? $extra_charge[$i]['extra_adult'] : 0;
            $extra_rate_adult = !empty($extra_charge[$i]['extra_rate_adult']) ? preg_replace('(,)', '', $extra_charge[$i]['extra_rate_adult']) : 0;
            $extra_child = !empty($extra_charge[$i]['extra_child']) ? $extra_charge[$i]['extra_child'] : 0;
            $extra_rate_child = !empty($extra_charge[$i]['extra_rate_child']) ? preg_replace('(,)', '', $extra_charge[$i]['extra_rate_child']) : 0;
            $extra_infant = !empty($extra_charge[$i]['extra_infant']) ? $extra_charge[$i]['extra_infant'] : 0;
            $extra_rate_infant = !empty($extra_charge[$i]['extra_rate_infant']) ? preg_replace('(,)', '', $extra_charge[$i]['extra_rate_infant']) : 0;
            $extra_num_private = !empty($extra_charge[$i]['extra_num_private']) ? $extra_charge[$i]['extra_num_private'] : 0;
            $extra_rate_private = !empty($extra_charge[$i]['extra_rate_private']) ? preg_replace('(,)', '', $extra_charge[$i]['extra_rate_private']) : 0;

            if ($extra_charge[$i]['bec_id'] == '') {
                $response = ($response > 0 && $response != false) && ($extra > 0 || !empty($extra_name)) && ($extra_type > 0) ? $bookObj->insert_booking_extra($bo_id, $extra, $extra_name, $extra_type, $extra_adult, $extra_rate_adult, $extra_child, $extra_rate_child, $extra_infant, $extra_rate_infant, $extra_num_private, $extra_rate_private) : $response; // insert booking extra charge
            } else {
                $response = ($response > 0 && $response != false) ? $bookObj->update_booking_extra($bec_id, $extra, $extra_name, $extra_type, $extra_adult, $extra_rate_adult, $extra_child, $extra_rate_child, $extra_infant, $extra_rate_infant, $extra_num_private, $extra_rate_private) : $response; // update booking extra charge
            }
        }
    }

    if ($travel_date != $before_travel) {
        $response = $bookObj->delete_booking_manage_transfer($mange_transfer, $bt_id, $mange_transfer_id);
        $response = $bookObj->delete_booking_manage_boat($mange_boat, $bo_id, $mange_boat_id);
    }

    $response = $bookObj->delete_confirm($confirm_id);

    echo $response != FALSE && $response > 0 ? $response : FALSE;
} else {
    echo $response = FALSE;
}

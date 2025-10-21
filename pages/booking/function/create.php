<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();
$response = FALSE;
$today = date("Y-m-d H:i:s");

if (isset($_POST['action']) && $_POST['action'] == "create" && !empty($_POST['category_id'])) {
    # --- setting system --- #
    $open_rates = !empty('open_rates') ? $_POST['open_rates'] : 0;
    # --- get value booking form --- #
    $quick = !empty($_POST['quick']) ? $_POST['quick'] : 0;
    $book_status = !empty($_POST['book_status']) ? $_POST['book_status'] : 0;
    $book_type = !empty($_POST['booking_type']) ? $_POST['booking_type'] : 0;
    $book_date = $_POST['book_date'] != "" ? $_POST['book_date'] : '0000-00-00';
    $book_time = $_POST['book_time'] != "" ? $_POST['book_time'] : '00:00:00';
    $agent = !empty($_POST['agent']) ? $_POST['agent'] : 0;
    $voucher_no = !empty($_POST['voucher_no']) ? $_POST['voucher_no'] : '';
    $sender = !empty($_POST['sender']) ? $_POST['sender'] : '';
    $cot = !empty($_POST['cot']) ? preg_replace('(,)', '', $_POST['cot']) : 0;
    # --- get value booking no. --- #
    if (!empty($book_date)) {
        $book_no = $bookObj->create_booking_no($book_date);
        $bo_title = $book_no['bo_title'] != "" ? $book_no['bo_title'] : '';
        $bo_date = $book_no['bo_date'] != "" ? $book_no['bo_date'] : '';
        $bo_year = $book_no['bo_year'] != "" ? $book_no['bo_year'] : 0;
        $bo_year_th = $book_no['bo_year_th'] != "" ? $book_no['bo_year_th'] : 0;
        $bo_month = $book_no['bo_month'] != "" ? $book_no['bo_month'] : 0;
        $bo_no = $book_no['bo_no'] != "" ? $book_no['bo_no'] : 0;
        $bo_full = $book_no['bo_full'] != "" ? $book_no['bo_full'] : '';
    }
    // # --- get value booking product form --- #
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : 0;
    $bp_note = !empty($_POST['bp_note']) ? $_POST['bp_note'] : '';
    $language_id = !empty($_POST['language_id']) ? $_POST['language_id'] : 0;
    # --- get value booking product rate form (thai) --- #
    $customer_thai = !empty($_POST['customer_thai']) ? $_POST['customer_thai'] : 0;
    $category_id_thai = !empty($_POST['category_id_thai']) ? $_POST['category_id_thai'] : 0;
    $pror_id_thai = !empty($_POST['pror_id_thai']) ? $_POST['pror_id_thai'] : 0;
    $adult_thai = !empty($_POST['adult_thai']) ? $_POST['adult_thai'] : 0;
    $child_thai = !empty($_POST['child_thai']) ? $_POST['child_thai'] : 0;
    $infant_thai = !empty($_POST['infant_thai']) ? $_POST['infant_thai'] : 0;
    $foc_thai = !empty($_POST['foc_thai']) ? $_POST['foc_thai'] : 0;
    $rate_adult_thai = !empty($_POST['rate_adult_thai']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_adult_thai']) : 0;
    $rate_child_thai = !empty($_POST['rate_child_thai']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_child_thai']) : 0;
    $rate_infant_thai = !empty($_POST['rate_infant_thai']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_infant_thai']) : 0;
    $rate_total_thai = !empty($_POST['rate_total_thai']) ? preg_replace('(,)', '', $_POST['rate_total_thai']) : 0;
    $private_rates_thai = !empty($_POST['private_rates_thai']) ? preg_replace('(,)', '', $_POST['private_rates_thai']) : 0;
    # --- get value booking product rate form (thai) --- #
    $customer_foreign = !empty($_POST['customer_foreign']) ? $_POST['customer_foreign'] : 0;
    $category_id_foreign = !empty($_POST['category_id_foreign']) ? $_POST['category_id_foreign'] : 0;
    $pror_id_foreign = !empty($_POST['pror_id_foreign']) ? $_POST['pror_id_foreign'] : 0;
    $adult_foreign = !empty($_POST['adult_foreign']) ? $_POST['adult_foreign'] : 0;
    $child_foreign = !empty($_POST['child_foreign']) ? $_POST['child_foreign'] : 0;
    $infant_foreign = !empty($_POST['infant_foreign']) ? $_POST['infant_foreign'] : 0;
    $foc_foreign = !empty($_POST['foc_foreign']) ? $_POST['foc_foreign'] : 0;
    $rate_adult_foreign = !empty($_POST['rate_adult_foreign']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_adult_foreign']) : 0;
    $rate_child_foreign = !empty($_POST['rate_child_foreign']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_child_foreign']) : 0;
    $rate_infant_foreign = !empty($_POST['rate_infant_foreign']) && $book_type == 1 ? preg_replace('(,)', '', $_POST['rate_infant_foreign']) : 0;
    $rate_total_foreign = !empty($_POST['rate_total_foreign']) ? preg_replace('(,)', '', $_POST['rate_total_foreign']) : 0;
    $private_rates_foreign = !empty($_POST['private_rates_foreign']) ? preg_replace('(,)', '', $_POST['private_rates_foreign']) : 0;

    $tran_adult = 0;
    $tran_child = 0;
    $tran_infant = 0;
    $tran_foc = 0;
    if ($customer_thai == 1) {
        $tran_adult = $tran_adult + $adult_thai;
        $tran_child = $tran_child + $child_thai;
        $tran_infant = $tran_infant + $infant_thai;
        $tran_foc = $tran_foc + $foc_thai;
    }
    if ($customer_foreign == 1) {
        $tran_adult = $tran_adult + $adult_foreign;
        $tran_child = $tran_child + $child_foreign;
        $tran_infant = $tran_infant + $infant_foreign;
        $tran_foc = $tran_foc + $foc_foreign;
    }

    # --- get value customer form --- #
    $customers = !empty($_POST['itinerary']) ? $_POST['itinerary'] : '';
    $cus_name = !empty($_POST['cus_name']) ? $_POST['cus_name'] : '';
    # --- get value Transfer from --- #
    $pickup_type = !empty($_POST['pickup_type']) ? $_POST['pickup_type'] : 0;
    $transfer_type = !empty($_POST['transfer_type']) ? $_POST['transfer_type'] : 0;
    $start_pickup = !empty($_POST['start_pickup']) ? $_POST['start_pickup'] : '00:00:00';
    $end_pickup = !empty($_POST['end_pickup']) ? $_POST['end_pickup'] : '00:00:00';
    $hotel_pickup = !empty($_POST['hotel_pickup']) ? $_POST['hotel_pickup'] : 0;
    $zone_pickup = !empty($_POST['zone_pickup']) ? $_POST['zone_pickup'] : 0;
    $pickup = !empty($_POST['pickup']) ? $_POST['pickup'] : 0;
    $hotel_outside = !empty($_POST['hotel_outside']) ? $_POST['hotel_outside'] : '';
    $zone_dropoff = !empty($_POST['zone_dropoff']) ? $_POST['zone_dropoff'] : 0;
    $dropoff_outside = !empty($_POST['dropoff_outside']) ? $_POST['dropoff_outside'] : '';
    $hotel_pickup_outside = !empty($_POST['hotel_pickup_outside']) ? $_POST['hotel_pickup_outside'] : '';
    $hotel_dropoff = empty($_POST['hotel_dropoff']) ? !empty($_POST['hotel_pickup']) ? $_POST['hotel_pickup'] : 0 : $_POST['hotel_dropoff'];
    $dropoff = empty($_POST['dropoff']) ? !empty($_POST['pickup']) ? $_POST['pickup'] : 0 : $_POST['dropoff'];
    $hotel_dropoff_outside = empty($_POST['hotel_dropoff_outside']) ? !empty($_POST['hotel_pickup_outside']) ? $_POST['hotel_pickup_outside'] : '' : $_POST['hotel_dropoff_outside'];
    $room_no = !empty($_POST['room_no']) ? $_POST['room_no'] : '';
    $trans_note = !empty($_POST['trans_note']) ? $_POST['trans_note'] : '';
    $include = !empty($_POST['include']) ? $_POST['include'] : 0;
    # --- get value rate transfer (Join) --- #
    $tran_rate_adult = !empty($_POST['tran_adult']) && $transfer_type == 1 ? $_POST['tran_adult'] : 0;
    $tran_rate_child = !empty($_POST['tran_child']) && $transfer_type == 1 ? $_POST['tran_child'] : 0;
    $tran_rate_infant = !empty($_POST['tran_infant']) && $transfer_type == 1 ? $_POST['tran_infant'] : 0;
    $tran_total_price = !empty($_POST['tran_total_price']) ? $_POST['tran_total_price'] : 0;
    # --- get value rate transfer (Private) --- #
    $transfers = !empty($_POST['transfers']) ? $_POST['transfers'] : '';
    # --- get value payment from --- #
    $payments = !empty($_POST['payments']) ? $_POST['payments'] : '';
    # --- get value extra chang from --- #
    $extra_charge = !empty($_POST['extra-charge']) ? $_POST['extra-charge'] : '';
    # --- check confirm agent --- #
    if (($agent != 'outside' && $agent > 0) && ($travel_date != '0000-00-00')) {
        $confirm_id = $bookObj->get_values('id', 'confirm_agent', 'agent_id = ' . $agent . ' AND travel_date	= "' . $travel_date . '"');
        if ($confirm_id != false && $confirm_id['id'] > 0) {
            $response = $bookObj->delete_confirm($confirm_id['id']);
        }
    }

    if ($quick > 0) {
        # --- chack insert agent --- #
        if ($agent == 'outside' && !empty($_POST['agent_outside'])) {
            $agent_out_id = $bookObj->insert_agent($_POST['agent_outside']);
        }

        $bo_id = $bookObj->insert_data($book_status, $book_type, $book_date, $book_time, ($agent == 'outside' && !empty($_POST['agent_outside'])) ? $agent_out_id : $agent, $voucher_no, $sender); // insert bookings
        
        $response = ($bo_id != FALSE && $bo_id > 0) ? $bookObj->insert_booking_no($bo_id, $bo_date, $bo_year, $bo_year_th, $bo_month, $bo_no, $bo_full) : FALSE; // insert bookings no
        
        $response = ($bo_id != FALSE && $bo_id > 0) ? $bookObj->insert_log('สร้าง Booking', 'หมายเลข booking no. ' . $bo_full, $bo_id, 1, $today) : FALSE; // insert log booking

        $bp_id = ($response != FALSE && $response > 0) ? $bookObj->insert_booking_product($travel_date, $bp_note, $book_type, $language_id, 1, $bo_id, $product_id) : FALSE; // insert booking products

        if ($customer_thai == 1) {
            $response = ($bp_id > 0 && $bp_id != FALSE) ? $bookObj->insert_booking_rate($adult_thai, $child_thai, $infant_thai, $foc_thai, $rate_adult_thai, $rate_child_thai, $rate_infant_thai, $private_rates_thai, $rate_total_thai, $category_id_thai, $bp_id, $pror_id_thai) : $response; // insert booking products rate
        }

        if ($customer_foreign == 1) {
            $response = ($bp_id > 0 && $bp_id != FALSE) ? $bookObj->insert_booking_rate($adult_foreign, $child_foreign, $infant_foreign, $foc_foreign, $rate_adult_foreign, $rate_child_foreign, $rate_infant_foreign, $private_rates_foreign, $rate_total_foreign, $category_id_foreign, $bp_id, $pror_id_foreign) : $response; // insert booking products rate
        }

        $bt_id = ($response > 0 && $response != false) ? $bookObj->insert_booking_transfer($tran_adult, $tran_child, $tran_infant, $tran_foc, $start_pickup, $end_pickup, $hotel_outside, (!empty($dropoff_outside)) ? $dropoff_outside : $hotel_outside, $room_no, '', $zone_pickup, ($zone_dropoff > 0) ? $zone_dropoff : $zone_pickup, ($hotel_pickup != 'outside') ? $hotel_pickup : 0, ($hotel_dropoff != 'outside') ? $hotel_dropoff : 0, 1, $include, $bp_id, 0) : false; // insert booking transfer
        
        $response = ($bt_id > 0 && $bt_id != false) ? $bookObj->insert_transfer_rate(0, 0, 0, 0, $bt_id, 0) : false; // insert booking transfer rate (join)

        if (!empty($_POST['customers']['cus_age'])) {
            for ($i = 0; $i < count($_POST['customers']['cus_age']); $i++) {
                $response = ($response > 0 && $response != false) && (!empty($_POST['customers']['cus_name'][$i])) ? $bookObj->insert_customer($_POST['customers']['cus_name'][$i], $_POST['customers']['cus_birth_date'][$i], $_POST['customers']['id_card'][$i], $i == 0 ? $_POST['telephone'] : '', $address = '', !empty($_POST['customers']['cus_age'][$i]) ? $_POST['customers']['cus_age'][$i] : 0, 0, $email = '', $i == 0 ? 1 : 0, $bo_id, !empty($_POST['customers']['cus_nationality_id'][$i]) ? $_POST['customers']['cus_nationality_id'][$i] : 0) : $response;
            }
        }

        $response = $bookObj->insert_booking_paid($bo_id, '0000-00-00', $cot, '', '', 0, 0, $cot > 0 ? 4 : 2, $fileArray = []); // insert booking payment (paid)

        if (!empty($extra_charge) && count($extra_charge) > 0 && $bo_id > 0) {
            for ($i = 0; $i < count($extra_charge); $i++) {
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

                $response = ($response > 0 && $response != false) && ($extra > 0 || !empty($extra_name)) && ($extra_type > 0) ? $bookObj->insert_booking_extra($bo_id, $extra, $extra_name, $extra_type, $extra_adult, $extra_rate_adult, $extra_child, $extra_rate_child, $extra_infant, $extra_rate_infant, $extra_num_private, $extra_rate_private) : $response;
            }
        }
    } else {
        # --- chack insert agent --- #
        if ($agent == 'outside' && !empty($_POST['agent_outside'])) {
            $agent_out_id = $bookObj->insert_agent($_POST['agent_outside']);
        }

        $bo_id = $bookObj->insert_data($book_status, $book_type, $book_date, $book_time, $agent, $voucher_no, $sender); // insert bookings

        $response = ($bo_id != FALSE && $bo_id > 0) ? $bookObj->insert_booking_no($bo_id, $bo_date, $bo_year, $bo_year_th, $bo_month, $bo_no, $bo_full) : FALSE; // insert bookings no

        $bp_id = ($response != FALSE && $response > 0) ? $bookObj->insert_booking_product($travel_date, $bp_note, $book_type, $language_id, 1, $bo_id, $product_id) : FALSE; // insert booking products

        $response = ($bp_id > 0 && $bp_id != FALSE) ? $bookObj->insert_booking_rate($adult, $child, $infant, $foc, $rate_adult, $rate_child, $rate_infant, $rate_total, 0, $category_id, $bp_id, $pror_id) : false; // insert booking products rate

        $response = ($response > 0 && $response != false) && (!empty($cus_name)) ? $bookObj->insert_customer($cus_name, '0000-00-00', '', !empty($_POST['telephone']) ? $_POST['telephone'] : '', $address = '', 1, 0, $email = '', 1, $bo_id, 0) : $response;
        // if ($customers != '') {
        //     for ($i = 0; $i < count($customers); $i++) {
        //         $head = $i == 0 ? 1 : 0;
        //         $response = ($response > 0 && $response != false) && !empty($customers[$i]['cus_name']) ? $bookObj->insert_customer($customers[$i]['cus_name'], $customers[$i]['cus_birth_date'], $customers[$i]['id_card'], $customers[$i]['cus_telephone'], $address = '', !empty($customers[$i]['cus_age']) ? $customers[$i]['cus_age'] : 0, !empty($customers[$i]['cus_type']) ? $customers[$i]['cus_type'] : 0, $email = '', $head, $bo_id, !empty($customers[$i]['cus_nationality_id']) ? $customers[$i]['cus_nationality_id'] : 0) : false; // insert customers
        //     }
        // }

        # --- check insert hotel outside --- #
        if (!empty($hotel_pickup_outside)) {
            $hotel_pickup = $bookObj->insert_hotel($hotel_pickup_outside, $pickup);
            $hotel_dropoff = ($hotel_pickup != false && $hotel_pickup > 0) ? $hotel_pickup : $hotel_dropoff;
            $hotel_pickup_outside = ($hotel_pickup != false && $hotel_pickup > 0) ? '' : $hotel_pickup_outside;
            $hotel_dropoff_outside = ($hotel_pickup != false && $hotel_pickup > 0) ? '' : $hotel_dropoff_outside;
        }
        // $bt_id = ($response > 0 && $response != false) ? $bookObj->insert_booking_transfer($tran_adult, $tran_child, $tran_infant, $tran_foc, $start_pickup, $end_pickup, $hotel_pickup_outside, $hotel_dropoff_outside, $room_no, $trans_note, $pickup, $dropoff, $hotel_pickup, $hotel_dropoff, $transfer_type, $pickup_type, $bp_id, $category_id) : false; // insert booking transfer
        $bt_id = ($response > 0 && $response != false) ? $bookObj->insert_booking_transfer($adult, $child, $infant, $foc, $start_pickup, $end_pickup, $hotel_outside, (!empty($dropoff_outside)) ? $dropoff_outside : $hotel_outside, $room_no, '', $zone_pickup, ($zone_dropoff > 0) ? $zone_dropoff : $zone_pickup, ($hotel_pickup != 'outside') ? $hotel_pickup : 0, ($hotel_dropoff != 'outside') ? $hotel_dropoff : 0, 1, 1, $bp_id, $category_id) : false; // insert booking transfer

        if ($transfer_type == 2 && $transfers != '' && !empty($block_transfer)) {
            for ($i = 0; $i < count($transfers); $i++) {
                $response = ($bt_id > 0 && $bt_id != false) && !empty($transfers[$i]['cars_category']) ? $bookObj->insert_transfer_rate($tran_rate_adult, $tran_rate_child, $tran_rate_infant, $transfers[$i]['cars_total'], $bt_id, $transfers[$i]['cars_category']) : false; // insert booking transfer rate (private)
            }
        } elseif ($transfer_type == 1) {
            $response = ($bt_id > 0 && $bt_id != false) ? $bookObj->insert_transfer_rate($tran_rate_adult, $tran_rate_child, $tran_rate_infant, $tran_total_price, $bt_id, $cars_category = 0) : false; // insert booking transfer rate (join)
        }

        if (!empty($extra_charge) && count($extra_charge) > 0 && $bo_id > 0) {
            for ($i = 0; $i < count($extra_charge); $i++) {
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

                $response = ($response > 0 && $response != false) && ($extra > 0 || !empty($extra_name)) && ($extra_type > 0) ? $bookObj->insert_booking_extra($bo_id, $extra, $extra_name, $extra_type, $extra_adult, $extra_rate_adult, $extra_child, $extra_rate_child, $extra_infant, $extra_rate_infant, $extra_num_private, $extra_rate_private) : $response;
            }
        }
    }

    echo $response != FALSE && $response > 0 ? $bo_id : FALSE;
} else {
    echo $response = FALSE;
}

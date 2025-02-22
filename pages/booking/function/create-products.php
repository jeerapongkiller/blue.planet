<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();
$response = false;

if (isset($_POST['bp_action']) && $_POST['bp_action'] == "create" && !empty($_POST['product_id']) && !empty($_POST['category_id'])) {
    # --- get value from booking --- #
    $bo_id = !empty($_POST['bo_id']) ? $_POST['bo_id'] : 0;
    $voucher_no_agent = $_POST['voucher_no_agent'] != "" ? $_POST['voucher_no_agent'] : '';
    $sender = $_POST['sender'] != "" ? $_POST['sender'] : '';
    $book_status = $_POST['book_status'] != "" ? $_POST['book_status'] : 0;
    $company_id = !empty($_POST['agent']) ? $_POST['agent'] : 0;
    # --- get value from program --- #
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : 0;
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : 0;
    $pror_id = !empty($_POST['pror_id']) ? $_POST['pror_id'] : 0;
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';
    $bp_note = !empty($_POST['bp_note']) ? $_POST['bp_note'] : '';
    $adult = !empty($_POST['adult']) ? $_POST['adult'] : 0;
    $child = !empty($_POST['child']) ? $_POST['child'] : 0;
    $infant = !empty($_POST['infant']) ? $_POST['infant'] : 0;
    $foc = !empty($_POST['foc']) ? $_POST['foc'] : 0;
    # --- (rate product and transfer) --- #
    $booking_type_id = !empty($_POST['booking_type_id']) ? $_POST['booking_type_id'] : 0;
    $private_type = 0;
    $rate_adult = !empty($_POST['rate_adult']) && $booking_type_id == 1 ? preg_replace('(,)', '', $_POST['rate_adult']) : 0;
    $rate_child = !empty($_POST['rate_child']) && $booking_type_id == 1 ? preg_replace('(,)', '', $_POST['rate_child']) : 0;
    $rate_infant = !empty($_POST['rate_infant']) && $booking_type_id == 1 ? preg_replace('(,)', '', $_POST['rate_infant']) : 0;
    $rate_total = !empty($_POST['rate_total']) ? preg_replace('(,)', '', $_POST['rate_total']) : 0;
    # --- get value from customer --- #
    $customers = !empty($_POST['itinerary']) ? $_POST['itinerary'] : '';
    # --- get value from Transfer --- #
    $pickup_type = !empty($_POST['pickup_type']) ? $_POST['pickup_type'] : 0;
    $transfer_type = !empty($_POST['transfer_type']) ? $_POST['transfer_type'] : 0;
    $pickup = !empty($_POST['pickup']) ? $_POST['pickup'] : 0;
    $dropoff = empty($_POST['dropoff']) ? !empty($_POST['pickup']) ? $_POST['pickup'] : 0 : $_POST['dropoff'];
    $hotel_pickup = !empty($_POST['hotel_pickup']) ? $_POST['hotel_pickup'] : 0;
    $hotel_pickup_outside = !empty($_POST['hotel_pickup_outside']) ? $_POST['hotel_pickup_outside'] : '';
    $hotel_dropoff = empty($_POST['hotel_dropoff']) ? !empty($_POST['hotel_pickup']) ? $_POST['hotel_pickup'] : 0 : $_POST['hotel_dropoff'];
    $hotel_dropoff_outside = empty($_POST['hotel_dropoff_outside']) ? !empty($_POST['hotel_pickup_outside']) ? $_POST['hotel_pickup_outside'] : '' : $_POST['hotel_dropoff_outside'];
    $room_no = !empty($_POST['room_no']) ? $_POST['room_no'] : '';
    $start_pickup = !empty($_POST['start_pickup']) ? $_POST['start_pickup'] : '00:00:00';
    $end_pickup = !empty($_POST['end_pickup']) ? $_POST['end_pickup'] : '00:00:00';
    $trans_note = !empty($_POST['trans_note']) ? $_POST['trans_note'] : '';
    $tran_adult = !empty($_POST['tran_adult_pax']) ? $_POST['tran_adult_pax'] : 0;
    $tran_child = !empty($_POST['tran_child_pax']) ? $_POST['tran_child_pax'] : 0;
    $tran_infant = !empty($_POST['tran_infant_pax']) ? $_POST['tran_infant_pax'] : 0;
    $tran_foc = !empty($_POST['tran_foc_pax']) ? $_POST['tran_foc_pax'] : 0;
    # --- get value rate transfer (Join) --- #
    $tran_rate_adult = !empty($_POST['tran_adult']) && $transfer_type == 1 ? $_POST['tran_adult'] : 0;
    $tran_rate_child = !empty($_POST['tran_child']) && $transfer_type == 1 ? $_POST['tran_child'] : 0;
    $tran_rate_infant = !empty($_POST['tran_infant']) && $transfer_type == 1 ? $_POST['tran_infant'] : 0;
    # --- get value rate transfer (Private) --- #
    $cars_category = !empty($_POST['array_car']) ? $_POST['array_car'] : 0;
    $rate_private = !empty($_POST['array_rate_private']) ? $_POST['array_rate_private'] : 0;
    $trans_total = !empty($_POST['tran_total_price']) ? preg_replace('(,)', '', $_POST['tran_total_price']) : 0;
    # --- get value extra chang --- #
    $extar_chang = !empty($_POST['extar-chang']) ? $_POST['extar-chang'] : '';

    # --- update data booking booking --- #
    $response = $bookObj->update_data($bo_id, $book_status, $voucher_no_agent, $sender, $company_id, $booking_type_id);
    # --- update data booking programe --- #
    $bp_id = $bookObj->insert_booking_product($travel_date, $adult, $child, $infant, $foc, $bp_note, $private_type, $booking_type_id, $bo_id, $product_id, $category_id);
    $response = ($bp_id > 0 && $bp_id != false) ? $bookObj->insert_booking_rate($rate_adult, $rate_child, $rate_infant, $rate_total, $bp_id, $pror_id) : false;
    if ($response > 0 && $response != false && $customers != '') {
        for ($i = 0; $i < count($customers); $i++) {
            $head = $i == 0 ? 1 : 0;
            $response = ($response > 0 && $response != false) ? $bookObj->insert_customer($customers[$i]['cus_name'], $customers[$i]['cus_birth_date'], $customers[$i]['id_card'], $customers[$i]['cus_telephone'], $address = '', !empty($customers[$i]['cus_age']) ? $customers[$i]['cus_age'] : 0, !empty($customers[$i]['cus_type']) ? $customers[$i]['cus_type'] : 0, $email = '', $head, $bo_id, 0) : false;
        }
    }
    if ($response > 0 && $response != false) {
        $bt_id = $bookObj->insert_booking_transfer($tran_adult, $tran_child, $tran_infant, $tran_foc, $start_pickup, $end_pickup, $hotel_pickup_outside, $hotel_dropoff_outside, $room_no, $trans_note, $pickup, $dropoff, $hotel_pickup, $hotel_dropoff, $transfer_type, $pickup_type, $bp_id, $category_id);
        if ($transfer_type == 1) {
            $response = ($bt_id > 0 && $bt_id != false) ? $bookObj->insert_transfer_rate($tran_rate_adult, $tran_rate_child, $tran_rate_infant, $rate_private, $bt_id, $cars_category = 0) : false;
        } else {
            for ($i = 0; $i < count($cars_category); $i++) {
                $response = ($bt_id > 0 && $bt_id != false) ? $bookObj->insert_transfer_rate($tran_rate_adult, $tran_rate_child, $tran_rate_infant, preg_replace('(,)', '', $rate_private[$i]), $bt_id, $cars_category[$i]) : false;
            }
        }
    }
    if (!empty($bo_id) && ($response > 0 && $response != false) && !empty($extar_chang)) {
        for ($i = 0; $i < count($extar_chang); $i++) {
            $response = $bookObj->insert_booking_extra($bo_id, $extar_chang[$i]['extc_name'], preg_replace('(,)', '', $extar_chang[$i]['extc_total']));
        }
    }

    echo ($response > 0 && $response != false) ? $response : false;
} else {
    echo $response = false;
}

// echo '</br> <b>Program</b> <hr class="mt-0 mb-0">';
// echo 'bo_id : ' . $bo_id;
// echo '</br> product_id : ' . $product_id;
// echo '</br> category_id : ' . $category_id;
// echo '</br> pror_id : ' . $pror_id;
// echo '</br> travel_date : ' . $travel_date;
// echo '</br> bp_note : ' . $bp_note;
// echo '</br> adult : ' . $adult;
// echo '</br> child : ' . $child;
// echo '</br> infant : ' . $infant;
// echo '</br> booking_type_id : ' . $booking_type_id;
// echo '</br> private_type : ' . $private_type;
// echo '</br> rate_adult : ' . $rate_adult;
// echo '</br> rate_child : ' . $rate_child;
// echo '</br> rate_infant : ' . $rate_infant;
// echo '</br> rate_total : ' . $rate_total;

// echo '<br><br><b> Customer </b><hr class="mt-0 mb-0">';
// echo 'id_card : ';
// print_r($head);
// echo 'id_card : ';
// print_r($id_card);
// echo '</br> cus_name : ';
// print_r($cus_name);
// echo '</br> cus_telephone : ';
// print_r($cus_telephone);
// echo '</br> cus_email : ';
// print_r($cus_email);
// echo '</br> cus_nationality : ';
// print_r($cus_nationality);
// echo '</br> cus_whatsapp : ';
// print_r($cus_whatsapp);
// echo '</br> cus_facebook : ';
// print_r($cus_facebook);
// echo '</br> cus_birth_date : ';
// print_r($cus_birth_date);
// echo '</br> cus_address : ';
// print_r($cus_address);

// echo '<br><br><b> Transfer </b><hr class="mt-0 mb-0">';
// echo 'pickup_type : ' . $pickup_type;
// echo '</br> transfer_type : ' . $transfer_type;
// echo '</br> pickup : ' . $pickup;
// echo '</br> dropoff : ' . $dropoff;
// echo '</br> hotel_pickup : ' . $hotel_pickup;
// echo '</br> hotel_dropoff : ' . $hotel_dropoff;
// echo '</br> room_no : ' . $room_no;
// echo '</br> start_pickup : ' . $start_pickup;
// echo '</br> end_pickup : ' . $end_pickup;
// echo '</br> trans_note : ' . $trans_note;
// echo '</br> tran_adult : ' . $tran_adult;
// echo '</br> tran_child : ' . $tran_child;
// echo '</br> tran_infant : ' . $tran_infant;
// echo '</br> tran_rate_adult : ' . $tran_rate_adult;
// echo '</br> tran_rate_child : ' . $tran_rate_child;
// echo '</br> tran_rate_infant : ' . $tran_rate_infant;
// echo '</br> cars_category : ';
// print_r($cars_category);
// echo '</br> rate_private : ';
// print_r($rate_private);
// echo '</br> trans_total : ' . $trans_total;

// echo '<br><br><b> Extar Chang </b><hr class="mt-0 mb-0">';
// echo 'extc_name : ' . $extc_name;
// echo '</br> extc_total : ' . $extc_total;

// echo '<br><br><br>';

<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();
$response = FALSE;

function notify_message($message, $token)
{
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array(
                'http' => array(
                        'method' => 'POST',
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                                . "Authorization: Bearer " . $token . "\r\n"
                                . "Content-Length: " . strlen($queryData) . "\r\n",
                        'content' => $queryData
                ),
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents(LINE_API, FALSE, $context);
        $res = json_decode($result);
        return $res;
}

if (!empty($_POST['id']) && $_POST['id'] > 0) {
        $bookings = $bookObj->get_data($_POST['id']);

        $start_pickup = !empty($bookings[0]['start_pickup']) ? date('H:i', strtotime($bookings[0]['start_pickup'])) : '00:00';
        $end_pickup = !empty($bookings[0]['end_pickup']) ? date('H:i', strtotime($bookings[0]['end_pickup'])) : '00:00';
        $booker_name = !empty($bookings[0]['booker_id']) ? $bookings[0]['booker_fname'] . ' ' . $bookings[0]['booker_lname'] : '';
        $staby_name = !empty($bookings[0]['status_by']) ? $bookings[0]['stabyFname'] . ' ' . $bookings[0]['stabyLname'] : '';
        $bookings_type_id = !empty(!empty($bookings[0]['booking_type_id'])) ? $bookings[0]['booking_type_id'] : 0;
        $status_name = '';
        switch ($bookings_type_id) {
                case '1':
                        $status_name = 'Confirm';
                        break;
                case '3':
                        $status_name = 'Canceled';
                        break;
        }
        $transfer = !empty($bookings[0]['pickup_type']) && $bookings[0]['pickup_type'] == 1 ? "Yes" : "No";

        $voucher_no = "Voucher No. : " . $bookings[0]['voucher_no_agent'];
        $agent_select = "Agent : " . $bookings[0]['comp_name'];
        $product_name = "Programe : " . $bookings[0]['product_name'];
        $traveldate = "Date : " . date("d-m-Y", strtotime($bookings[0]['travel_date']));
        $customers = "Customer : " . $bookings[0]['cus_name'];
        $totalpeople = "Adult(s): " . $bookings[0]['bpr_adult'] . " Child(s): " . $bookings[0]['bpr_child'] . " Infant(s): " . $bookings[0]['bpr_infant'];
        $transfer_select = "Transfer: " . $transfer;
        $hotel_select = "Hotel : " . $bookings[0]['hotel_pickup'];
        $room_select = "Room : " . $bookings[0]['room_no'];
        $pickuptime = "Pick up Time : " . $start_pickup . ' - ' . $end_pickup;
        $payment = ($bookings[0]['payment_id'] == 4) ? "Payment : " . $bookings[0]['bookpay_name'] . ' (' . number_format($bookings[0]['payment_paid']) . ')' : "Payment : " . $bookings[0]['bookpay_name'];
        $note = "Note : " . $bookings[0]['bp_note'];
        $booking_by = "Booking by : " . $booker_name;
        $status_by = $status_name . " by : " . $staby_name;

        $password = "hvk";
        define('LINE_API', "https://notify-api.line.me/api/notify");

        $token = "xLbM5uWEqiOZ6pvUt3ItTTRO8J25VqOaEsaYjCMhZ89"; //ใส่Token ที่copy เอาไว้

        $str = "\r\n" . $status_name . " Booking " .
                "\r\n" . $voucher_no .
                "\r\n" . $agent_select .
                "\r\n" . $product_name .
                "\r\n" . $traveldate .
                "\r\n" . $customers .
                "\r\n" . $totalpeople .
                "\r\n" . $transfer_select .
                "\r\n" . $hotel_select .
                "\r\n" . $room_select .
                "\r\n" . $pickuptime .
                "\r\n" . $payment;
        $str .= !empty($bookings[0]['bp_note']) ?  "\r\n" . $note : "";
        $str .= "\r\n" . $booking_by .
                "\r\n" . $status_by .
                "\r\nThank You";

        // ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร

        // $res = notify_message($str, $token);
        // print_r($str);

        echo $response = TRUE;
} else {
        echo $response = FALSE;
}

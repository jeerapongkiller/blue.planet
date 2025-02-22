<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();
$response = FALSE;

if (isset($_POST['paid_action']) && $_POST['paid_action'] == "create" && isset($_POST['paid_bo_id'])) {
    // get value from ajax
    $bo_id = !empty($_POST['paid_bo_id']) ? $_POST['paid_bo_id'] : 0;
    $book_payment = !empty($_POST['book_payment']) ? $_POST['book_payment'] : 0;
    $paid_date = !empty($_POST['paid_date']) ? $_POST['paid_date'] : '0000-00-00';
    $paid_time = !empty($_POST['paid_time']) ? $_POST['paid_time'] : '00:00:00';
    $payments_type = !empty($_POST['payments_type']) ? $_POST['payments_type'] : 0;
    $bank_account = !empty($_POST['bank_account']) ? $_POST['bank_account'] : 0;
    $card_no = !empty($_POST['card_no']) ? $_POST['card_no'] : 0;
    $note = $_POST['note'] != "" ? $_POST['note'] : '';
    $total_paid = !empty($_POST['total_paid']) ? preg_replace('(,)', '', $_POST['total_paid']) : 0;
    $paymnet_detail = !empty($_POST['paymnet_detail']) ? 1 : 0;

    // get details of the uploaded file
    $countfiles = count($_FILES['photo']['name']);
    $fileArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $fileArray['fileTmpPath'][$i] = $_FILES['photo']['tmp_name'][$i];
        $fileArray['fileName'][$i] = $_FILES['photo']['name'][$i];
        $fileArray['fileSize'][$i] = $_FILES['photo']['size'][$i];
        $fileArray['fileDir'][$i] = '../../../storage/uploads/booking/paid/';
        $fileArray['fileBefore'][$i] = '';
        $fileArray['fileDelete'][$i] = 0;
    }

    $booking_paid_id = $bookObj->insert_booking_paid($bo_id, $book_payment);
    $response = ($paymnet_detail > 0 && $booking_paid_id != FALSE && $booking_paid_id > 0) ? $bookObj->insert_booking_paid_detail($booking_paid_id, $paid_date, $paid_time, $total_paid, $card_no, $note, $payments_type, $bank_account, $fileArray) : FALSE;

    echo ($booking_paid_id != FALSE && $booking_paid_id > 0) || ($response != FALSE && $response > 0) ? TRUE : FALSE;
} else {
    echo $response = FALSE;
}
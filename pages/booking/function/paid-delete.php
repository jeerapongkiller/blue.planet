<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();
$response = FALSE;

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['paid_id'])) {
    // get value from ajax
    $paid_id = $_POST['paid_id'] > 0 ? $_POST['paid_id'] : 0;
    $paid_detail_id = $_POST['paid_detail_id'] > 0 ? $_POST['paid_detail_id'] : 0;

    if ($paid_id > 0) {
        $response = $bookObj->delete_booking_paid($paid_id);
    }

    if ($paid_detail_id > 0) {
        $response = $bookObj->delete_booking_paid_detail($paid_detail_id);
    }

    echo $response;
} else {
    echo $response = false;
}

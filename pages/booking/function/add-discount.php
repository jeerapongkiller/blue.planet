<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "check" && isset($_POST['bp_id']) && isset($_POST['discount'])) {
    # --- get value from ajax --- #
    $bp_id = !empty($_POST['bp_id']) ? $_POST['bp_id'] : 0;
    $discount = !empty($_POST['discount']) ? preg_replace('(,)', '', $_POST['discount']) : 0;
    # --- update booking rates --- #
    $response = $bookObj->update_booking_discount($bp_id, $discount);

    echo $response;
} else {
    echo $response = FALSE;
}
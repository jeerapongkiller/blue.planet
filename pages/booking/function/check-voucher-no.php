<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Booking.php';

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "check" && !empty($_POST['agent']) && !empty($_POST['voucher_no'])) {
    // get value from ajax
    $bo_id = !empty($_POST['bo_id']) ? $_POST['bo_id'] : 0;
    $agent = !empty($_POST['agent']) ? $_POST['agent'] : 0;
    $voucher_no = !empty($_POST['voucher_no']) ? $_POST['voucher_no'] : '';

    $response = $bookObj->check_doubly_agent($bo_id, $agent, $voucher_no);

    echo $response;
}
<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Booking.php';

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "check" && !empty($_POST['agent']) && !empty($_POST['voucher_no_agent'])) {
    // get value from ajax
    $agent = !empty($_POST['agent']) ? $_POST['agent'] : 0;
    $voucher_no_agent = !empty($_POST['voucher_no_agent']) ? $_POST['voucher_no_agent'] : '';

    $response = $bookObj->check_doubly_agent($agent, $voucher_no_agent);

    echo $response;
}
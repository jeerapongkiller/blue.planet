<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$orderObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "delete" && (!empty($_POST['manage_id']))) {
    // get value from ajax
    $response = FALSE;
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;

    $response = $orderObj->delete_order_transfer($manage_id);
    $response = $orderObj->delete_booking_order_transfer($manage_id, 0);

    echo $response;
} else {
    echo $response = FALSE;
}

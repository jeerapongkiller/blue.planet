<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$orderObj = new Order();

if (isset($_POST['action_park']) && $_POST['action_park'] == "create" && !empty($_POST['orboat_id'])) {
    // get value from ajax
    $response = FALSE;
    $order_boat_id = !empty($_POST['orboat_id']) ? $_POST['orboat_id'] : 0;
    $park_id = !empty($_POST['parks']) ? $_POST['parks'] : 0;
    $adult_eng = !empty($_POST['rate_adult_eng']) ? preg_replace('(,)', '', $_POST['rate_adult_eng']) : 0;
    $child_eng = !empty($_POST['rate_child_eng']) ? preg_replace('(,)', '', $_POST['rate_child_eng']) : 0;
    $adult_th = !empty($_POST['rate_adult_th']) ? preg_replace('(,)', '', $_POST['rate_adult_th']) : 0;
    $child_th = !empty($_POST['rate_child_th']) ? preg_replace('(,)', '', $_POST['rate_child_th']) : 0;
    $total = !empty($_POST['total_park']) ? preg_replace('(,)', '', $_POST['total_park']) : 0;
    $note = !empty($_POST['note']) ? $_POST['note'] : '';

    $response = $orderObj->insert_order_park($adult_eng, $child_eng, $adult_th, $child_th, $total, $note, $park_id, $order_boat_id);

    echo $response != false && $response > 0 ? true : false;
} else {
    echo $response = FALSE;
}
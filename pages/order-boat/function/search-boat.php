<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $response = array();
    $boat_id = $_POST['boat_id'] != "" ? $_POST['boat_id'] : 0;
    $arr_boats = $_POST['arr_boats'] != "" ? json_decode($_POST['arr_boats'], true) : 0;
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';

    $boats = $manageObj->show_boats();
    foreach ($boats as $boat) {
        // if (empty($arr_boats[$programe]['id']) || $boat_id == $boat['id']) {
        //     $response['id'][] = $boat['id'];
        //     $response['name'][] = $boat['name'];
        //     $response['refcode'][] = $boat['refcode'];
        // } elseif (!empty($arr_boats[$programe]['id']) && in_array($boat['id'], $arr_boats[$programe]['id']) == false) {
        //     $response['id'][] = $boat['id'];
        //     $response['name'][] = $boat['name'];
        //     $response['refcode'][] = $boat['refcode'];
        // }
        if (!empty($arr_boats['id']) && in_array($boat['id'], $arr_boats['id']) == false) {
            $response['id'][] = $boat['id'];
            $response['name'][] = $boat['name'];
            $response['refcode'][] = $boat['refcode'];
        } elseif (empty($arr_boats['id']) || $boat_id == $boat['id']) {
            $response['id'][] = $boat['id'];
            $response['name'][] = $boat['name'];
            $response['refcode'][] = $boat['refcode'];
        }
    }

    echo !empty($response) ? json_encode($response) : false;
} else {
    echo $response = false;
}

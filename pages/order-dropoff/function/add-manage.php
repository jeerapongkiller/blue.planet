<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$orderObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "add" && !empty($_POST['cars']) && !empty($_POST['bt_id'])) {
    // get value from ajax
    $response = FALSE;
    $arrange = 1;
    $cars = !empty($_POST['cars']) ? ($_POST['cars'] != 'outside') ? $_POST['cars'] : 0 : 0;
    $car_name = !empty($_POST['car_name']) ? $_POST['car_name'] : '';
    $drivers = 0;
    $driver_name = !empty($_POST['driver_name']) ? $_POST['driver_name'] : '';
    $guides = !empty($_POST['guides']) ? ($_POST['guides'] != 'outside') ? $_POST['guides'] : 0 : 0;
    $guide_name = !empty($_POST['guide_name']) ? $_POST['guide_name'] : '';
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $price = !empty($_POST['price']) ? $_POST['price'] : 0;
    $percent = !empty($_POST['percent']) ? $_POST['percent'] : 0;
    $date_travel = !empty($_POST['date_travel']) ? $_POST['date_travel'] : '0000-00-00';
    $bt_id = !empty($_POST['bt_id']) ? $_POST['bt_id'] : 0;
    $data = json_decode($bt_id, true);

    $manage_id = $orderObj->insert_order_transfer($drivers, $cars, $guides, $driver_name, $car_name, $guide_name, $date_travel, $note, $return = 2, $price, $percent);
    if ($manage_id != false && $manage_id > 0 && !empty($data)) {
        for ($i = 0; $i < count($data); $i++) {
            $response = $orderObj->insert_booking_order_transfer($manage_id, $arrange, $data[$i]);
            $arrange++;
        }
    }

    echo $response;
} else {
    echo $response = FALSE;
}

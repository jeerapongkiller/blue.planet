<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$orderObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "edit" && (!empty($_POST['order_id']))) {
    // get value from ajax
    $response = FALSE;
    $arrange = 1;
    $order_id = !empty($_POST['order_id']) ? $_POST['order_id'] : 0;
    $cars = !empty($_POST['cars']) ? ($_POST['cars'] != 'outside') ? $_POST['cars'] : 0 : 0;
    $car_name = !empty($_POST['car_name']) ? $_POST['car_name'] : '';
    $drivers = 0;
    $driver_name = !empty($_POST['driver_name']) ? $_POST['driver_name'] : '';
    $guides = !empty($_POST['guides']) ? ($_POST['guides'] != 'outside') ? $_POST['guides'] : 0 : 0;
    $guide_name = !empty($_POST['guide_name']) ? $_POST['guide_name'] : '';
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $return = !empty($_POST['return']) ? $_POST['return'] : 1;
    $price = !empty($_POST['price']) ? $_POST['price'] : 0;
    $percent = !empty($_POST['percent']) ? $_POST['percent'] : 0;

    $bt_id = !empty($_POST['bt_id']) ? $_POST['bt_id'] : 0;
    $data = json_decode($bt_id, true);

    $before_id = !empty($_POST['before_id']) ? $_POST['before_id'] : 0;
    $before = json_decode($before_id, true);

    $response = $orderObj->update_order_transfer($drivers, $cars, $guides, $driver_name, $car_name, $guide_name, $note, $price, $percent, $order_id);

    if (count($before) > 0) {
        for ($i = 0; $i < count($before); $i++) {
            if (in_array($before[$i], $data) == false) {
                $response = $orderObj->delete_booking_order_transfer($order_id, $before[$i]);
                // echo ' delete : ' . $before[$i] . '</br>';
            }
        }
    }

    if (count($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
            if (in_array($data[$i], $before) == false) {
                // echo ' insert : ' . $data[$i] . '</br>';
                $response = $orderObj->insert_booking_order_transfer($order_id, 0, $data[$i]);
            }
        }
        for ($i = 0; $i < count($data); $i++) {
            // echo ' update : ' . $data[$i] . ' arrange : ' . $arrange . '</br>';
            $response = $orderObj->update_booking_order_transfer($order_id, $arrange, $data[$i]);
            $arrange++;
        }
    }

    echo $response;
} else {
    echo $response = FALSE;
}

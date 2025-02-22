<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Manage.php');

$manageObj = new Manage();

if (isset($_POST['action']) && $_POST['action'] == "create" && (!empty($_POST['drivers']) || !empty($_POST['cars']))) {
    // get value from ajax
    $response = FALSE;
    $arrange = 1;
    $car_id = !empty($_POST['cars']) ? ($_POST['cars'] != 'outside') ? $_POST['cars'] : 0 : 0;
    $outside_car = !empty($_POST['car_name']) ? $_POST['car_name'] : '';
    $driver_id = !empty($_POST['drivers']) ? ($_POST['drivers'] != 'outside') ? $_POST['drivers'] : 0 : 0;
    $outside_driver = !empty($_POST['driver_name']) ? $_POST['driver_name'] : '';
    $guide_id = !empty($_POST['guides']) ? ($_POST['guides'] != 'outside') ? $_POST['guides'] : 0 : 0;
    $outside_guide = !empty($_POST['guide_name']) ? $_POST['guide_name'] : '';
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $return = !empty($_POST['return']) ? $_POST['return'] : 0;
    $date_travel = !empty($_POST['date_travel']) ? $_POST['date_travel'] : '0000-00-00';
    $bt_id = !empty($_POST['bt_id']) ? $_POST['bt_id'] : 0;
    $data = json_decode($bt_id, true);

    $manage_id = $manageObj->insert_manage_transfer($outside_driver, $outside_car, $outside_guide, $date_travel, $note, $return, $driver_id, $car_id, $guide_id);
    if($manage_id != false && $manage_id > 0 && !empty($data)){
        for ($i = 0; $i < count($data); $i++) {
            $response = $manageObj->update_booking_transfer($manage_id, $arrange, $data[$i]);
            $arrange++;
        }
    }

    echo $response;
} else {
    echo $response = FALSE;
}
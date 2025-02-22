<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Manage.php');

$manageObj = new Manage();

if (isset($_POST['action']) && $_POST['action'] == "edit" && (!empty($_POST['manage_id']))) {
    // get value from ajax
    $response = TRUE;
    $arrange = 1;
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $return = !empty($_POST['return']) ? $_POST['return'] : 0;
    $car_id = !empty($_POST['cars']) ? $_POST['cars'] : 0;
    $driver_id = !empty($_POST['drivers']) ? $_POST['drivers'] : 0;
    $guide_id = !empty($_POST['guides']) ? $_POST['guides'] : 0;
    $outside_car = !empty($_POST['car_outside']) ? $_POST['car_outside'] : '';
    $outside_driver = !empty($_POST['driver_outside']) ? $_POST['driver_outside'] : '';
    $outside_guide = !empty($_POST['guide_outside']) ? $_POST['guide_outside'] : '';
    $date_travel = !empty($_POST['date_travel']) ? $_POST['date_travel'] : '0000-00-00';
    $note = '';
    $bt_id = !empty($_POST['bt_id']) ? $_POST['bt_id'] : 0;
    $data = json_decode($bt_id, true);

    $before_id = !empty($_POST['before_id']) ? $_POST['before_id'] : 0;
    $before = json_decode($before_id, true);

    $response = $manageObj->update_manage_transfer($outside_driver, $outside_car, $outside_guide, $note, $driver_id, $car_id, $guide_id, $manage_id);

    if (count($before) > 0) {
        for ($i = 0; $i < count($before); $i++) {
            if (in_array($before[$i], $data) == false) {
                $response = $manageObj->update_booking_transfer(0, 0, $before[$i]);
            }
        }
    }

    if (count($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
            if (in_array($data[$i], $before) == false) {
                $response = $manageObj->update_booking_transfer($manage_id, $arrange, $data[$i]);
            } else {
                $response = $manageObj->update_booking_transfer($manage_id, $arrange, $data[$i]);
            }
            $arrange++;
        }
    }

    echo $response;
} else {
    echo $response = FALSE;
}

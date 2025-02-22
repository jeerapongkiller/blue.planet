<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Car.php';

$carObj = new Car();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['car_id']) && $_POST['car_id'] > 0) {
    // get value from ajax
    $car_id = $_POST['car_id'] > 0 ? $_POST['car_id'] : 0;

    if ($car_id > 0) {
        $response = $carObj->delete_data($car_id);
    }

    echo $response;
} else {
    echo $response = false;
}

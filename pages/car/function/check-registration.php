<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Car.php';

$carObj = new Car();

if (isset($_POST['registration'])) {
    // get value from ajax
    $car_id = !empty($_POST['car_id']) != "" ? $_POST['car_id'] : 0;
    $registration = $_POST['registration'] != "" ? $_POST['registration'] : '';

    $response = $carObj->check_registration($car_id, $registration);

    echo $response;
} else {
    echo $response = false;
}

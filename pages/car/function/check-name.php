<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Car.php';

$carObj = new Car();

if (isset($_POST['name'])) {
    // get value from ajax
    $car_id = !empty($_POST['car_id']) != "" ? $_POST['car_id'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $response = $carObj->check_name($car_id, $name);

    echo $response;
} else {
    echo $response = false;
}

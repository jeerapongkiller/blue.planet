<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarType.php';

$carObj = new Car_type();

if (isset($_POST['name']) && isset($_POST['category'])) {
    // get value from ajax
    $car_type_id = !empty($_POST['car_type_id']) != "" ? $_POST['car_type_id'] : 0;
    $category = !empty($_POST['category']) != "" ? $_POST['category'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $response = $carObj->check_name($car_type_id, $category, $name);

    echo $response;
} else {
    echo $response = false;
}

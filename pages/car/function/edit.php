<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Car.php';

$carObj = new Car();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['car_id']) && $_POST['car_id'] > 0) {
    // get value from ajax
    $car_id = $_POST['car_id'] > 0 ? $_POST['car_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $category = !empty($_POST['category']) ? $_POST['category'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $registration = $_POST['registration'] != "" ? $_POST['registration'] : '';
    $capacity = $_POST['capacity'] != "" ? $_POST['capacity'] : 0;

    if ($car_id > 0) {
        $response = $carObj->update_data($is_approved, $category, $name, $registration, $capacity, $car_id);
    }

    echo $response;
} else {
    echo $response = false;
}

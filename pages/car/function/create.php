<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Car.php';

$carObj = new Car();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $category = !empty($_POST['category']) ? $_POST['category'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $registration = $_POST['registration'] != "" ? $_POST['registration'] : '';
    $capacity = $_POST['capacity'] != "" ? $_POST['capacity'] : 0;

    $response = $carObj->insert_data($is_approved, $category, $name, $registration, $capacity);

    echo $response;
} else {
    echo $response = false;
}
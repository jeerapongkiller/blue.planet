<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarType.php';

$car_typeObj = new Car_type();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $category = $_POST['category'] != "" ? $_POST['category'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $response = $car_typeObj->insert_data($name, $category);

    echo $response;
} else {
    echo $response = false;
}
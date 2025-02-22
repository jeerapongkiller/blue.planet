<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarType.php';

$car_typeObj = new Car_type();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['car_type_id']) && $_POST['car_type_id'] > 0) {
    // get value from ajax
    $car_type_id = $_POST['car_type_id'] > 0 ? $_POST['car_type_id'] : 0;
    $category = $_POST['category'] != "" ? $_POST['category'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    if ($car_type_id > 0) {
        $response = $car_typeObj->update_data($car_type_id, $category, $name);
    }

    echo $response;
} else {
    echo $response = false;
}

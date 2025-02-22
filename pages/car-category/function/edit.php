<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarCategory.php';

$car_categoryObj = new Cars_category();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['car_category_id']) && $_POST['car_category_id'] > 0) {
    // get value from ajax
    $car_category_id = $_POST['car_category_id'] > 0 ? $_POST['car_category_id'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $capacity = $_POST['capacity'] != "" ? $_POST['capacity'] : '';

    if ($car_category_id > 0) {
        $response = $car_categoryObj->update_data($car_category_id, $name, $capacity);
    }

    echo $response;
} else {
    echo $response = false;
}

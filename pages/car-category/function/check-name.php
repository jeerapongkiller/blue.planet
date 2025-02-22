<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarCategory.php';

$carObj = new Cars_category();

if (isset($_POST['name'])) {
    // get value from ajax
    $car_category_id = !empty($_POST['car_category_id']) != "" ? $_POST['car_category_id'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $response = $carObj->check_name($car_category_id, $name);

    echo $response;
} else {
    echo $response = false;
}

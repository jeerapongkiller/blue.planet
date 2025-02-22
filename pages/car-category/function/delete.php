<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarCategory.php';

$car_categoryObj = new Cars_category();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['car_category_id']) && $_POST['car_category_id'] > 0) {
    // get value from ajax
    $car_category_id = $_POST['car_category_id'] > 0 ? $_POST['car_category_id'] : 0;

    if ($car_category_id > 0) {
        $response = $car_categoryObj->delete_data($car_category_id);
    }

    echo $response;
} else {
    echo $response = false;
}

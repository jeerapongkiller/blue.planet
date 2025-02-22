<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarCategory.php';

$carObj = new Cars_category();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $capacity = $_POST['capacity'] != "" ? $_POST['capacity'] : '';

    $response = $carObj->insert_data($name, $capacity);

    echo $response;
} else {
    echo $response = false;
}

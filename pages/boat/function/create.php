<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Boat.php';

$boatObj = new Boat();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $type = !empty($_POST['type']) ? $_POST['type'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    $capacity = $_POST['capacity'] != "" ? $_POST['capacity'] : 0;

    $response = $boatObj->insert_data($is_approved, $type, $name, $refcode, $capacity);

    echo $response;
} else {
    echo $response = false;
}
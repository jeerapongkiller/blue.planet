<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Hotel.php';

$hotObj = new Hotel();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = !empty($_POST['name']) ? $_POST['name'] : '';
    $name_th = !empty($_POST['name_th']) ? $_POST['name_th'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';
    $email = $_POST['email'] != "" ? $_POST['email'] : '';
    $zone = !empty($_POST['zone']) ? $_POST['zone'] : 0;
    $address = $_POST['address'] != "" ? $_POST['address'] : '';

    $response = $hotObj->insert_data($is_approved, $name, $name_th, $telephone, $email, $zone, $address);
   
    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Hotel.php';

$hotObj = new Hotel();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['id']) && $_POST['id'] > 0) {
    // get value from ajax
    $id = $_POST['id'] > 0 ? $_POST['id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = !empty($_POST['name']) ? $_POST['name'] : '';
    $name_th = !empty($_POST['name_th']) ? $_POST['name_th'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';
    $email = $_POST['email'] != "" ? $_POST['email'] : '';
    $zone = !empty($_POST['zone']) ? $_POST['zone'] : 0;
    $address = $_POST['address'] != "" ? $_POST['address'] : '';

    if ($id > 0) {
        $response = $hotObj->update_data($is_approved, $name, $name_th, $telephone, $email, $zone, $address, $id);
    }

    echo $response;
} else {
    echo $response = false;
}

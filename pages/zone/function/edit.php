<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Zone.php';

$plaObj = new Zone();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['id']) && $_POST['id'] > 0) {
    // get value from ajax
    $id = !empty($_POST['id']) ? $_POST['id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $name_th = $_POST['name_th'] != "" ? $_POST['name_th'] : '';
    $start_pickup = !empty($_POST['start_pickup']) ? $_POST['start_pickup'] : '00:00:00';
    $end_pickup = !empty($_POST['end_pickup']) ? $_POST['end_pickup'] : '00:00:00';
    $province = !empty($_POST['province']) ? $_POST['province'] : 0;
 
    if ($id > 0) {
        $response = $plaObj->update_data($is_approved, $name, $name_th, $start_pickup, $end_pickup, $province, $id);
    }

    echo !empty($response) && $response != false ? $response : false;
} else {
    echo $response = false;
}

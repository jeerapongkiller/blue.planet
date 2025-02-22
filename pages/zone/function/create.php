<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Zone.php';

$zoneObj = new Zone();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $pickup = 1;
    $dropoff = 1;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $name_th = $_POST['name_th'] != "" ? $_POST['name_th'] : '';
    $start_pickup = !empty($_POST['start_pickup']) ? $_POST['start_pickup'] : '00:00:00';
    $end_pickup = !empty($_POST['end_pickup']) ? $_POST['end_pickup'] : '00:00:00';
    $province = !empty($_POST['province']) ? $_POST['province'] : 0;

    $response = $zoneObj->insert_data($is_approved, $name, $name_th, $start_pickup, $end_pickup, $pickup, $dropoff, $province);
   
    echo $response;
} else {
    echo $response = false;
}

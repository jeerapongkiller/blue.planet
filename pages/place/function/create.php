<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Place.php';

$plaObj = new Place();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $pickup = !empty($_POST['pickup']) ? $_POST['pickup'] : 0;
    $dropoff = !empty($_POST['dropoff']) ? $_POST['dropoff'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $province = $_POST['province'] != "" ? $_POST['province'] : 0;
    $zone = $_POST['zone'] != "" ? $_POST['zone'] : 0;

    $response = $plaObj->insert_data($is_approved, $name, $pickup, $dropoff,$province,$zone);
   
    echo $response;
} else {
    echo $response = false;
}

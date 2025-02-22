<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Place.php';

$plaObj = new Place();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['place_id']) && $_POST['place_id'] > 0) {
    // get value from ajax
    $place_id = $_POST['place_id'] > 0 ? $_POST['place_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $pickup = !empty($_POST['pickup']) ? $_POST['pickup'] : 0;
    $dropoff = !empty($_POST['dropoff']) ? $_POST['dropoff'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $province = $_POST['province'] != "" ? $_POST['province'] : 0;
    $zone = $_POST['zone'] != "" ? $_POST['zone'] : 0;

    if ($place_id > 0) {
        $response = $plaObj->update_data($is_approved, $name, $pickup, $dropoff, $province, $zone, $place_id);
    }

    echo $response;
} else {
    echo $response = false;
}

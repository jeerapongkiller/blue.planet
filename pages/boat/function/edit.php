<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Boat.php';

$boatObj = new Boat();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['boat_id']) && $_POST['boat_id'] > 0) {
    // get value from ajax
    $boat_id = $_POST['boat_id'] > 0 ? $_POST['boat_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $type = !empty($_POST['type']) ? $_POST['type'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    $capacity = $_POST['capacity'] != "" ? $_POST['capacity'] : 0;

    if ($boat_id > 0) {
        $response = $boatObj->update_data($is_approved, $type, $name, $refcode, $capacity, $boat_id);
    }

    echo $response;
} else {
    echo $response = false;
}

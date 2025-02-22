<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Boat.php';

$boatObj = new Boat();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['boat_id']) && $_POST['boat_id'] > 0) {
    // get value from ajax
    $boat_id = $_POST['boat_id'] > 0 ? $_POST['boat_id'] : 0;

    if ($boat_id > 0) {
        $response = $boatObj->delete_data($boat_id);
    }

    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/BoatType.php';

$boat_typeObj = new Boats_type();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['boat_type_id']) && $_POST['boat_type_id'] > 0) {
    // get value from ajax
    $boat_type_id = $_POST['boat_type_id'] > 0 ? $_POST['boat_type_id'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    if ($boat_type_id > 0) {
        $response = $boat_typeObj->update_data($boat_type_id, $category, $name);
    }

    echo $response;
} else {
    echo $response = false;
}

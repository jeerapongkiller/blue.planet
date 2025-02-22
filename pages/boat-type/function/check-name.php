<?php
require_once '../../../config/env.php';
require_once '../../../controllers/BoatType.php';

$boat_typeObj = new Boats_type();

if (isset($_POST['name'])) {
    // get value from ajax
    $boat_type_id = !empty($_POST['boat_type_id']) != "" ? $_POST['boat_type_id'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $response = $boat_typeObj->check_name($boat_type_id, $name);

    echo $response;
} else {
    echo $response = false;
}

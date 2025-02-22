<?php
require_once '../../../config/env.php';
require_once '../../../controllers/BoatType.php';

$boat_typeObj = new Boats_type();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $response = $boat_typeObj->insert_data($name);

    echo $response;
} else {
    echo $response = false;
}

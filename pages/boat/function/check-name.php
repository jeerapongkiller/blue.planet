<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Boat.php';

$boatObj = new Boat();

if (isset($_POST['name'])) {
    // get value from ajax
    $boat_id = !empty($_POST['boat_id']) != "" ? $_POST['boat_id'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $response = $boatObj->check_name($boat_id, $name);

    echo $response;
} else {
    echo $response = false;
}

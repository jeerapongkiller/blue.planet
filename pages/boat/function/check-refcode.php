<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Boat.php';

$boatObj = new Boat();

if (isset($_POST['refcode'])) {
    // get value from ajax
    $boat_id = !empty($_POST['boat_id']) != "" ? $_POST['boat_id'] : 0;
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';

    $response = $boatObj->check_refcode($boat_id, $refcode);

    echo $response;
} else {
    echo $response = false;
}

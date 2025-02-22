<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Driver.php';

$drvObj = new Driver();

if (isset($_POST['id_card'])) {
    // get value from ajax
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : '';
    $driver_id = !empty($_POST['driver_id']) != "" ? $_POST['driver_id'] : 0;

    $response = $drvObj->check_id_card($id_card, $driver_id);

    echo $response;
} else {
    echo $response = false;
}

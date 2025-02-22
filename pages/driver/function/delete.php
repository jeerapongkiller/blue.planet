<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Driver.php';

$drvObj = new Driver();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['driver_id']) && $_POST['driver_id'] > 0) {
    // get value from ajax
    $driver_id = $_POST['driver_id'] > 0 ? $_POST['driver_id'] : 0;

    if ($driver_id > 0) {
        $response = $drvObj->delete_data($driver_id);
    }

    echo $response;
} else {
    echo $response = false;
}

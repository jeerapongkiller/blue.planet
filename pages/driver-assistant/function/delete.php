<?php
require_once '../../../config/env.php';
require_once '../../../controllers/DriverAssistant.php';

$drv_assObj = new Driver_Assistant();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['driver_ass_id']) && $_POST['driver_ass_id'] > 0) {
    // get value from ajax
    $driver_ass_id = $_POST['driver_ass_id'] > 0 ? $_POST['driver_ass_id'] : 0;

    if ($driver_ass_id > 0) {
        $response = $drv_assObj->delete_data($driver_ass_id);
    }

    echo $response;
} else {
    echo $response = false;
}

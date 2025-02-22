<?php
require_once '../../../config/env.php';
require_once '../../../controllers/DriverAssistant.php';

$drv_assObj = new Driver_Assistant();

if (isset($_POST['id_card'])) {
    // get value from ajax
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : '';
    $driver_ass_id = !empty($_POST['driver_ass_id']) != "" ? $_POST['driver_ass_id'] : 0;

    $response = $drv_assObj->check_id_card($id_card, $driver_ass_id);

    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Driver.php';

$drvObj = new Driver();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';
    $number_plate = $_POST['number_plate'] != "" ? $_POST['number_plate'] : '';
    $seat = $_POST['seat'] != "" ? $_POST['seat'] : '0';

    $response = $drvObj->insert_data($is_approved, $name, $telephone, $number_plate, $seat);
   
    echo $response;
} else {
    echo $response = false;
}

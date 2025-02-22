<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Driver.php';

$drvObj = new Driver();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['id']) && $_POST['id'] > 0) {
    // get value from ajax
    $id = $_POST['id'] > 0 ? $_POST['id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';
    $number_plate = $_POST['number_plate'] != "" ? $_POST['number_plate'] : '';
    $seat = $_POST['seat'] != "" ? $_POST['seat'] : '0';

    $response = $drvObj->update_data($is_approved, $name, $telephone, $number_plate, $seat, $id);

    echo $response;
} else {
    echo $response = false;
}

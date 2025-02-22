<?php
require_once '../../../config/env.php';
require_once '../../../controllers/DriverAssistant.php';

$drv_assObj = new Driver_Assistant();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['driver_ass_id']) && $_POST['driver_ass_id'] > 0) {
    // get value from ajax
    $driver_ass_id = $_POST['driver_ass_id'] > 0 ? $_POST['driver_ass_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : 0;
    $first_name = $_POST['first_name'] != "" ? $_POST['first_name'] : '';
    $last_name = $_POST['last_name'] != "" ? $_POST['last_name'] : '';
    $nickname = $_POST['nickname'] != "" ? $_POST['nickname'] : '';
    $birth_date = $_POST['birth_date'] != "" ? $_POST['birth_date'] : '0000-00-00';
    $gender = $_POST['gender'] != "" ? $_POST['gender'] : 0;
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';
    $address = $_POST['address'] != "" ? $_POST['address'] : '';

    // get details of the uploaded file
    $countfiles = count($_FILES['pic']['name']);
    $picArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $picArray['fileTmpPath'][$i] = $_FILES['pic']['tmp_name'][$i];
        $picArray['fileName'][$i] = $_FILES['pic']['name'][$i];
        $picArray['fileSize'][$i] = $_FILES['pic']['size'][$i];
        $picArray['fileBefore'][$i] = !empty($_POST['before_pic'][$i]) ? $_POST['before_pic'][$i] : '';
        $picArray['fileDelete'][$i] = !empty($_POST['delete_pic'][$i]) && $_POST['delete_pic'][$i] == 1 ? $_POST['delete_pic'][$i] : 0;
        $picArray['fileDir'][$i] = '../../../storage/uploads/drivers-assistant/pic/';
    }

    if ($driver_ass_id > 0) {
        $response = $drv_assObj->update_data($is_approved, $id_card, $first_name, $last_name, $nickname, $telephone, $address, $gender, $birth_date, $picArray, $driver_ass_id);
    }

    echo $response;
} else {
    echo $response = false;
}

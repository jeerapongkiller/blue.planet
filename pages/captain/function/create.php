<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Captain.php';

$capObj = new Captain();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
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
        $picArray['fileBefore'][$i] = '';
        $picArray['fileDelete'][$i] = 0;
        $picArray['fileDir'][$i] = '../../../storage/uploads/captain/pic/';
    }

    $response = $capObj->insert_data($is_approved, $id_card, $name, $telephone, $address, $gender, $birth_date, $picArray);
   
    echo $response;
} else {
    echo $response = false;
}

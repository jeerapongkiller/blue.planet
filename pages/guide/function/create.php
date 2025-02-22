<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Guide.php';

$guideObj = new Guide();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';

    // get PIC of the uploaded file
    $countfiles = count($_FILES['pic']['name']);
    $picArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $picArray['fileTmpPath'][$i] = $_FILES['pic']['tmp_name'][$i];
        $picArray['fileName'][$i] = $_FILES['pic']['name'][$i];
        $picArray['fileSize'][$i] = $_FILES['pic']['size'][$i];
        $picArray['fileBefore'][$i] = '';
        $picArray['fileDelete'][$i] = 0;
        $picArray['fileDir'][$i] = '../../../storage/uploads/guide/pic/';
    }

    // get language of the uploaded file
    $languageArray = array();
    $languageArray = $_POST['language'];

    $guide_id = $guideObj->insert_data($is_approved, $name, $telephone, $picArray);
   
    if ($guide_id != false && $guide_id > 0) { 
        $response = $guideObj->insert_data_language($guide_id, $languageArray);
    }

    echo $response = $guide_id;
} else {
    echo $response = false;
}

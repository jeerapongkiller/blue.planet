<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Guide.php';

$guideObj = new Guide();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['guide_id']) && $_POST['guide_id'] > 0) {
    // get value from ajax
    $guide_id = $_POST['guide_id'] > 0 ? $_POST['guide_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';

    // get details of the uploaded file
    $countfiles = count($_FILES['pic']['name']);
    $picArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $picArray['fileTmpPath'][$i] = $_FILES['pic']['tmp_name'][$i];
        $picArray['fileName'][$i] = $_FILES['pic']['name'][$i];
        $picArray['fileSize'][$i] = $_FILES['pic']['size'][$i];
        $picArray['fileBefore'][$i] = !empty($_POST['before_pic'][$i]) ? $_POST['before_pic'][$i] : '';
        $picArray['fileDelete'][$i] = !empty($_POST['delete_pic'][$i]) && $_POST['delete_pic'][$i] == 1 ? $_POST['delete_pic'][$i] : 0;
        $picArray['fileDir'][$i] = '../../../storage/uploads/guide/pic/';
    }

    // get language of the uploaded file
    $languageArray = array();
    $languageArray = $_POST['language'];

    $before_languageArray = array();
    $before_languageArray = !empty($_POST['before_language']) ? $_POST['before_language'] : array();

    $check_guide_id = $guideObj->update_data($is_approved, $name, $telephone, $picArray, $guide_id);

    if ($check_guide_id != false && $check_guide_id > 0) {
        $response = $guideObj->update_language($guide_id, $languageArray, $before_languageArray);
    }

    echo $response;
    
} else {
    echo $response = false;
}

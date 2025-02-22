<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Province.php';

$plaObj = new Province();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['province_id']) && $_POST['province_id'] > 0) {
    // get value from ajax
    $province_id = $_POST['province_id'] > 0 ? $_POST['province_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name_en = $_POST['name_en'] != "" ? $_POST['name_en'] : '';
    $name_th = $_POST['name_th'] != "" ? $_POST['name_th'] : '';
    $country = $_POST['country'] != "" ? $_POST['country'] : '';

     // get details of the uploaded file
     $countfiles = count($_FILES['pic']['name']);
     $picArray = array();
 
     for ($i = 0; $i < $countfiles; $i++) {
         $picArray['fileTmpPath'][$i] = $_FILES['pic']['tmp_name'][$i];
         $picArray['fileName'][$i] = $_FILES['pic']['name'][$i];
         $picArray['fileSize'][$i] = $_FILES['pic']['size'][$i];
         $picArray['fileBefore'][$i] = !empty($_POST['before_pic'][$i]) ? $_POST['before_pic'][$i] : '';
         $picArray['fileDelete'][$i] = !empty($_POST['delete_pic'][$i]) && $_POST['delete_pic'][$i] == 1 ? $_POST['delete_pic'][$i] : 0;
         $picArray['fileDir'][$i] = '../../../storage/uploads/province/pic/';
     }

    if ($province_id > 0) {
        $response = $plaObj->update_data($is_approved, $name_en, $name_th, $country, $picArray, $province_id);
    }

    echo $response;
} else {
    echo $response = false;
}

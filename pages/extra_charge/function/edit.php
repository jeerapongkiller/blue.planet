<?php
require_once '../../../config/env.php';
require_once '../../../controllers/ExtraCharge.php';

$extraObj = new ExtraCharge();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['extra_id']) && $_POST['extra_id'] > 0) {
    // get value from ajax
    $extra_id = $_POST['extra_id'] > 0 ? $_POST['extra_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $unit = $_POST['unit'] != "" ? $_POST['unit'] : '';
    $rate_adult = !empty($_POST['rate_adult']) ? preg_replace('(,)', '', $_POST['rate_adult']) : 0;
    $rate_child = !empty($_POST['rate_child']) ? preg_replace('(,)', '', $_POST['rate_child']) : 0;
    $rate_infant = !empty($_POST['rate_infant']) ? preg_replace('(,)', '', $_POST['rate_infant']) : 0;
    $rate_total = !empty($_POST['rate_total']) ? preg_replace('(,)', '', $_POST['rate_total']) : 0;
    $detail = $_POST['detail'] != "" ? $_POST['detail'] : '';

    // get details of the uploaded file
    $countfiles = count($_FILES['pic']['name']);
    $picArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $picArray['fileTmpPath'][$i] = $_FILES['pic']['tmp_name'][$i];
        $picArray['fileName'][$i] = $_FILES['pic']['name'][$i];
        $picArray['fileSize'][$i] = $_FILES['pic']['size'][$i];
        $picArray['fileBefore'][$i] = !empty($_POST['before_pic'][$i]) ? $_POST['before_pic'][$i] : '';
        $picArray['fileDelete'][$i] = !empty($_POST['delete_pic'][$i]) && $_POST['delete_pic'][$i] == 1 ? $_POST['delete_pic'][$i] : 0;
        $picArray['fileDir'][$i] = '../../../storage/uploads/extra_charge/pic/';
    }

    if ($extra_id > 0) {
        $response = $extraObj->update_data($is_approved, $name, $unit, $rate_adult, $rate_child, $rate_infant, $rate_total, $detail, $picArray, $extra_id);
    }

    echo $response;
} else {
    echo $response = false;
}

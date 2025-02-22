<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Park.php';

$plaObj = new Park();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['park_id']) && $_POST['park_id'] > 0) {
    // get value from ajax
    $park_id = $_POST['park_id'] > 0 ? $_POST['park_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $rate_adult_eng = $_POST['rate_adult_eng'] != "" ? preg_replace('(,)', '', $_POST['rate_adult_eng']) : 0;
    $rate_child_eng = $_POST['rate_child_eng'] != "" ? preg_replace('(,)', '', $_POST['rate_child_eng']) : 0;
    $rate_adult_th = $_POST['rate_adult_th'] != "" ? preg_replace('(,)', '', $_POST['rate_adult_th']) : 0;
    $rate_child_th = $_POST['rate_child_th'] != "" ? preg_replace('(,)', '', $_POST['rate_child_th']) : 0;
    $response = false;
 
    if ($park_id > 0) {
        $response = $plaObj->update_data($is_approved, $name, $rate_adult_eng, $rate_child_eng, $rate_adult_th, $rate_child_th, $park_id);
    }

    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Park.php';

$plaObj = new Park();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $rate_adult_eng = $_POST['rate_adult_eng'] != "" ? preg_replace('(,)', '', $_POST['rate_adult_eng']) : 0;
    $rate_child_eng = $_POST['rate_child_eng'] != "" ? preg_replace('(,)', '', $_POST['rate_child_eng']) : 0;
    $rate_adult_th = $_POST['rate_adult_th'] != "" ? preg_replace('(,)', '', $_POST['rate_adult_th']) : 0;
    $rate_child_th = $_POST['rate_child_th'] != "" ? preg_replace('(,)', '', $_POST['rate_child_th']) : 0;
   
    
    $response = $plaObj->insert_data($is_approved, $name, $rate_adult_eng, $rate_child_eng, $rate_adult_th, $rate_child_th);
   
    echo $response;
} else {
    echo $response = false;
}

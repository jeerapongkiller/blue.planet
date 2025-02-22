<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Agent.php';

$agObj = new Agent();

if (isset($_POST['action']) && $_POST['action'] == "edit" && !empty($_POST['rate_id']) && $_POST['rate_id'] > 0) {
    // get value from ajax
    $rate_id = $_POST['rate_id'] != "" ? $_POST['rate_id'] : 0;
    $rate_adult = $_POST['rate_adult'] != "" ? preg_replace('(,)', '', $_POST['rate_adult']) : 0;
    $rate_child = $_POST['rate_child'] != "" ? preg_replace('(,)', '', $_POST['rate_child']) : 0;
    $rate_infant = $_POST['rate_infant'] != "" ? preg_replace('(,)', '', $_POST['rate_infant']) : 0;
    $rate_private = $_POST['rate_private'] != "" ? preg_replace('(,)', '', $_POST['rate_private']) : 0;

    $response = $agObj->update_data_rate($rate_adult, $rate_child, $rate_infant, $rate_private, $rate_id);

    echo $response;
} else {
    echo $response = false;
}

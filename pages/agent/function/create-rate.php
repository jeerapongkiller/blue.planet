<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Agent.php';

$agObj = new Agent();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $company_id = $_POST['company_id'] != "" ? $_POST['company_id'] : 0;
    $period_id = $_POST['period_id'] != "" ? $_POST['period_id'] : 0;
    $rate_adult = $_POST['rate_adult'] != "" ? preg_replace('(,)', '', $_POST['rate_adult']) : 0;
    $rate_child = $_POST['rate_child'] != "" ? preg_replace('(,)', '', $_POST['rate_child']) : 0;
    $rate_infant = $_POST['rate_infant'] != "" ? preg_replace('(,)', '', $_POST['rate_infant']) : 0;
    $rate_private = $_POST['rate_private'] != "" ? preg_replace('(,)', '', $_POST['rate_private']) : 0;

    $rate_id = $agObj->insert_data_rate($rate_adult, $rate_child, $rate_infant, $rate_private, $period_id);
    $response = $rate_id != false && $rate_id > 0 ? $agObj->insert_data_company($period_id, $rate_id, $company_id) : false;

    echo $response;
} else {
    echo $response = false;
}

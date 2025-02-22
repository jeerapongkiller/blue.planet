<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Agent.php';

$agObj = new Agent();

if (isset($_POST['tat_license'])) {
    // get value from ajax
    $tat_license = $_POST['tat_license'] != "" ? $_POST['tat_license'] : '';
    $company_id = !empty($_POST['company_id']) ? $_POST['company_id'] : 0;

    $response = $agObj->check_tat_license($tat_license, $company_id);

    echo $response;
} else {
    echo $response = false;
}

<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();
$response = false;

if (isset($_POST['action']) && $_POST['action'] == "create" && !empty($_POST['bo_id'])) {
    // get value from ajax
    $bo_id = !empty($_POST['bo_id']) ? $_POST['bo_id'] : 0;

    $response = $manageObj->insert_check($bo_id, 2); // 2 = Guide

    echo $response;
} elseif (isset($_POST['action']) && $_POST['action'] == "delete" && !empty($_POST['bo_id'])) {
    // get value from ajax
    $bo_id = !empty($_POST['bo_id']) ? $_POST['bo_id'] : 0;

    $response = $manageObj->delete_check($bo_id, 2); // 2 = Guide

    echo 0;
} else {
    echo $response = FALSE;
}


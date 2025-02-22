<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Invoice.php';

$invObj = new Invoice();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['cover_id'])) {
    // get value from ajax
    $cover_id = !empty($_POST['cover_id']) ? $_POST['cover_id'] : 0;
    $bo_id = !empty($_POST['bo_id']) ? $_POST['bo_id'] : '';

    $response = $invObj->delete_data_cover($cover_id);
    $response = $invObj->delete_data($cover_id);
    if (!empty($bo_id)) {
        for ($i = 0; $i < count($bo_id); $i++) {
            $response = $invObj->delete_booking_paid($bo_id[$i]);
        }
    }

    echo $response;
} else {
    echo $response = false;
}

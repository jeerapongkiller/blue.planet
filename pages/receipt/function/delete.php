<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Receipt.php';

$recObj = new Receipt();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['rec_id'])) {
    // get value from ajax
    $rec_id = !empty($_POST['rec_id']) ?  $_POST['rec_id'] : 0;
    $bo_id = !empty($_POST['bo_id']) ?  $_POST['bo_id'] : 0;

    $response = $recObj->delete_data($rec_id);
    if (!empty($bo_id)) {
        for ($i = 0; $i < count($bo_id); $i++) {
            $response = $recObj->delete_booking_paid($bo_id[$i]);
        }
    }

    echo $response;
} else {
    echo $response = false;
}

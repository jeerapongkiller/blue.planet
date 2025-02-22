<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Guide.php';

$guideObj = new Guide();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['guide_id']) && $_POST['guide_id'] > 0) {
    // get value from ajax
    $guide_id = $_POST['guide_id'] > 0 ? $_POST['guide_id'] : 0;

    if ($guide_id > 0) {
        $response = $guideObj->delete_data($guide_id);
    }

    echo $response;
} else {
    echo $response = false;
}

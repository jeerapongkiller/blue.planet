<?php
require_once '../../../config/env.php';
require_once '../../../controllers/ExtraCharge.php';

$extraObj = new ExtraCharge();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['extra_id']) && $_POST['extra_id'] > 0) {
    // get value from ajax
    $extra_id = $_POST['extra_id'] > 0 ? $_POST['extra_id'] : 0;

    if ($extra_id > 0) {
        $response = $extraObj->delete_data($extra_id);
    }

    echo $response;
} else {
    echo $response = false;
}

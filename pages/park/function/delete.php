<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Park.php';

$plaObj = new Park();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['park_id']) && $_POST['park_id'] > 0) {
    // get value from ajax
    $park_id = $_POST['park_id'] > 0 ? $_POST['park_id'] : 0;

    if ($park_id > 0) {
        $response = $plaObj->delete_data($park_id);
    }

    echo $response;
} else {
    echo $response = false;
}

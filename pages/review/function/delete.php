<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Captain.php';

$capObj = new Captain();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['captain_id']) && $_POST['captain_id'] > 0) {
    // get value from ajax
    $captain_id = $_POST['captain_id'] > 0 ? $_POST['captain_id'] : 0;

    if ($captain_id > 0) {
        $response = $capObj->delete_data($captain_id);
    }

    echo $response;
} else {
    echo $response = false;
}

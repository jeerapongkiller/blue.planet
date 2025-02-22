<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Province.php';

$plaObj = new Province();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['place_id']) && $_POST['place_id'] > 0) {
    // get value from ajax
    $place_id = $_POST['place_id'] > 0 ? $_POST['place_id'] : 0;

    if ($place_id > 0) {
        $response = $plaObj->delete_data($place_id);
    }

    echo $response;
} else {
    echo $response = false;
}

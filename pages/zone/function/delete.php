<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Zone.php';

$plaObj = new Zone();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['zone_id']) && $_POST['zone_id'] > 0) {
    // get value from ajax
    $zone_id = $_POST['zone_id'] > 0 ? $_POST['zone_id'] : 0;

    if ($zone_id > 0) {
        $response = $plaObj->delete_data($zone_id);
    }

    echo $response;
} else {
    echo $response = false;
}

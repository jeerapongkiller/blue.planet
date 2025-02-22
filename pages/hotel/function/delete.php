<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Hotel.php';

$hotObj = new Hotel();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['hotel_id']) && $_POST['hotel_id'] > 0) {
    // get value from ajax
    $hotel_id = $_POST['hotel_id'] > 0 ? $_POST['hotel_id'] : 0;

    if ($hotel_id > 0) {
        $response = $hotObj->delete_data($hotel_id);
    }

    echo $response;
} else {
    echo $response = false;
}

<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['zone_id'])) {
    # --- get value --- #
    $zone_id = !empty($_POST['zone_id']) ? $_POST['zone_id'] : 0;
    
    $hotels = $bookObj->search_hotel($zone_id);

    echo !empty($hotels) ? json_encode($hotels) : false;
} else {
    echo $response = false;
}
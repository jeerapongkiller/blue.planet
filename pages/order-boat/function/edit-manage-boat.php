<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "edit" && (!empty($_POST['edit_bo_id']))) {
    $response = true;
    $bo_mange_id = !empty($_POST['bo_mange_id']) ? $_POST['bo_mange_id'] : 0;
    $brfore_manage_id = !empty($_POST['brfore_manage_id']) ? $_POST['brfore_manage_id'] : 0;
    $booking_id = !empty($_POST['edit_bo_id']) ? $_POST['edit_bo_id'] : 0;
    $edit_manage = !empty($_POST['edit_manage']) ? $_POST['edit_manage'] : 0;

    if ($bo_mange_id == 0 && $brfore_manage_id == 0 && $booking_id > 0 && $edit_manage > 0) {
        $response = $manageObj->insert_booking_manage_boat(0, $booking_id, $edit_manage);
    } elseif ($bo_mange_id > 0 && $brfore_manage_id > 0 && $booking_id > 0 && $edit_manage > 0) {
        $response = $manageObj->update_booking_manage_boat(0, $booking_id, $edit_manage, $bo_mange_id);
    } elseif ($bo_mange_id > 0 && $brfore_manage_id > 0 && $booking_id > 0 && $edit_manage == 0) {
        $response = $manageObj->delete_booking_manage_boat($bo_mange_id, 0, $brfore_manage_id);
    }

    echo $response;
} else {
    echo $response = FALSE;
}

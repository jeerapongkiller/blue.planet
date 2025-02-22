<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "edit" && !empty($_POST['edit_bt_id'])) {
    $response = true;
    $brfore_manage_id = !empty($_POST['brfore_manage_id']) ? $_POST['brfore_manage_id'] : 0;
    $bt_id = !empty($_POST['edit_bt_id']) ? $_POST['edit_bt_id'] : 0;
    $edit_manage = !empty($_POST['edit_manage']) ? $_POST['edit_manage'] : 0;

    if ($edit_manage == 0 && $brfore_manage_id > 0) {
        $response = $manageObj->delete_manage_booking($bt_id, $brfore_manage_id);
    } elseif ($edit_manage > 0 && $brfore_manage_id > 0) {
        $response = $manageObj->update_manage_booking($brfore_manage_id, 0, $edit_manage, $bt_id);
    } elseif ($edit_manage > 0 && $brfore_manage_id == 0) {
        $response = $manageObj->insert_manage_booking(0, $edit_manage, $bt_id);
    }

    echo $response;
} else {
    echo $response = FALSE;
}

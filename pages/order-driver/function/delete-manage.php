<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "delete" && (!empty($_POST['manage_id']))) {
    // get value from ajax
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;

    $response = $manageObj->delete_manage_transfer($manage_id);
    $response = $manageObj->delete_manage_booking(0, $manage_id);

    echo $response;
} else {
    echo $response = FALSE;
}

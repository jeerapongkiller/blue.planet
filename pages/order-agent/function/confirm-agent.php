<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();
$response = false;

if (isset($_POST['action']) && $_POST['action'] == "create" && !empty($_POST['agent_id'])) {
    // get value from ajax
    $agent_id = !empty($_POST['agent_id']) ? $_POST['agent_id'] : 0;
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';

    $response = $manageObj->insert_confirm($agent_id, $travel_date);

    echo $response;
} elseif (isset($_POST['action']) && $_POST['action'] == "delete" && !empty($_POST['agent_id'])) {
    // get value from ajax
    $agent_id = !empty($_POST['agent_id']) ? $_POST['agent_id'] : 0;
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';

    $response = $manageObj->delete_confirm($agent_id, $travel_date);

    echo 0;
} else {
    echo $response = FALSE;
}

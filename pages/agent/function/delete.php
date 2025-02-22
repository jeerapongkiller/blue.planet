<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Agent.php';

$agObj = new Agent();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['agent_id']) && $_POST['agent_id'] > 0) {
    // get value from ajax
    $agent_id = $_POST['agent_id'] > 0 ? $_POST['agent_id'] : 0;

    if ($agent_id > 0) {
        $response = $agObj->delete_data($agent_id);
    }

    echo $response;
} else {
    echo $response = false;
}

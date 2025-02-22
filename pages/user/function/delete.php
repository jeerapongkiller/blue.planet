<?php
require_once '../../../config/env.php';
require_once '../../../controllers/User.php';

$userObj = new User();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['user_id']) && $_POST['user_id'] > 0) {
    // get value from ajax
    $user_id = $_POST['user_id'] > 0 ? $_POST['user_id'] : 0;

    if ($user_id > 0) {
        $response = $userObj->delete_data($user_id);
    }

    echo $response;
} else {
    echo $response = false;
}

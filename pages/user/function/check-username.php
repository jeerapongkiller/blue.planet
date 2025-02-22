<?php
require_once '../../../config/env.php';
require_once '../../../controllers/User.php';

$userObj = new User();

if (isset($_POST['username'])) {
    // get value from ajax
    $username = $_POST['username'] != "" ? $_POST['username'] : '';

    $response = $userObj->check_username($username);

    echo $response;
} else {
    echo $response = false;
}

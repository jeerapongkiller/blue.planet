<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Bank.php';

$bankObj = new Bank();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $response = $bankObj->insert_data($name);

    echo $response;
} else {
    echo $response = false;
}

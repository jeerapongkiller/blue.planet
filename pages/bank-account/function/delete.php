<?php
require_once '../../../config/env.php';
require_once '../../../controllers/BankAccount.php';

$bankaccObj = new BankAccount();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['account_id']) && $_POST['account_id'] > 0) {
    // get value from ajax
    $id = $_POST['account_id'] > 0 ? $_POST['account_id'] : 0;

    $response = $bankaccObj->delete_data($id);

    echo $response;
} else {
    echo $response = false;
}

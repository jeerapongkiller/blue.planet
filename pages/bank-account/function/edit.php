<?php
require_once '../../../config/env.php';
require_once '../../../controllers/BankAccount.php';

$bankaccObj = new BankAccount();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['account_id']) && $_POST['account_id'] > 0) {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $account_id = $_POST['account_id'] > 0 ? $_POST['account_id'] : 0;
    $bank_id = $_POST['bank'] != "" ? $_POST['bank'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $no = $_POST['no'] != "" ? $_POST['no'] : '';

    if ($account_id > 0) {
        $response = $bankaccObj->update_data($is_approved, $account_id, $bank_id, $name, $no);
    }

    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/BankAccount.php';

$bankaccObj = new BankAccount();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $bank_id = $_POST['bank'] != "" ? $_POST['bank'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $no = $_POST['no'] != "" ? $_POST['no'] : '';

    $response = $bankaccObj->insert_data($is_approved, $bank_id, $name, $no);

    echo $response;
} else {
    echo $response = false;
}

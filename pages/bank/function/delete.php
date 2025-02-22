<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Bank.php';

$bankObj = new Bank();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['bank_id']) && $_POST['bank_id'] > 0) {
    // get value from ajax
    $bank_id = $_POST['bank_id'] > 0 ? $_POST['bank_id'] : 0;

    $response = $bankObj->delete_data($bank_id);

    echo $response;
} else {
    echo $response = false;
}

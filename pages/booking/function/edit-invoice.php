<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Invoice.php');

$invObj = new Invoice();
$response = true;
$today = date("Y-m-d");
$times = date("H:i:s");

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['inv_id'])) {
    # --- get value --- #
    $inv_id = !empty($_POST['inv_id']) ? $_POST['inv_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $inv_date = $_POST['inv_date'] != "" ? $_POST['inv_date'] : '';
    $rec_date = $_POST['rec_date'] != "" ? $_POST['rec_date'] : '';
    $currency_id = !empty($_POST['currency']) ? $_POST['currency'] : 0;
    $vat_id = !empty($_POST['vat']) ? $_POST['vat'] : 0;
    $withholding = !empty($_POST['withholding']) ? $_POST['withholding'] : 0;
    $branch = !empty($_POST['branch']) ? $_POST['branch'] : 0;
    $payment_id = 0;
    $bank_account_id = !empty($_POST['bank_account']) ? $_POST['bank_account'] : 0;
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $amount = !empty($_POST['amount']) ? $_POST['amount'] : 0;

    $response = $invObj->update_data($rec_date, $withholding, $note, $branch, $payment_id, $vat_id, $currency_id, $bank_account_id, $is_approved, $inv_id);
    
    echo $response != false && $response > 0 ? $response : false;
} else {
    echo $response = false;
}
<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Receipt.php');

$recObj = new Receipt();
$response = true;
$today = date("Y-m-d");
$times = date("H:i:s");

function setNumberLength($num, $length)
{
    $sumstr = strlen($num);
    $zero = str_repeat("0", $length - $sumstr);
    $results = $zero . $num;

    return $results;
}

if (isset($_POST['action']) && $_POST['action'] == "edit" && (isset($_POST['rec_id']))) {
    # --- get value --- #
    $rec_id = !empty($_POST['rec_id']) ? $_POST['rec_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $rec_date = $_POST['rec_date'] != "" ? $_POST['rec_date'] : '';
    $payment_id = !empty($_POST['payments_type']) ? $_POST['payments_type'] : 0;
    $bank_account_id = !empty($_POST['bank_account']) ? $_POST['bank_account'] : 0;
    $bank_cheque_id = !empty($_POST['rec_bank']) ? $_POST['rec_bank'] : 0;
    $cheque_no = !empty($_POST['check_no']) && is_int($_POST['check_no']) ? $_POST['check_no'] : 0;
    $cheque_date = !empty($_POST['date_check']) ? $_POST['date_check'] : 0;
    $amount = !empty($_POST['amount']) ? $_POST['amount'] : 0;
    $note = $_POST['note'] != "" ? $_POST['note'] : '';

    // get details of the uploaded file
    $countfiles = count($_FILES['file']['name']);
    $fileArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $fileArray['fileTmpPath'][$i] = $_FILES['file']['tmp_name'][$i];
        $fileArray['fileName'][$i] = $_FILES['file']['name'][$i];
        $fileArray['fileSize'][$i] = $_FILES['file']['size'][$i];
        $fileArray['fileBefore'][$i] = !empty($_POST['before_file']) ? $_POST['before_file'] : '';
        $fileArray['fileDelete'][$i] = !empty($_POST['delete_file']) && $_POST['delete_file'] == 1 ? $_POST['delete_file'] : 0;
    }

    $response = $recObj->update_data($rec_date, $cheque_no, $cheque_date, $bank_account_id, $bank_cheque_id, $payment_id, $is_approved, $note, $rec_id, $fileArray);

    echo $response != false && $response > 0 ? $response : false;
} else {
    echo $response = false;
}

<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Receipt.php');

$recObj = new Receipt();
$response = false;
$today = date("Y-m-d");
$times = date("H:i:s");

function setNumberLength($num, $length)
{
    $sumstr = strlen($num);
    $zero = str_repeat("0", $length - $sumstr);
    $results = $zero . $num;

    return $results;
}

if (isset($_POST['action']) && $_POST['action'] == "create" && isset($_POST['cover_id'])) {
    // get value from ajax
    # --- booking create form --- #
    $cover_id = !empty($_POST['cover_id']) ? $_POST['cover_id'] : 0;
    $bo_id = !empty($_POST['bo_id']) ? $_POST['bo_id'] : '';
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $rec_date = $_POST['rec_date'] != "" ? $_POST['rec_date'] : '';
    $payments_type = !empty($_POST['payments_type']) ? $_POST['payments_type'] : 0;
    $bank_account = !empty($_POST['bank_account']) ? $_POST['bank_account'] : 0;
    $rec_bank = !empty($_POST['rec_bank']) ? $_POST['rec_bank'] : 0;
    $check_no = !empty($_POST['check_no']) ? $_POST['check_no'] : 0;
    $date_check = !empty($_POST['date_check']) ? $_POST['date_check'] : 0;
    $amount = !empty($_POST['amount']) ? $_POST['amount'] : 0;
    $note = $_POST['note'] != "" ? $_POST['note'] : '';

    // get details of the uploaded file
    $countfiles = count($_FILES['file']['name']);
    $fileArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $fileArray['fileTmpPath'][$i] = $_FILES['file']['tmp_name'][$i];
        $fileArray['fileName'][$i] = $_FILES['file']['name'][$i];
        $fileArray['fileSize'][$i] = $_FILES['file']['size'][$i];
        $fileArray['fileBefore'][$i] = '';
        $fileArray['fileDelete'][$i] = 0;
    }

    # --- recipet no full --- #
    if ($cover_id > 0) {
        $rec_no = $recObj->checkrecno();
        $no = (!empty($rec_no['max_rec_no'])) ? $rec_no['max_rec_no'] : 0;
        $no = $no + 1;
        $rec['full'] = 'REC-' . setNumberLength($no, 7);
        $rec['no'] = $no;

        $response = $recObj->insert_data($rec['no'], $rec['full'], $rec_date, $check_no, $date_check, $bank_account, $rec_bank, $cover_id, $payments_type, $is_approved, $note, $fileArray);
    }

    # --- insert booking paid --- #
    if (!empty($bo_id)) {
        for ($i = 0; $i < count($bo_id); $i++) {
            $response = $response != false && $response > 0 ? $recObj->update_booking_paid($bo_id[$i], 3) : false;
        }
    }

    echo $response != false && $response > 0 ? $response : false;
} else {
    echo $response = false;
}

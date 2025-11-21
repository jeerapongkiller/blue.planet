<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Invoice.php');

$invObj = new Invoice();
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

if (isset($_POST['action']) && $_POST['action'] == "create" && isset($_POST['bo_id'])) {
    // get value from ajax
    # --- booking create form --- #
    $bo_id = !empty($_POST['bo_id']) ? json_decode($_POST['bo_id']) : 0;
    $island = !empty($_POST['island']) ? json_decode($_POST['island']) : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $inv_date = $_POST['inv_date'] != "" ? $_POST['inv_date'] : '';
    $rec_date = $_POST['rec_date'] != "" ? $_POST['rec_date'] : '';
    $currency_id = !empty($_POST['currency']) ? $_POST['currency'] : 0;
    $vat_id = !empty($_POST['vat']) ? $_POST['vat'] : 0;
    $withholding = !empty($_POST['withholding']) ? $_POST['withholding'] : 0;
    $branch = !empty($_POST['branch']) ? $_POST['branch'] : 0;
    $payment_id = !empty($_POST['payments_type']) ? $_POST['payments_type'] : 0;
    $bank_account_id = !empty($_POST['bank_account']) ? $_POST['bank_account'] : 0;
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $amount = !empty($_POST['amount']) ? $_POST['amount'] : 0;
    # --- invoice no full --- #
    $inv['no'] = '';
    $inv['full'] = '';
    $inv_no = $invObj->checkinvno($today, $island[0]);
    $no = !empty($inv_no['max_inv_no']) ? $inv_no['max_inv_no'] + 1 : 1;
    $island_no = !empty($island[0]) ? setNumberLength($island[0], 2) : 0;
    $inv['full'] = 'IN' . date("Ymd") . $island_no . '-' . setNumberLength($no, 3);
    $inv['no'] = $no;
    $cover_id = (!empty($inv['no']) && !empty($inv['full'])) ? $invObj->insert_cover_inv($today, $inv['no'], $inv['full'], $island_no) : 0;
    # --- create invoice --- #
    if (!empty($bo_id)) {
        $no = 1;
        for ($i = 0; $i < count($bo_id); $i++) {
            $response = $response != false && $response > 0 ? $invObj->insert_data($no, $rec_date, $withholding, $note, $branch, $bo_id[$i], $payment_id, $vat_id, $currency_id, $cover_id, $bank_account_id, $is_approved) : false;
            # --- insert booking paid --- #
            $response = $response != false && $response > 0 ? $invObj->insert_booking_paid($bo_id[$i], 6) : false;
            $no++;
        }
    }

    echo $response != false && $response > 0 ? $response : false;
} else {
    echo $response = false;
}

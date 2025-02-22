<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Receipt.php';

$recObj = new Receipt();
$today = date("Y-m-d");
$times = date("H:i:s");

function diff_date($today, $diff_date)
{
    $diff_inv = array();
    $date1 = date_create($today);
    $date2 = date_create($diff_date);
    $diff = date_diff($date1, $date2);
    $diff_inv['day'] =  $diff->format("%R%a");
    $diff_inv['num'] =  $diff->format("%a");

    return $diff_inv;
}

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $search_period = $_POST['search_period'] != "" ? $_POST['search_period'] : 'all';
    $search_rec_form = !empty($_POST['search_rec_form']) ? $_POST['search_rec_form'] : '0000-00-00';
    $search_rec_to = !empty($_POST['search_rec_to']) ? $_POST['search_rec_to'] : '0000-00-00';
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 0;

    $first_rec = array();
    $first_inv = array();
    $first_ext = array();
    $total = 0;
    $receipts = $recObj->showlistreceipt($search_period, $search_rec_form, $search_rec_to, $search_agent, 'list', 0);
    # --- Check Invoice --- #
    if (!empty($receipts)) {
        foreach ($receipts as $receipt) {
            if (in_array($receipt['id'], $first_rec) == false) {
                $first_rec[] = $receipt['id'];
                # --- get value invoice --- #
                $is_approved[] = !empty($receipt['is_approved']) ? $receipt['is_approved'] : 0;
                $rec_id[] = !empty($receipt['id']) ? $receipt['id'] : 0;
                $rec_date[] = !empty($receipt['rec_date']) ? $receipt['rec_date'] : 0;
                $rec_full[] = !empty($receipt['rec_full']) ? $receipt['rec_full'] : '';
                $inv_full[] = !empty($receipt['inv_full']) ? $receipt['inv_full'] : '';
                $book_full[] = !empty($receipt['book_full']) ? $receipt['book_full'] : '';
                $brch_name[] = !empty($receipt['brch_name']) ? $receipt['brch_name'] : '';
                $payment[] = !empty($receipt['payt_id']) ? $receipt['payt_id'] : '';
                $banacc[] = !empty($receipt['banacc_id']) ? $receipt['banacc_id'] : '';
                $bank[] = !empty($receipt['bank_id']) ? $receipt['bank_id'] : '';
                $cheque_no[] = !empty($receipt['cheque_no']) ? $receipt['cheque_no'] : '';
                $cheque_date[] = !empty($receipt['cheque_date']) ? $receipt['cheque_date'] : '';
                $note[] = !empty($receipt['note']) ? $receipt['note'] : '';
                $vat[] = !empty($receipt['vat_id']) ? $receipt['vat_id'] : 0;
                $vat_name[] = !empty($receipt['vat_name']) ? $receipt['vat_name'] : 0;
                $withholding[] = !empty($receipt['withholding']) ? $receipt['withholding'] : 0;
                # --- get value company agent --- #
                $agent_id[] = !empty($receipt['comp_id']) ? $receipt['comp_id'] : 0;
                $agent_name[] = !empty($receipt['comp_name']) ? $receipt['comp_name'] : '';
                $agent_address[] = !empty($receipt['comp_address']) ? $receipt['comp_address'] : '';
                $agent_telephone[] = !empty($receipt['comp_telephone']) ? $receipt['comp_telephone'] : '';
                $agent_tat[] = !empty($receipt['comp_tat']) ? $receipt['comp_tat'] : '';
            }

            if (in_array($receipt['inv_id'], $first_inv) == false) {
                $first_inv[] = $receipt['inv_id'];
                $inv_id[$receipt['id']][] = !empty($receipt['inv_id']) ? $receipt['inv_id'] : 0;
                $inv_no[$receipt['id']][] = !empty($receipt['inv_no']) ? $receipt['inv_no'] : 0;
                $bo_id[$receipt['id']][] = !empty($receipt['bo_id']) ? $receipt['bo_id'] : 0;
                $voucher_no_agent[$receipt['id']][] = !empty($receipt['voucher_no_agent']) ? $receipt['voucher_no_agent'] : '';
                $travel_date[$receipt['id']][] = !empty($receipt['travel_date']) ? date("j F Y", strtotime($receipt['travel_date'])) : 0;
                $discount[$receipt['id']][] = !empty($receipt['discount']) ? $receipt['discount'] : 0;
                # --- get value payment --- #
                $bopay_id[$receipt['id']][] = !empty($receipt['bopay_id']) ? $receipt['bopay_id'] : 0;
                $total_paid[$receipt['id']][] = !empty($receipt['bopay_id']) ? $receipt['total_paid'] : 0;
                # --- calculator --- #
                $transfer_type[$receipt['id']][] = !empty($receipt['transfer_type']) ? $receipt['transfer_type'] : 0;
                $rate_total[$receipt['id']][] = !empty($receipt['rate_total']) ? $receipt['rate_total'] : 0;
                $bt_adult[$receipt['id']][] = !empty($receipt['bt_adult']) ? $receipt['bt_adult'] : 0;
                $bt_child[$receipt['id']][] = !empty($receipt['bt_child']) ? $receipt['bt_child'] : 0;
                $bt_infant[$receipt['id']][] = !empty($receipt['bt_infant']) ? $receipt['bt_infant'] : 0;
                $btr_rate_adult[$receipt['id']][] = !empty($receipt['btr_rate_adult']) && $receipt['transfer_type'] == 1 ? $receipt['btr_rate_adult'] : 0;
                $btr_rate_child[$receipt['id']][] = !empty($receipt['btr_rate_child']) && $receipt['transfer_type'] == 1 ? $receipt['btr_rate_child'] : 0;
                $btr_rate_infant[$receipt['id']][] = !empty($receipt['btr_rate_infant']) && $receipt['transfer_type'] == 1 ? $receipt['btr_rate_infant'] : 0;
            }
            # --- get value booking extra chang --- #
            if ((in_array($receipt['bec_id'], $first_ext) == false) && !empty($receipt['bec_id'])) {
                $first_ext[] = $receipt['bec_id'];
                $bec_id[$receipt['bo_id']][] = !empty($receipt['bec_id']) ? $receipt['bec_id'] : 0;
                $extra_name[$receipt['bo_id']][] = !empty($receipt['extra_name']) ? $receipt['extra_name'] : '';
                $bec_name[$receipt['bo_id']][] = !empty($receipt['bec_name']) ? $receipt['bec_name'] : '';
                $bec_type[$receipt['bo_id']][] = !empty($receipt['bec_type']) ? $receipt['bec_type'] : 0;
                $bec_adult[$receipt['bo_id']][] = !empty($receipt['bec_adult']) ? $receipt['bec_adult'] : 0;
                $bec_child[$receipt['bo_id']][] = !empty($receipt['bec_child']) ? $receipt['bec_child'] : 0;
                $bec_infant[$receipt['bo_id']][] = !empty($receipt['bec_infant']) ? $receipt['bec_infant'] : 0;
                $bec_privates[$receipt['bo_id']][] = !empty($receipt['bec_privates']) ? $receipt['bec_privates'] : 0;
                $bec_rate_adult[$receipt['bo_id']][] = !empty($receipt['bec_rate_adult']) ? $receipt['bec_rate_adult'] : 0;
                $bec_rate_child[$receipt['bo_id']][] = !empty($receipt['bec_rate_child']) ? $receipt['bec_rate_child'] : 0;
                $bec_rate_infant[$receipt['bo_id']][] = !empty($receipt['bec_rate_infant']) ? $receipt['bec_rate_infant'] : 0;
                $bec_rate_private[$receipt['bo_id']][] = !empty($receipt['bec_rate_private']) ? $receipt['bec_rate_private'] : 0;
            }
        }
    }
?>
    <table class="table table-bordered">
        <thead class="bg-primary bg-darken-2 text-white">
            <tr>
                <th>REC DATE</th>
                <th>RECEIPT NO.</th>
                <th>INVOICE NO.</th>
                <th class="cell-fit">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rec_id)) {
                for ($i = 0; $i < count($rec_id); $i++) {
                    $href = 'href="javascript:void(0)" style="color:#6E6B7B" data-toggle="modal" data-target="#modal-show-receipt" onclick="modal_show_receipt(\'' . $rec_id[$i] . '\');"';
                    for ($b = 0; $b < count($rate_total[$rec_id[$i]]); $b++) {
                        $total = 0;
                        $total = $total + $rate_total[$rec_id[$i]][$b];
                        $total = $transfer_type[$rec_id[$i]][$b] == 1 ? $total + ($bt_adult[$rec_id[$i]][$b] * $btr_rate_adult[$rec_id[$i]][$b]) : $total;
                        $total = $transfer_type[$rec_id[$i]][$b] == 1 ? $total + ($bt_child[$rec_id[$i]][$b] * $btr_rate_child[$rec_id[$i]][$b]) : $total;
                        $total = $transfer_type[$rec_id[$i]][$b] == 1 ? $total + ($bt_infant[$rec_id[$i]][$b] * $btr_rate_infant[$rec_id[$i]][$b]) : $total;
                        $total = $transfer_type[$rec_id[$i]][$b] == 2 ? $recObj->sumbtrprivate($bt_id[$rec_id[$i]][$b])['sum_rate_private'] + $total : $total;
                        if (!empty($bec_id[$bo_id[$rec_id[$i]][$b]])) {
                            for ($a = 0; $a < count($bec_id[$bo_id[$rec_id[$i]][$b]]); $a++) {
                                $total = $bec_type[$bo_id[$rec_id[$i]][$b]][$a] == 1 ? $total + ($bec_adult[$bo_id[$rec_id[$i]][$b]][$a] * $bec_rate_adult[$bo_id[$rec_id[$i]][$b]][$a]) + ($bec_child[$bo_id[$rec_id[$i]][$b]][$a] * $bec_rate_child[$bo_id[$rec_id[$i]][$b]][$a]) + ($bec_infant[$bo_id[$rec_id[$i]][$b]][$a] * $bec_rate_infant[$bo_id[$rec_id[$i]][$b]][$a]) : $total;
                                $total = $bec_type[$bo_id[$rec_id[$i]][$b]][$a] == 2 ? $total + ($bec_privates[$bo_id[$rec_id[$i]][$b]][$a] * $bec_rate_private[$bo_id[$rec_id[$i]][$b]][$a]) : $total;
                            }
                        }
                        $array_bo_total[$rec_id[$i]][] = $total;
                        $total = $total - $discount[$rec_id[$i]][$b];
                        // $total = ($bo_bopay_id[$rec_id[$i]][$b] == 4 || $bo_bopay_id[$rec_id[$i]][$b] == 5) ? $total - $bo_total_paid[$rec_id[$i]][$b] : $total;
                        $array_total[$rec_id[$i]][] = $total;
                    }
            ?>
                    <tr>
                        <td>
                            <a <?php echo $href; ?>><?php echo date("j F Y", strtotime($rec_date[$i])); ?></a>
                            <input type="hidden" id="<?php echo 'rec' . $rec_id[$i]; ?>" name="<?php echo 'rec' . $rec_id[$i]; ?>" value="<?php echo $rec_id[$i]; ?>" data-bo_id='<?php echo json_encode($bo_id[$rec_id[$i]]); ?>' data-inv_id='<?php echo json_encode($inv_id[$rec_id[$i]]); ?>' data-inv_full="<?php echo $inv_full[$i]; ?>" data-inv_no='<?php echo json_encode($inv_no[$rec_id[$i]]); ?>' data-voucher='<?php echo json_encode($voucher_no_agent[$rec_id[$i]]); ?>' data-is_approved="<?php echo $is_approved[$i]; ?>" data-rec_date="<?php echo $rec_date[$i]; ?>" data-travel_date='<?php echo json_encode($travel_date[$rec_id[$i]]); ?>' data-branche="<?php echo $brch_name[$i]; ?>" data-payment="<?php echo $payment[$i]; ?>" data-bank="<?php echo $bank[$i]; ?>" data-banacc="<?php echo $banacc[$i]; ?>" data-cheque_no="<?php echo $cheque_no[$i]; ?>" data-cheque_date="<?php echo $cheque_date[$i]; ?>" data-note="<?php echo $note[$i]; ?>" data-vat="<?php echo $vat[$i]; ?>" data-vat_name="<?php echo $vat_name[$i]; ?>" data-withholding="<?php echo $withholding[$i]; ?>" data-agent_name="<?php echo $agent_name[$i]; ?>" data-agent_address="<?php echo $agent_address[$i]; ?>" data-agent_telephone="<?php echo $agent_telephone[$i]; ?>" data-agent_tat="<?php echo $agent_tat[$i]; ?>" data-payment_id='<?php echo json_encode($bopay_id[$rec_id[$i]]); ?>' data-payment_paid='<?php echo json_encode($total_paid[$rec_id[$i]]); ?>' data-discount='<?php echo json_encode($discount[$rec_id[$i]]); ?>' data-total='<?php echo json_encode($array_total[$rec_id[$i]]); ?>' />
                        </td>
                        <td><a <?php echo $href; ?>><?php echo $rec_full[$i]; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $inv_full[$i]; ?></a></td>
                        <td class="text-right"><a <?php echo $href; ?>><?php echo number_format(array_sum($array_total[$rec_id[$i]])); ?></a></td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
<?php
} else {
    echo $bookings = false;
}

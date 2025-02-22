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
    $search_due_form = $_POST['search_due_form'] != "" ? $_POST['search_due_form'] : '0000-00-00';
    $search_due_to = $_POST['search_due_to'] != "" ? $_POST['search_due_to'] : '0000-00-00';
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 'all';
    $total = 0;
    $first_inv = array();
    $first_cover = array();
    $first_ext = array();
    $invoices = $recObj->showlistinvoice($search_period, $search_due_form, $search_due_to, $search_agent);
    # --- Check products --- #
    if (!empty($invoices)) {
        foreach ($invoices as $invoice) {
            # --- get value invoice --- #
            if ((in_array($invoice['cover_id'], $first_cover) == false)) {
                $first_cover[] = $invoice['cover_id'];
                $cover_id[] = !empty($invoice['cover_id']) ? $invoice['cover_id'] : 0;
                $inv_full[] = !empty($invoice['inv_full']) ? $invoice['inv_full'] : 0;
                $rec_date[] = !empty($invoice['rec_date']) ? $invoice['rec_date'] : 0;
                $vat_id[] = !empty($invoice['vat_id']) ? $invoice['vat_id'] : 0;
                $vat_name[] = !empty($invoice['vat_name']) ? $invoice['vat_name'] : '-';
                $withholding[] = !empty($invoice['withholding']) ? $invoice['withholding'] : 0;
                $status[] = (diff_date($today, $invoice['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">ครบกำหนดชำระในอีก ' . diff_date($today, $invoice['rec_date'])['num'] . ' วัน</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">เกินกำหนดชำระมาแล้ว ' . diff_date($today, $invoice['rec_date'])['num'] . ' วัน</span>';
            }

            if ((in_array($invoice['id'], $first_inv) == false)) {
                $first_inv[] = $invoice['id'];
                $inv_id[$invoice['cover_id']][] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $inv_no[$invoice['cover_id']][] = !empty($invoice['no']) ? $invoice['no'] : 0;
                $bo_id[$invoice['cover_id']][] = !empty($invoice['bo_id']) ? $invoice['bo_id'] : 0;
                $travel_date[$invoice['cover_id']][] = !empty($invoice['travel_date']) ? $invoice['travel_date'] : 0;
                $book_full[$invoice['cover_id']][] = !empty($invoice['book_full']) ? $invoice['book_full'] : 0;
                $voucher_no[$invoice['cover_id']][] = !empty($invoice['voucher_no_agent']) ? $invoice['voucher_no_agent'] : 0;
                $brch_name[$invoice['cover_id']][] = !empty($invoice['brch_name']) ? $invoice['brch_name'] : '-';
                $discount[$invoice['cover_id']][] = !empty($invoice['discount']) ? $invoice['discount'] : 0;
                # --- get value company agent --- #
                $agent_id[$invoice['cover_id']][] = !empty($invoice['comp_id']) ? $invoice['comp_id'] : 0;
                $agent_name[$invoice['cover_id']][] = !empty($invoice['comp_name']) ? $invoice['comp_name'] : '';
                $agent_address[$invoice['cover_id']][] = !empty($invoice['comp_address']) ? $invoice['comp_address'] : '';
                $agent_telephone[$invoice['cover_id']][] = !empty($invoice['comp_telephone']) ? $invoice['comp_telephone'] : '';
                $agent_tat[$invoice['cover_id']][] = !empty($invoice['comp_tat']) ? $invoice['comp_tat'] : '';
                # --- get value payment --- #
                $bopay_id[$invoice['cover_id']][] = !empty($invoice['bopay_id']) ? $invoice['bopay_id'] : 0;
                $bopay_name[$invoice['cover_id']][] = !empty($invoice['bopay_name']) ? $invoice['bopay_name'] : 0;
                $total_paid[$invoice['cover_id']][] = !empty($invoice['bopay_id']) ? $invoice['total_paid'] : 0;
                # --- calculator --- #
                $bo_bopay_id[$invoice['bo_id']] = !empty($invoice['bopay_id']) ? $invoice['bopay_id'] : 0;
                $bo_total_paid[$invoice['bo_id']] = !empty($invoice['bopay_id']) ? $invoice['total_paid'] : 0;
                $bt_id[$invoice['bo_id']] = !empty($invoice['bt_id']) ? $invoice['bt_id'] : 0;
                $transfer_type[$invoice['bo_id']] = !empty($invoice['transfer_type']) ? $invoice['transfer_type'] : 0;
                $rate_total[$invoice['bo_id']] = !empty($invoice['rate_total']) ? $invoice['rate_total'] : 0;
                $bt_adult[$invoice['bo_id']] = !empty($invoice['bt_adult']) ? $invoice['bt_adult'] : 0;
                $bt_child[$invoice['bo_id']] = !empty($invoice['bt_child']) ? $invoice['bt_child'] : 0;
                $bt_infant[$invoice['bo_id']] = !empty($invoice['bt_infant']) ? $invoice['bt_infant'] : 0;
                $btr_rate_adult[$invoice['bo_id']] = !empty($invoice['btr_rate_adult']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_adult'] : 0;
                $btr_rate_child[$invoice['bo_id']] = !empty($invoice['btr_rate_child']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_child'] : 0;
                $btr_rate_infant[$invoice['bo_id']] = !empty($invoice['btr_rate_infant']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_infant'] : 0;
            }
            # --- get value booking extra chang --- #
            if ((in_array($invoice['bec_id'], $first_ext) == false) && !empty($invoice['bec_id'])) {
                $first_ext[] = $invoice['bec_id'];
                $bec_id[$invoice['bo_id']][] = !empty($invoice['bec_id']) ? $invoice['bec_id'] : 0;
                $extra_name[$invoice['bo_id']][] = !empty($invoice['extra_name']) ? $invoice['extra_name'] : '';
                $bec_name[$invoice['bo_id']][] = !empty($invoice['bec_name']) ? $invoice['bec_name'] : '';
                $bec_type[$invoice['bo_id']][] = !empty($invoice['bec_type']) ? $invoice['bec_type'] : 0;
                $bec_adult[$invoice['bo_id']][] = !empty($invoice['bec_adult']) ? $invoice['bec_adult'] : 0;
                $bec_child[$invoice['bo_id']][] = !empty($invoice['bec_child']) ? $invoice['bec_child'] : 0;
                $bec_infant[$invoice['bo_id']][] = !empty($invoice['bec_infant']) ? $invoice['bec_infant'] : 0;
                $bec_privates[$invoice['bo_id']][] = !empty($invoice['bec_privates']) ? $invoice['bec_privates'] : 0;
                $bec_rate_adult[$invoice['bo_id']][] = !empty($invoice['bec_rate_adult']) ? $invoice['bec_rate_adult'] : 0;
                $bec_rate_child[$invoice['bo_id']][] = !empty($invoice['bec_rate_child']) ? $invoice['bec_rate_child'] : 0;
                $bec_rate_infant[$invoice['bo_id']][] = !empty($invoice['bec_rate_infant']) ? $invoice['bec_rate_infant'] : 0;
                $bec_rate_private[$invoice['bo_id']][] = !empty($invoice['bec_rate_private']) ? $invoice['bec_rate_private'] : 0;
                # --- get value array booking extra charge --- #
                $array_extra[$invoice['bo_id']]['bec_id'][] = !empty($invoice['bec_id']) ? $invoice['bec_id'] : '';
                $array_extra[$invoice['bo_id']]['extra_name'][] = !empty($invoice['extra_name']) ? $invoice['extra_name'] : '';
                $array_extra[$invoice['bo_id']]['bec_name'][] = !empty($invoice['bec_name']) ? $invoice['bec_name'] : '';
                $array_extra[$invoice['bo_id']]['bec_type'][] = !empty($invoice['bec_type']) ? $invoice['bec_type'] : 0;
                $array_extra[$invoice['bo_id']]['bec_adult'][] = !empty($invoice['bec_adult']) ? $invoice['bec_adult'] : 0;
                $array_extra[$invoice['bo_id']]['bec_child'][] = !empty($invoice['bec_child']) ? $invoice['bec_child'] : 0;
                $array_extra[$invoice['bo_id']]['bec_infant'][] = !empty($invoice['bec_infant']) ? $invoice['bec_infant'] : 0;
                $array_extra[$invoice['bo_id']]['bec_privates'][] = !empty($invoice['bec_privates']) ? $invoice['bec_privates'] : 0;
                $array_extra[$invoice['bo_id']]['bec_rate_adult'][] = !empty($invoice['bec_rate_adult']) ? $invoice['bec_rate_adult'] : 0;
                $array_extra[$invoice['bo_id']]['bec_rate_child'][] = !empty($invoice['bec_rate_child']) ? $invoice['bec_rate_child'] : 0;
                $array_extra[$invoice['bo_id']]['bec_rate_infant'][] = !empty($invoice['bec_rate_infant']) ? $invoice['bec_rate_infant'] : 0;
                $array_extra[$invoice['bo_id']]['bec_rate_private'][] = !empty($invoice['bec_rate_private']) ? $invoice['bec_rate_private'] : 0;
            }
        }
    }
?>
    <table class="invoice-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th class="cell-fit">STATUS</th>
                <th>AGENT</th>
                <th>DUE DATE.</th>
                <th>INVOICE NO.</th>
                <th class="cell-fit">ภาษีมูลค่าเพิ่ม</th>
                <th class="cell-fit">หัก ณ ที่จ่าย (%)</th>
                <th class="cell-fit">AMOUNT</th>
            </tr>
        </thead>
        <?php if (!empty($invoices)) { ?>
            <tbody>
                <?php
                for ($i = 0; $i < count($cover_id); $i++) {
                    # --- get value total calculator --- #
                    for ($b = 0; $b < count($bo_id[$cover_id[$i]]); $b++) {
                        $total = 0;
                        $total = $total + $rate_total[$bo_id[$cover_id[$i]][$b]];
                        $total = $transfer_type[$bo_id[$cover_id[$i]][$b]] == 1 ? $total + ($bt_adult[$bo_id[$cover_id[$i]][$b]] * $btr_rate_adult[$bo_id[$cover_id[$i]][$b]]) : $total;
                        $total = $transfer_type[$bo_id[$cover_id[$i]][$b]] == 1 ? $total + ($bt_child[$bo_id[$cover_id[$i]][$b]] * $btr_rate_child[$bo_id[$cover_id[$i]][$b]]) : $total;
                        $total = $transfer_type[$bo_id[$cover_id[$i]][$b]] == 1 ? $total + ($bt_infant[$bo_id[$cover_id[$i]][$b]] * $btr_rate_infant[$bo_id[$cover_id[$i]][$b]]) : $total;
                        $total = $transfer_type[$bo_id[$cover_id[$i]][$b]] == 2 ? $recObj->sumbtrprivate($bt_id[$bo_id[$cover_id[$i]][$b]])['sum_rate_private'] + $total : $total;
                        if (!empty($bec_id[$bo_id[$cover_id[$i]][$b]])) {
                            for ($a = 0; $a < count($bec_id[$bo_id[$cover_id[$i]][$b]]); $a++) {
                                $total = $bec_type[$bo_id[$cover_id[$i]][$b]][$a] == 1 ? $total + ($bec_adult[$bo_id[$cover_id[$i]][$b]][$a] * $bec_rate_adult[$bo_id[$cover_id[$i]][$b]][$a]) + ($bec_child[$bo_id[$cover_id[$i]][$b]][$a] * $bec_rate_child[$bo_id[$cover_id[$i]][$b]][$a]) + ($bec_infant[$bo_id[$cover_id[$i]][$b]][$a] * $bec_rate_infant[$bo_id[$cover_id[$i]][$b]][$a]) : $total;
                                $total = $bec_type[$bo_id[$cover_id[$i]][$b]][$a] == 2 ? $total + ($bec_privates[$bo_id[$cover_id[$i]][$b]][$a] * $bec_rate_private[$bo_id[$cover_id[$i]][$b]][$a]) : $total;
                            }
                        }
                        $array_bo_total[$cover_id[$i]][] = $total;
                        $total = $total - array_sum($discount[$cover_id[$i]]);
                        $total = ($bo_bopay_id[$bo_id[$cover_id[$i]][$b]] == 4 || $bo_bopay_id[$bo_id[$cover_id[$i]][$b]] == 5) ? $total - $bo_total_paid[$bo_id[$cover_id[$i]][$b]] : $total;
                        $array_total[$cover_id[$i]][] = $total;
                    }
                    $href = 'href="javascript:void(0)" style="color:#6E6B7B" data-toggle="modal" data-target="#modal_add_receipt" onclick="modal_receipt(\'' . $cover_id[$i] . '\');"';
                ?>
                    <tr>
                        <td>
                            <a <?php echo $href; ?>>
                                <?php echo $status[$i]; ?>
                                <input class="custom-control-input dt-checkboxes" type="checkbox" id="checkbox<?php echo $cover_id[$i]; ?>" name="cover_id" value="<?php echo $cover_id[$i]; ?>" data-inv_id='<?php echo json_encode($inv_id[$cover_id[$i]]); ?>' data-bo_id='<?php echo json_encode($bo_id[$cover_id[$i]]); ?>' data-inv_full="<?php echo $inv_full[$i]; ?>" data-inv_no='<?php echo json_encode($inv_no[$cover_id[$i]]); ?>' data-voucher='<?php echo json_encode($voucher_no[$cover_id[$i]]); ?>' data-cus_name="<?php echo $cus_name[$i]; ?>" data-vat_id="<?php echo $vat_id[$i]; ?>" data-vat_name="<?php echo $vat_name[$i]; ?>" data-withholding="<?php echo $withholding[$i]; ?>" data-rec_date="<?php echo date("j F Y", strtotime($rec_date[$i])); ?>" data-brch_name="<?php echo $brch_name[$cover_id[$i]][0]; ?>" data-payment_id='<?php echo json_encode($bopay_id[$cover_id[$i]]); ?>' data-payment_name='<?php echo json_encode($bopay_name[$cover_id[$i]]); ?>' data-total_paid='<?php echo json_encode($total_paid[$cover_id[$i]]); ?>' data-discount='<?php echo json_encode($discount[$cover_id[$i]]); ?>' data-total='<?php echo json_encode($array_total[$cover_id[$i]]); ?>' data-agent_name="<?php echo $agent_name[$cover_id[$i]][0]; ?>" data-agent_address="<?php echo $agent_address[$cover_id[$i]][0]; ?>" data-agent_telephone="<?php echo $agent_telephone[$cover_id[$i]][0]; ?>" data-agent_tat="<?php echo $agent_tat[$cover_id[$i]][0]; ?>" />
                            </a>
                        </td>
                        <td><a <?php echo $href; ?>><?php echo $agent_name[$cover_id[$i]][0]; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo date("j F Y", strtotime($rec_date[$i])); ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $inv_full[$i]; ?></a></td>
                        <td class="text-nowrap"><a <?php echo $href; ?>><?php echo $vat_name[$i]; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $withholding[$i]; ?></a></td>
                        <td class="text-right"><a <?php echo $href; ?>><?php echo number_format(array_sum($array_total[$cover_id[$i]])); ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $invoices = false;
}

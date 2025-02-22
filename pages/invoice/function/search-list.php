<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Invoice.php';

$invObj = new Invoice();
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
    $search_status = $_POST['search_status'] != "" ? $_POST['search_status'] : 'all';
    $search_period = $_POST['search_period'] != "" ? $_POST['search_period'] : 'all';
    $search_inv_form = !empty($_POST['search_inv_form']) ? $_POST['search_inv_form'] : '0000-00-00';
    $search_inv_to = !empty($_POST['search_inv_to']) ? $_POST['search_inv_to'] : '0000-00-00';
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 0;
    echo $search_status;

    $a = 0;
    $total = 0;
    $first_inv = array();
    $first_cover = array();
    $first_btr = array();
    $first_ext = array();
    $invoices = $invObj->showlistinvoice($search_period, $search_inv_form, $search_inv_to, $search_agent, 'list', 0, 0);
    # --- Check Invoice --- #
    if (!empty($invoices)) {
        foreach ($invoices as $invoice) {
            # --- get value booking transfer rate !transfer_type == 2! --- #
            if ((in_array($invoice['btr_id'], $first_btr) == false) && ($invoice['transfer_type'] == 2) && !empty($invoice['btr_id'])) {
                $first_btr[] = $invoice['btr_id'];
                $array_transfer[$invoice['id']]['cars_category'][] = !empty($invoice['cars_category']) ? $invoice['cars_category'] : 0;
                $array_transfer[$invoice['id']]['rate_private'][] = !empty($invoice['rate_private']) ? $invoice['rate_private'] : 0;
            }

            if (in_array($invoice['id'], $first_inv) == false) {
                $first_inv[] = $invoice['id'];
                # --- get value invoice --- #
                $is_approved[] = !empty($invoice['is_approved']) ? $invoice['is_approved'] : 0;
                $inv_id[] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $cover_id[] = !empty($invoice['cover_id']) ? $invoice['cover_id'] : 0;
                $inv_no[] = !empty($invoice['no']) ? $invoice['no'] : 0;
                $inv_full[] = !empty($invoice['inv_full']) ? $invoice['inv_full'] : 0;
                $inv_date[] = !empty($invoice['inv_date']) ? $invoice['inv_date'] : '0000-00-00';
                $rec_date[] = !empty($invoice['rec_date']) ? $invoice['rec_date'] : '0000-00-00';
                $vat_id[] = !empty($invoice['vat_id']) ? $invoice['vat_id'] : 0;
                $vat_name[] = !empty($invoice['vat_name']) ? $invoice['vat_name'] : '-';
                $withholding[] = !empty($invoice['withholding']) ? $invoice['withholding'] : 0;
                $branche[] = !empty($invoice['branche_id']) ? $invoice['branche_id'] : 0;
                $bank_account[] = !empty($invoice['bank_account_id']) ? $invoice['bank_account_id'] : 0;
                $note[] = !empty($invoice['note']) ? $invoice['note'] : '';
                $status[] = (diff_date($today, $invoice['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">วันที่ครบกำหนดชำระ : ' . date("j F Y", strtotime($invoice['rec_date'])) . ' (ครบกำหนดชำระในอีก ' . diff_date($today, $invoice['rec_date'])['num'] . ' วัน)</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">วันที่ครบกำหนดชำระ : ' . date("j F Y", strtotime($invoice['rec_date'])) . ' (เกินกำหนดชำระมาแล้ว ' . diff_date($today, $invoice['rec_date'])['num'] . ' วัน)</span>';
                # --- get value booking --- #
                $bo_id[] = !empty($invoice['bo_id']) ? $invoice['bo_id'] : 0;
                $book_full[] = !empty($invoice['book_full']) ? $invoice['book_full'] : '';
                $discount[] = !empty($invoice['discount']) ? $invoice['discount'] : 0;
                $bo_type[] = !empty($invoice['bo_type']) ? $invoice['bo_type'] : 0;
                $voucher_no_agent[] = !empty($invoice['voucher_no_agent']) ? $invoice['voucher_no_agent'] : '';
                $book_type_name[] = !empty(!empty($invoice['booking_type_id'])) ? $invoice['booktye_name'] : '';
                $book_status_name[] = !empty(!empty($invoice['booksta_name'])) ? $invoice['booksta_name'] : 0;
                # --- get value company agent --- #
                $agent_id[] = !empty($invoice['comp_id']) ? $invoice['comp_id'] : 0;
                $agent_name[] = !empty($invoice['comp_name']) ? $invoice['comp_name'] : '';
                $agent_address[] = !empty($invoice['comp_address']) ? $invoice['comp_address'] : '';
                $agent_telephone[] = !empty($invoice['comp_telephone']) ? $invoice['comp_telephone'] : '';
                $agent_tat[] = !empty($invoice['comp_tat']) ? $invoice['comp_tat'] : '';
                # --- get value booking products --- #
                $bp_id[] = !empty($invoice['bp_id']) ? $invoice['bp_id'] : 0;
                $product_name[] = !empty($invoice['product_name']) ? $invoice['product_name'] : 0;
                $travel_date[] = !empty($invoice['travel_date']) ? $invoice['travel_date'] : '0000-00-00';
                $adult[] = !empty($invoice['bpr_adult']) ? $invoice['bpr_adult'] : 0;
                $child[] = !empty($invoice['bpr_child']) ? $invoice['bpr_child'] : 0;
                $infant[] = !empty($invoice['bpr_infant']) ? $invoice['bpr_infant'] : 0;
                $private_type[] = !empty($invoice['bp_private_type']) ? $invoice['bp_private_type'] : 0;
                # --- get value booking product rate --- #
                $bpr_id[] = !empty($invoice['bpr_id']) ? $invoice['bpr_id'] : 0;
                $rate_adult[] = !empty($invoice['rate_adult']) ? $invoice['rate_adult'] : 0;
                $rate_child[] = !empty($invoice['rate_child']) ? $invoice['rate_child'] : 0;
                $rate_infant[] = !empty($invoice['rate_infant']) ? $invoice['rate_infant'] : 0;
                $rate_total[] = !empty($invoice['rate_total']) ? $invoice['rate_total'] : 0;
                # --- get value booking transfer --- #
                $bt_id[] = !empty($invoice['bt_id']) ? $invoice['bt_id'] : 0;
                $bt_adult[] = !empty($invoice['bt_adult']) ? $invoice['bt_adult'] : 0;
                $bt_child[] = !empty($invoice['bt_child']) ? $invoice['bt_child'] : 0;
                $bt_infant[] = !empty($invoice['bt_infant']) ? $invoice['bt_infant'] : 0;
                $start_pickup[] = !empty($invoice['start_pickup']) ? $invoice['start_pickup'] : '00:00:00';
                $end_pickup[] = !empty($invoice['end_pickup']) ? $invoice['end_pickup'] : '00:00:00';
                $hotel_pickup[] = !empty($invoice['hotel_pickup_id']) ? $invoice['hotel_pickup_name'] : $invoice['hotel_pickup'];
                $hotel_dropoff[] = !empty($invoice['hotel_dropoff_id']) ? $invoice['hotel_dropoff_name'] : $invoice['hotel_dropoff'];
                $hotel_dropoff[] = !empty($invoice['hotel_dropoff']) ? $invoice['hotel_dropoff'] : '';
                $room_no[] = !empty($invoice['room_no']) ? $invoice['room_no'] : '';
                $transfer_type[] = !empty($invoice['transfer_type']) ? $invoice['transfer_type'] : 0;
                $pickup_type[] = !empty($invoice['pickup_type']) ? $invoice['pickup_type'] : 0;
                $pickup_id[] = !empty($invoice['pickup_id']) ? $invoice['pickup_id'] : 0;
                $pickup_name[] = !empty($invoice['pickup_name']) ? $invoice['pickup_name'] : '';
                # --- get value transfer --- #
                $bt_adult[] = !empty($invoice['bt_adult']) ? $invoice['bt_adult'] : 0;
                $bt_child[] = !empty($invoice['bt_child']) ? $invoice['bt_child'] : 0;
                $bt_infant[] = !empty($invoice['bt_infant']) ? $invoice['bt_infant'] : 0;
                $btr_rate_adult[] = !empty($invoice['btr_rate_adult']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_adult'] : 0;
                $btr_rate_child[] = !empty($invoice['btr_rate_child']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_child'] : 0;
                $btr_rate_infant[] = !empty($invoice['btr_rate_infant']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_infant'] : 0;
                $array_transfer[$invoice['id']]['bt_adult'] = !empty($invoice['bt_adult']) ? $invoice['bt_adult'] : 0;
                $array_transfer[$invoice['id']]['bt_child'] = !empty($invoice['bt_child']) ? $invoice['bt_child'] : 0;
                $array_transfer[$invoice['id']]['bt_infant'] = !empty($invoice['bt_infant']) ? $invoice['bt_infant'] : 0;
                $array_transfer[$invoice['id']]['btr_rate_adult'] = !empty($invoice['btr_rate_adult']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_adult'] : 0;
                $array_transfer[$invoice['id']]['btr_rate_child'] = !empty($invoice['btr_rate_child']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_child'] : 0;
                $array_transfer[$invoice['id']]['btr_rate_infant'] = !empty($invoice['btr_rate_infant']) && $invoice['transfer_type'] == 1 ? $invoice['btr_rate_infant'] : 0;
                # --- get value customers --- #
                $cus_id[] = !empty($invoice['cus_id']) && $invoice['cus_head'] == 1 ? $invoice['cus_id'] : 0;
                $cus_name[] = !empty($invoice['cus_name']) && $invoice['cus_head'] == 1 ? $invoice['cus_name'] : '';
                $cus_whatsapp['whatsapp'][] = !empty($invoice['whatsapp']) && $invoice['cus_head'] == 1 ? $invoice['whatsapp'] : '';
                # --- get value payment --- #
                $bopay_id[] = !empty($invoice['bopay_id']) ? $invoice['bopay_id'] : 0;
                $bopay_name[] = !empty($invoice['bopay_name']) ? $invoice['bopay_name'] : '';
                $total_paid[] = !empty($invoice['bopay_id']) ? $invoice['total_paid'] : 0;
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
    <table class="table table-bordered">
        <thead class="bg-primary bg-darken-2 text-white">
            <tr>
                <th>วันที่ออก INVOICE</th>
                <th>INVOICE NO.</th>
                <th>BOOKING NO.</th>
                <th>AGENT VOUCHER NO.</th>
                <th class="cell-fit">ภาษีมูลค่าเพิ่ม</th>
                <th class="cell-fit">หัก ณ ที่จ่าย (%)</th>
                <th class="cell-fit">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($inv_id)) {
                for ($i = 0; $i < count($inv_id); $i++) {
                    $href = 'href="javascript:void(0)" style="color:#6E6B7B" data-toggle="modal" data-target="#modal-show-invoice" onclick="modal_show_invoice(\'' . $inv_id[$i] . '\', \'0\');"';
                    if ((in_array($cover_id[$i], $first_cover) == false) && $inv_no[$i] > 0) {
                        $first_cover[] = $cover_id[$i];
                        $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                        $a++;
                        $no = $invObj->get_data('MAX(no) as no', 'invoices', 'cover_id = ' . $cover_id[$i])['no'];
                        echo '<tr class="' . $class_tr . '">
                                                    <td colspan="8">
                                                        <a href="javascript:void(0)" style="color:#6E6B7B" data-toggle="modal" data-target="#modal-show-invoice" onclick="modal_show_invoice(\'0\', \'' . $cover_id[$i] . '\');"><span class="text-bold text-primary">ใบปะหน้า ใบใน ' . $no . ' ใบ : ' . $inv_full[$i] . ' (' . $agent_name[$i] . ')</span> ' . $status[$i] . '</a>
                                                    </td>
                                                </tr>';
                    }
                    if ($inv_no[$i] == 0) {
                        $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                        $a++;
                        echo '<tr class="' . $class_tr . '"><td colspan="8"><a ' . $href . '><span class="text-bold text-primary">' . $inv_full[$i] . ' (' . $agent_name[$i] . ')</span> ' . $status[$i] . '</a></td></tr>';
                    }
                    # --- get value total --- #
                    $total = $rate_total[$i];
                    $total = $transfer_type[$i] == 1 ? $total + ($bt_adult[$i] * $btr_rate_adult[$i]) : $total;
                    $total = $transfer_type[$i] == 1 ? $total + ($bt_child[$i] * $btr_rate_child[$i]) : $total;
                    $total = $transfer_type[$i] == 1 ? $total + ($bt_infant[$i] * $btr_rate_infant[$i]) : $total;
                    $total = $transfer_type[$i] == 2 ? $invObj->sumbtrprivate($bt_id[$i])['sum_rate_private'] + $total : $total;
                    if (!empty($bec_id[$bo_id[$i]])) {
                        for ($a = 0; $a < count($bec_id[$bo_id[$i]]); $a++) {
                            $total = $bec_type[$bo_id[$i]][$a] == 1 ? $total + ($bec_adult[$bo_id[$i]][$a] * $bec_rate_adult[$bo_id[$i]][$a]) + ($bec_child[$bo_id[$i]][$a] * $bec_rate_child[$bo_id[$i]][$a]) + ($bec_infant[$bo_id[$i]][$a] * $bec_rate_infant[$bo_id[$i]][$a]) : $total;
                            $total = $bec_type[$bo_id[$i]][$a] == 2 ? $total + ($bec_privates[$bo_id[$i]][$a] * $bec_rate_private[$bo_id[$i]][$a]) : $total;
                        }
                    }
                    $bo_sum = $total;
                    $total = $total - $discount[$i];
                    $total = ($bopay_id[$i] == 4 || $bopay_id[$i] == 5) ? $total - $total_paid[$i] : $total;
            ?>
                    <tr class="<?php echo $class_tr; ?>">
                        <td><a <?php echo $href; ?>><?php echo date("j F Y", strtotime($inv_date[$i])); ?></a></td>
                        <td>
                            <a <?php echo $href; ?>><?php echo $inv_no[$i] > 0 ? $inv_full[$i] . '/' . $inv_no[$i] : $inv_full[$i]; ?></a>
                            <input type="hidden" class="<?php echo 'cover' . $cover_id[$i]; ?>" id="<?php echo 'inv' . $inv_id[$i]; ?>" name="<?php echo 'inv' . $inv_id[$i]; ?>" value="<?php echo $inv_id[$i]; ?>" data-is_approved="<?php echo $is_approved[$i]; ?>" data-inv_date="<?php echo $inv_date[$i]; ?>" data-rec_date="<?php echo $rec_date[$i]; ?>" data-vat_id="<?php echo $vat_id[$i]; ?>" data-withholding="<?php echo $withholding[$i]; ?>" data-branche="<?php echo $branche[$i]; ?>" data-bank_account="<?php echo $bank_account[$i]; ?>" data-note="<?php echo $note[$i]; ?>" data-bo_id="<?php echo $bo_id[$i]; ?>" data-bo_type="<?php echo $bo_type[$i]; ?>" data-voucher="<?php echo $voucher_no_agent[$i]; ?>" data-payment_id="<?php echo $bopay_id[$i]; ?>" data-payment_name="<?php echo $bopay_name[$i]; ?>" data-total_paid="<?php echo $total_paid[$i]; ?>" data-inv_full="<?php echo $inv_full[$i]; ?>" data-book_full="<?php echo $book_full[$i]; ?>" data-programe_name="<?php echo $product_name[$i]; ?>" data-travel_date="<?php echo date('j F Y', strtotime($travel_date[$i])); ?>" data-cus_name="<?php echo $cus_name[$i]; ?>" data-adult="<?php echo $adult[$i]; ?>" data-child="<?php echo $child[$i]; ?>" data-infant="<?php echo $infant[$i]; ?>" data-room_no="<?php echo $room_no[$i]; ?>" data-hotel_pickup="<?php echo $hotel_pickup[$i]; ?>" data-pickup_time="<?php echo date("H:i", strtotime($start_pickup[$i])) . ' - ' . date("H:i", strtotime($end_pickup[$i])) . ' น.'; ?>" data-rate_adult="<?php echo $rate_adult[$i]; ?>" data-rate_child="<?php echo $rate_child[$i]; ?>" data-rate_infant="<?php echo $rate_infant[$i]; ?>" data-rate_total="<?php echo $rate_total[$i]; ?>" data-discount="<?php echo $discount[$i]; ?>" data-total="<?php echo $bo_sum; ?>" data-agent_name="<?php echo $agent_name[$i]; ?>" data-agent_address="<?php echo $agent_address[$i]; ?>" data-agent_telephone="<?php echo $agent_telephone[$i]; ?>" data-agent_tat="<?php echo $agent_tat[$i]; ?>" data-transfer_type="<?php echo $transfer_type[$i]; ?>" data-transfer='<?php echo json_encode($array_transfer[$inv_id[$i]]); ?>' data-extra='<?php echo !empty($array_extra[$bo_id[$i]]) ? json_encode($array_extra[$bo_id[$i]]) : ''; ?>' />
                        </td>
                        <td><a <?php echo $href; ?>><?php echo $book_full[$i]; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $voucher_no_agent[$i]; ?></a></td>
                        <td class="text-nowrap"><a <?php echo $href; ?>><?php echo $vat_name[$i]; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $withholding[$i]; ?></a></td>
                        <td class="text-right"><a <?php echo $href; ?>><?php echo number_format($total); ?></a></td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
<?php
} else {
    echo $invoices = false;
}

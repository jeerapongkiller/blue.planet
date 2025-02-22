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

if (isset($_POST['action']) && $_POST['action'] == "search-booking" && !empty($_POST['travel_date'])) {
    // get value from ajax
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';

    $first_booking = array();
    $first_company = array();
    $first_bpr = array();
    $first_extar = array();
    $bookings = $invObj->showlist('bookings', $travel_date, 'all', 0);
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value agent --- #
            if (in_array($booking['comp_id'], $first_company) == false && !empty($booking['comp_id'])) {
                $first_company[] = $booking['comp_id'];
                $agent_id[] = !empty($booking['comp_id']) ? $booking['comp_id'] : 0;
                $agent_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
            }
            # --- get value booking --- #
            if (in_array($booking['id'], $first_booking) == false) {
                $first_booking[] = $booking['id'];
                $bo_id[$booking['comp_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                // $adult[$booking['comp_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                // $child[$booking['comp_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                // $infant[$booking['comp_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                // $foc[$booking['comp_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                // $tourrist[$booking['comp_id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
                $cot[$booking['comp_id']][] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
            }
            # --- get value rates --- #
            if ((in_array($booking['bpr_id'], $first_bpr) == false) && !empty($booking['bpr_id'])) {
                $first_bpr[] = $booking['bpr_id'];
                $bpr_id[$booking['comp_id']][] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
                $category_id[$booking['comp_id']][] = !empty($booking['category_id']) ? $booking['category_id'] : 0;
                $category_name[$booking['comp_id']][] = !empty($booking['category_name']) ? $booking['category_name'] : 0;
                $category_cus[$booking['comp_id']][] = !empty($booking['category_cus']) ? $booking['category_cus'] : 0;
                $adult[$booking['comp_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $child[$booking['comp_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $infant[$booking['comp_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $foc[$booking['comp_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                $tourrist[$booking['comp_id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
                $rate_total[$booking['comp_id']][] = $booking['bp_private_type'] == 1 ? ($booking['booksta_id'] != 2 && $booking['booksta_id'] != 4) ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'] : $booking['rate_total'];
            }
            # --- get value booking --- #
            if (in_array($booking['bec_id'], $first_extar) == false && (!empty($booking['extra_id']) || !empty($booking['bec_name']))) {
                $first_extar[] = $booking['bec_id'];
                $total_extar[$booking['comp_id']][] = $booking['bec_type'] == 1 ? ($booking['bec_adult'] * $booking['bec_rate_adult']) + ($booking['bec_child'] * $booking['bec_rate_child']) : ($booking['bec_privates'] * $booking['bec_rate_private']);
            }
        }
    }
?>

    <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1">
        <div class="col-4 text-left text-bold h4"></div>
        <div class="col-4 text-center text-bold h4"><?php echo !empty(substr($travel_date, 14, 24)) ? date('j F Y', strtotime(substr($travel_date, 0, 10))) . ' - ' . date('j F Y', strtotime(substr($travel_date, 14, 24))) : date('j F Y', strtotime($travel_date)); ?></div>
        <div class="col-4 text-right mb-50"></div>
    </div>

    <?php if (!empty($agent_id)) { ?>
        <table class="table table-striped text-uppercase table-vouchure-t2">
            <thead class="bg-light">
                <tr>
                    <th>ชื่อเอเยนต์</th>
                    <th class="text-center">Booking</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Audlt</th>
                    <th class="text-center">Children</th>
                    <th class="text-center">Infant</th>
                    <th class="text-center">FOC</th>
                    <th class="text-center">COT</th>
                    <th class="text-center">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                for ($i = 0; $i < count($agent_id); $i++) {
                    # -- calculator booking -- #
                    if (!empty($rate_total[$agent_id[$i]])) {
                        $total = !empty($cot[$agent_id[$i]]) ? array_sum($rate_total[$agent_id[$i]]) - array_sum($cot[$agent_id[$i]]) : array_sum($rate_total[$agent_id[$i]]); // booking
                        $total = !empty($total_extar[$agent_id[$i]]) ? $total + array_sum($total_extar[$agent_id[$i]]) : $total; // extar charge
                    } ?>
                    <tr onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail">
                        <td><?php echo $agent_name[$i]; ?></td>
                        <td class="text-center"><?php echo !empty($bo_id[$agent_id[$i]]) ? count($bo_id[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($tourrist[$agent_id[$i]]) ? array_sum($tourrist[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($adult[$agent_id[$i]]) ? array_sum($adult[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($child[$agent_id[$i]]) ? array_sum($child[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($infant[$agent_id[$i]]) ? array_sum($infant[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($foc[$agent_id[$i]]) ? array_sum($foc[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($cot[$agent_id[$i]]) ? number_format(array_sum($cot[$agent_id[$i]])) : 0; ?></td>
                        <td class="text-center"><?php echo number_format($total, 2);  ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

<?php
} elseif (isset($_POST['action']) && $_POST['action'] == "search-invoice" && !empty($_POST['travel_date'])) {
    // get value from ajax
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';

    $first_cover = array();
    $first_company = array();
    $first_booking = array();
    $first_bpr = array();
    $first_extar = array();
    $invoices = $invObj->showlist('invoices', $travel_date, 'all', 0);
    if (!empty($invoices)) {
        foreach ($invoices as $invoice) {
            # --- get value booking --- #
            if (in_array($invoice['cover_id'], $first_cover) == false) {
                $first_cover[] = $invoice['cover_id'];
                $cover_id[$invoice['comp_id']][] = !empty($invoice['cover_id']) ? $invoice['cover_id'] : 0;
                $inv_full[$invoice['comp_id']][] = !empty($invoice['inv_full']) ? $invoice['inv_full'] : '';
                $inv_date[$invoice['comp_id']][] = !empty($invoice['inv_date']) ? $invoice['inv_date'] : '0000-00-00';
                $rec_date[$invoice['comp_id']][] = !empty($invoice['rec_date']) ? $invoice['rec_date'] : '0000-00-00';
                $vat[$invoice['comp_id']][] = !empty($invoice['vat']) ? $invoice['vat'] : '-';
                $withholding[$invoice['comp_id']][] = !empty($invoice['withholding']) ? $invoice['withholding'] : '-';
                $due_date[$invoice['comp_id']][] = (diff_date($today, $invoice['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">วันที่ครบกำหนดชำระ : ' . date("j F Y", strtotime($invoice['rec_date'])) . ' (ครบกำหนดชำระในอีก ' . diff_date($today, $invoice['rec_date'])['num'] . ' วัน)</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">วันที่ครบกำหนดชำระ : ' . date("j F Y", strtotime($invoice['rec_date'])) . ' (เกินกำหนดชำระมาแล้ว ' . diff_date($today, $invoice['rec_date'])['num'] . ' วัน)</span>';
            }
            # --- get value agent --- #
            if (in_array($invoice['comp_id'], $first_company) == false && !empty($invoice['comp_id'])) {
                $first_company[] = $invoice['comp_id'];
                $agent_id[] = !empty($invoice['comp_id']) ? $invoice['comp_id'] : 0;
                $agent_name[] = !empty($invoice['comp_name']) ? $invoice['comp_name'] : '';
            }
            # --- get value booking --- #
            if (in_array($invoice['id'], $first_booking) == false) {
                $first_booking[] = $invoice['id'];
                $bo_id[$invoice['comp_id']][] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $bo_inv[$invoice['cover_id']][] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $cot[$invoice['comp_id']][] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : 0;
                $cot_comp[$invoice['comp_id']][] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : 0;
                $cot_inv[$invoice['cover_id']][] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : 0;
            }
            # --- get value rates --- #
            if ((in_array($invoice['bpr_id'], $first_bpr) == false) && !empty($invoice['bpr_id'])) {
                $first_bpr[] = $invoice['bpr_id'];
                $bpr_id[$invoice['comp_id']][] = !empty($invoice['bpr_id']) ? $invoice['bpr_id'] : 0;
                $category_id[$invoice['comp_id']][] = !empty($invoice['category_id']) ? $invoice['category_id'] : 0;
                $category_name[$invoice['comp_id']][] = !empty($invoice['category_name']) ? $invoice['category_name'] : 0;
                $category_cus[$invoice['comp_id']][] = !empty($invoice['category_cus']) ? $invoice['category_cus'] : 0;
                $adult[$invoice['comp_id']][] = !empty($invoice['bpr_adult']) ? $invoice['bpr_adult'] : 0;
                $child[$invoice['comp_id']][] = !empty($invoice['bpr_child']) ? $invoice['bpr_child'] : 0;
                $infant[$invoice['comp_id']][] = !empty($invoice['bpr_infant']) ? $invoice['bpr_infant'] : 0;
                $foc[$invoice['comp_id']][] = !empty($invoice['bpr_foc']) ? $invoice['bpr_foc'] : 0;
                $tourrist[$invoice['comp_id']][] = $invoice['bpr_adult'] + $invoice['bpr_child'] + $invoice['bpr_infant'] + $invoice['bpr_foc'];
                $total_comp[$invoice['comp_id']][] = $invoice['bp_private_type'] == 1 ? ($invoice['booksta_id'] != 2 && $invoice['booksta_id'] != 4) ? ($invoice['bpr_adult'] * $invoice['rate_adult']) + ($invoice['bpr_child'] * $invoice['rate_child']) : $invoice['rate_total'] : $invoice['rate_total'];
                $total_inv[$invoice['cover_id']][] = $invoice['bp_private_type'] == 1 ? ($invoice['booksta_id'] != 2 && $invoice['booksta_id'] != 4) ? ($invoice['bpr_adult'] * $invoice['rate_adult']) + ($invoice['bpr_child'] * $invoice['rate_child']) : $invoice['rate_total'] : $invoice['rate_total'];
            }
            # --- get value booking --- #
            if (in_array($invoice['bec_id'], $first_extar) == false && (!empty($invoice['extra_id']) || !empty($invoice['bec_name']))) {
                $first_extar[] = $invoice['bec_id'];
                $extar['agent'][$invoice['comp_id']][] = $invoice['bec_type'] == 1 ? ($invoice['bec_adult'] * $invoice['bec_rate_adult']) + ($invoice['bec_child'] * $invoice['bec_rate_child']) : ($invoice['bec_privates'] * $invoice['bec_rate_private']);
                $extar['inv'][$invoice['cover_id']][] = $invoice['bec_type'] == 1 ? ($invoice['bec_adult'] * $invoice['bec_rate_adult']) + ($invoice['bec_child'] * $invoice['bec_rate_child']) : ($invoice['bec_privates'] * $invoice['bec_rate_private']);
            }
        }
    }
?>
    <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1">
        <div class="col-4 text-left text-bold h4"></div>
        <div class="col-4 text-center text-bold h4"><?php echo !empty(substr($travel_date, 14, 24)) ? date('j F Y', strtotime(substr($travel_date, 0, 10))) . ' - ' . date('j F Y', strtotime(substr($travel_date, 14, 24))) : date('j F Y', strtotime($travel_date)); ?></div>
        <div class="col-4 text-right mb-50"></div>
    </div>

    <?php if (!empty($agent_id)) { ?>
        <table class="table table-striped text-uppercase table-vouchure-t2">
            <?php for ($i = 0; $i < count($agent_id); $i++) { ?>
                <tr class="table-warning">
                    <td>ชื่อเอเยนต์</td>
                    <td class="text-center">Invoice</td>
                    <td> </td>
                    <td class="text-center">Booking</td>
                    <td class="text-center">ยอดรวม</td>
                    <td class="text-center">COT</td>
                    <td class="text-center">ยอดชำระ</td>
                </tr>
                <tr>
                    <td><b><?php echo $agent_name[$i]; ?></b></td>
                    <td class="text-center"><?php echo !empty($cover_id[$agent_id[$i]]) ? count($cover_id[$agent_id[$i]]) : 0; ?></td>
                    <td></td>
                    <td class="text-center"><?php echo !empty($bo_id[$agent_id[$i]]) ? count($bo_id[$agent_id[$i]]) : 0; ?></td>
                    <td class="text-center" ><?php echo !empty($total_comp[$agent_id[$i]]) ? !empty($extar['agent'][$agent_id[$i]]) ? number_format((array_sum($total_comp[$agent_id[$i]]) + array_sum($extar['agent'][$agent_id[$i]])), 2) : number_format(array_sum($total_comp[$agent_id[$i]]), 2) : '-'; ?></td>
                    <td class="text-center" ><?php echo !empty($cot_comp[$agent_id[$i]]) ? number_format(array_sum($cot_comp[$agent_id[$i]]), 2) : '-'; ?></td>
                    <td class="text-center"><?php echo !empty($total_comp[$agent_id[$i]]) ? !empty($extar['agent'][$agent_id[$i]]) ? number_format((array_sum($total_comp[$agent_id[$i]]) + array_sum($extar['agent'][$agent_id[$i]]) - array_sum($cot[$agent_id[$i]])), 2) : number_format(array_sum($total_comp[$agent_id[$i]]) - array_sum($cot[$agent_id[$i]]), 2) : '-'; ?></td>
                </tr>

                <tr class="table-info">
                    <td>วันที่ออก INVOICE</td>
                    <td class="text-center">Invoice No.</td>
                    <td>Due Date</td>
                    <td class="text-center" width="2%">Booking</td>
                    <td class="text-center">ยอดรวม</td>
                    <td class="text-center">COT</td>
                    <td class="text-center" width="8%">ยอดชำระ</td>
                </tr>
                <?php
                if (!empty($cover_id[$agent_id[$i]])) {
                    // $total = 0;
                    for ($a = 0; $a < count($cover_id[$agent_id[$i]]); $a++) { ?>
                        <tr data-dismiss="modal" data-toggle="modal" data-target="#modal-show" onclick="modal_show_invoice(<?php echo $cover_id[$agent_id[$i]][$a]; ?>);">
                            <td><?php echo date('j F Y', strtotime($inv_date[$agent_id[$i]][$a])); ?></td>
                            <td class="text-center"><?php echo $inv_full[$agent_id[$i]][$a]; ?></td>
                            <td><?php echo $due_date[$agent_id[$i]][$a]; ?></td>
                            <td class="text-center" width="2%"><?php echo !empty($bo_inv[$cover_id[$agent_id[$i]][$a]]) ? count([$cover_id[$agent_id[$i]][$a]]) : '-'; ?></td>
                            <td class="text-center" ><?php echo !empty($total_inv[$cover_id[$agent_id[$i]][$a]]) ? !empty($extar['inv'][$cover_id[$agent_id[$i]][$a]]) ? number_format((array_sum($total_inv[$cover_id[$agent_id[$i]][$a]]) + array_sum($extar['inv'][$cover_id[$agent_id[$i]][$a]])), 2) : number_format(array_sum($total_inv[$cover_id[$agent_id[$i]][$a]]), 2) : '-'; ?></td>
                            <td class="text-center" ><?php echo !empty($cot_inv[$cover_id[$agent_id[$i]][$a]]) ? number_format(array_sum($cot_inv[$cover_id[$agent_id[$i]][$a]]), 2) : '-'; ?></td>
                            <td class="text-center" width="8%"><?php echo !empty($total_inv[$cover_id[$agent_id[$i]][$a]]) ? !empty($extar['inv'][$cover_id[$agent_id[$i]][$a]]) ? number_format((array_sum($total_inv[$cover_id[$agent_id[$i]][$a]]) + array_sum($extar['inv'][$cover_id[$agent_id[$i]][$a]]) - array_sum($cot_inv[$cover_id[$agent_id[$i]][$a]])), 2) : number_format(array_sum($total_inv[$cover_id[$agent_id[$i]][$a]]) - array_sum($cot_inv[$cover_id[$agent_id[$i]][$a]]), 2) : '-'; ?></td>
                        </tr>
            <?php }
                }
            } ?>
        </table>

        <table class="table table-striped text-uppercase table-vouchure-t2" hidden>
            <thead class="bg-light">
                <tr>
                    <th>ชื่อเอเยนต์</th>
                    <th class="text-center">Invoice</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Audlt</th>
                    <th class="text-center">Children</th>
                    <th class="text-center">Infant</th>
                    <th class="text-center">FOC</th>
                    <th class="text-center">COT</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($agent_id); $i++) { ?>
                    <tr onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail">
                        <td><?php echo $agent_name[$i]; ?></td>
                        <td class="text-center"><?php echo !empty($cover_id[$agent_id[$i]]) ? count($cover_id[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($tourrist[$agent_id[$i]]) ? array_sum($tourrist[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($adult[$agent_id[$i]]) ? array_sum($adult[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($child[$agent_id[$i]]) ? array_sum($child[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($infant[$agent_id[$i]]) ? array_sum($infant[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($foc[$agent_id[$i]]) ? array_sum($foc[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($cot[$agent_id[$i]]) ? number_format(array_sum($cot[$agent_id[$i]])) : 0; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
<?php
} else {
    echo false;
}

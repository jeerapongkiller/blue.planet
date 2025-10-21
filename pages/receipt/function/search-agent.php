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

if (isset($_POST['action']) && $_POST['action'] == "search-invoice" && !empty($_POST['travel_date'])) {
    // get value from ajax
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';
    $search_product = !empty($_POST['search_product']) ? $_POST['search_product'] : 'all';
    $search_island = !empty($_POST['search_island']) ? $_POST['search_island'] : 'all';

    $first_booking = array();
    $first_cover = array();
    $first_bpr = array();
    $first_company = array();
    $invoices = $recObj->showlist('invoices', $travel_date, $search_island, $search_product, 'all', 0);
    if (!empty($invoices)) {
        foreach ($invoices as $invoice) {
            # --- get value agent --- #
            if (in_array($invoice['comp_id'], $first_company) == false && !empty($invoice['comp_id'])) {
                $first_company[] = $invoice['comp_id'];
                $agent_id[] = !empty($invoice['comp_id']) ? $invoice['comp_id'] : 0;
                $agent_name[] = !empty($invoice['comp_name']) ? $invoice['comp_name'] : '';
            }
            # --- get value booking --- #
            if (in_array($invoice['cover_id'], $first_cover) == false) {
                $first_cover[] = $invoice['cover_id'];
                $cover_id[$invoice['comp_id']][] = !empty($invoice['cover_id']) ? $invoice['cover_id'] : 0;
            }
            # --- get value booking --- #
            if (in_array($invoice['id'], $first_booking) == false) {
                $first_booking[] = $invoice['id'];
                $bo_id[$invoice['comp_id']][] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $cot[$invoice['comp_id']][] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : 0;
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
                    <tr onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>', '<?php echo $search_product; ?>', '<?php echo $search_island; ?>');" data-toggle="modal" data-target="#modal-detail">
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
} elseif (isset($_POST['action']) && $_POST['action'] == "search-receipt" && !empty($_POST['travel_date'])) {
    // get value from ajax
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';
    $search_product = !empty($_POST['search_product']) ? $_POST['search_product'] : 'all';
    $search_island = !empty($_POST['search_island']) ? $_POST['search_island'] : 'all';

    $first_rec = array();
    $first_cover = array();
    $first_company = array();
    $first_booking = array();
    $first_bpr = array();
    $first_extar = array();
    $invoices = $recObj->showlist('receipts', $travel_date, $search_island, $search_product, 'all', 0);
    if (!empty($invoices)) {
        foreach ($invoices as $invoice) {
            # --- get value booking --- #
            if (in_array($invoice['rec_id'], $first_rec) == false) {
                $first_rec[] = $invoice['rec_id'];
                $rec_id[$invoice['comp_id']][] = !empty($invoice['rec_id']) ? $invoice['rec_id'] : 0;
                $rec_full[$invoice['comp_id']][] = !empty($invoice['rec_full']) ? $invoice['rec_full'] : '';
                $date_rec[$invoice['comp_id']][] = !empty($invoice['date_rec']) ? $invoice['date_rec'] : '0000-00-00';
                $inv_full[$invoice['comp_id']][] = !empty($invoice['inv_full']) ? $invoice['inv_full'] : '';
            }
            # --- get value booking --- #
            if (in_array($invoice['cover_id'], $first_cover) == false) {
                $first_cover[] = $invoice['cover_id'];
                $cover_id[$invoice['comp_id']][] = !empty($invoice['cover_id']) ? $invoice['cover_id'] : 0;
            }
            # --- get value agent --- #
            if (in_array($invoice['comp_id'], $first_company) == false && !empty($invoice['comp_id'])) {
                $first_company[] = $invoice['comp_id'];
                $agent_id[] = !empty($invoice['comp_id']) ? $invoice['comp_id'] : 0;
                $agent_name[] = !empty($invoice['comp_name']) ? $invoice['comp_name'] : '';
                $comp_id[] = !empty($invoice['comp_id']) ? $invoice['comp_id'] : 0;
                $agent_license[] = !empty($invoice['tat_license']) ? $invoice['tat_license'] : '';
                $agent_telephone[] = !empty($invoice['comp_telephone']) ? $invoice['comp_telephone'] : '';
                $agent_address[] = !empty($invoice['comp_address']) ? $invoice['comp_address'] : '';

                $arr_inv[$invoice['rec_id']]['cover_id'] = !empty($invoice['cover_id']) ? $invoice['cover_id'] : 0;
                $arr_inv[$invoice['cover_id']]['inv_full'] = !empty($invoice['inv_full']) ? $invoice['inv_full'] : '';
                $arr_inv[$invoice['cover_id']]['inv_date'] = !empty($invoice['inv_date']) ? date('j F Y', strtotime($invoice['inv_date'])) : '0000-00-00';
                $arr_inv[$invoice['cover_id']]['rec_date'] = !empty($invoice['rec_date']) ? date('j F Y', strtotime($invoice['rec_date'])) : '0000-00-00';
                $arr_inv[$invoice['cover_id']]['vat'] = !empty($invoice['vat']) ? $invoice['vat'] : 0;
                $arr_inv[$invoice['cover_id']]['withholding'] = !empty($invoice['withholding']) ? $invoice['withholding'] : 0;
                $arr_inv[$invoice['cover_id']]['brch_name'] = !empty($invoice['brch_name']) ? $invoice['brch_name'] : '';
                $arr_inv[$invoice['cover_id']]['due_date'] = (diff_date($today, $invoice['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">ครบกำหนดชำระในอีก ' . diff_date($today, $invoice['rec_date'])['num'] . ' วัน</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">เกินกำหนดชำระมาแล้ว ' . diff_date($today, $invoice['rec_date'])['num'] . ' วัน</span>';
            }
            # --- get value booking --- #
            if (in_array($invoice['id'], $first_booking) == false) {
                $first_booking[] = $invoice['id'];
                $bo_id[$invoice['comp_id']][] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $bo_rec[$invoice['rec_id']][] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $cot[$invoice['comp_id']][] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : 0;
                $cot_rec[$invoice['rec_id']][] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : 0;

                $arr_bo[$invoice['rec_id']]['id'][] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $arr_bo[$invoice['id']]['inv_id'] = !empty($invoice['inv_id']) ? $invoice['inv_id'] : 0;
                $arr_bo[$invoice['id']]['status'] = !empty($invoice['booksta_id']) ? $invoice['booksta_id'] : 0;
                $arr_bo[$invoice['id']]['status_name'] = !empty($invoice['booksta_name']) ? '<b class="text-danger">(' . $invoice['booksta_name'] . ')</b>' : '';
                $arr_bo[$invoice['id']]['travel_date'] = !empty($invoice['travel_date']) ? $invoice['travel_date'] : '';
                $arr_bo[$invoice['id']]['text_date'] = !empty($invoice['travel_date']) ? date("d/m/Y", strtotime($invoice['travel_date'])) : '';
                $arr_bo[$invoice['id']]['cus_name'] = !empty($invoice['cus_name']) ? $invoice['cus_name'] : '';
                $arr_bo[$invoice['id']]['product_name'] = !empty($invoice['product_name']) ? $invoice['product_name'] : '';
                $arr_bo[$invoice['id']]['voucher_no'] = !empty($invoice['voucher_no']) ? $invoice['voucher_no'] : $invoice['book_full'];
                $arr_bo[$invoice['id']]['discount'] = !empty($invoice['discount']) ? $invoice['discount'] : '-';
                $arr_bo[$invoice['id']]['cot'] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : '-';
                $arr_bo[$invoice['id']]['color'] = !empty($invoice['island_color']) ? $invoice['island_color'] : '';
                $arr_bo[$invoice['id']]['darken'] = !empty($invoice['island_darken']) ? $invoice['island_darken'] : '';
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
                $total_comp[$invoice['comp_id']][] = $invoice['booktye_id'] == 1 ? ($invoice['booksta_id'] != 2 && $invoice['booksta_id'] != 4) ? ($invoice['bpr_adult'] * $invoice['rate_adult']) + ($invoice['bpr_child'] * $invoice['rate_child']) : $invoice['rate_total'] : $invoice['rate_private'];
                $total_rec[$invoice['rec_id']][] = $invoice['booktye_id'] == 1 ? ($invoice['booksta_id'] != 2 && $invoice['booksta_id'] != 4) ? ($invoice['bpr_adult'] * $invoice['rate_adult']) + ($invoice['bpr_child'] * $invoice['rate_child']) : $invoice['rate_total'] : $invoice['rate_private'];

                $arr_rates[$invoice['id']]['id'][] = !empty($invoice['bpr_id']) ? $invoice['bpr_id'] : 0;
                $arr_rates[$invoice['id']]['category_name'][] = !empty($invoice['category_name']) ? $invoice['category_name'] : '';
                $arr_rates[$invoice['id']]['customer'][] = !empty($invoice['category_cus']) ? $invoice['category_cus'] : 0;
                $arr_rates[$invoice['id']]['adult'][] = !empty($invoice['bpr_adult']) ? $invoice['bpr_adult'] : 0;
                $arr_rates[$invoice['id']]['child'][] = !empty($invoice['bpr_child']) ? $invoice['bpr_child'] : 0;
                $arr_rates[$invoice['id']]['infant'][] = !empty($invoice['bpr_infant']) ? $invoice['bpr_infant'] : 0;
                $arr_rates[$invoice['id']]['foc'][] = !empty($invoice['bpr_foc']) ? $invoice['bpr_foc'] : 0;
                $arr_rates[$invoice['id']]['rate_adult'][] = !empty($invoice['rate_adult']) && $invoice['bpr_adult'] > 0 ? $invoice['rate_adult'] : '-';
                $arr_rates[$invoice['id']]['rate_child'][] = !empty($invoice['rate_child']) && $invoice['bpr_child'] > 0 ? $invoice['rate_child'] : '-';
                $arr_rates[$invoice['id']]['total'][] = $invoice['bp_private_type'] == 1 ? ($invoice['booksta_id'] != 2 && $invoice['booksta_id'] != 4) ? ($invoice['bpr_adult'] * $invoice['rate_adult']) + ($invoice['bpr_child'] * $invoice['rate_child']) : $invoice['rate_total'] : $invoice['rate_total'];
            }
            # --- get value booking --- #
            if (in_array($invoice['bec_id'], $first_extar) == false && (!empty($invoice['extra_id']) || !empty($invoice['bec_name']))) {
                $first_extar[] = $invoice['bec_id'];
                $arr_extar[$invoice['id']]['id'][] = !empty($invoice['bec_id']) ? $invoice['bec_id'] : '-';
                $arr_extar[$invoice['id']]['name'][] = !empty($invoice['extra_id']) ? $invoice['extra_name'] : $invoice['bec_name'];
                $arr_extar[$invoice['id']]['adult'][] = !empty($invoice['bec_adult']) ? $invoice['bec_adult'] : $invoice['bec_privates'];
                $arr_extar[$invoice['id']]['child'][] = !empty($invoice['bec_child']) ? $invoice['bec_child'] : '-';
                $arr_extar[$invoice['id']]['rate_adult'][] = !empty($invoice['bec_rate_adult']) && $invoice['bec_adult'] > 0 ? $invoice['bec_rate_adult'] : '-';
                $arr_extar[$invoice['id']]['rate_child'][] = !empty($invoice['bec_rate_child']) && $invoice['bec_child'] > 0 ? $invoice['bec_rate_child'] : '-';
                $arr_extar[$invoice['id']]['privates'][] = !empty($invoice['bec_privates']) ? $invoice['bec_privates'] : '-';
                $arr_extar[$invoice['id']]['rate_private'][] = !empty($invoice['bec_rate_private']) && $invoice['bec_privates'] > 0 ? $invoice['bec_rate_private'] : '-';
                $arr_extar[$invoice['id']]['total'][] = $invoice['bec_type'] == 1 ? ($invoice['bec_adult'] * $invoice['bec_rate_adult']) + ($invoice['bec_child'] * $invoice['bec_rate_child']) : ($invoice['bec_privates'] * $invoice['bec_rate_private']);

                $extar['rec'][$invoice['rec_id']][] = $invoice['bec_type'] == 1 ? ($invoice['bec_adult'] * $invoice['bec_rate_adult']) + ($invoice['bec_child'] * $invoice['bec_rate_child']) : ($invoice['bec_privates'] * $invoice['bec_rate_private']);
                $extar['agent'][$invoice['comp_id']][] = $invoice['bec_type'] == 1 ? ($invoice['bec_adult'] * $invoice['bec_rate_adult']) + ($invoice['bec_child'] * $invoice['bec_rate_child']) : ($invoice['bec_privates'] * $invoice['bec_rate_private']);
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
                    <td class="text-center">Receipt</td>
                    <td class="text-center">Invoice</td>
                    <td></td>
                    <td class="text-center">Amount</td>
                </tr>
                <tr>
                    <td><?php echo $agent_name[$i]; ?></td>
                    <td class="text-center"><?php echo !empty($rec_id[$agent_id[$i]]) ? count($rec_id[$agent_id[$i]]) : 0; ?></td>
                    <td class="text-center"><?php echo !empty($cover_id[$agent_id[$i]]) ? count($cover_id[$agent_id[$i]]) : 0; ?></td>
                    <td></td>
                    <td class="text-center"><?php echo !empty($total_comp[$agent_id[$i]]) ? !empty($extar['agent'][$agent_id[$i]]) ? number_format((array_sum($total_comp[$agent_id[$i]]) + array_sum($extar['agent'][$agent_id[$i]]) - array_sum($cot[$agent_id[$i]])), 2) : number_format(array_sum($total_comp[$agent_id[$i]]) - array_sum($cot[$agent_id[$i]]), 2) : '-'; ?></td>
                </tr>
                <tr class="table-info">
                    <th>วันที่ออก Receipt</th>
                    <th class="text-center">Receipt No.</th>
                    <th class="text-center">Invoice No.</th>
                    <th class="text-center">Booking</th>
                    <th class="text-center">AMOUNT</th>
                </tr>
                <?php
                if (!empty($rec_id[$agent_id[$i]])) {
                    for ($a = 0; $a < count($rec_id[$agent_id[$i]]); $a++) {
                ?>
                        <tr data-dismiss="modal" data-toggle="modal" data-target="#modal-show" onclick="modal_show_receipt(<?php echo $rec_id[$agent_id[$i]][$a]; ?>);">
                            <td><?php echo date('j F Y', strtotime($date_rec[$agent_id[$i]][$a])); ?></td>
                            <td class="text-center"><?php echo $rec_full[$agent_id[$i]][$a]; ?></td>
                            <td class="text-center"><?php echo $inv_full[$agent_id[$i]][$a]; ?></td>
                            <td class="text-center"><?php echo !empty($bo_rec[$rec_id[$agent_id[$i]][$a]]) ? count($bo_rec[$rec_id[$agent_id[$i]][$a]]) : '-'; ?></td>
                            <td class="text-center"><?php echo !empty($total_rec[$rec_id[$agent_id[$i]][$a]]) ? !empty($extar['rec'][$rec_id[$agent_id[$i]][$a]]) ? number_format((array_sum($total_rec[$rec_id[$agent_id[$i]][$a]]) + array_sum($extar['rec'][$rec_id[$agent_id[$i]][$a]]) - array_sum($cot_rec[$rec_id[$agent_id[$i]][$a]])), 2) : number_format(array_sum($total_rec[$rec_id[$agent_id[$i]][$a]]) - array_sum($cot_rec[$rec_id[$agent_id[$i]][$a]]), 2) : '-'; ?></td>
                        </tr>
                <?php }
                } ?>
            <?php } ?>
        </table>

        <table class="table table-striped text-uppercase table-vouchure-t2" hidden>
            <thead class="bg-light">
                <tr>
                    <th>ชื่อเอเยนต์</th>
                    <th class="text-center">Receipt</th>
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
                    <tr onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>', '<?php echo $search_product; ?>', '<?php echo $search_island; ?>');" data-toggle="modal" data-target="#modal-detail">
                        <td><?php echo $agent_name[$i]; ?></td>
                        <td class="text-center"><?php echo !empty($rec_id[$agent_id[$i]]) ? count($rec_id[$agent_id[$i]]) : 0; ?></td>
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

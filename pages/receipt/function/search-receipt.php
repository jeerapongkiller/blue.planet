<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Receipt.php';

$recObj = new Receipt();
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime(" +1 day"));
// $today = '2024-09-29';
// $tomorrow = '2024-09-30';

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

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['agent_id']) && !empty($_POST['travel_date'])) {
    // get value from ajax
    $agent_id = $_POST['agent_id'] != "" ? $_POST['agent_id'] : 0;
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';
    $search_product = !empty($_POST['search_product']) ? $_POST['search_product'] : 'all';
    $search_island = !empty($_POST['search_island']) ? $_POST['search_island'] : 'all';

    $first_rec = array();
    $first_cover = array();
    $first_booking = array();
    $first_bpr = array();
    $first_extar = array();
    $receipts = $recObj->showlist('receipts', $travel_date, $search_island, $search_product, $agent_id, 0);
    if (!empty($receipts)) {
        foreach ($receipts as $receipt) {
            # --- get value receipt --- #
            if (in_array($receipt['rec_id'], $first_rec) == false) {
                $first_rec[] = $receipt['rec_id'];
                $rec_id[] = !empty($receipt['rec_id']) ? $receipt['rec_id'] : 0;
                $rec_full[] = !empty($receipt['rec_full']) ? $receipt['rec_full'] : '';
                $date_rec[] = !empty($receipt['date_rec']) ? $receipt['date_rec'] : '0000-00-00';
                $cheque_no[] = !empty($receipt['cheque_no']) ? $receipt['cheque_no'] : '';
                $cheque_date[] = !empty($receipt['cheque_date']) ? $receipt['cheque_date'] : '0000-00-00';
                $rec_note[] = !empty($receipt['rec_note']) ? $receipt['rec_note'] : '';

                $cover_id[] = !empty($receipt['cover_id']) ? $receipt['cover_id'] : 0;
                $inv_full[] = !empty($receipt['inv_full']) ? $receipt['inv_full'] : '';
                $inv_date[] = !empty($receipt['inv_date']) ? $receipt['inv_date'] : '0000-00-00';
                $rec_date[] = !empty($receipt['rec_date']) ? $receipt['rec_date'] : '0000-00-00';
                $vat[] = !empty($receipt['vat']) ? $receipt['vat'] : '-';
                $withholding[] = !empty($receipt['withholding']) ? $receipt['withholding'] : '-';
            }
            # --- get value invoice --- #
            if (in_array($receipt['cover_id'], $first_cover) == false) {
                $first_cover[] = $receipt['cover_id'];
                $due_date[] = (diff_date($today, $receipt['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">วันที่ครบกำหนดชำระ : ' . date("j F Y", strtotime($receipt['rec_date'])) . ' (ครบกำหนดชำระในอีก ' . diff_date($today, $receipt['rec_date'])['num'] . ' วัน)</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">วันที่ครบกำหนดชำระ : ' . date("j F Y", strtotime($receipt['rec_date'])) . ' (เกินกำหนดชำระมาแล้ว ' . diff_date($today, $receipt['rec_date'])['num'] . ' วัน)</span>';

                $arr_inv[$receipt['rec_id']]['cover_id'] = !empty($receipt['cover_id']) ? $receipt['cover_id'] : 0;
                $arr_inv[$receipt['cover_id']]['inv_full'] = !empty($receipt['inv_full']) ? $receipt['inv_full'] : '';
                $arr_inv[$receipt['cover_id']]['inv_date'] = !empty($receipt['inv_date']) ? date('j F Y', strtotime($receipt['inv_date'])) : '0000-00-00';
                $arr_inv[$receipt['cover_id']]['rec_date'] = !empty($receipt['rec_date']) ? date('j F Y', strtotime($receipt['rec_date'])) : '0000-00-00';
                $arr_inv[$receipt['cover_id']]['vat'] = !empty($receipt['vat']) ? $receipt['vat'] : 0;
                $arr_inv[$receipt['cover_id']]['withholding'] = !empty($receipt['withholding']) ? $receipt['withholding'] : 0;
                $arr_inv[$receipt['cover_id']]['brch_name'] = !empty($receipt['brch_name']) ? $receipt['brch_name'] : '';
                $arr_inv[$receipt['cover_id']]['due_date'] = (diff_date($today, $receipt['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">ครบกำหนดชำระในอีก ' . diff_date($today, $receipt['rec_date'])['num'] . ' วัน</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">เกินกำหนดชำระมาแล้ว ' . diff_date($today, $receipt['rec_date'])['num'] . ' วัน</span>';
            }
            # --- get value booking --- #
            if (in_array($receipt['id'], $first_booking) == false) {
                $first_booking[] = $receipt['id'];
                $inv_id[] = !empty($receipt['inv_id']) ? $receipt['inv_id'] : 0;
                $bo_id[$receipt['rec_id']][] = !empty($receipt['id']) ? $receipt['id'] : 0;
                $comp_id[] = !empty($receipt['comp_id']) ? $receipt['comp_id'] : 0;
                $agent_name[] = !empty($receipt['comp_name']) ? $receipt['comp_name'] : '';
                $agent_license[] = !empty($receipt['tat_license']) ? $receipt['tat_license'] : '';
                $agent_telephone[] = !empty($receipt['comp_telephone']) ? $receipt['comp_telephone'] : '';
                $agent_address[] = !empty($receipt['comp_address']) ? $receipt['comp_address'] : '';
                // $adult[] = !empty($receipt['bpr_adult']) ? $receipt['bpr_adult'] : 0;
                // $child[] = !empty($receipt['bpr_child']) ? $receipt['bpr_child'] : 0;
                // $infant[] = !empty($receipt['bpr_infant']) ? $receipt['bpr_infant'] : 0;
                // $foc[] = !empty($receipt['bpr_foc']) ? $receipt['bpr_foc'] : 0;
                // $cot[] = !empty($receipt['total_paid']) ? $receipt['total_paid'] : 0;
                $start_pickup[] = !empty($receipt['start_pickup']) ? date('H:i', strtotime($receipt['start_pickup'])) : '00:00:00';
                $car_name[] = !empty($receipt['car_name']) ? $receipt['car_name'] : '';
                $cus_name[] = !empty($receipt['cus_name']) ? $receipt['cus_name'] : '';
                $book_full[] = !empty($receipt['book_full']) ? $receipt['book_full'] : '';
                $voucher_no[] = !empty($receipt['voucher_no_agent']) ? $receipt['voucher_no_agent'] : '';
                $pickup_type[] = !empty($receipt['pickup_type']) ? $receipt['pickup_type'] : 0;
                $room_no[] = !empty($receipt['room_no']) ? $receipt['room_no'] : '-';
                $hotel_pickup[] = !empty($receipt['pickup_name']) ? $receipt['pickup_name'] : $receipt['outside'];
                $zone_pickup[] = !empty($receipt['zonep_name']) ? ' (' . $receipt['zonep_name'] . ')' : '';
                $hotel_dropoff[] = !empty($receipt['dropoff_name']) ? $receipt['dropoff_name'] : $receipt['outside_dropoff'];
                $zone_dropoff[] = !empty($receipt['zoned_name']) ? ' (' . $receipt['zoned_name'] . ')' : '';
                $bp_note[] = !empty($receipt['bp_note']) ? $receipt['bp_note'] : '';
                $product_name[] = !empty($receipt['product_name']) ? $receipt['product_name'] : '';
                $cot[$receipt['rec_id']][] = !empty($receipt['total_paid']) ? $receipt['total_paid'] : 0;
                // $total[] = $receipt['bp_private_type'] == 1 ? ($receipt['bpr_adult'] * $receipt['rate_adult']) + ($receipt['bpr_child'] * $receipt['rate_child']) : $receipt['rate_total'];

                $arr_bo[$receipt['rec_id']]['id'][] = !empty($receipt['id']) ? $receipt['id'] : 0;
                $arr_bo[$receipt['id']]['inv_id'] = !empty($receipt['inv_id']) ? $receipt['inv_id'] : 0;
                $arr_bo[$receipt['id']]['travel_date'] = !empty($receipt['travel_date']) ? $receipt['travel_date'] : '';
                $arr_bo[$receipt['id']]['text_date'] = !empty($receipt['travel_date']) ? date("d/m/Y", strtotime($receipt['travel_date'])) : '';
                $arr_bo[$receipt['id']]['cus_name'] = !empty($receipt['cus_name']) ? $receipt['cus_name'] : '';
                $arr_bo[$receipt['id']]['product_name'] = !empty($receipt['product_name']) ? $receipt['product_name'] : '';
                $arr_bo[$receipt['id']]['voucher_no'] = !empty($receipt['voucher_no']) ? $receipt['voucher_no'] : $receipt['book_full'];
                // $arr_bo[$receipt['id']]['adult'] = !empty($receipt['bpr_adult']) ? $receipt['bpr_adult'] : '-';
                // $arr_bo[$receipt['id']]['child'] = !empty($receipt['bpr_child']) ? $receipt['bpr_child'] : '-';
                // $arr_bo[$receipt['id']]['rate_adult'] = !empty($receipt['rate_adult']) && $receipt['bpr_adult'] > 0 ? $receipt['rate_adult'] : '-';
                // $arr_bo[$receipt['id']]['rate_child'] = !empty($receipt['rate_child']) && $receipt['bpr_child'] > 0 ? $receipt['rate_child'] : '-';
                // $arr_bo[$receipt['id']]['foc'] = !empty($receipt['bpr_foc']) ? $receipt['bpr_foc'] : '-';
                $arr_bo[$receipt['id']]['discount'] = !empty($receipt['discount']) ? $receipt['discount'] : '-';
                $arr_bo[$receipt['id']]['cot'] = !empty($receipt['total_paid']) ? $receipt['total_paid'] : '-';
                $arr_bo[$receipt['id']]['color'] = !empty($receipt['island_color']) ? $receipt['island_color'] : '';
                $arr_bo[$receipt['id']]['darken'] = !empty($receipt['island_darken']) ? $receipt['island_darken'] : '';
                // $arr_bo[$receipt['id']]['total'] = $receipt['bp_private_type'] == 1 ? ($receipt['bpr_adult'] * $receipt['rate_adult']) + ($receipt['bpr_child'] * $receipt['rate_child']) : $receipt['rate_total'];
            }
            # --- get value rates --- #
            if ((in_array($receipt['bpr_id'], $first_bpr) == false) && !empty($receipt['bpr_id'])) {
                $first_bpr[] = $receipt['bpr_id'];
                $bpr_id[$receipt['id']][] = !empty($receipt['bpr_id']) ? $receipt['bpr_id'] : 0;
                $category_id[$receipt['id']][] = !empty($receipt['category_id']) ? $receipt['category_id'] : 0;
                $category_name[$receipt['id']][] = !empty($receipt['category_name']) ? $receipt['category_name'] : 0;
                $category_cus[$receipt['id']][] = !empty($receipt['category_cus']) ? $receipt['category_cus'] : 0;
                $adult[$receipt['id']][] = !empty($receipt['bpr_adult']) ? $receipt['bpr_adult'] : 0;
                $child[$receipt['id']][] = !empty($receipt['bpr_child']) ? $receipt['bpr_child'] : 0;
                $infant[$receipt['id']][] = !empty($receipt['bpr_infant']) ? $receipt['bpr_infant'] : 0;
                $foc[$receipt['id']][] = !empty($receipt['bpr_foc']) ? $receipt['bpr_foc'] : 0;
                $total[$receipt['rec_id']][] = $receipt['bp_private_type'] == 1 ? ($receipt['bpr_adult'] * $receipt['rate_adult']) + ($receipt['bpr_child'] * $receipt['rate_child']) : $receipt['rate_total'];

                $arr_rates[$receipt['id']]['id'][] = !empty($receipt['bpr_id']) ? $receipt['bpr_id'] : 0;
                $arr_rates[$receipt['id']]['customer'][] = !empty($receipt['category_cus']) ? $receipt['category_cus'] : 0;
                $arr_rates[$receipt['id']]['adult'][] = !empty($receipt['bpr_adult']) ? $receipt['bpr_adult'] : 0;
                $arr_rates[$receipt['id']]['child'][] = !empty($receipt['bpr_child']) ? $receipt['bpr_child'] : 0;
                $arr_rates[$receipt['id']]['infant'][] = !empty($receipt['bpr_infant']) ? $receipt['bpr_infant'] : 0;
                $arr_rates[$receipt['id']]['foc'][] = !empty($receipt['bpr_foc']) ? $receipt['bpr_foc'] : 0;
                $arr_rates[$receipt['id']]['rate_adult'][] = !empty($receipt['rate_adult']) && $receipt['bpr_adult'] > 0 ? $receipt['rate_adult'] : '-';
                $arr_rates[$receipt['id']]['rate_child'][] = !empty($receipt['rate_child']) && $receipt['bpr_child'] > 0 ? $receipt['rate_child'] : '-';
                $arr_rates[$receipt['id']]['total'][] = $receipt['bp_private_type'] == 1 ? ($receipt['bpr_adult'] * $receipt['rate_adult']) + ($receipt['bpr_child'] * $receipt['rate_child']) : $receipt['rate_total'];
            }
            # --- get value booking --- #
            if (in_array($receipt['bec_id'], $first_extar) == false && (!empty($receipt['extra_id']) || !empty($receipt['bec_name']))) {
                $first_extar[] = $receipt['bec_id'];
                $arr_extar[$receipt['id']]['id'][] = !empty($receipt['bec_id']) ? $receipt['bec_id'] : '-';
                $arr_extar[$receipt['id']]['name'][] = !empty($receipt['extra_id']) ? $receipt['extra_name'] : $receipt['bec_name'];
                $arr_extar[$receipt['id']]['adult'][] = !empty($receipt['bec_adult']) ? $receipt['bec_adult'] : $receipt['bec_privates'];
                $arr_extar[$receipt['id']]['child'][] = !empty($receipt['bec_child']) ? $receipt['bec_child'] : '-';
                $arr_extar[$receipt['id']]['rate_adult'][] = !empty($receipt['bec_rate_adult']) && $receipt['bec_adult'] > 0 ? $receipt['bec_rate_adult'] : '-';
                $arr_extar[$receipt['id']]['rate_child'][] = !empty($receipt['bec_rate_child']) && $receipt['bec_child'] > 0 ? $receipt['bec_rate_child'] : '-';
                $arr_extar[$receipt['id']]['privates'][] = !empty($receipt['bec_privates']) ? $receipt['bec_privates'] : '-';
                $arr_extar[$receipt['id']]['rate_private'][] = !empty($receipt['bec_rate_private']) && $receipt['bec_privates'] > 0 ? $receipt['bec_rate_private'] : '-';
                $arr_extar[$receipt['id']]['total'][] = $receipt['bec_type'] == 1 ? ($receipt['bec_adult'] * $receipt['bec_rate_adult']) + ($receipt['bec_child'] * $receipt['bec_rate_child']) : ($receipt['bec_privates'] * $receipt['bec_rate_private']);

                $extar_total[$receipt['rec_id']][] = $receipt['bec_type'] == 1 ? ($receipt['bec_adult'] * $receipt['bec_rate_adult']) + ($receipt['bec_child'] * $receipt['bec_rate_child']) : ($receipt['bec_privates'] * $receipt['bec_rate_private']);
            }
        }
    }
?>
    <div class="modal-header">
        <h4 class="modal-title"><span class="text-success"><?php echo $agent_name[0]; ?></span> (<?php echo !empty(substr($travel_date, 14, 24)) ? date('j F Y', strtotime(substr($travel_date, 0, 10))) . ' - ' . date('j F Y', strtotime(substr($travel_date, 14, 24))) : date('j F Y', strtotime($travel_date)); ?>)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" id="order-agent-image-table" style="background-color: #fff;">

        <div class="text-center mt-1 mb-1">
            <h4>
                <div class="badge badge-pill badge-light-warning">
                    <b class="text-danger"><?php echo $agent_name[0]; ?></b> <span class="text-danger">(<?php echo !empty(substr($travel_date, 14, 24)) ? date('j F Y', strtotime(substr($travel_date, 0, 10))) . ' - ' . date('j F Y', strtotime(substr($travel_date, 14, 24))) : date('j F Y', strtotime($travel_date)); ?>)</span>
                </div>
            </h4>
        </div>

        <input type="hidden" id="agent_value" name="agent_value" value="<?php echo $comp_id[0]; ?>"
            data-name="<?php echo $agent_name[0]; ?>"
            data-license="<?php echo $agent_license[0]; ?>"
            data-telephone="<?php echo $agent_telephone[0]; ?>"
            data-address="<?php echo $agent_address[0]; ?>">
        <textarea id="array_invoice" hidden><?php echo !empty($arr_inv) ? json_encode($arr_inv, true) : ''; ?></textarea>
        <textarea id="array_rates" hidden><?php echo !empty($arr_rates) ? json_encode($arr_rates, true) : ''; ?></textarea>
        <textarea id="array_booking" hidden><?php echo !empty($arr_bo) ? json_encode($arr_bo, true) : ''; ?></textarea>
        <textarea id="array_extar" hidden><?php echo !empty($arr_extar) ? json_encode($arr_extar, true) : ''; ?></textarea>

        <table class="table table-striped text-uppercase table-vouchure-t2">
            <thead class="bg-light">
                <tr>
                    <th>วันที่ออก Receipt</th>
                    <th>Receipt No.</th>
                    <th>Invoice No.</th>
                    <th class="text-center">Booking</th>
                    <th class="text-center">ภาษีมูลค่าเพิ่ม</th>
                    <th class="text-center">หัก ณ ที่จ่าย (%)</th>
                    <th class="text-center">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($rec_id)) {
                    for ($i = 0; $i < count($rec_id); $i++) {
                ?>
                        <tr data-dismiss="modal" data-toggle="modal" data-target="#modal-show" onclick="modal_show_receipt(<?php echo $rec_id[$i]; ?>);">
                            <td><?php echo date('j F Y', strtotime($date_rec[$i])); ?></td>
                            <td><?php echo $rec_full[$i]; ?></td>
                            <td><?php echo $inv_full[$i]; ?></td>
                            <td class="text-center"><?php echo count($bo_id[$rec_id[$i]]); ?></td>
                            <td class="text-center"><?php echo $vat[$i] != '-' ? $vat[$i] == 1 ? 'รวมภาษี 7%' : 'แยกภาษี 7%' : '-'; ?></td>
                            <td class="text-center"><?php echo $withholding[$i] != '-' ? $withholding[$i] . '%' : '-'; ?></td>
                            <td class="text-center"><?php echo !empty($total[$rec_id[$i]]) ? !empty($extar_total[$rec_id[$i]]) ? number_format(array_sum($total[$rec_id[$i]]) + array_sum($extar_total[$rec_id[$i]]) - array_sum($cot[$rec_id[$i]])) : number_format(array_sum($total[$rec_id[$i]]) - array_sum($cot[$rec_id[$i]])) : ''; ?></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>

    </div>

    <div class="modal-footer">
    </div>
<?php
} else {
    echo false;
}

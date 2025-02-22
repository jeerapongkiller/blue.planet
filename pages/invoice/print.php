<?php

use Mpdf\Tag\Em;

$type = !empty($_POST['action']) ? 'POST' : 'GET';
$action = empty($_POST['action']) ? !empty($_GET['action']) ? $_GET['action'] : 0 : $_POST['action'];
$get_cover = empty($_POST['cover_id']) ? !empty($_GET['cover_id']) ? $_GET['cover_id'] : 0 : $_POST['cover_id'];
$btn_edit = false;

$env_contro = $action == "preview" && $type == 'POST' ? '../../config/env.php' : 'config/env.php';
$inc_contro = $action == "preview" && $type == 'POST' ? '../../controllers/Invoice.php' : 'controllers/Invoice.php';
include_once($env_contro);
include_once($inc_contro);

$invObj = new Invoice();
$today = date("Y-m-d");
$times = date("H:i:s");

function bahtText(float $amount): string
{
    [$integer, $fraction] = explode('.', number_format(abs($amount), 2, '.', ''));

    $baht = convert($integer);
    $satang = convert($fraction);

    $output = $amount < 0 ? 'ติดลบ' : '';
    $output .= $baht ? $baht . 'บาท' : '';
    $output .= $satang ? $satang . 'สตางค์' : 'ถ้วน';

    return $baht . $satang === '' ? 'ศูนย์บาทถ้วน' : $output;
}

function convert(string $number): string
{
    $values = ['', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
    $places = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
    $exceptions = ['หนึ่งสิบ' => 'สิบ', 'สองสิบ' => 'ยี่สิบ', 'สิบหนึ่ง' => 'สิบเอ็ด'];

    $output = '';

    foreach (str_split(strrev($number)) as $place => $value) {
        if ($place % 6 === 0 && $place > 0) {
            $output = $places[6] . $output;
        }

        if ($value !== '0') {
            $output = $values[$value] . $places[$place % 6] . $output;
        }
    }

    foreach ($exceptions as $search => $replace) {
        $output = str_replace($search, $replace, $output);
    }

    return $output;
}

if (isset($action) && $action == "preview" && !empty($get_cover)) {
    $no = 0;
    $amount = 0;
    $sum_total = 0;
    $first_cover = array();
    $first_booking = array();
    $first_extar = array();
    $first_bpr = array();
    $invoices = $invObj->showlist('invoices', '0000-00-00', 'all', $get_cover);
    if (!empty($invoices)) {
        foreach ($invoices as $invoice) {
            # --- get value booking --- #
            if (in_array($invoice['cover_id'], $first_cover) == false) {
                $first_cover[] = $invoice['cover_id'];
                $cover_id[] = !empty($invoice['cover_id']) ? $invoice['cover_id'] : 0;
                $inv_full[] = !empty($invoice['inv_full']) ? $invoice['inv_full'] : '';
                $inv_date[] = !empty($invoice['inv_date']) ? $invoice['inv_date'] : '0000-00-00';
                $inv_note[] = !empty($invoice['inv_note']) ? $invoice['inv_note'] : '';
                $rec_date[] = !empty($invoice['rec_date']) ? $invoice['rec_date'] : '0000-00-00';
                $vat[] = !empty($invoice['vat']) ? $invoice['vat'] : 0;
                $withholding[] = !empty($invoice['withholding']) ? $invoice['withholding'] : 0;
                $user_name[] = !empty($invoice['user_fname']) ? $invoice['user_fname'] . ' ' . $invoice['user_lname'] : '';

                $comp_id[] = !empty($invoice['comp_id']) ? $invoice['comp_id'] : 0;
                $agent_name[] = !empty($invoice['comp_name']) ? $invoice['comp_name'] : '';
                $agent_license[] = !empty($invoice['tat_license']) ? $invoice['tat_license'] : '';
                $agent_telephone[] = !empty($invoice['comp_telephone']) ? $invoice['comp_telephone'] : '';
                $agent_email[] = !empty($invoice['comp_email']) ? $invoice['comp_email'] : '';
                $agent_address[] = !empty($invoice['comp_address']) ? $invoice['comp_address'] : '';
                $brch_name[] = !empty($invoice['brch_name']) ? $invoice['brch_name'] : '';
                $banacc_id[] = !empty($invoice['banacc_id']) ? $invoice['banacc_id'] : 0;
                $account_name[] = !empty($invoice['account_name']) ? $invoice['account_name'] : '';
                $account_no[] = !empty($invoice['account_no']) ? $invoice['account_no'] : '';
                $bank_name[] = !empty($invoice['bank_name']) ? $invoice['bank_name'] : '';
            }
            # --- get value booking --- #
            if (in_array($invoice['id'], $first_booking) == false) {
                $first_booking[] = $invoice['id'];
                $inv_id[] = !empty($invoice['inv_id']) ? $invoice['inv_id'] : 0;
                $bo_id[] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $status[] = !empty($invoice['booksta_id']) ? $invoice['booksta_id'] : 0;
                $status_name[] = !empty($invoice['booksta_name']) ? $invoice['booksta_name'] : '';
                $travel_date[] = !empty($invoice['travel_date']) ? $invoice['travel_date'] : '0000-00-00';
                $cot[] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : 0;
                $start_pickup[] = !empty($invoice['start_pickup']) ? date('H:i', strtotime($invoice['start_pickup'])) : '00:00:00';
                $end_pickup[] = !empty($invoice['end_pickup']) ? date('H:i', strtotime($invoice['end_pickup'])) : '00:00:00';
                $car_name[] = !empty($invoice['car_name']) ? $invoice['car_name'] : '';
                $cus_name[] = !empty($invoice['cus_name']) ? $invoice['cus_name'] : '';
                $book_full[] = !empty($invoice['book_full']) ? $invoice['book_full'] : '';
                $voucher_no[] = !empty($invoice['voucher_no_agent']) ? $invoice['voucher_no_agent'] : '';
                $pickup_type[] = !empty($invoice['pickup_type']) ? $invoice['pickup_type'] : 0;
                $room_no[] = !empty($invoice['room_no']) ? $invoice['room_no'] : '-';
                $hotel_pickup[] = !empty($invoice['pickup_name']) ? $invoice['pickup_name'] : $invoice['outside'];
                $zone_pickup[] = !empty($invoice['zonep_name']) ? ' (' . $invoice['zonep_name'] . ')' : '';
                $hotel_dropoff[] = !empty($invoice['dropoff_name']) ? $invoice['dropoff_name'] : $invoice['outside_dropoff'];
                $zone_dropoff[] = !empty($invoice['zoned_name']) ? ' (' . $invoice['zoned_name'] . ')' : '';
                $bp_note[] = !empty($invoice['bp_note']) ? $invoice['bp_note'] : '';
                $product_name[] = !empty($invoice['product_name']) ? $invoice['product_name'] : '';
                $discount[] = !empty($invoice['discount']) ? $invoice['discount'] : 0;
                $created_at[] = !empty($invoice['created_at']) ? $invoice['created_at'] : '0000-00-00';
                $booker_name[] = !empty($invoice['booker_fname']) ? $invoice['booker_fname'] . ' ' . $invoice['booker_lname'] : '';
                // $total[] = $invoice['bp_private_type'] == 1 ? ($invoice['bpr_adult'] * $invoice['rate_adult']) + ($invoice['bpr_child'] * $invoice['rate_child']) : $invoice['rate_total'];

                $arr_bo['id'][] = !empty($invoice['id']) ? $invoice['id'] : 0;
                $arr_bo[$invoice['id']]['status'] = !empty($invoice['booksta_id']) ? $invoice['booksta_id'] : 0;
                $arr_bo[$invoice['id']]['status_name'] = !empty($invoice['booksta_name']) ? '<b class="text-danger">(' . $invoice['booksta_name'] . ')</b>' : '';
                $arr_bo[$invoice['id']]['travel_date'] = !empty($invoice['travel_date']) ? $invoice['travel_date'] : '';
                $arr_bo[$invoice['id']]['text_date'] = !empty($invoice['travel_date']) ? date("d/m/Y", strtotime($invoice['travel_date'])) : '';
                $arr_bo[$invoice['id']]['cus_name'] = !empty($invoice['cus_name']) ? $invoice['cus_name'] : '';
                $arr_bo[$invoice['id']]['product_name'] = !empty($invoice['product_name']) ? $invoice['product_name'] : '';
                $arr_bo[$invoice['id']]['voucher_no'] = !empty($invoice['voucher_no']) ? $invoice['voucher_no'] : $invoice['book_full'];
                // $arr_bo[$invoice['id']]['adult'] = !empty($invoice['bpr_adult']) ? $invoice['bpr_adult'] : '-';
                // $arr_bo[$invoice['id']]['child'] = !empty($invoice['bpr_child']) ? $invoice['bpr_child'] : '-';
                // $arr_bo[$invoice['id']]['rate_adult'] = !empty($invoice['rate_adult']) && $invoice['bpr_adult'] > 0 ? $invoice['rate_adult'] : '-';
                // $arr_bo[$invoice['id']]['rate_child'] = !empty($invoice['rate_child']) && $invoice['bpr_child'] > 0 ? $invoice['rate_child'] : '-';
                $arr_bo[$invoice['id']]['foc'] = !empty($invoice['bpr_foc']) ? $invoice['bpr_foc'] : '-';
                $arr_bo[$invoice['id']]['discount'] = !empty($invoice['discount']) ? $invoice['discount'] : '-';
                $arr_bo[$invoice['id']]['cot'] = !empty($invoice['total_paid']) ? $invoice['total_paid'] : '-';
                $arr_bo[$invoice['id']]['total'] = $invoice['bp_private_type'] == 1 ? ($invoice['bpr_adult'] * $invoice['rate_adult']) + ($invoice['bpr_child'] * $invoice['rate_child']) : $invoice['rate_total'];
            }
            # --- get value rates --- #
            if ((in_array($invoice['bpr_id'], $first_bpr) == false) && !empty($invoice['bpr_id'])) {
                $first_bpr[] = $invoice['bpr_id'];
                $bpr_id[$invoice['id']][] = !empty($invoice['bpr_id']) ? $invoice['bpr_id'] : 0;
                $category_id[$invoice['id']][] = !empty($invoice['category_id']) ? $invoice['category_id'] : 0;
                $category_name[$invoice['id']][] = !empty($invoice['category_name']) ? $invoice['category_name'] : 0;
                $category_cus[$invoice['id']][] = !empty($invoice['category_cus']) ? $invoice['category_cus'] : 0;
                $adult[$invoice['id']][] = !empty($invoice['bpr_adult']) ? $invoice['bpr_adult'] : 0;
                $child[$invoice['id']][] = !empty($invoice['bpr_child']) ? $invoice['bpr_child'] : 0;
                $infant[$invoice['id']][] = !empty($invoice['bpr_infant']) ? $invoice['bpr_infant'] : 0;
                $foc[$invoice['id']][] = !empty($invoice['bpr_foc']) ? $invoice['bpr_foc'] : 0;
                $rate_adult[$invoice['id']][] = !empty($invoice['rate_adult']) && $invoice['bpr_adult'] > 0 ? $invoice['rate_adult'] : '-';
                $rate_child[$invoice['id']][] = !empty($invoice['rate_child']) && $invoice['bpr_child'] > 0 ? $invoice['rate_child'] : '-';
                $rate_infant[$invoice['id']][] = !empty($invoice['rate_infant']) && $invoice['bpr_infant'] > 0 ? $invoice['rate_infant'] : '-';
                $total[$invoice['id']][] = $invoice['bp_private_type'] == 1 ? ($invoice['booksta_id'] != 2 && $invoice['booksta_id'] != 4) ? ($invoice['bpr_adult'] * $invoice['rate_adult']) + ($invoice['bpr_child'] * $invoice['rate_child']) : $invoice['rate_total'] : $invoice['rate_total'];

                $arr_rates[$invoice['id']]['id'][] = !empty($invoice['bpr_id']) ? $invoice['bpr_id'] : 0;
                $arr_rates[$invoice['id']]['category_name'][] = !empty($invoice['category_name']) ? $invoice['category_name'] : 0;
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
            if (in_array($invoice['bec_id'], $first_extar) == false && !empty($invoice['bec_id'])) {
                $first_extar[] = $invoice['bec_id'];
                $arr_extar[$invoice['id']]['id'][] = !empty($invoice['bec_id']) ? $invoice['bec_id'] : '-';
                $arr_extar[$invoice['id']]['type'][] = !empty($invoice['bec_type']) ? $invoice['bec_type'] : 0;
                $arr_extar[$invoice['id']]['name'][] = !empty($invoice['extra_id']) ? $invoice['extra_name'] : $invoice['bec_name'];
                $arr_extar[$invoice['id']]['adult'][] = !empty($invoice['bec_adult']) ? $invoice['bec_adult'] : $invoice['bec_privates'];
                $arr_extar[$invoice['id']]['child'][] = !empty($invoice['bec_child']) ? $invoice['bec_child'] : '-';
                $arr_extar[$invoice['id']]['rate_adult'][] = !empty($invoice['bec_rate_adult']) && $invoice['bec_adult'] > 0 ? $invoice['bec_rate_adult'] : '-';
                $arr_extar[$invoice['id']]['rate_child'][] = !empty($invoice['bec_rate_child']) && $invoice['bec_child'] > 0 ? $invoice['bec_rate_child'] : '-';
                $arr_extar[$invoice['id']]['privates'][] = !empty($invoice['bec_privates']) ? $invoice['bec_privates'] : '-';
                $arr_extar[$invoice['id']]['rate_private'][] = !empty($invoice['bec_rate_private']) && $invoice['bec_privates'] > 0 ? $invoice['bec_rate_private'] : '-';
                $arr_extar[$invoice['id']]['total'][] = $invoice['bec_type'] == 1 ? ($invoice['bec_adult'] * $invoice['bec_rate_adult']) + ($invoice['bec_child'] * $invoice['bec_rate_child']) : ($invoice['bec_privates'] * $invoice['bec_rate_private']);
            }
        }
    }

?>

    <input type="hidden" id="agent_value" name="agent_value" value="<?php echo $comp_id[0]; ?>"
        data-name="<?php echo $agent_name[0]; ?>"
        data-license="<?php echo $agent_license[0]; ?>"
        data-telephone="<?php echo $agent_telephone[0]; ?>"
        data-address="<?php echo $agent_address[0]; ?>"
        data-cover="<?php echo $cover_id[0]; ?>"
        data-inv_full="<?php echo $inv_full[0]; ?>"
        data-inv_date="<?php echo $inv_date[0]; ?>"
        data-rec_date="<?php echo $rec_date[0]; ?>"
        data-vat="<?php echo $vat[0]; ?>"
        data-withholding="<?php echo $withholding[0]; ?>"
        data-bank_account="<?php echo $banacc_id[0]; ?>"
        data-note="<?php echo $inv_note[0]; ?>">
    <textarea id="array_booking" hidden><?php echo !empty($arr_bo) ? json_encode($arr_bo, true) : ''; ?></textarea>
    <textarea id="array_rates" hidden><?php echo !empty($arr_rates) ? json_encode($arr_rates, true) : ''; ?></textarea>
    <textarea id="array_extar" hidden><?php echo !empty($arr_extar) ? json_encode($arr_extar, true) : ''; ?></textarea>

    <style>
        .invoice-padding {
            background-color: #fff;
        }

        .invoice-padding .table-black td {
            color: #FFFFFF;
            background-color: #003285;
            padding: 0.7rem;
        }

        .invoice-padding .table-black-2 td {
            color: #FFFFFF;
            background-color: #0060ff;
            padding: 0.5rem;
        }

        .invoice-padding .table-content td {
            border: 1px solid #333;
            font-size: 14px;
            color: #000;
            /* padding: 0.72rem 2rem */
            padding: 0.2rem 1rem
        }
    </style>
    <div class="card-body invoice-padding pb-0" id="invoice-preview-vertical">
        <!-- Header starts -->
        <div class="row">
            <div class="col-6">
                <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="120"></span>
            </div>
            <div class="col-6 text-right mt-md-0 mt-2">
                <span style="color: #000;">
                    <?php echo $main_document; ?>
                </span>
                <table width="100%" class="mt-50" hidden>
                    <tr class="table-content">
                        <th rowspan="2" class="text-center" bgcolor="#003285" style="color: #fff; border-radius: 15px 0px 0px 0px;">
                            ใบแจ้งหนี้ / INVOICE
                        </th>
                        <td class="text-center">
                            INVOICE NO.
                        </td>
                    </tr>
                    <tr class="table-content">
                        <td class="text-center">
                            <?php echo $inv_full[0]; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Header ends -->
        <?php if ($cover_id > 0) { ?>
            <table width="100%" class="mt-1">
                <tr class="table-content">
                    <td class="p-0" width="34%" align="left" colspan="4">
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-4 text-right">
                                Company
                            </dt>
                            <dd class="col-sm-8"><?php echo $agent_name[0]; ?></dd>
                        </dl>
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-4 text-right">
                                Address
                            </dt>
                            <dd class="col-sm-8"><?php echo $agent_address[0]; ?></dd>
                        </dl>
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-4 text-right">
                                Tel
                            </dt>
                            <dd class="col-sm-8"><?php echo $agent_telephone[0]; ?></dd>
                        </dl>
                    </td>
                    <td class="p-0" width="34%" align="left" colspan="2">
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-6 text-right">
                                Tax ID.
                            </dt>
                            <dd class="col-sm-6"><?php echo $agent_license[0]; ?></dd>
                        </dl>
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-6 text-right">
                                สำนักงาน
                            </dt>
                            <dd class="col-sm-6"><?php echo $brch_name[0]; ?></dd>
                        </dl>
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-6 text-right">
                                Departure Date
                            </dt>
                            <dd class="col-sm-6"><?php echo date('j F Y', strtotime($inv_date[0])); ?></dd>
                        </dl>
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-6 text-right">
                                Due Date
                            </dt>
                            <dd class="col-sm-6"><?php echo date('j F Y', strtotime($rec_date[0])); ?></dd>
                        </dl>
                    </td>
                    <td class="p-0" width="34%" align="left" colspan="2">
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-6 text-right">
                                INVOICE NO.
                            </dt>
                            <dd class="col-sm-6"><?php echo $inv_full[0]; ?></dd>
                        </dl>
                    </td>
                </tr>
            </table>

            <table width="100%" class="mt-1">
                <tr class="table-black">
                    <td class="text-center" style="border-radius: 15px 0px 0px 0px;" width="3%"><b>เลขที่</b></td>
                    <td class="text-center"><b>วันที่เดินทาง</b></td>
                    <td class="text-center"><b>ชื่อลูกค้า</b></td>
                    <td class="text-center"><b>โปรแกรม</b></td>
                    <td class="text-center"><b>หมายเลข</b></td>
                    <td class="text-center" colspan="2"><b>จํานวน</b></td>
                    <td class="text-center" colspan="2"><b>ราคาต่อหน่วย</b></td>
                    <td class="text-center"><b>ส่วนลด</b></td>
                    <td class="text-center"><b>จำนวนเงิน</b></td>
                    <td class="text-center" style="border-radius: 0px 15px 0px 0px;"><b>Cash on tour</b></td>
                </tr>
                <tr class="table-black-2">
                    <td class="text-center"><small>Items</small></td>
                    <td class="text-center"><small>Date</small></td>
                    <td class="text-center"><small>Customer's name</small></td>
                    <td class="text-center"><small>Programe</small></td>
                    <td class="text-center"><small>Voucher No.</small></td>
                    <td class="text-center"><small>Adult</small></td>
                    <td class="text-center"><small>Child</small></td>
                    <td class="text-center"><small>Adult</small></td>
                    <td class="text-center"><small>Child</small></td>
                    <td class="text-center"><small>Discount</small></td>
                    <td class="text-center"><small>Amounth</small></td>
                    <td class="text-center"><small>เงินมัดจำ</small></td>
                </tr>
                <?php if (!empty($inv_id)) {
                    $no = 1;
                    for ($i = 0; $i < count($inv_id); $i++) {
                        $rowspan = count($bpr_id[$bo_id[$i]]);
                        for ($r = 0; $r < $rowspan; $r++) {
                            $amount = $total[$bo_id[$i]][$r] + $amount;
                            $sum_total = $total[$bo_id[$i]][$r] + $sum_total;
                            // $customer = $category_cus[$bo_id[$i]][$r] == 1 ? ' (Thai)' : ' (Foreign)';
                            $customer = ($status[$i] == 2 || $status[$i] == 4) ? ' (' . $category_name[$bo_id[$i]][$r] . ')' . ' <b class="text-danger">(' . $status_name[$i] . ')</b>' : ' (' . $category_name[$bo_id[$i]][$r] . ')';
                            if ($r == 0) { ?>
                                <tr class="table-content">
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td class="text-center" rowspan="<?php echo $rowspan; ?>"><?php echo date("d/m/Y", strtotime($travel_date[$i])); ?></td>
                                    <td rowspan="<?php echo $rowspan; ?>"><?php echo $cus_name[$i]; ?></td>
                                    <td><?php echo $product_name[$i] . $customer; ?></td>
                                    <td class="text-center" rowspan="<?php echo $rowspan; ?>"><?php echo $voucher_no[$i]; ?></td>
                                    <td class="text-center"><?php echo $adult[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center"><?php echo $child[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center"><?php echo $rate_adult[$bo_id[$i]][$r] != '-' ? number_format($rate_adult[$bo_id[$i]][$r]) : $rate_adult[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center"><?php echo $rate_child[$bo_id[$i]][$r] != '-' ? number_format($rate_child[$bo_id[$i]][$r]) : $rate_child[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center" rowspan="<?php echo $rowspan; ?>"><?php echo $discount[$i] != '-' ? number_format($discount[$i]) : $discount[$i]; ?></td>
                                    <td class="text-center"><?php echo $total[$bo_id[$i]][$r] != '-' ? number_format($total[$bo_id[$i]][$r]) : $total[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center" rowspan="<?php echo $rowspan; ?>"><?php echo $cot[$i] != '-' ? number_format($cot[$i]) : $cot[$i]; ?></td>
                                </tr>
                            <?php } elseif ($r > 0) {
                                $customer = $category_cus[$bo_id[$i]][$r] == 1 ? ' (Thai)' : ' (Foreign)'; ?>
                                <tr class="table-content">
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td><?php echo $product_name[$i] . $customer; ?></td>
                                    <td class="text-center"><?php echo $adult[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center"><?php echo $child[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center"><?php echo $rate_adult[$bo_id[$i]][$r] != '-' ? number_format($rate_adult[$bo_id[$i]][$r]) : $rate_adult[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center"><?php echo $rate_child[$bo_id[$i]][$r] != '-' ? number_format($rate_child[$bo_id[$i]][$r]) : $rate_child[$bo_id[$i]][$r]; ?></td>
                                    <td class="text-center"><?php echo $total[$bo_id[$i]][$r] != '-' ? number_format($total[$bo_id[$i]][$r]) : $total[$bo_id[$i]][$r]; ?></td>
                                </tr>
                        <?php }
                        } ?>

                        <?php if (!empty($arr_extar[$bo_id[$i]]['id'])) {
                            for ($e = 0; $e < count($arr_extar[$bo_id[$i]]['id']); $e++) {
                                $amount = $arr_extar[$bo_id[$i]]['total'][$e] + $amount;
                                $sum_total = $arr_extar[$bo_id[$i]]['total'][$e] + $sum_total; ?>
                                <tr class="table-content">
                                    <td class="text-left" colspan="2"><?php echo $arr_extar[$bo_id[$i]]['name'][$e]; ?></td>
                                    <td class="text-left" colspan="3"></td>
                                    <td class="text-center"><?php echo $arr_extar[$bo_id[$i]]['adult'][$e]; ?></td>
                                    <td class="text-center"><?php echo $arr_extar[$bo_id[$i]]['child'][$e]; ?></td>
                                    <td class="text-center"><?php echo $arr_extar[$bo_id[$i]]['rate_adult'][$e] != '-' ? number_format($arr_extar[$bo_id[$i]]['rate_adult'][$e]) : $arr_extar[$bo_id[$i]]['rate_adult'][$e]; ?></td>
                                    <td class="text-center"><?php echo $arr_extar[$bo_id[$i]]['rate_child'][$e] != '-' ? number_format($arr_extar[$bo_id[$i]]['rate_child'][$e]) : $arr_extar[$bo_id[$i]]['rate_child'][$e]; ?></td>
                                    <td class="text-center">-</td>
                                    <td class="text-center"><?php echo $arr_extar[$bo_id[$i]]['total'][$e] != '-' ? number_format($arr_extar[$bo_id[$i]]['total'][$e]) : $arr_extar[$bo_id[$i]]['total'][$e]; ?></td>
                                    <td class="text-center">-</td>
                                </tr>
                        <?php
                            }
                        } ?>

                <?php
                    }
                }
                if ($vat[0] == 1) {
                    $vat_total = $amount * 100 / 107;
                    $vat_cut = $vat_total;
                    $vat_total = $amount - $vat_total;
                    $withholding_total = $withholding[0] > 0 ? ($vat_cut * $withholding[0]) / 100 : 0;
                    $amount = $amount - $withholding_total;
                } elseif ($vat[0] == 2) {
                    $vat_total = ($amount * 7) / 100;
                    $amount = $amount + $vat_total;
                    $withholding_total = $withholding[0] > 0 ? ($amount - $vat_total) * $withholding[0] / 100 : 0;
                    $amount = $amount - $withholding_total;
                }
                ?>

                <tr class="table-content">
                    <td class="text-center" colspan="9"><em><b><?php echo bahtText($amount) ?></b></em></td>
                    <td class="text-center" colspan="3">
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-8 text-right">
                                <b>ยอดรวม : </b>
                                <p style="font-size: 10px; margin-bottom: 2px;">(Total)</p>
                            </dt>
                            <dd class="col-sm-4 mt-50 text-nowrap">฿ <?php echo number_format($amount); ?></dd>
                        </dl>
                    </td>
                </tr>

                <?php
                $amount = !empty($discount) ? $amount - array_sum($discount) : $amount;
                $amount = !empty($cot) ? $amount - array_sum($cot) : $amount;
                ?>

                <tr class="table-content">
                    <td colspan="9" rowspan="5">
                        <b>หมายเหตุและเงื่อนใข (Terms & Conditions)</b><br>
                        <p>
                            <?php echo !empty($account_name[0]) ? '</br><b>ชื่อบัญชี</b> ' . $account_name[0] . '</br><b>เลขที่บัญชี</b> ' . $account_no[0] . '</br><b>ธนาคาร</b> ' . $bank_name[0] : ''; ?>
                        </p>
                        <p>
                            <?php echo $inv_note[0]; ?>
                        </p>
                    </td>
                    <?php if (!empty($discount)) { ?>
                        <td class="table-content text-center" colspan="3">
                            <dl class="row" style="margin-bottom: 0;">
                                <dt class="col-sm-8 text-right">
                                    <b> ส่วนลด : </b>
                                    <p style="font-size: 10px; margin-bottom: 2px;">(Discount)</p>
                                </dt>
                                <dd class="col-sm-4 mt-50 text-nowrap">฿ <?php echo number_format(array_sum($discount)); ?></dd>
                            </dl>
                        </td>
                    <?php } ?>
                </tr>

                <?php if (!empty($cot)) { ?>
                    <tr class="table-content">
                        <td class="text-center" colspan="3">
                            <dl class="row" style="margin-bottom: 0;">
                                <dt class="col-sm-8 text-right">
                                    <b>Cash on tour :</b>
                                </dt>
                                <dd class="col-sm-4 mt-50 text-nowrap">฿ <?php echo number_format(array_sum($cot)); ?></dd>
                            </dl>
                        </td>
                    </tr>
                <?php } ?>

                <?php if ($vat[0] > 0) { ?>
                    <tr class="table-content">
                        <td class="text-center" colspan="3">
                            <dl class="row" style="margin-bottom: 0;">
                                <dt class="col-sm-8 text-right">
                                    <b> <?php echo $vat[0] != '-' ? $vat[0] == 1 ? 'รวมภาษี 7%' : 'แยกภาษี 7%' : '-' ?> : </b>
                                    <p style="font-size: 10px; margin-bottom: 2px;">(Tax)</p>
                                </dt>
                                <dd class="col-sm-4 mt-50 text-nowrap">฿ <?php echo number_format($vat_total, 2); ?></dd>
                            </dl>
                        </td>
                    </tr>
                <?php } ?>

                <?php if ($withholding[0] > 0) { ?>
                    <tr class="table-content">
                        <td class="text-center" colspan="3">
                            <dl class="row" style="margin-bottom: 0;">
                                <dt class="col-sm-8 text-right">
                                    <b> หัก ณ ที่จ่าย (<?php echo $withholding[0]; ?>%) : </b>
                                    <p style="font-size: 10px; margin-bottom: 2px;">(Withholding Tax)</p>
                                </dt>
                                <dd class="col-sm-4 mt-50 text-nowrap">฿ <?php echo number_format($withholding_total, 2); ?></dd>
                            </dl>
                        </td>
                    </tr>
                <?php } ?>

                <tr class="table-content">
                    <!-- <td colspan="9"></td> -->
                    <td class="text-center" bgcolor="#003285" style="color: #fff;" colspan="3">
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-8 text-right">
                                <b>ยอดชำระ : </b>
                                <p style="font-size: 10px; margin-bottom: 2px;">(Payment Amount)</p>
                            </dt>
                            <dd class="col-sm-4 mt-50 text-nowrap"><b>฿ <?php echo number_format($amount, 2); ?></b></dd>
                        </dl>
                    </td>
                </tr>
            </table>

            <table width="100%" class="mt-1">
                <tr>
                    <table width="100%" height="150px">
                        <tr class="table-content">
                            <td class="table-content" align="center" valign="bottom" width="35%">
                                _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ <br>
                                ผู้รับวางบิล / Receiver Signature <br>
                                วันที่ / Date _ _ _ _ _ _ _ _ _ _ _ _ _ _
                            </td>
                            <td class="table-content" align="center" valign="center" width="30%" style="font-weight: bold; font-size: 24px; color: rgba(0, 0, 0, 0.5);">
                                <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="100"></span>
                            </td>
                            <td class="table-content" align="center" valign="bottom" width="35%">
                                <span class="text-center h3 text-black"></span><br>
                                _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ <br>
                                ผู้มีอำนาจลงนาม / Authorized Signature <br>
                                วันที่ / Date _ _ _ <?php echo date('j F Y', strtotime($rec_date[0])); ?> _ _ _
                            </td>
                        </tr>
                    </table>
                </tr>
            </table>

        <?php } ?>
    </div>
    <div class="modal-footer d-flex justify-content-between <?php echo $type == 'GET' ? 'hidden' : ''; ?>">
        <div>
            <a href="javascript:void(0);" onclick="modal_invoice(<?php echo $get_cover; ?>);">
                <button type="button" class="btn btn-primary text-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                    Edit
                </button>
            </a>
        </div>
        <div>
            <a href="./?pages=invoice/print&action=<?php echo $action; ?>&cover_id=<?php echo $get_cover; ?>" target="_blank">
                <button type="button" class="btn btn-info text-left" name="print" value="print"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                    </svg>
                    Print
                </button>
            </a>
            <a href="javascript:void(0);">
                <button type="button" class="btn btn-info text-left" value="image" onclick="download_image();"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-image" viewBox="0 0 16 16">
                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                        <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54A.505.505 0 0 1 1 12.5v-9a.5.5 0 0 1 .5-.5h13z" />
                    </svg>
                    Image
                </button>
            </a>
        </div>
    </div>
    <input type="hidden" name="name_img" id="name_img" value="<?php echo 'Invoice-' . $inv_full[0]; ?>">
<?php } ?>
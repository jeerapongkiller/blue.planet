<?php
$type = !empty($_POST['action']) ? 'POST' : 'GET';
$action = empty($_POST['action']) ? !empty($_GET['action']) ? "print" : 0 : "preview";
$id = empty($_POST['rec_id']) ? !empty($_GET['rec_id']) ? $_GET['rec_id'] : 0 : $_POST['rec_id'];
$btn_edit = false;

$env_contro = $action == "preview" && $type == 'POST' ? '../../config/env.php' : 'config/env.php';
$inc_contro = $action == "preview" && $type == 'POST' ? '../../controllers/Receipt.php' : 'controllers/Receipt.php';
include_once($env_contro);
include_once($inc_contro);

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

if (isset($action) && !empty($id)) {
    $no = 0;
    $amount = 0;
    $sum_total = 0;
    $first_rec = array();
    $first_cover = array();
    $first_booking = array();
    $first_bpr = array();
    $first_extar = array();
    $receipts = $recObj->showlist('receipts', '0000-00-00', 'all', $id);
    if (!empty($receipts)) {
        foreach ($receipts as $receipt) {
            # --- get value receipt --- #
            if (in_array($receipt['rec_id'], $first_rec) == false) {
                $first_rec[] = $receipt['rec_id'];
                $rec_id[] = !empty($receipt['rec_id']) ? $receipt['rec_id'] : 0;
                $rec_full[] = !empty($receipt['rec_full']) ? $receipt['rec_full'] : '';
                $rec_file[] = !empty($receipt['rec_file']) ? $receipt['rec_file'] : '';
                $date_rec[] = !empty($receipt['date_rec']) ? $receipt['date_rec'] : '0000-00-00';
                $cheque_no[] = !empty($receipt['cheque_no']) ? $receipt['cheque_no'] : '';
                $cheque_date[] = !empty($receipt['cheque_date']) ? $receipt['cheque_date'] : '0000-00-00';
                $rec_note[] = !empty($receipt['rec_note']) ? $receipt['rec_note'] : '';
                $payt_id[] = !empty($receipt['payt_id']) ? $receipt['payt_id'] : 0;
                $payt_name[] = !empty($receipt['payt_name']) ? $receipt['payt_name'] : '';

                $cover_id[] = !empty($receipt['cover_id']) ? $receipt['cover_id'] : 0;
                $inv_full[] = !empty($receipt['inv_full']) ? $receipt['inv_full'] : '';
                $inv_date[] = !empty($receipt['inv_date']) ? $receipt['inv_date'] : '0000-00-00';
                $rec_date[] = !empty($receipt['rec_date']) ? $receipt['rec_date'] : '0000-00-00';
                $vat[] = !empty($receipt['vat']) ? $receipt['vat'] : '-';
                $withholding[] = !empty($receipt['withholding']) ? $receipt['withholding'] : '-';
                $comp_id[] = !empty($receipt['comp_id']) ? $receipt['comp_id'] : 0;
                $agent_name[] = !empty($receipt['comp_name']) ? $receipt['comp_name'] : '';
                $agent_license[] = !empty($receipt['tat_license']) ? $receipt['tat_license'] : '';
                $agent_telephone[] = !empty($receipt['comp_telephone']) ? $receipt['comp_telephone'] : '';
                $agent_address[] = !empty($receipt['comp_address']) ? $receipt['comp_address'] : '';
                $brch_name[] = !empty($receipt['brch_name']) ? $receipt['brch_name'] : '';
                $banacc_id[] = !empty($receipt['banacc_id']) ? $receipt['banacc_id'] : 0;
                $bank_id[] = !empty($receipt['bank_id']) ? $receipt['bank_id'] : 0;
                $account_name[] = !empty($receipt['account_name']) ? $receipt['account_name'] : '';
                $account_no[] = !empty($receipt['account_no']) ? $receipt['account_no'] : '';
                $bank_name[] = !empty($receipt['bank_name']) ? $receipt['bank_name'] : '';
            }
            # --- get value invoice --- #
            if (in_array($receipt['cover_id'], $first_cover) == false) {
                $first_cover[] = $receipt['cover_id'];
                $due_date[] = (diff_date($today, $receipt['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">วันที่ครบกำหนดชำระ : ' . date("j F Y", strtotime($receipt['rec_date'])) . ' (ครบกำหนดชำระในอีก ' . diff_date($today, $receipt['rec_date'])['num'] . ' วัน)</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">วันที่ครบกำหนดชำระ : ' . date("j F Y", strtotime($receipt['rec_date'])) . ' (เกินกำหนดชำระมาแล้ว ' . diff_date($today, $receipt['rec_date'])['num'] . ' วัน)</span>';

                $arr_inv[$receipt['rec_id']]['cover_id'] = !empty($receipt['cover_id']) ? $receipt['cover_id'] : 0;
                $arr_inv[$receipt['rec_id']]['inv_full'] = !empty($receipt['inv_full']) ? $receipt['inv_full'] : '';
                $arr_inv[$receipt['rec_id']]['inv_date'] = !empty($receipt['inv_date']) ? date('j F Y', strtotime($receipt['inv_date'])) : '0000-00-00';
                $arr_inv[$receipt['rec_id']]['rec_date'] = !empty($receipt['rec_date']) ? date('j F Y', strtotime($receipt['rec_date'])) : '0000-00-00';
                $arr_inv[$receipt['rec_id']]['vat'] = !empty($receipt['vat']) ? $receipt['vat'] : 0;
                $arr_inv[$receipt['rec_id']]['withholding'] = !empty($receipt['withholding']) ? $receipt['withholding'] : 0;
                $arr_inv[$receipt['rec_id']]['brch_name'] = !empty($receipt['brch_name']) ? $receipt['brch_name'] : '';
                $arr_inv[$receipt['rec_id']]['due_date'] = (diff_date($today, $receipt['rec_date'])['day'] > 0) ? '<span class="badge badge-pill badge-light-success text-capitalized">ครบกำหนดชำระในอีก ' . diff_date($today, $receipt['rec_date'])['num'] . ' วัน</span>' : '<span class="badge badge-pill badge-light-danger text-capitalized">เกินกำหนดชำระมาแล้ว ' . diff_date($today, $receipt['rec_date'])['num'] . ' วัน</span>';
            }
            # --- get value booking --- #
            if (in_array($receipt['id'], $first_booking) == false) {
                $first_booking[] = $receipt['id'];
                $inv_id[] = !empty($receipt['inv_id']) ? $receipt['inv_id'] : 0;
                $inv_no[] = !empty($receipt['inv_no']) ? $receipt['inv_no'] : 0;
                $bo_id[] = !empty($receipt['id']) ? $receipt['id'] : 0;
                $travel_date[] = !empty($receipt['travel_date']) ? $receipt['travel_date'] : '0000-00-00';
                $status[] = !empty($receipt['booksta_id']) ? $receipt['booksta_id'] : 0;
                $status_name[] = !empty($receipt['booksta_name']) ? $receipt['booksta_name'] : '';
                // $adult[] = !empty($receipt['bpr_adult']) ? $receipt['bpr_adult'] : 0;
                // $child[] = !empty($receipt['bpr_child']) ? $receipt['bpr_child'] : 0;
                // $rate_adult[] = !empty($receipt['rate_adult']) ? $receipt['rate_adult'] : 0;
                // $rate_child[] = !empty($receipt['rate_child']) ? $receipt['rate_child'] : 0;
                // $infant[] = !empty($receipt['bpr_infant']) ? $receipt['bpr_infant'] : 0;
                // $foc[] = !empty($receipt['bpr_foc']) ? $receipt['bpr_foc'] : 0;
                $cot[] = !empty($receipt['total_paid']) ? $receipt['total_paid'] : 0;
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
                $discount[] = !empty($receipt['discount']) ? $receipt['discount'] : 0;
                // $total[] = $receipt['bp_private_type'] == 1 ? ($receipt['bpr_adult'] * $receipt['rate_adult']) + ($receipt['bpr_child'] * $receipt['rate_child']) : $receipt['rate_total'];

                $arr_bo['id'][] = !empty($receipt['id']) ? $receipt['id'] : 0;
                $arr_bo[$receipt['id']]['status'] = !empty($receipt['booksta_id']) ? $receipt['booksta_id'] : 0;
                $arr_bo[$receipt['id']]['status_name'] = !empty($receipt['booksta_name']) ? '<b class="text-danger">(' . $receipt['booksta_name'] . ')</b>' : '';
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
                $rate_adult[$receipt['id']][] = !empty($receipt['rate_adult']) && $receipt['bpr_adult'] > 0 ? $receipt['rate_adult'] : '-';
                $rate_child[$receipt['id']][] = !empty($receipt['rate_child']) && $receipt['bpr_child'] > 0 ? $receipt['rate_child'] : '-';
                $total[$receipt['id']][] = $receipt['bp_private_type'] == 1 ? ($receipt['booksta_id'] != 2 && $receipt['booksta_id'] != 4) ? ($receipt['bpr_adult'] * $receipt['rate_adult']) + ($receipt['bpr_child'] * $receipt['rate_child']) : $receipt['rate_total'] : $receipt['rate_total'];

                $arr_rates[$receipt['id']]['id'][] = !empty($receipt['bpr_id']) ? $receipt['bpr_id'] : 0;
                $arr_rates[$receipt['id']]['category_name'][] = !empty($receipt['category_name']) ? $receipt['category_name'] : '';
                $arr_rates[$receipt['id']]['customer'][] = !empty($receipt['category_cus']) ? $receipt['category_cus'] : 0;
                $arr_rates[$receipt['id']]['adult'][] = !empty($receipt['bpr_adult']) ? $receipt['bpr_adult'] : 0;
                $arr_rates[$receipt['id']]['child'][] = !empty($receipt['bpr_child']) ? $receipt['bpr_child'] : 0;
                $arr_rates[$receipt['id']]['infant'][] = !empty($receipt['bpr_infant']) ? $receipt['bpr_infant'] : 0;
                $arr_rates[$receipt['id']]['foc'][] = !empty($receipt['bpr_foc']) ? $receipt['bpr_foc'] : 0;
                $arr_rates[$receipt['id']]['rate_adult'][] = !empty($receipt['rate_adult']) && $receipt['bpr_adult'] > 0 ? $receipt['rate_adult'] : '-';
                $arr_rates[$receipt['id']]['rate_child'][] = !empty($receipt['rate_child']) && $receipt['bpr_child'] > 0 ? $receipt['rate_child'] : '-';
                $arr_rates[$receipt['id']]['total'][] = $receipt['bp_private_type'] == 1 ? ($receipt['booksta_id'] != 2 && $receipt['booksta_id'] != 4) ? ($receipt['bpr_adult'] * $receipt['rate_adult']) + ($receipt['bpr_child'] * $receipt['rate_child']) : $receipt['rate_total'] : $receipt['rate_total'];
            }
            # --- get value booking --- #
            if (in_array($receipt['bec_id'], $first_extar) == false && !empty($receipt['bec_id'])) {
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
            }
        }
    }
?>
    <style>
        .default-td td {
            border: 1px solid #333;
            font-size: 14px;
            color: #000;
            padding: 5px 5px;
        }

        .default {
            border: 1px solid #333;
            font-size: 14px;
            color: #000;
            padding: 5px 5px;
        }

        #receipt-preview-vertical {
            background-color: #fff;
        }

        #receipt-preview-vertical .table-black td {
            background-color: #003285;
            color: #fff;
            padding: 10px 0;
        }

        #receipt-preview-vertical .table-black-2 td {
            background-color: #0060ff;
            color: #fff;
            padding: 5px 0;
        }
    </style>
    <div class="card-body receipt-padding pb-0" id="receipt-preview-vertical">

        <input type="hidden" id="agent_value" name="agent_value" value="<?php echo $comp_id[0]; ?>"
            data-name="<?php echo $agent_name[0]; ?>"
            data-license="<?php echo $agent_license[0]; ?>"
            data-telephone="<?php echo $agent_telephone[0]; ?>"
            data-address="<?php echo $agent_address[0]; ?>"
            data-rec_full="<?php echo $rec_full[0]; ?>"
            data-rec_file="<?php echo $rec_file[0]; ?>"
            data-rec_date="<?php echo $date_rec[0]; ?>"
            data-vat="<?php echo $vat[0]; ?>"
            data-withholding="<?php echo $withholding[0]; ?>"
            data-brch_name="<?php echo $brch_name[0]; ?>"
            data-payt_id="<?php echo $payt_id[0]; ?>"
            data-banacc_id="<?php echo $banacc_id[0]; ?>"
            data-bank_id="<?php echo $bank_id[0]; ?>"
            data-cheque_no="<?php echo $cheque_no[0]; ?>"
            data-cheque_date="<?php echo $cheque_date[0]; ?>"
            data-note="<?php echo $rec_note[0]; ?>">
        <textarea id="array_invoice" hidden><?php echo !empty($arr_inv) ? json_encode($arr_inv, true) : ''; ?></textarea>
        <textarea id="array_rates" hidden><?php echo !empty($arr_rates) ? json_encode($arr_rates, true) : ''; ?></textarea>
        <textarea id="array_booking" hidden><?php echo !empty($arr_bo) ? json_encode($arr_bo, true) : ''; ?></textarea>
        <textarea id="array_extar" hidden><?php echo !empty($arr_extar) ? json_encode($arr_extar, true) : ''; ?></textarea>

        <!-- Header starts -->
        <div class="row">
            <div class="col-6">
                <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="120"></span>
            </div>
            <div class="col-6 text-right mt-md-0 mt-2">
                <span style="color: #000;">
                    <?php echo $main_document; ?>
                </span>
                <table width="100%" class="mt-50">
                    <tr>
                        <td rowspan="2" class="text-center" bgcolor="#003285" style="color: #fff; border-radius: 15px 0px 0px 0px;">
                            <?php echo ($vat[0] > 0) ? 'ใบเสร็จรับเงิน / ใบกำกับภาษี <br> RECEIPT / TAX INVOICE' : 'ใบเสร็จรับเงิน <br> RECEIPT'; ?>
                        </td>
                        <td class="default text-center">
                            เลขใบเสร็จรับเงิน
                        </td>
                    </tr>
                    <tr class="default-td">
                        <td class="text-center">
                            <?php echo $rec_full[0]; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <table width="100%" class="mt-1">
            <tr class="default-td">
                <td width="34%" align="left" colspan="4">
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
                <td align="left" colspan="2">
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
                            PAID Date
                        </dt>
                        <dd class="col-sm-6"><?php echo date('j F Y', strtotime($date_rec[0])); ?></dd>
                    </dl>
                </td>
                <td width="34%" align="left" colspan="2">
                    <dl class="row" style="margin-bottom: 0;">
                        <dt class="col-sm-4 text-right">
                            เลขใบแจ้งหนี้
                        </dt>
                        <dd class="col-sm-8"><?php echo $inv_full[0]; ?></dd>
                    </dl>
                    <dl class="row" style="margin-bottom: 0;">
                        <dt class="col-sm-4 text-right">
                            การชำระเงิน
                        </dt>
                        <dd class="col-sm-8"><?php echo $payt_name[0]; ?></dd>
                    </dl>
                    <?php if ($receipts[0]['payt_id'] == 4) { ?>
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-4 text-right">
                                เลขบัญชี
                            </dt>
                            <dd class="col-sm-8"><?php echo $account_name[0] . ' (' . $account_no[0] . ')'; ?></dd>
                        </dl>
                    <?php } elseif ($receipts[0]['payt_id'] == 5) { ?>
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-4 text-right">
                                เลขที่เช็ค/ธนาคาร
                            </dt>
                            <dd class="col-sm-8"><?php echo $cheque_no[0] . ' / ' . $bank_name[0]; ?></dd>
                        </dl>
                        <dl class="row" style="margin-bottom: 0;">
                            <dt class="col-sm-4 text-right">
                                วันที่เช็ค
                            </dt>
                            <dd class="col-sm-8"><?php echo date('j F Y', strtotime($cheque_date[0])); ?></dd>
                        </dl>
                    <?php } ?>
                </td>
            </tr>
        </table>

        <table width="100%" class="mt-1">
            <tr class="table-black">
                <td class="text-center" style="border-radius: 15px 0px 0px 0px;" width="3%"><b>เลขที่</b></td>
                <!-- <td class="text-center"><b>เลขใบแจ้งหนี้</b></td> -->
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
                <!-- <td class="text-center"><small>Invoice No.</small></td> -->
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
                            <tr class="default-td">
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
                            <tr class="default-td">
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
                            <tr class="default-td">
                                <td class="text-left" colspan="2"><?php echo $arr_extar[$bo_id[$i]]['name'][$e]; ?></td>
                                <td class="text-left" colspan="4"></td>
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

            <tr class="default-td">
                <td class="text-center" colspan="10"><em><b><?php echo bahtText($amount) ?></b></em></td>
                <td class="text-center" colspan="3">
                    <dl class="row" style="margin-bottom: 0;">
                        <dt class="col-sm-8 text-right">
                            <b>ยอดรวม : </b>
                            <p style="font-size: 10px; margin-bottom: 2px;">(Total)</p>
                        </dt>
                        <dd class="col-sm-4 mt-50 text-nowrap">฿ <?php echo number_format($sum_total); ?></dd>
                    </dl>
                </td>
            </tr>

            <?php
            $amount = !empty($discount) ? $amount - array_sum($discount) : $amount;
            $amount = !empty($cot) ? $amount - array_sum($cot) : $amount;
            ?>

            <tr class="default-td">
                <td colspan="10" rowspan="5">
                    <b>หมายเหตุและเงื่อนใข (Terms & Conditions)</b><br>
                    <p>
                        <?php echo !empty($account_name[0]) ? '</br><b>ชื่อบัญชี</b> ' . $account_name[0] . '</br><b>เลขที่บัญชี</b> ' . $account_no[0] . '</br><b>ธนาคาร</b> ' . $bank_name[0] : ''; ?>
                    </p>
                    <p>
                        <?php echo $rec_note[0]; ?>
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
                <tr class="default-td">
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
                <tr class="default-td">
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
                <tr class="default-td">
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

            <tr class="default-td">
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
                    <tr class="default-td">
                        <td align="center" valign="bottom" width="35%">
                            _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ <br>
                            ผู้รับวางบิล / Receiver Signature <br>
                            วันที่ / Date _ _ _ _ _ _ _ _ _ _ _ _ _ _
                        </td>
                        <td align="center" valign="center" width="30%" style="font-weight: bold; font-size: 24px; color: rgba(0, 0, 0, 0.5);">
                            <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="100"></span>
                        </td>
                        <td align="center" valign="bottom" width="35%">
                            <span class="text-center h3 text-black"></span><br>
                            _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ <br>
                            ผู้มีอำนาจลงนาม / Authorized Signature <br>
                            วันที่ / Date _ _ _ <?php echo date('j F Y', strtotime($date_rec[0])); ?> _ _ _
                        </td>
                    </tr>
                </table>
            </tr>
        </table>
        <br><br>

    </div>
    <div class="modal-footer d-flex justify-content-between <?php echo $type == 'GET' ? 'hidden' : '';  ?>" id="btn-page">
        <div>
            <a href="javascript:void(0);" onclick="modal_receipt(<?php echo $id; ?>);">
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
            <a href="./?pages=receipt/print&action=<?php echo $action; ?>&rec_id=<?php echo $id; ?>" target="_blank">
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
    <input type="hidden" name="name_img" id="name_img" value="<?php echo $rec_full[0]; ?>">
<?php } ?>
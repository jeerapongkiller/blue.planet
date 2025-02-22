<?php
ob_end_clean();

require_once 'controllers/Order.php';
$orderObj = new Order();
$today = date("Y-m-d");

// import the PhpSpreadsheet Class
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// include composer autoload
require 'app-assets/vendors/excel/autoload.php';

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// การกำหนดค่า ข้อมูลเกี่ยวกับไฟล์ excel 
$spreadsheet->getProperties()
    ->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription(
        "Test document for Office 2007 XLSX, generated using PHP classes."
    )
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

$sheet->setCellValue('A1', 'ใบงาน'); // กำหนดค่าใน cell A1
$sheet->setCellValue('A2', '1 May 2023'); // กำหนดค่าใน cell B2
$sheet->mergeCells('A1:P1'); // รวม cel A1:P1
$sheet->mergeCells('A2:P2'); // รวม cel A2:P2

# --- get value --- #
$search_period = $_GET['search_period'] != "" ? $_GET['search_period'] : 'all';
$search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
$date_travel_form = $_GET['date_travel_form'] != "" ? $_GET['date_travel_form'] : '0000-00-00';

// echo '<b>search_period :</b> ' . $search_period . ' <b>search_product :</b> ' . $search_product . ' <b>date_travel_form :</b> ' . $date_travel_form . '</br>';
$first_order = array();
$first_bo = array();
$first_cus = array();
$orders = $orderObj->showlistboat('job', $search_period, $date_travel_form, $search_product, 'all', 'all', 'all');
if (!empty($orders)) {
    foreach ($orders as $order) {
        if ((in_array($order['orboat_id'], $first_order) == false)) {
            $first_order[] = $order['orboat_id'];
            $orboat_id[] = !empty($order['orboat_id']) ? $order['orboat_id'] : 0;
            $order_boat_id[] = !empty($order['boat_id']) ? $order['boat_id'] : '';
            $order_boat_name[] = empty($order['boat_id']) ? !empty($order['orboat_boat_name']) ? $order['orboat_boat_name'] : '' : $order['boat_name'];
            $order_boat_refcode[] = !empty($order['boat_refcode']) ? $order['boat_refcode'] : '';
            $order_capt_id[] = !empty($order['capt_id']) ? $order['capt_id'] : '';
            $order_capt_name[] = empty($order['capt_id']) ? !empty($order['orboat_captain_name']) ? $order['orboat_captain_name'] : '' : $order['capt_fname'] . ' ' . $order['capt_lname'] . ' ' . $order['capt_lname'] . ' (' . $order['capt_telephone'] . ')';
            $order_guide_id[] = !empty($order['guide_id']) ? $order['guide_id'] : '';
            $order_guide_name[] = empty($order['guide_id']) ? !empty($order['orboat_guide_name']) ? $order['orboat_guide_name'] : '' : $order['guide_name'] . ' (' . $order['guide_telephone'] . ')';
            $order_note[] = !empty($order['orboat_note']) ? $order['orboat_note'] : '';
            $order_fcrew_name[] = !empty($order['fcrew_id']) ? $order['fcrew_fname'] . ' ' . $order['fcrew_lname'] : '';
            $order_screw_name[] = !empty($order['screw_id']) ? $order['screw_fname'] . ' ' . $order['screw_lname'] : '';
            $order_price[] = !empty($order['orboat_price']) ? $order['orboat_price'] : '';
            $orboat_color[] = !empty($order['orboat_color']) ? $order['orboat_color'] : '';
            # --- order park --- #
            $orpark_id[] = !empty($order['orpark_id']) ? $order['orpark_id'] : 0;
            $array_orpark[$order['orpark_id']]['adult_eng'][] = !empty($order['adult_eng']) ? $order['adult_eng'] : 0;
            $array_orpark[$order['orpark_id']]['child_eng'][] = !empty($order['child_eng']) ? $order['child_eng'] : 0;
            $array_orpark[$order['orpark_id']]['adult_th'][] = !empty($order['adult_th']) ? $order['adult_th'] : 0;
            $array_orpark[$order['orpark_id']]['child_th'][] = !empty($order['child_th']) ? $order['child_th'] : 0;
            $array_orpark[$order['orpark_id']]['orpark_total'][] = !empty($order['orpark_total']) ? $order['orpark_total'] : 0;
            $array_orpark[$order['orpark_id']]['orpark_note'][] = !empty($order['orpark_note']) ? $order['orpark_note'] : '';
            $array_orpark[$order['orpark_id']]['orpark_park'][] = !empty($order['orpark_park']) ? $order['orpark_park'] : 0;
        }

        if (in_array($order['id'], $first_bo) == false) {
            $first_bo[] = $order['id'];
            $bo_id[$order['orboat_id']][] = !empty($order['id']) ? $order['id'] : 0;
            $park_id[$order['orboat_id']][] = !empty($order['park_id']) ? $order['park_id'] : 0;
            $pickup_time[$order['orboat_id']][] = $order['start_pickup'] != '00:00:00' ? $order['end_pickup'] != '00:00:00' ? date('H:i', strtotime($order['start_pickup'])) . '-' . date('H:i', strtotime($order['end_pickup'])) : date('H:i', strtotime($order['start_pickup'])) : '-';
            $room_no[$order['orboat_id']][] = !empty($order['room_no']) ? $order['room_no'] : '-';
            $hotel_name[$order['orboat_id']][] = empty($order['hotel_pickup_id']) ? !empty($order['hotel_pickup']) ? $order['hotel_pickup'] : '-' : $order['hotel_pickup_name'];
            $bp_note[$order['orboat_id']][] = !empty($order['bp_note']) ? $order['bp_note'] : '';
            $product_name[$order['orboat_id']][] = !empty($order['product_name']) ? $order['product_name'] : '';
            $booking_type[$order['orboat_id']][] = !empty($order['bp_private_type']) && $order['bp_private_type'] == 2 ? 'Private' : 'Join';
            $company_name[$order['orboat_id']][] = !empty($order['comp_name']) ? $order['comp_name'] : '';
            $voucher[$order['orboat_id']][] = !empty($order['voucher_no_agent']) ? $order['voucher_no_agent'] : '';
            $sender[$order['orboat_id']][] = !empty($order['sender']) ? $order['sender'] : '';
            $adult[$order['orboat_id']][] = !empty($order['bpr_adult']) ? $order['bpr_adult'] : 0;
            $child[$order['orboat_id']][] = !empty($order['bpr_child']) ? $order['bpr_child'] : 0;
            $infant[$order['orboat_id']][] = !empty($order['bpr_infant']) ? $order['bpr_infant'] : 0;
            $cus_name[$order['orboat_id']][] = !empty($order['cus_name']) ? $order['cus_name'] : '';
            $car_registration[$order['orboat_id']][] = !empty($order['car_registration']) ? $order['car_registration'] : '';
            $driver_name[$order['orboat_id']][] = !empty($order['driver_fname']) ? $order['driver_fname'] . ' ' . $order['driver_lname'] : '';
            $boker_name[$order['orboat_id']][] = !empty($order['booker_fname']) ? $order['booker_fname'] . ' ' . $order['booker_lname'] : '';
            $book_date[$order['orboat_id']][] = !empty($order['created_at']) ? date('j F Y', strtotime($order['created_at'])) : '';
            $bopay_id[$order['orboat_id']][] = !empty($order['bopay_id']) ? $order['bopay_id'] : 0;
            $bopay_name[$order['orboat_id']][] = !empty($order['bopay_name']) ? $order['bopay_name'] : '';
            $total_paid[$order['orboat_id']][] = !empty($order['total_paid']) ? $order['total_paid'] : '';
            $total = $order['rate_total'];
            $total = $order['transfer_type'] == 1 ? $total + ($order['bt_adult'] * $order['btr_rate_adult']) : $total;
            $total = $order['transfer_type'] == 1 ? $total + ($order['bpr_child'] * $order['btr_rate_child']) : $total;
            $total = $order['transfer_type'] == 1 ? $total + ($order['bpr_infant'] * $order['btr_rate_infant']) : $total;
            $total = $order['transfer_type'] == 2 ? $orderObj->sumbtrprivate($order['bt_id'])['sum_rate_private'] + $total : $total;
            $total = $orderObj->sumbectotal($order['id'])['sum_rate_total'] + $total;
            $total = !empty($order['discount']) ? $total - $order['discount'] : $total;
            $array_total[$order['orboat_id']][] = $total;
        }

        if (in_array($order['cus_id'], $first_cus) == false) {
            $first_cus[] = $order['cus_id'];
            $cus_id[$order['id']][] = !empty($order['cus_id']) ? $order['cus_id'] : 0;
            if (!empty($order['nationality_id']) && $order['nationality_id'] == 182) {
                $ad_th[$order['id']][] = !empty($order['cus_age']) && $order['cus_age'] == 1 ? 1 : 0;
                $chd_th[$order['id']][] = !empty($order['cus_age']) && $order['cus_age'] == 2 ? 1 : 0;
            } elseif (!empty($order['nationality_id']) && $order['nationality_id'] != 182) {
                $ad_eng[$order['id']][] = !empty($order['cus_age']) && $order['cus_age'] == 1 ? 1 : 0;
                $chd_eng[$order['id']][] = !empty($order['cus_age']) && $order['cus_age'] == 2 ? 1 : 0;
            }
            # --- array customers --- #
            $customers[$order['id']]['cus_name'][] = !empty($order['cus_name']) ? $order['cus_name'] : '-';
            $customers[$order['id']]['nation_name'][] = !empty($order['nation_name']) ? $order['nation_name'] : '-';
            $customers[$order['id']]['cus_age'][] = !empty($order['cus_age']) ? $order['cus_age'] != 1 ? $order['cus_age'] == 2 ? 'เด็ก' : '-' : 'ผู้ใหญ่' : '-';
            $customers[$order['id']]['id_card'][] = !empty($order['id_card']) ? $order['id_card'] : '-';
            $customers[$order['id']]['telephone'][] = !empty($order['telephone']) ? $order['telephone'] : '-';
            $customers[$order['id']]['birth_date'][] = !empty($order['birth_date']) && $order['birth_date'] != '0000-00-00' ? date('j F Y', strtotime($order['birth_date'])) : '-';
        }
    }
}

if (!empty($orboat_id)) {
    for ($i = 0; $i < count($orboat_id); $i++) {
        # --- head --- #
        $rowlist = 2;
        $columnName[] = ['Programe', $product_name[$orboat_id[$i]][0] . ' (' . $booking_type[$orboat_id[$i]][0] . ')', 'Boat', $order_boat_name[$i] . ' (' . $order_boat_refcode[$i] . ')', 'Captine', $order_capt_name[$i], 'Guide', $order_guide_name[$i], 'Staff1', $order_fcrew_name[$i], 'Staff2', $order_screw_name[$i]];
        $columnName[] = ['VOUCHER', 'AGENT', 'SENDER', 'CUSTOMERs NAME', 'AD', 'CHD', 'INF', 'HOTEL', 'ROOM', 'TIME', 'CAR', 'REMARK', 'PAYMENT', 'TOTAL', 'CONFIRMED', 'BOOKING DATE'];
        # --- body --- #
        if (!empty($bo_id[$orboat_id[$i]])) {
            for ($a = 0; $a < count($bo_id[$orboat_id[$i]]); $a++) {
                $columnName[] = [$voucher[$orboat_id[$i]][$a], $company_name[$orboat_id[$i]][$a], $sender[$orboat_id[$i]][$a], $cus_name[$orboat_id[$i]][$a], $adult[$orboat_id[$i]][$a], $child[$orboat_id[$i]][$a], $infant[$orboat_id[$i]][$a], $hotel_name[$orboat_id[$i]][$a], $room_no[$orboat_id[$i]][$a], $pickup_time[$orboat_id[$i]][$a], $car_registration[$orboat_id[$i]][$a] . ' (' . $driver_name[$orboat_id[$i]][$a] . ')', $bp_note[$orboat_id[$i]][$a], $bopay_id[$orboat_id[$i]][$a] == 4 || $bopay_id[$orboat_id[$i]][$a] == 5 ? $bopay_name[$orboat_id[$i]][$a] . ' (' . number_format($total_paid[$orboat_id[$i]][$a]) . ')' : $bopay_name[$orboat_id[$i]][$a], number_format($array_total[$orboat_id[$i]][$a]), $boker_name[$orboat_id[$i]][$a], $book_date[$orboat_id[$i]][$a]];
                $rowlist++;
            }
        }
        // echo 'rowlist : ' . $rowlist . '</br>';
        $columnName[] = [];
    }
}

// กำหนดหัวข้อคอลัมน์
// $columnName = [
//     ['Programe', 'Similan Island', 'Boat', ' เรือ', 'Captine', 'กัปตัน', 'Guide', 'ไกด์', 'Staff1', 'สตาฟ 1', 'Staff2', 'สตาฟ 2'],
//     ['VOUCHER', 'AGENT', 'SENDER', 'CUSTOMERs NAME', 'AD', 'CHD', 'INF', 'HOTEL', 'ROOM', 'TIME', 'CAR', 'REMARK', 'PAYMENT', 'TOTAL', 'CONFIRMED', 'BOOKING DATE'],
// ];

// print_r($columnName);

$sheet->fromArray(
    $columnName, // ตัวแปร array ข้อมูล
    NULL, // ค่าข้อมูลที่ตรงตามค่านี้ จะไม่ถูกำหนด
    'A3' // จุดพิกัดเริ่มต้น ที่ใช้งานข้อมูล เริ่มทึ่มุมบนซ้าย  หากไม่กำหนดจะเป็น "A4" ค่าเริ่มต้น
);

$writer = new Xlsx($spreadsheet);

// ชื่อไฟล์
$file_export = "Excel-" . date("dmY-Hs");


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $file_export . '.xlsx"');
header("Content-Transfer-Encoding: binary ");

$writer->save('php://output');
exit();

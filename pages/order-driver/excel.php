<?php
require_once 'controllers/Order.php';
$manageObj = new Order();
$today = date("Y-m-d");

require_once "app-assets/vendors/excel/Classes/PHPExcel.php"; //เรียกใช้ library สำหรับอ่านไฟล์ excel
$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0);

# --- get value --- #
$date_travel = $_GET['date_travel'] != "" ? $_GET['date_travel'] : '0000-00-00';
$search_car = $_GET['search_car'] != "" ? $_GET['search_car'] : 'all';
$search_driver = $_GET['search_driver'] != "" ? $_GET['search_driver'] : 'all';
$search_retrun = $_GET['search_return'] != "" ? $_GET['search_return'] : 1;
$search_status = $_GET['search_status'] != "" ? $_GET['search_status'] : 'all';
$search_agent = $_GET['search_agent'] != "" ? $_GET['search_agent'] : 'all';
$search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
$search_voucher_no = $_GET['voucher_no'] != "" ? $_GET['voucher_no'] : '';
$refcode = $_GET['refcode'] != "" ? $_GET['refcode'] : '';
$name = $_GET['name'] != "" ? $_GET['name'] : '';


# --- show list boats booking --- #
$first_manage = array();
$first_booking = array();
$frist_bomange = array();
$frist_bt[1] = [];
$bookings = $manageObj->showlisttransfers('all', 1, $date_travel, $search_car, $search_driver, 'all', $search_status, $search_agent, $search_product, $search_voucher_no, $refcode, $name);
# --- Check products --- #
if (!empty($bookings)) {
    foreach ($bookings as $booking) {
        # --- get value Programe --- #
        if (in_array($booking['mange_id'], $first_manage) == false) {
            $first_manage[] = $booking['mange_id'];
            $mange_id[] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
            $pickup[] = !empty($booking['mange_pickup']) ? $booking['mange_pickup'] : 0;
            $dropoff[] = !empty($booking['mange_dropoff']) ? $booking['mange_dropoff'] : 0;
            $driver_name[] = !empty($booking['driver_name']) ? $booking['driver_name'] : '';
            $license[] = !empty($booking['license']) ? $booking['license'] : '';
            $manage_telephone[] = !empty($booking['manage_telephone']) ? $booking['manage_telephone'] : '';
            $mange_note[] = !empty($booking['mange_note']) ? $booking['mange_note'] : '';
        }
        # --- get value booking --- #
        if (in_array($booking['id'], $first_booking) == false) {
            $first_booking[] = $booking['id'];
            $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
            $product_name[$booking['id']] = !empty($booking['product_name']) ? $booking['product_name'] : '';
            $agent_name[$booking['id']] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
            $book_full[$booking['id']] = !empty($booking['book_full']) ? $booking['book_full'] : '';
            $voucher_no[$booking['id']] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
            $cus_name[$booking['id']][] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
            $nation_name[$booking['id']][] = !empty($booking['nation_name']) ? ' (' . $booking['nation_name'] . ')' : '';
            $telephone[$booking['id']][] = !empty($booking['telephone']) ? $booking['telephone'] : '';
            $language[$booking['id']] = !empty(!empty($booking['lang_name'])) ? $booking['lang_name'] : '';
            $cate_transfer[$booking['id']] = !empty($booking['category_transfer']) ? $booking['category_transfer'] : 0;

            if ($booking['mange_id'] > 0 && (in_array($booking['bomange_id'], $frist_bomange) == false)) {
                $frist_bomange[] = $booking['bomange_id'];
                $bomange_bo[$booking['mange_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
            }
        }
        # --- get value booking transfer --- #
        if ((in_array($booking['bt_id'], $frist_bt[1]) == false)) {
            $frist_bt[1][] = $booking['bt_id'];
            $bt_id[$booking['id']][1] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
            // $mange_id[$booking['id']][1] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
            $arrange[$booking['id']][1] = !empty($booking['arrange']) ? $booking['arrange'] : 0;
            $bt_adult[$booking['id']][1] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
            $bt_child[$booking['id']][1] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
            $bt_infant[$booking['id']][1] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
            $bt_foc[$booking['id']][1] = !empty($booking['bt_foc']) ? $booking['bt_foc'] : 0;
            $hotel_name[$booking['id']][1] = !empty($booking['pickup_name']) ? $booking['pickup_name'] : '';
            $hotel_name[$booking['id']][2] = !empty($booking['dropoff_name']) ? $booking['dropoff_name'] : '';
            $room_no[$booking['id']][1] = !empty($booking['room_no']) ? $booking['room_no'] : '';
            $start_pickup[$booking['id']][1] = !empty($booking['start_pickup']) && $booking['start_pickup'] != '00:00' ? $booking['start_pickup'] : '00:00';
            $end_pickup[$booking['id']][1] = !empty($booking['end_pickup']) && $booking['end_pickup'] != '00:00' ? $booking['end_pickup'] : '00:00';
            $outside[$booking['id']][1] = !empty($booking['outside']) ? $booking['outside'] : '';
            $outside[$booking['id']][2] = !empty($booking['outside_dropoff']) ? $booking['outside_dropoff'] : '';
            $zone_name[$booking['id']][1] = !empty($booking['zonep_name']) ? $booking['zonep_name'] : '';
            $zone_name[$booking['id']][2] = !empty($booking['zoned_name']) ? $booking['zoned_name'] : '';
            $bt_note[$booking['id']][1] = !empty($booking['bt_note']) ? $booking['bt_note'] : '';

            $check_mange[$booking['product_id']][1][] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;

            if (($booking['pickup_id'] != $booking['dropoff_id']) || ($booking['outside'] != $booking['outside_dropoff'])) {
                $check_dropoff[$booking['product_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
            }

            if ($booking['mange_id'] > 0) {
                $bo_manage['id'][$booking['mange_id']][1][] = !empty($booking['id']) ? $booking['id'] : 0;
            }
        }
    }
}

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ใบจัดรถ (Pickup)');
$objPHPExcel->getActiveSheet()->SetCellValue('A2', date('j F Y', strtotime($date_travel)));
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');

$columnName = [];
if (!empty($mange_id)) {
    $row = 4;
    for ($i = 0; $i < count($mange_id); $i++) {
        $return = $search_retrun == 1 ? $pickup[$i] == 1 ? true : false : false;
        $return = $search_retrun == 2 ? $dropoff[$i] == 1 ? true : false : $return;
        $text_retrun = $pickup[$i] == $search_retrun ? 'Pickup' : 'Dropoff';
        $mange_retrun = 1;
        if (!empty($bomange_bo[$mange_id[$i]]) && $return == true) {
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':D' . $row);
            $objPHPExcel->getActiveSheet()->mergeCells('E' . $row . ':H' . $row);
            $objPHPExcel->getActiveSheet()->mergeCells('I' . $row . ':M' . $row);
            $columnName[] = ['คนขับ : ' . $driver_name[$i], '', '', '', 'ป้ายทะเบียน : ' . $license[$i], '', '', '', 'โทรศัพท์ : ' . $manage_telephone[$i], '', '', '', '',];
            $row++;
            $columnName[] = ['เวลารับ', 'โปรแกรม', 'เอเยนต์', 'V/C', 'โรงแรม', 'โซน', 'ห้อง', 'ชื่อลูกค้า', 'ภาษา (ไกด์)', 'A', 'C', 'INF', 'FOC', 'Remark',];
            $row++;

            $total_tourist = 0;
            $total_adult = 0;
            $total_child = 0;
            $total_infant = 0;
            $total_foc = 0;
            if (!empty($bomange_bo[$mange_id[$i]])) {
                for ($a = 0; $a < count($bomange_bo[$mange_id[$i]]); $a++) {
                    $row++;
                    $id = $bomange_bo[$mange_id[$i]][$a];
                    $total_tourist = $total_tourist + $bt_adult[$id][$mange_retrun] + $bt_child[$id][$mange_retrun] + $bt_infant[$id][$mange_retrun] + $bt_foc[$id][$mange_retrun];
                    $total_adult = $total_adult + $bt_adult[$id][$mange_retrun];
                    $total_child = $total_child + $bt_child[$id][$mange_retrun];
                    $total_infant = $total_infant + $bt_infant[$id][$mange_retrun];
                    $total_foc = $total_foc + $bt_foc[$id][$mange_retrun];
                    $category_text = '';
                    if (!empty($category_name[$id])) {
                        $category_text .= ' (';
                        for ($c = 0; $c < count($category_name[$id]); $c++) {
                            $category_text .= $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                        }
                    }
                    $category_text .= ')';
                    $text_hotel = '';
                    $text_zone = '';
                    if ($cate_transfer[$id] == 1) {
                        if (!empty($zone_name[$id][1])) {
                            $text_zone = $zone_name[$id][1] != $zone_name[$id][2] ? $zone_name[$id][1] . '<br>(D: ' . $zone_name[$id][2] . ')' : $zone_name[$id][1];
                        }
                        if (!empty($hotel_name[$id][1])) {
                            $text_hotel = $hotel_name[$id][1] != $hotel_name[$id][2] ? $hotel_name[$id][1] . '<br>(D: ' . $hotel_name[$id][2] . ')' : $hotel_name[$id][1];
                        } else {
                            $text_hotel = $outside[$id][1] != $outside[$id][2] ? $outside[$id][1] . '<br>(D: ' . $outside[$id][2] . ')' : $outside[$id][1];
                        }
                    } else {
                        $text_hotel = 'เดินทางมาเอง';
                        $text_zone = 'เดินทางมาเอง';
                    }

                    $columnName[] = [
                        $start_pickup[$id][$mange_retrun] != '00:00' ? date('H:i', strtotime($start_pickup[$id][$mange_retrun])) . ' - ' . date('H:i', strtotime($end_pickup[$id][$mange_retrun])) : '',
                        $product_name[$id] . $category_text,
                        $agent_name[$id],
                        !empty($voucher_no[$id]) ? $voucher_no[$id] : $book_full[$id],
                        $text_hotel,
                        $text_zone,
                        $room_no[$id][$mange_retrun],
                        !empty($telephone[$id][0]) ? $cus_name[$id][0] . '  (TEL : ' . $telephone[$id][0] . ') ' : $cus_name[$id][0],
                        !empty($language[$id]) ? $language[$id] : '',
                        $bt_adult[$id][$mange_retrun],
                        $bt_child[$id][$mange_retrun],
                        $bt_infant[$id][$mange_retrun],
                        $bt_foc[$id][$mange_retrun],
                        $bt_note[$id][1],
                    ];
                }
            }
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':M' . $row);
            $columnName[] = ['Remark : ' . $mange_note[$i]];
            $row++;
            $columnName[] = ['TOTAL', 'Adult', 'Child', 'Infant', 'FOC',];
            $row++;
            $columnName[] = [$total_tourist, $total_adult, $total_child, $total_infant, $total_foc,];
            $row++;
            $columnName[] = [''];
            $row++;
        }
    }
}

$objPHPExcel->getActiveSheet()->fromArray($columnName, null, 'A4');

// ชื่อไฟล์
$file_export = "Excel-" . date("dmY-Hs");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $file_export . '.xlsx"');
ob_end_clean();
$objWriter->save('php://output');
exit();

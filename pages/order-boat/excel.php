<?php
require_once 'controllers/Order.php';
$manageObj = new Order();
$today = date("Y-m-d");

if (isset($_GET['action']) && $_GET['action'] == "customer" && (!empty($_GET['manage_id']))) {
    require_once "app-assets/vendors/excel/Classes/PHPExcel.php"; //เรียกใช้ library สำหรับอ่านไฟล์ excel
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->setActiveSheetIndex(0);

    # --- get value --- #
    $manage_id = $_GET['manage_id'] != "" ? $_GET['manage_id'] : 0;
    $travel_date = $_GET['date_travel'] != "" ? $_GET['date_travel'] : '0000-00-00';

    # --- show list boats booking --- #
    $first_cus = array();
    $bookings = $manageObj->showlistboats('customer', $manage_id, $travel_date, 'all', 'all', 'all', 'all', 'all', '', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            if ($booking['mange_id'] == $manage_id) {

                $boat_name = !empty($booking['boat_name']) ? $booking['boat_name'] : 0;
                $product_name = !empty($booking['product_name']) ? $booking['product_name'] : '';

                if (in_array($booking['cus_id'], $first_cus) == false) {
                    $first_cus[] = $booking['cus_id'];
                    $cus_id[] = !empty($booking['cus_id']) ? $booking['cus_id'] : 0;
                    $cus_age[] = !empty($booking['cus_age']) ? $booking['cus_age'] : 0;
                    $nation_id[] = !empty($booking['nation_id']) ? $booking['nation_id'] : 0;
                    $age_name[] = !empty($booking['cus_age']) ? $booking['cus_age'] != 1 ? $booking['cus_age'] != 2 ? $booking['cus_age'] != 3 ? $booking['cus_age'] == 4 ? 'FOC' : '' : 'Infant' : 'Children' : 'Adult' : '';
                    $cus_name[] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                    $id_card[] = !empty($booking['id_card']) ? $booking['id_card'] : '';
                    $birth_date[] = !empty($booking['birth_date']) && $booking['birth_date'] != '0000-00-00' ? date('j F Y', strtotime($booking['birth_date'])) : '';
                    $nation_name[] = !empty($booking['nation_name']) ? $booking['nation_name'] : '';
                    $nation_name[] = !empty($booking['nation_name']) ? $booking['nation_name'] : '';
                    $voucher_no_agent[] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
                    $telephone[] = !empty($booking['telephone']) ? $booking['telephone'] : '';
                }
            }
        }
    }

    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'รายชื่อส่งอุทยาน' . $product_name);
    $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'วันที่เดินทาง ' . date('j F Y', strtotime($travel_date)) . ' ' . $boat_name);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');

    $columnName = [];
    $total_tourist = 0;
    $total_adult = 0;
    $total_child = 0;
    $total_infant = 0;
    $total_foc = 0;
    if (!empty($cus_id)) {
        $columnName[] = ['ลำดับ', 'ชื่อ-สกุล', 'วัน/เดือน/ปีเกิด', 'เลขพาส', 'สัญชาติ', 'เบอร์โทร', 'ลายเซ็น',];

        for ($i = 0; $i < count($cus_id); $i++) {
            $total_adult = $cus_age[$i] == 1 ? $total_adult + 1 : $total_adult;
            $total_child = $cus_age[$i] == 2 ? $total_child + 1 : $total_child;
            $total_infant = $cus_age[$i] == 3 ? $total_infant + 1 : $total_infant;
            $total_foc = $cus_age[$i] == 4 ? $total_foc + 1 : $total_foc;
            $total_tourist = $total_tourist + 1;

            $columnName[] = [$i + 1, $cus_name[$i], $birth_date[$i], $id_card[$i], $nation_name[$i], $telephone[$i], ''];
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
} else if (isset($_GET['action']) && $_GET['action'] == "boat" && !empty($_GET['date_travel'])) {
    require_once "app-assets/vendors/excel/Classes/PHPExcel.php"; //เรียกใช้ library สำหรับอ่านไฟล์ excel
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->setActiveSheetIndex(0);
    // get value from ajax
    $date_travel = $_GET['date_travel'] != "" ? $_GET['date_travel'] : '0000-00-00';
    $search_boat = $_GET['search_boat'] != "" ? $_GET['search_boat'] : 'all';
    $search_status = $_GET['search_status'] != "" ? $_GET['search_status'] : 'all';
    $search_agent = $_GET['search_agent'] != "" ? $_GET['search_agent'] : 'all';
    $search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';
    $search_voucher_no = $_GET['search_voucher_no'] != "" ? $_GET['search_voucher_no'] : '';
    $refcode = $_GET['refcode'] != "" ? $_GET['refcode'] : '';
    $name = $_GET['name'] != "" ? $_GET['name'] : '';

    $first_manage = array();
    $first_booking = array();
    $first_bpr = array();
    $bookings = $manageObj->showlistboats('list', 0, $date_travel, $search_boat, 'all', $search_status, $search_agent, $search_product, $search_voucher_no, $refcode, $name, '');
    # --- Check products --- #
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value manage --- #
            if (in_array($booking['mange_id'], $first_manage) == false && !empty($booking['mange_id'])) {
                $first_manage[] = $booking['mange_id'];
                $mange_id[] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
                $boat_name[] = !empty($booking['boat_id']) ? !empty($booking['boat_name']) ? $booking['boat_name'] : '' : $booking['outside_boat'];
                $guide_name[] = !empty($booking['guide_id']) ? $booking['guide_name'] : '';
                $counter[] = !empty($booking['counter']) ? $booking['counter'] : '';
                $text_color[] = !empty($booking['text_color']) ? $booking['text_color'] : '';
                $mange_note[] = !empty($booking['mange_note']) ? $booking['mange_note'] : '';
            }
            # --- get value booking --- #
            if (in_array($booking['id'], $first_booking) == false) {
                $first_booking[] = $booking['id'];
                $bo_id[$booking['mange_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                $book_full[$booking['id']] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                $voucher_no[$booking['id']] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
                $agent_name[$booking['id']] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                $start_pickup[$booking['id']] = !empty($booking['start_pickup']) && $booking['start_pickup'] != '00:00' ? date('H:i', strtotime($booking['start_pickup'])) : '';
                $end_pickup[$booking['id']] = !empty($booking['end_pickup']) && $booking['end_pickup'] != '00:00' ? date('H:i', strtotime($booking['end_pickup'])) : '';
                $car_name[$booking['id']] = !empty($booking['car_name']) ? $booking['car_name'] : '';
                $driver_name[$booking['id']] = !empty($booking['driver_name']) ? $booking['driver_name'] : '';
                $product_name[$booking['id']] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $cate_transfer[$booking['id']] = !empty($booking['category_transfer']) ? $booking['category_transfer'] : 0;
                $hotel_name[$booking['id']] = !empty($booking['pickup_name']) ? $booking['pickup_name'] : '';
                $zone_pickup[$booking['id']] = !empty($booking['zonep_name']) ? ' (' . $booking['zonep_name'] . ')' : '';
                $dropoff_name[$booking['id']] = !empty($booking['dropoff_name']) ? $booking['dropoff_name'] : '';
                $zone_dropoff[$booking['id']] = !empty($booking['zoned_name']) ? ' (' . $booking['zoned_name'] . ')' : '';
                $room_no[$booking['id']] = !empty($booking['room_no']) ? $booking['room_no'] : '';
                $outside[$booking['id']] = !empty($booking['outside']) ? $booking['outside'] : '';
                $outside_dropoff[$booking['id']] = !empty($booking['outside_dropoff']) ? $booking['outside_dropoff'] : '';
                $pickup_type[$booking['id']] = !empty($booking['pickup_type']) ? $booking['pickup_type'] : 0;
                $note[$booking['id']] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
                $cus_name[$booking['id']][] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $telephone[$booking['id']][] = !empty($booking['telephone']) ? $booking['telephone'] : '';
                $language[$booking['id']] = !empty($booking['lang_name']) ? $booking['lang_name'] : '';
            }
            # --- get value booking rates --- #
            if ((in_array($booking['bpr_id'], $first_bpr) == false) && !empty($booking['bpr_id'])) {
                $first_bpr[] = $booking['bpr_id'];
                $bpr_id[$booking['id']][] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
                $category_id[$booking['id']][] = !empty($booking['category_id']) ? $booking['category_id'] : 0;
                $category_name[$booking['id']][] = !empty($booking['category_name']) ? $booking['category_name'] : 0;
                $category_cus[$booking['id']][] = !empty($booking['category_cus']) ? $booking['category_cus'] : 0;
                $adult[$booking['id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $child[$booking['id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $infant[$booking['id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $foc[$booking['id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
            }
        }
    }

    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ใบจัดเรือ');
    $objPHPExcel->getActiveSheet()->SetCellValue('A2', date('j F Y', strtotime($date_travel)));
    $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');

    $columnName = [];
    if (!empty($mange_id)) {
        $row = 4;
        for ($i = 0; $i < count($mange_id); $i++) {
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':L' . $row);
            $columnName[] = [$boat_name[$i]];
            $row++;
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':E' . $row);
            $objPHPExcel->getActiveSheet()->mergeCells('F' . $row . ':J' . $row);
            $objPHPExcel->getActiveSheet()->mergeCells('K' . $row . ':N' . $row);
            $columnName[] = ['ไกด์ : ' . $guide_name[$i], '', '', '',  'เคาน์เตอร์ : ' . $counter[$i], '', '', '',  'สี : ' . $text_color[$i], '', '', '', ];
            $row++;
            $columnName[] = ['เวลารับ', 'Driver', 'โปรแกรม', 'เอเยนต์', 'ชื่อลูกค้า', 'ภาษา (ไกด์)', 'V/C',  'โรงแรม', 'โซน', 'A', 'C', 'INF', 'FOC', 'Remark',];
            $row++;

            $total_tourist = 0;
            $total_adult = 0;
            $total_child = 0;
            $total_infant = 0;
            $total_foc = 0;
            if (!empty($bo_id[$mange_id[$i]])) {
                for ($a = 0; $a < count($bo_id[$mange_id[$i]]); $a++) {
                    $id = $bo_id[$mange_id[$i]][$a];
                    $total_tourist = $total_tourist + array_sum($adult[$id]) + array_sum($child[$id]) + array_sum($infant[$id]) + array_sum($foc[$id]);
                    $total_adult = $total_adult + array_sum($adult[$id]);
                    $total_child = $total_child + array_sum($child[$id]);
                    $total_infant = $total_infant + array_sum($infant[$id]);
                    $total_foc = $total_foc + array_sum($foc[$id]);

                    $category_text = '';
                    if (!empty($category_name[$id])) {
                        $category_text .= ' (';
                        for ($c = 0; $c < count($category_name[$id]); $c++) {
                            $category_text .= $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                        }
                    }
                    $category_text .= ')';

                    
                    $columnName[] = [
                        !empty($start_pickup[$id]) ? !empty($end_pickup[$id]) ? $start_pickup[$id] . ' - ' . $end_pickup[$id] : $start_pickup[$id] : '',
                        !empty($car_name[$id]) ? $car_name[$id] : $driver_name[$id],
                        $product_name[$id] . $category_text,
                        $agent_name[$id],
                        !empty($telephone[$id][0]) ? $cus_name[$id][0] . '  (TEL : ' . $telephone[$id][0] . ') ' : $cus_name[$id][0],
                        !empty($language[$id]) ? $language[$id] : '',
                        !empty($voucher_no[$id]) ? $voucher_no[$id] : $book_full[$id],
                        (!empty($hotel_name[$id])) ? $hotel_name[$id] : $outside[$id],
                        (!empty($zone_pickup[$id])) ? $zone_pickup[$id] : '',
                        !empty($adult[$id]) ? array_sum($adult[$id]) : 0,
                        !empty($child[$id]) ? array_sum($child[$id]) : 0,
                        !empty($infant[$id]) ? array_sum($infant[$id]) : 0,
                        !empty($foc[$id]) ? array_sum($foc[$id]) : 0,
                        $note[$id],
                    ];
                    $row++;
                }
            }
            $columnName[] = ['Remark : ' . $mange_note[$i]];
            $row++;
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':M' . $row);
            $columnName[] = ['TOTAL', 'Adult', 'Child', 'Infant', 'FOC',];
            $row++;
            $columnName[] = [$total_tourist, $total_adult, $total_child, $total_infant, $total_foc,];
            $row++;
            $columnName[] = [''];
            $row++;
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
}
exit();

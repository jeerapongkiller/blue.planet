<?php
require_once 'controllers/Report.php';

$repObj = new Report();
$today = date("Y-m-d");
$times = date("H:i:s");

require_once "app-assets/vendors/excel/Classes/PHPExcel.php"; //เรียกใช้ library สำหรับอ่านไฟล์ excel
$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0);

if (isset($_GET['action']) && $_GET['action'] == "print" && isset($_GET['type'])) {
    # --- get value --- #
    $search_status = !empty($_GET["search_status"]) ? $_GET["search_status"] : 'all';
    $search_travel = !empty($_GET["search_travel"]) ? $_GET["search_travel"] : '0000-00-00';
    $date_form = substr($search_travel, 0, 10) != '' ? substr($search_travel, 0, 10) : '0000-00-00';
    $date_to = substr($search_travel, 14, 10) != '' ? substr($search_travel, 14, 10) : $date_form;
    $search_agent = $_GET['search_agent'] != "" ? $_GET['search_agent'] : 'all';
    $search_product = $_GET['search_product'] != "" ? $_GET['search_product'] : 'all';

    $text_detail = '';
    $text_detail .= $date_form != '0000-00-00' ? $date_to != '0000-00-00' ? 'วันที่ ' . date('j F Y', strtotime($date_form)) . ' ถึง ' . date('j F Y', strtotime($date_to)) : 'วันที่ ' . date('j F Y', strtotime($date_form)) : '';
    $text_detail .= $search_agent != 'all' ? ' เอเยนต์ ' . $repObj->get_value('name', 'companies', $search_agent)['name'] : ' เอเยนต์ทั้งหมด';
    $text_detail .= $search_product != 'all' ? ' โปรแกรม ' . $repObj->get_value('name', 'products', $search_product)['name'] : ' โปรแกรมทั้งหมด';

    # --- get data --- #
    $inv_no = 0;
    $no_rec = 0;
    $balance = 0;
    $count_boboat = 0;
    $count_bot = 0;
    $paid = 0;
    $not_issued = 0;
    $issued_inv = 0;
    $first_book = array();
    $first_agent = array();
    $first_prod = array();
    $first_bot = array();
    $first_boboat = array();
    $first_bpr = array();
    $first_extar = array();
    $first_pay = array();
    $bookings = $repObj->showlist($search_status, $date_form, $date_to, $search_agent, $search_product);
    foreach ($bookings as $booking) {
        # --- get value booking --- #
        if (in_array($booking['id'], $first_book) == false) {
            $first_book[] = $booking['id'];
            # --- get value booking --- #
            $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
            $status[] = $booking['booksta_name'];
            $rec_id[] = !empty($booking['rec_id']) ? $booking['rec_id'] : 0;
            $book_full[] = !empty($booking['book_full']) ? $booking['book_full'] : '';
            $voucher_no_agent[] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
            $inv_full[] = !empty($booking['inv_full']) ? $booking['inv_full'] : '';
            $travel_date[] = !empty($booking['travel_date']) ? $booking['travel_date'] : '0000-00-00';
            $bo_status[] = !empty($booking['booksta_id']) ? $booking['booksta_id'] : 0;
            $sender[] = !empty($booking['sender']) ? $booking['sender'] : '';
            # --- get value booking products --- #
            $discount[] = !empty($booking['discount']) ? $booking['discount'] : 0;
            $array_discount[$booking['id']] = !empty($booking['discount']) ? $booking['discount'] : 0;
            $comp_discount[$booking['comp_id']] = !empty($booking['discount']) ? $booking['discount'] : 0;
            # --- get value booking products --- #
            $hotel_pickup_name[] = !empty($booking['hotel_pickup_name']) ? $booking['hotel_pickup_name'] : '';
            $hotel_dropoff_name[] = !empty($booking['hotel_dropoff_name']) ? $booking['hotel_dropoff_name'] : '';
            # --- get value customers --- #
            $cus_name[] = !empty($booking['cus_name']) && $booking['cus_head'] == 1 ? $booking['cus_name'] : '';
            $inv_no = !empty($booking['inv_id']) ? $inv_no + 1 : $inv_no;
            # --- Agent --- #
            $comp_id[] = !empty($booking['comp_id']) ? $booking['comp_id'] : 0;
            $comp_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
            # --- Programe --- #
            $prod_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
            $product_name[$booking['product_id']] = !empty($booking['product_name']) ? $booking['product_name'] : '';
            # --- order boat --- #
            if (!empty(!empty($booking['orboat_id'])) && !empty($booking['orboat_id']) > 0) {
                # --- Boat --- #
                $boat_id[$booking['orboat_id']][] = !empty($booking['boat_id']) ? $booking['boat_id'] : 0;
                $boat_color[$booking['orboat_id']] = !empty($booking['orboat_color']) ? $booking['orboat_color'] : 0;
                $boat_name[$booking['boat_id']] = !empty($booking['boat_name']) ? $booking['boat_name'] : '';
                $boat_order_id[$booking['orboat_id']][] = !empty($booking['boat_id']) ? $booking['boat_id'] : 0;
                $boat_product[$booking['orboat_id']] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
            }
            # --- order car --- #
            if (!empty(!empty($booking['ortran_id'])) && !empty($booking['ortran_id']) > 0) {
                $ortran_id[$booking['ortran_id']] = !empty($booking['ortran_id']) ? $booking['ortran_id'] : 0;
                $ortran_retrun[$booking['ortran_id']] = !empty($booking['ortran_retrun']) ? $booking['ortran_retrun'] : 0;
                $car_name[$booking['ortran_id']] = !empty($booking['car_name']) ? $booking['car_name'] : '';
                $car_registration[$booking['ortran_id']] = !empty($booking['license']) ? $booking['license'] : '';
                $driver_name[$booking['ortran_id']] = !empty($booking['driver_name']) ? $booking['driver_name'] : '';
                $ortran_product[$booking['ortran_id']] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                $ortran_travel[$booking['ortran_id']] = !empty($booking['ortran_travel']) ? $booking['ortran_travel'] : 0;
                $bt_id[$booking['ortran_id']][] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                $car_adult[$booking['ortran_id']][] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
                $car_child[$booking['ortran_id']][] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
                $car_infant[$booking['ortran_id']][] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
                $car_foc[$booking['ortran_id']][] = !empty($booking['bt_foc']) ? $booking['bt_foc'] : 0;
            }
            # --- Park --- #
            $bo_park[] = !empty($booking['park_id']) ? $booking['park_id'] : 0;
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
            $rate_adult[$booking['id']][] = !empty($booking['rate_adult']) ? $booking['rate_adult'] : 0;
            $rate_child[$booking['id']][] = !empty($booking['rate_child']) ? $booking['rate_child'] : 0;
            $rate_infant[$booking['id']][] = !empty($booking['rate_infant']) ? $booking['rate_infant'] : 0;
            $rate_total[$booking['id']][] = !empty($booking['rate_total']) ? $booking['rate_total'] : 0;
            $rate_private[$booking['id']][] = !empty($booking['rate_private']) ? $booking['rate_private'] : 0;
            $tourist[$booking['id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
            $total[$booking['id']][] = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];
            $array_total[] = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];
            $array_amount[$booking['id']][] = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];

            $comp_adult[$booking['comp_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
            $comp_child[$booking['comp_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
            $comp_infant[$booking['comp_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
            $comp_foc[$booking['comp_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
            $comp_sum[$booking['comp_id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
            $comp_amount[$booking['comp_id']][] = $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'];
            $comp_revenue[$booking['comp_id']][] = !empty($booking['rec_id']) ? $booking['bp_private_type'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) : $booking['rate_total'] : 0;

            $product_adult[$booking['product_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
            $product_child[$booking['product_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
            $product_infant[$booking['product_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
            $product_foc[$booking['product_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;

            if (!empty(!empty($booking['orboat_id'])) && !empty($booking['orboat_id']) > 0) {
                $boat_adult[$booking['orboat_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $boat_child[$booking['orboat_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $boat_infant[$booking['orboat_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $bpr_foc[$booking['orboat_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
            }
        }
        # --- get value agent company --- #
        if (in_array($booking['comp_id'], $first_agent) == false) {
            $first_agent[] = $booking['comp_id'];
            $agent_id[] = !empty($booking['comp_id']) ? $booking['comp_id'] : 0;
            $agent_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
            $agent_logo[] = !empty($booking['comp_logo']) ? $booking['comp_logo'] : '';
        }
        # --- get value booking products --- #
        if (in_array($booking['product_id'], $first_prod) == false) {
            $first_prod[] = $booking['product_id'];
            $product_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
        }
        # --- get value booking order transfer --- #
        if (in_array($booking['bt_id'], $first_bot) == false && !empty($booking['ortran_id']) && !empty($booking['bt_id'])) {
            $first_bot[] = $booking['bt_id'];
            $bot_id[$booking['ortran_id']][] = $booking['bt_id'];
            $count_bot++;
        }
        # --- get value booking order boat --- #
        if (in_array($booking['boboat_id'], $first_boboat) == false && !empty($booking['orboat_id']) && !empty($booking['boboat_id'])) {
            $first_boboat[] = $booking['boboat_id'];
            $boboat_id[$booking['orboat_id']][] = $booking['boboat_id'];
            $count_boboat++;
        }
        # --- get value booking payment --- #
        if ((in_array($booking['bopa_id'], $first_pay) == false) && !empty($booking['bopa_id'])) {
            # --- in array get value booking payment --- #
            $first_pay[] = $booking['bopa_id'];
            $bopay_id[$booking['id']] = !empty($booking['bopay_id']) ? $booking['bopay_id'] : 0;
            $bopay_name[$booking['id']] = !empty($booking['bopay_name']) ? $booking['bopay_name'] : '';
            $total_paid[$booking['id']] = !empty($booking['total_paid']) ? $booking['total_paid'] : '';
            $bo_cot[$booking['id']] = !empty($booking['bopay_id']) && $booking['bopay_id'] == 4 ? !empty($booking['total_paid']) ? $booking['total_paid'] : 0 : 0;
            $bo_dep[$booking['id']] = !empty($booking['bopay_id']) && $booking['bopay_id'] == 5 ? !empty($booking['total_paid']) ? $booking['total_paid'] : 0 : 0;
            $bopay_name_class[$booking['id']] = !empty($booking['bopay_name_class']) ? $booking['bopay_name_class'] : '';
            $bopay_paid_name[$booking['id']] = $booking['bopay_id'] == 4 || $booking['bopay_id'] == 5 ? $booking['bopay_name'] . '</br>(' . number_format($booking['total_paid']) . ')' : $booking['bopay_name'];

            $pay_id[$booking['id']][] = !empty($booking['bopay_id']) ? $booking['bopay_id'] : 0;
            $pay_name[$booking['id']][] = !empty($booking['bopay_name']) ? $booking['bopay_name'] : 0;
        }
        # --- get value booking --- #
        if (in_array($booking['bec_id'], $first_extar) == false && (!empty($booking['extra_id']) || !empty($booking['bec_name']))) {
            $first_extar[] = $booking['bec_id'];
            $ext_total = $booking['bec_type'] == 1 ? ($booking['bec_adult'] * $booking['bec_rate_adult']) + ($booking['bec_child'] * $booking['bec_rate_child']) : ($booking['bec_privates'] * $booking['bec_rate_private']);
            $extar_arr_total[] = $ext_total;
            $extar_total[$booking['id']][] = $ext_total;
            $extar_total_agent[$booking['comp_id']][] = $ext_total;
        }
    }
    # ------ calculate booking paid ------ #
    if (!empty($bopay_id)) {
        foreach ($bopay_id as $x => $val) {
            $paid_amount = !empty($array_discount[$x]) ? array_sum($array_amount[$x]) - $array_discount[$x] : array_sum($array_amount[$x]);

            $not_issued = (!empty($pay_id[$x]) && (in_array(6, $pay_id[$x]) == false) && (in_array(3, $pay_id[$x]) == false)) ? !empty($extar_total[$x]) ? $not_issued + $paid_amount + array_sum($extar_total[$x]) : $not_issued + $paid_amount : $not_issued;

            $issued_inv = (!empty($pay_id[$x]) && (in_array(6, $pay_id[$x]) == true) && (in_array(3, $pay_id[$x]) == false)) ? !empty($extar_total[$x]) ? $issued_inv + $paid_amount + array_sum($extar_total[$x]) : $issued_inv + $paid_amount : $issued_inv;

            $paid = (!empty($pay_id[$x]) && (in_array(3, $pay_id[$x]) == true)) ? !empty($extar_total[$x]) ? $paid + $paid_amount + array_sum($extar_total[$x]) : $paid + $paid_amount : $paid;
        }
    }


    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Filter');
    $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Agent');
    $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Programe');
    $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Travel Date');

    $objPHPExcel->getActiveSheet()->SetCellValue('B2', $search_agent != 'all' ? $repObj->get_value('name', 'companies', $search_agent)['name'] : 'all');
    $objPHPExcel->getActiveSheet()->SetCellValue('D2', $search_product != 'all' ? $repObj->get_value('name', 'products', $search_product)['name'] : 'all');
    $objPHPExcel->getActiveSheet()->SetCellValue('B3', $search_travel);

    $columnName = [];

    if ($_GET['type'] == 'booking') {
        $columnName[] = ['Status', 'Payment', 'Voucher No.', 'Agent', 'Travel Date', 'Programe', 'Pax', 'Hotel', 'Customer', 'Booker',];
        if (!empty($bo_id)) {
            for ($i = 0; $i < count($bo_id); $i++) {
                $columnName[] = [$status[$i], !empty($bopay_id[$bo_id[$i]]) ? $bopay_paid_name[$bo_id[$i]] : 'ไม่ได้ระบุ', !empty($voucher_no_agent[$i]) ? $voucher_no_agent[$i] : $book_full[$i], $comp_name[$i], (!empty($travel_date[$i])) ? date('j F Y', strtotime($travel_date[$i])) : '', $product_name[$prod_id[$i]], array_sum($tourist[$bo_id[$i]]), $hotel_pickup_name[$i], $cus_name[$i], $sender[$i],];
            }
        }
    } elseif ($_GET['type'] == 'agent') {
        $columnName[] = ['Agent', 'Booking', 'AD', 'CHD', 'INF', 'FOC', 'TOTAL', 'Amount', 'Income', 'Overdue',];
        if (!empty($agent_id)) {
            $amount_comp = 0;
            $revenue_comp = 0;
            for ($i = 0; $i < count($agent_id); $i++) {
                $amount_comp = !empty($comp_amount[$agent_id[$i]]) ? !empty($extar_total_agent[$agent_id[$i]]) ? array_sum($comp_amount[$agent_id[$i]]) + array_sum($extar_total_agent[$agent_id[$i]]) : array_sum($comp_amount[$agent_id[$i]]) : 0;
                $revenue_comp = !empty($comp_revenue[$agent_id[$i]]) ? (!empty($extar_total_agent[$agent_id[$i]]) && array_sum($comp_revenue[$agent_id[$i]]) > 0) ? array_sum($comp_revenue[$agent_id[$i]]) + array_sum($extar_total_agent[$agent_id[$i]]) : array_sum($comp_revenue[$agent_id[$i]]) : 0;
                $columnName[] = [$agent_name[$i], array_count_values($comp_id)[$agent_id[$i]], !empty($comp_adult[$agent_id[$i]]) ? array_sum($comp_adult[$agent_id[$i]]) : 0, !empty($comp_child[$agent_id[$i]]) ? array_sum($comp_child[$agent_id[$i]]) : 0, !empty($comp_infant[$agent_id[$i]]) ? array_sum($comp_infant[$agent_id[$i]]) : 0, !empty($comp_foc[$agent_id[$i]]) ? array_sum($comp_foc[$agent_id[$i]]) : 0, !empty($comp_sum[$agent_id[$i]]) ? array_sum($comp_sum[$agent_id[$i]]) : 0, !empty($amount_comp) ? number_format($amount_comp) : 0, !empty($revenue_comp) ? number_format($revenue_comp) : 0, number_format($amount_comp - $revenue_comp),];
            }
        }
    } elseif ($_GET['type'] == 'programe') {
        $columnName[] = ['Programe Name', 'AD', 'CHD', 'INF', 'FOC', 'TOTAL',];
        if (!empty($prod_id)) {
            $age = array_count_values($prod_id);
            arsort($age);
            foreach ($age as $x => $x_value) {
                $columnName[] = [$product_name[$x], !empty($product_adult[$x]) ? array_sum($product_adult[$x]) : 0, !empty($product_child[$x]) ? array_sum($product_child[$x]) : 0, !empty($product_infant[$x]) ? array_sum($product_infant[$x]) : 0, !empty($product_foc[$x]) ? array_sum($product_foc[$x]) : 0, !empty($product_adult[$x]) && !empty($product_child[$x]) && !empty($product_infant[$x]) && !empty($product_foc[$x]) ? array_sum($product_adult[$x]) + array_sum($product_child[$x]) + array_sum($product_infant[$x]) + array_sum($product_foc[$x]) : 0,];
            }
        }
    } elseif ($_GET['type'] == 'transfer') {
        $columnName[] = ['Car & Driver', 'Travel Date', 'Booking', 'AD', 'CHD', 'INF', 'FOC', 'TOTAL',];
        if (!empty($ortran_id)) {
            foreach ($ortran_id as $x => $val) {
                $columnName[] = [!empty($car_name[$ortran_id[$x]]) ? !empty($driver_name[$ortran_id[$x]]) ? $car_name[$ortran_id[$x]] . ' / ' . $driver_name[$ortran_id[$x]] : $car_registration[$ortran_id[$x]] : '', (!empty($ortran_travel[$ortran_id[$x]])) ? date('j F Y', strtotime($ortran_travel[$ortran_id[$x]])) : '', !empty($bot_id[$val]) ? count($bot_id[$val]) : 0, !empty($car_adult[$x]) ? array_sum($car_adult[$x]) : 0, !empty($car_child[$x]) ? array_sum($car_child[$x]) : 0, !empty($car_infant[$x]) ? array_sum($car_infant[$x]) : 0, !empty($car_foc[$x]) ? array_sum($car_foc[$x]) : 0, array_sum($car_adult[$x]) + array_sum($car_child[$x]) + array_sum($car_infant[$x]) + array_sum($car_foc[$x]),];
            }
        }
    } elseif ($_GET['type'] == 'boat') {
        $columnName[] = ['Boat & Captain', 'Programe', 'Travel Date', 'Booking', 'AD', 'CHD', 'INF', 'FOC', 'TOTAL',];
        if (!empty($boat_order_id)) {
            foreach ($boat_order_id as $x => $val) {
                $columnName[] = [$boat_name[$val[0]], $product_name[$boat_product[$x]], (!empty($orboat_travel[$x])) ? date('j F Y', strtotime($orboat_travel[$x])) : '', count($boboat_id[$x]), !empty($boat_adult[$x]) ? array_sum($boat_adult[$x]) : 0, !empty($boat_child[$x]) ? array_sum($boat_child[$x]) : 0, !empty($boat_infant[$x]) ? array_sum($boat_infant[$x]) : 0, !empty($boat_foc[$x]) ? array_sum($boat_foc[$x]) : 0, array_sum($boat_adult[$x]) + array_sum($boat_child[$x]) + array_sum($boat_infant[$x]),];
            }
        }
    }

    $objPHPExcel->getActiveSheet()->getStyle('A4:R4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A4:R4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A4:R4')->getFont()->setSize(16);

    $objPHPExcel->getActiveSheet()->fromArray($columnName, null, 'A4');

    // ชื่อไฟล์
    $file_export = "Excel-" . date("dmY-Hs");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file_export . '.xlsx"');
    ob_end_clean();
    $objWriter->save('php://output');
    exit();
}

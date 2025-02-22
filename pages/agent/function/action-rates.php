<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Agent.php';

$agObj = new Agent();

if (isset($_POST['action']) && $_POST['action'] == "action") {
    // get value from ajax
    $company_id = $_POST['company_id'] != "" ? $_POST['company_id'] : 0;
    $period_id = $_POST['period_id'] != "" ? $_POST['period_id'] : 0;
    $rate_id = $_POST['rate_id'] != "" ? $_POST['rate_id'] : 0;
    $arr_rate_adult = $_POST['rate_adult'] != "" ? $_POST['rate_adult'] : '';
    $arr_rate_child = $_POST['rate_child'] != "" ? $_POST['rate_child'] : '';
    $arr_rate_infant = $_POST['rate_infant'] != "" ? $_POST['rate_infant'] : '';
    $arr_rate_private = $_POST['rate_private'] != "" ? $_POST['rate_private'] : '';

    if ($period_id) {
        for ($i = 0; $i < count($period_id); $i++) {
            $prod_rate = $agObj->check_product_rate($period_id[$i], $company_id); // check insert data by product rate
            // set value number rate
            $rate_adult = !empty($arr_rate_adult[$period_id[$i]]) ? preg_replace('(,)', '', $arr_rate_adult[$period_id[$i]]) : 0;
            $rate_child = !empty($arr_rate_child[$period_id[$i]]) ? preg_replace('(,)', '', $arr_rate_child[$period_id[$i]]) : 0;
            $rate_infant = !empty($arr_rate_infant[$period_id[$i]]) ? preg_replace('(,)', '', $arr_rate_infant[$period_id[$i]]) : 0;
            $rate_private = !empty($arr_rate_private[$period_id[$i]]) ? preg_replace('(,)', '', $arr_rate_private[$period_id[$i]]) : 0;
            if ($rate_id[$period_id[$i]] > 0) {
                $response = $agObj->update_data_rate($rate_adult, $rate_child, $rate_infant, $rate_private, $rate_id[$period_id[$i]]);
            } elseif (($prod_rate > 0 && $prod_rate != false) && ($rate_adult + $rate_child + $rate_infant + $rate_private) > 0) {
                $rate = $agObj->insert_data_rate($rate_adult, $rate_child, $rate_infant, $rate_private, $period_id[$i]);
                $response = $rate != false && $rate > 0 ? $agObj->insert_data_company($period_id[$i], $rate, $company_id) : false;
            }
        }
    }

    echo $response;
} else {
    echo $response = false;
}

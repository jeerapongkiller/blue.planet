<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['category_id'])) {
    # --- get value --- #
    $agent_id = !empty($_POST['agent_id']) && $_POST['agent_id'] != 'outside' ? $_POST['agent_id'] : 0;
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : 0;
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : 0;
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';
    $rate_arr = array();
    $rates = $bookObj->show_category_rate($agent_id, $category_id, $travel_date);
    // if (!empty($rates)) {
    //     $rate_arr['periodid'] = !empty($rates[0]['periodid']) ? $rates[0]['periodid'] : 0;
    //     $rate_arr['prodrid'] = !empty($rates[0]['prodrid']) ? $rates[0]['prodrid'] : 0;
    //     $rate_arr['transfer'] = !empty($rates[0]['transfer']) ? $rates[0]['transfer'] : 1;
    //     $rate_arr['rate_adult'] = !empty($rates[0]['rate_adult']) ? $rates[0]['rate_adult'] : 0;
    //     $rate_arr['rate_child'] = !empty($rates[0]['rate_child']) ? $rates[0]['rate_child'] : 0;
    //     $rate_arr['rate_infant'] = !empty($rates[0]['rate_infant']) ? $rates[0]['rate_infant'] : 0;
    //     $rate_arr['rate_private'] = !empty($rates[0]['rate_private']) ? $rates[0]['rate_private'] : 0;
    // } 

    $rate_arr['periodid'] = !empty($rates[0]['periodid']) ? $rates[0]['periodid'] : 0;
    $rate_arr['prodrid'] = !empty($rates[0]['prodrid']) ? $rates[0]['prodrid'] : 0;
    $rate_arr['transfer'] = !empty($rates[0]['transfer']) ? $rates[0]['transfer'] : 1;
    $rate_arr['rate_adult'] = !empty($rates[0]['rate_adult']) ? $rates[0]['rate_adult'] : 0;
    $rate_arr['rate_child'] = !empty($rates[0]['rate_child']) ? $rates[0]['rate_child'] : 0;
    $rate_arr['rate_infant'] = !empty($rates[0]['rate_infant']) ? $rates[0]['rate_infant'] : 0;
    $rate_arr['rate_private'] = !empty($rates[0]['rate_private']) ? $rates[0]['rate_private'] : 0;


    echo !empty($rate_arr) ? json_encode($rate_arr) : false;
} else {
    echo $response = false;
}

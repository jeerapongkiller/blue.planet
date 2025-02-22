<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['travel_date'])) {
    # --- get value --- #
    $bp_id = !empty($_POST['bp_id']) ? $_POST['bp_id'] : 0;
    $book_type = !empty($_POST['book_type']) ? $_POST['book_type'] : 0;
    $agent_id = !empty($_POST['agent_id']) ? $_POST['agent_id'] : 0;
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '';
    $prods = $bookObj->search_program($agent_id, $travel_date, $bp_id, $book_type);
    $prod_arr = array();
    $frist_prod = array();
    $frist_category = array();
    foreach ($prods as $prod) {
        if (in_array($prod['id'], $frist_prod) == false) {
            $frist_prod[] = $prod['id'];
            $prod_arr['prodid'][] = !empty($prod['id']) ? $prod['id'] : 0;
            $prod_arr['prodname'][] = !empty($prod['name']) ? $prod['name'] : 0;
            $prod_arr['periodid'][] = !empty($prod['periodid']) ? $prod['periodid'] : 0;
        }
        if (in_array($prod['categoryid'], $frist_category) == false) {
            $frist_category[] = $prod['categoryid'];
            $prod_arr['categoryid'][$prod['id']][] = !empty($prod['categoryid']) ? $prod['categoryid'] : 0;
            $prod_arr['categoryname'][$prod['id']][] = !empty($prod['categoryname']) ? $prod['categoryname'] : '';
            $prod_arr['prodrid'][$prod['id']][] = !empty($prod['prodrid']) ? $prod['prodrid'] : 0;
            $prod_arr['rate_adult'][$prod['id']][] = !empty($prod['rate_adult']) ? $prod['rate_adult'] : 0;
            $prod_arr['rate_child'][$prod['id']][] = !empty($prod['rate_child']) ? $prod['rate_child'] : 0;
            $prod_arr['rate_infant'][$prod['id']][] = !empty($prod['rate_infant']) ? $prod['rate_infant'] : 0;
            $prod_arr['rate_private'][$prod['id']][] = !empty($prod['rate_private']) ? $prod['rate_private'] : 0;
        }
    }

    echo !empty($prod_arr) ? json_encode($prod_arr) : false;
} else {
    echo $response;
}
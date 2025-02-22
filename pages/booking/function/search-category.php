<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['prod_id'])) {
    # --- get value --- #
    $prod_id = !empty($_POST['prod_id']) ? $_POST['prod_id'] : 0;
    $cates = $bookObj->show_product_category($prod_id);
    $cate_arr = array();
    foreach ($cates as $cate) {
        $cate_arr['id'][] = !empty($cate['id']) ? $cate['id'] : 0;
        $cate_arr['customer'][] = !empty($cate['customer']) ? $cate['customer'] : 0;
        $cate_arr['transfer'][] = !empty($cate['transfer']) ? $cate['transfer'] : 0;
        $cate_arr['name'][] = !empty($cate['name']) ? $cate['name'] : '';
    }

    echo !empty($cate_arr) ? json_encode($cate_arr) : false;
} else {
    echo $response;
}
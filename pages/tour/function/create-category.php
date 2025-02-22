<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Product.php';

$prodObj = new Product();

if (isset($_POST['category_action']) && $_POST['category_action'] == "create" && !empty($_POST['category_name'])) {
    # --- product detail create form --- #
    $is_approved = !empty($_POST['category_is_approved']) ? $_POST['category_is_approved'] : 0;
    $transfer = !empty($_POST['in_transfer']) ? $_POST['in_transfer'] : 0;
    $customer = !empty($_POST['customer']) ? $_POST['customer'] : 0;
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : 0;
    $name = !empty($_POST['category_name']) ? $_POST['category_name'] : '';
    $detail = !empty($_POST['cate_detail']) ? $_POST['cate_detail'] : '';
    
    $product_id = $prodObj->insert_category($is_approved, $transfer, $customer, $product_id, $name, $detail);
    $response = $product_id > 0;

   
    echo $response;
} else {
    echo $response = false;
}

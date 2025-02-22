<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Product.php';

$prodObj = new Product();

if (isset($_POST['category_action']) && $_POST['category_action'] == "edit" && !empty($_POST['category_name'])) {
    # --- product detail create form --- #
    $is_approved = !empty($_POST['category_is_approved']) ? $_POST['category_is_approved'] : 0;
    $transfer = !empty($_POST['in_transfer']) ? $_POST['in_transfer'] : 0;
    $customer = !empty($_POST['customer']) ? $_POST['customer'] : 0;
    $id = !empty($_POST['category_id']) ? $_POST['category_id'] : 0;
    $name = !empty($_POST['category_name']) ? $_POST['category_name'] : '';
    $detail = !empty($_POST['cate_detail']) ? $_POST['cate_detail'] : '';
    
    $response = $prodObj->update_category($is_approved, $transfer, $customer, $id, $name, $detail);

    echo $response;
} else {
    echo $response = false;
}

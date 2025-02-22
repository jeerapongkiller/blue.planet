<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Product.php';

$prodObj = new Product();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['product_id']) && $_POST['product_id'] > 0) {
    // get value from ajax
    $product_id = $_POST['product_id'] > 0 ? $_POST['product_id'] : 0;

    if ($product_id > 0) {
        $response = $prodObj->delete_data($product_id);
    }

    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Product.php';

$prodObj = new Product();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['id']) && $_POST['id'] > 0) {
    // get value from ajax
    $id = $_POST['id'] > 0 ? $_POST['id'] : 0;

    $response = $prodObj->delete_category($id);

    echo $response;
} else {
    echo $response = false;
}

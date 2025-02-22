<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Product.php';

$prodObj = new Product();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['product_id']) && $_POST['product_id'] > 0) {
    // get value from ajax
    $id = !empty($_POST['product_id']) ? $_POST['product_id'] : 0;
    $name = !empty($_POST['name']) ? $_POST['name'] : '';
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    $pax = $_POST['pax'] != "" ? $_POST['pax'] : 0;
    $park_id = $_POST['park'] != "" ? $_POST['park'] : 0;

    $response = $prodObj->update_data($is_approved, $name, $note, $pax, $park_id, $id);

    echo $response;
} else {
    echo $response = false;
}

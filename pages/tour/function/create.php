<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Product.php');

$prodObj = new Product();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    # --- product detail create form --- #
    $response = FALSE;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $note = $_POST['note'] != "" ? $_POST['note'] : '';
    $pax = $_POST['pax'] != "" ? $_POST['pax'] : 0;
    $park_id = $_POST['park'] != "" ? $_POST['park'] : 0;

    $response = $prodObj->insert_data($is_approved, $refcode, $name, $note, $pax, $park_id);

    echo $response != FALSE && $response > 0 ? $response : FALSE;
} else {
    echo $response = FALSE;
}

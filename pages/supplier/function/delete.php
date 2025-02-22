<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Supplier.php';

$supObj = new Supplier();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['supplier_id']) && $_POST['supplier_id'] > 0) {
    // get value from ajax
    $supplier_id = $_POST['supplier_id'] > 0 ? $_POST['supplier_id'] : 0;

    if ($supplier_id > 0) {
        $response = $supObj->delete_data($supplier_id);
    }

    echo $response;
} else {
    echo $response = false;
}

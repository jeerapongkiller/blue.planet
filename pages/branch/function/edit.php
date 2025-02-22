<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Branch.php';

$branObj = new Branch();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['branch_id']) && $_POST['branch_id'] > 0) {
    // get value from ajax
    $branch_id = $_POST['branch_id'] > 0 ? $_POST['branch_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    if ($branch_id > 0) {
        $response = $branObj->update_data($is_approved, $name, $branch_id);
    }

    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Branch.php';

$branObj = new Branch();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['branch_id']) && $_POST['branch_id'] > 0) {
    // get value from ajax
    $branch_id = $_POST['branch_id'] > 0 ? $_POST['branch_id'] : 0;

    if ($branch_id > 0) {
        $response = $branObj->delete_data($branch_id);
    }

    echo $response;
} else {
    echo $response = false;
}

<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $response = false;
    $array_id = !empty($_POST['array_id']) ? $_POST['array_id'] : '';
    $id = json_decode($array_id, true);
    
    if (!empty($id)) {
        for ($i = 0; $i < count($id); $i++) {
            if ($id[$i][0] == 1) {
                // echo ' | insert : ' . $id[$i][1];
                $response = $manageObj->insert_check($id[$i][1]);
            } elseif ($id[$i][0] == 2) {
                // echo ' | delete : ' . $id[$i][1];
                $response = $manageObj->delete_check($id[$i][1]);
            }
        }
    }

    echo $response;
} else {
    echo $response = FALSE;
}
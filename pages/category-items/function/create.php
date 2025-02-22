<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CategoryItems.php';

$plaObj = new CategotyItems();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
   
    
    $response = $plaObj->insert_data($is_approved, $name);
   
    echo $response;
} else {
    echo $response = false;
}

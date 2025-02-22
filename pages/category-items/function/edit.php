<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CategoryItems.php';

$plaObj = new CategotyItems();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['category_items_id']) && $_POST['category_items_id'] > 0) {
    // get value from ajax
    $category_items_id = $_POST['category_items_id'] > 0 ? $_POST['category_items_id'] : 0;
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
 
    if ($category_items_id > 0) {
        $response = $plaObj->update_data($is_approved, $name, $category_items_id);
    }

    echo $response;
} else {
    echo $response = false;
}

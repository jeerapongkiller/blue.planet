<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CategoryItems.php';

$plaObj = new CategotyItems();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['category_items_id']) && $_POST['category_items_id'] > 0) {
    // get value from ajax
    $category_items_id = $_POST['category_items_id'] > 0 ? $_POST['category_items_id'] : 0;

    if ($category_items_id > 0) {
        $response = $plaObj->delete_data($category_items_id);
    }

    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Review.php';

$reObj = new Review();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['review_id']) && $_POST['review_id'] > 0) {
    // get value from ajax
    $is_approved = !empty($_POST['is_approved']) ? $_POST['is_approved'] : 0;
    $review_id = $_POST['review_id'] > 0 ? $_POST['review_id'] : 0;
 

    if ($review_id > 0) {
        $response = $reObj->update_data($is_approved, $review_id);
    }

    echo $response;
} else {
    echo $response = false;
}

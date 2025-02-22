<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Product.php';

$prodObj = new Product();

if (isset($_POST['period_action']) && $_POST['period_action'] == "edit" && $_POST['period_status'] == "TRUE" && isset($_POST['period_id'])) {
    # --- product detail create form --- #
    $is_approved = !empty($_POST['period_is_approved']) ? $_POST['period_is_approved'] : 0;
    $period_id = !empty($_POST['period_id']) ? $_POST['period_id'] : 0;
    $period_from_date = !empty($_POST['period_from_date']) ? $_POST['period_from_date'] : 0;
    $period_to_date = !empty($_POST['period_to_date']) ? $_POST['period_to_date'] : 0;

    $response = $prodObj->update_period($is_approved, $period_id, $period_from_date, $period_to_date);

    echo $response;
} else {
    echo $response = false;
}

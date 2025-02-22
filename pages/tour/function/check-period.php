<?php
require_once('../../../config/env.php');
require_once('../../../controllers/Product.php');

$prodObj = new Product();

if (isset($_POST['action']) && $_POST['action'] == "check" && isset($_POST['period_from_date']) && isset($_POST['period_to_date'])) {
    # --- product detail create form --- #
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : 0;
    $period_id = !empty($_POST['period_id']) ? $_POST['period_id'] : 0;
    $period_from_date = !empty($_POST['period_from_date']) ? $_POST['period_from_date'] : 0;
    $period_to_date = !empty($_POST['period_to_date']) ? $_POST['period_to_date'] : 0;

    $response = $prodObj->check_period($period_id, $category_id, $period_from_date, $period_to_date);

    echo $response > 0 ? 'FALSE' : 'TRUE' ;
} else {
    echo $response = 'FALSE';
}
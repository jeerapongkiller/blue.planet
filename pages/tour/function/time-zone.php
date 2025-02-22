<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Product.php';

$prodObj = new Product();

if (isset($_POST['action']) && $_POST['action'] == "action" && isset($_POST['product_id']) && $_POST['product_id'] > 0 && isset($_POST['zone_id'])) {
    // get value from ajax
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : 0;
    $zone_id = !empty($_POST['zone_id']) ? $_POST['zone_id'] : '';
    $time_zone_id = !empty($_POST['time_zone_id']) ? $_POST['time_zone_id'] : '';
    for ($i = 0; $i < count($zone_id); $i++) {
        if (!empty($time_zone_id[$i])) {
            $response = $prodObj->update_timezone($time_zone_id[$i], $_POST['start' . $zone_id[$i]], $_POST['end' . $zone_id[$i]]);
        } elseif (!empty($_POST['start' . $zone_id[$i]])) {
            $response = $prodObj->insert_timezone($product_id, $zone_id[$i], $_POST['start' . $zone_id[$i]], $_POST['end' . $zone_id[$i]]);
        }
    }

    echo $response;
} else {
    echo $response = false;
}

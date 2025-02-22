<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Guide.php';

$guideObj = new Guide();

if (isset($_POST['id_card'])) {
    // get value from ajax
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : '';
    $guide_id = !empty($_POST['guide_id']) != "" ? $_POST['guide_id'] : 0;

    $response = $guideObj->check_id_card($id_card, $guide_id);

    echo $response;
} else {
    echo $response = false;
}

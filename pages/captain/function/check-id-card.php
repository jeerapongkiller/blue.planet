<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Captain.php';

$capObj = new Captain();

if (isset($_POST['id_card'])) {
    // get value from ajax
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : '';
    $captain_id = !empty($_POST['captain_id']) != "" ? $_POST['captain_id'] : 0;

    $response = $capObj->check_id_card($id_card, $captain_id);

    echo $response;
} else {
    echo $response = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Crew.php';

$crewObj = new Crew();

if (isset($_POST['id_card'])) {
    // get value from ajax
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : '';
    $crew_id = !empty($_POST['crew_id']) != "" ? $_POST['crew_id'] : 0;

    $response = $crewObj->check_id_card($id_card, $crew_id);

    echo $response;
} else {
    echo $response = false;
}

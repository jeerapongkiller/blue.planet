<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Crew.php';

$crewObj = new Crew();

if (isset($_POST['action']) && $_POST['action'] == "delete" && isset($_POST['crew_id']) && $_POST['crew_id'] > 0) {
    // get value from ajax
    $crew_id = $_POST['crew_id'] > 0 ? $_POST['crew_id'] : 0;

    if ($crew_id > 0) {
        $response = $crewObj->delete_data($crew_id);
    }

    echo $response;
} else {
    echo $response = false;
}

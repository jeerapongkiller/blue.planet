<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "edit" && (!empty($_POST['manage_id']))) {
    // get value from ajax
    $response = false;
    $id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    // $captain_id = !empty($_POST['captains']) ? ($_POST['captains'] != 'outside') ? $_POST['captains'] : 0 : 0;
    $boat_id = !empty($_POST['boats']) ? ($_POST['boats'] != 'outside') ? $_POST['boats'] : 0 : 0;
    $guide_id = !empty($_POST['guides']) ? ($_POST['guides'] != 'outside') ? $_POST['guides'] : 0 : 0;
    // $crew_first_id = !empty($_POST['crew_first']) ? $_POST['crew_first'] : 0;
    // $crew_second_id = !empty($_POST['crew_second']) ? $_POST['crew_second'] : 0;
    $color_id = !empty($_POST['color']) ? $_POST['color'] : 0;
    $time = !empty($_POST['time']) ? $_POST['time'] : '00:00:00';
    // $outside_captain = !empty($_POST['outside_captain']) ? $_POST['outside_captain'] : '';
    $outside_boat = !empty($_POST['outside_boat']) ? $_POST['outside_boat'] : '';
    $outside_guide = !empty($_POST['outside_guide']) ? $_POST['outside_guide'] : '';
    // $outside_crew_first = !empty($_POST['outside_crew_first']) ? $_POST['outside_crew_first'] : '';
    // $outside_crew_second = !empty($_POST['outside_crew_second']) ? $_POST['outside_crew_second'] : '';
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $counter = !empty($_POST['counter']) ? $_POST['counter'] : '';

    # --- insert captain (outside) --- #
    if (!empty($_POST['outside_boat']) && ($_POST['boats'] == 'outside')) {
        $boat_id = $manageObj->insert_boat($_POST['outside_boat']);
    }
    // # --- insert captain (outside) --- #
    // if (!empty($_POST['outside_captain']) && ($_POST['captains'] == 'outside')) {
    //     $captain_id = $manageObj->insert_captain($_POST['outside_captain']);
    // }
    # --- insert guide (outside) --- #
    if (!empty($_POST['outside_guide']) && ($_POST['guides'] == 'outside')) {
        $guide_id = $manageObj->insert_guide($_POST['outside_guide']);
    }
    // # --- insert crew first (outside) --- #
    // if (!empty($_POST['outside_crew_first']) && ($_POST['crew_first'] == 'outside')) {
    //     $crew_first_id = $manageObj->insert_crew($_POST['outside_crew_first']);
    // }
    // # --- insert crew second (outside) --- #
    // if (!empty($_POST['outside_crew_second']) && ($_POST['crew_second'] == 'outside')) {
    //     $crew_second_id = $manageObj->insert_crew($_POST['outside_crew_second']);
    // }

    $response = $manageObj->update_manage_boat($time, $counter, $note, $boat_id, $guide_id, $color_id, $id);

    echo $response;
} else {
    echo $response = FALSE;
}

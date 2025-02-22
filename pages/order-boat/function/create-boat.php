<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "create" && (!empty($_POST['boats']))) {
    // get value from ajax
    // $response = false;
    // $captain_id = !empty($_POST['captains']) ? ($_POST['captains'] != 'outside') ? $_POST['captains'] : 0 : 0;
    $boat_id = !empty($_POST['boats']) ? ($_POST['boats'] != 'outside') ? $_POST['boats'] : 0 : 0;
    $guide_id = !empty($_POST['guides']) ? ($_POST['guides'] != 'outside') ? $_POST['guides'] : 0 : 0;
    // $crew_first_id = !empty($_POST['crew_first']) ? $_POST['crew_first'] : 0;
    // $crew_second_id = !empty($_POST['crew_second']) ? $_POST['crew_second'] : 0;
    // $programe_id = !empty($_POST['programe']) ? $_POST['programe'] : 0;
    $color_id = !empty($_POST['color']) ? $_POST['color'] : 0;
    $time = !empty($_POST['time']) ? $_POST['time'] : '00:00:00';
    // $outside_captain = !empty($_POST['outside_captain']) ? $_POST['outside_captain'] : '';
    $outside_boat = !empty($_POST['outside_boat']) ? $_POST['outside_boat'] : '';
    $outside_guide = !empty($_POST['outside_guide']) ? $_POST['outside_guide'] : '';
    // $outside_crew_first = !empty($_POST['outside_crew_first']) ? $_POST['outside_crew_first'] : '';
    // $outside_crew_second = !empty($_POST['outside_crew_second']) ? $_POST['outside_crew_second'] : '';
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';
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
    
    $manage_id = $manageObj->insert_manage_boat($travel_date, $time, $counter, $note, $boat_id, $guide_id, $color_id);

    $response['travel_date'] = $travel_date;
    $response['id'] = $manage_id;

    echo !empty($response) && ($manage_id > 0 && $manage_id != false) ? json_encode($response) : false;

    // $response['travel_date'] = '2024-01-21';
    // $response['programe_id'] = 1;
    // $response['id'] = 32;
    // echo json_encode($response);
} else {
    echo $response = FALSE;
}

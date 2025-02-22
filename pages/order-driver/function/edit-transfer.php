<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "edit" && (!empty($_POST['car']) || !empty($_POST['driver']))) {
    // get value from ajax
    $response = false;
    $id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $car = !empty($_POST['car']) ? $_POST['car'] : 0;
    $driver = !empty($_POST['driver'] && $_POST['driver'] != 'outside') ? $_POST['driver'] : 0;
    $seat = !empty($_POST['seat']) ? $_POST['seat'] : 0;
    $license = !empty($_POST['license']) ? $_POST['license'] : '';
    $telephone = !empty($_POST['telephone']) ? $_POST['telephone'] : '';
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $outside_driver = !empty($_POST['outside_driver']) ? $_POST['outside_driver'] : '';

    # --- insert car (outside) --- #
    if (!empty($_POST['outside_car']) && ($_POST['car'] == 'outside')) {
        $car = $manageObj->insert_car($_POST['outside_car']);
    }
    # --- insert driver (outside) --- #
    if (!empty($_POST['outside_driver']) && ($_POST['driver'] == 'outside')) {
        $driver = $manageObj->insert_driver($_POST['outside_driver'], $telephone, $license, $seat);
    }

    $response = $manageObj->update_manage_transfer($outside_driver, $car, $seat, $driver, $license, $telephone, $note, $id);

    echo $response;
} else {
    echo $response = FALSE;
}

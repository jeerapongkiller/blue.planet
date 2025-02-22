<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "create" && (!empty($_POST['car']) || !empty($_POST['driver']))) {
    // get value from ajax
    $car = !empty($_POST['car']) ? $_POST['car'] : 0;
    $seat = !empty($_POST['seat']) ? $_POST['seat'] : 0;
    $driver = !empty($_POST['driver'] && $_POST['driver'] != 'outside') ? $_POST['driver'] : 0;
    $license = !empty($_POST['license']) ? $_POST['license'] : '';
    $telephone = !empty($_POST['telephone']) ? $_POST['telephone'] : '';
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';
    $note = !empty($_POST['note']) ? $_POST['note'] : '';
    $pickup = !empty($_POST['retrun']) && $_POST['retrun'] == 1 ? 1 : 0;
    $dropoff = !empty($_POST['retrun']) && $_POST['retrun'] == 2 ? 1 : 0;
    $outside_driver = !empty($_POST['outside_driver']) ? $_POST['outside_driver'] : '';
    # --- insert car (outside) --- #
    if (!empty($_POST['outside_car']) && ($_POST['car'] == 'outside')) {
        $car = $manageObj->insert_car($_POST['outside_car']);
    }
    # --- insert driver (outside) --- #
    if (!empty($_POST['outside_driver']) && ($_POST['driver'] == 'outside')) {
        $driver = $manageObj->insert_driver($_POST['outside_driver'], $telephone, $license, $seat);
    }

    $manage_id = $manageObj->insert_manage_transfer($outside_driver, $car, $seat, $driver, $license, $telephone, $travel_date, $note, $pickup, $dropoff);

    $response['travel_date'] = $travel_date;
    $response['retrun'] = ($pickup > 0) ? 1 : 2;
    $response['id'] = $manage_id;

    echo !empty($response) && ($manage_id > 0 && $manage_id != false) ? json_encode($response) : false;
} else {
    echo $response = FALSE;
}

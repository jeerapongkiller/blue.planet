<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Order.php');

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "create" && (!empty($_POST['manage_id'])) && (!empty($_POST['return']))) {
    $response = true;
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $return = !empty($_POST['return']) ? $_POST['return'] : 0;
    $transfer = !empty($_POST['transfer']) ? $_POST['transfer'] : '';
    $dropoff = !empty($_POST['dropoff']) ? $_POST['dropoff'] : '';
    $dropoff_2 = !empty($_POST['dropoff_2']) ? $_POST['dropoff_2'] : '';
    $manage_bt = !empty($_POST['manage_bt']) ? $_POST['manage_bt'] : '';
    $before = !empty($_POST['before']) ? $_POST['before'] : '';
    $before2 = !empty($_POST['before2']) ? $_POST['before2'] : '';
    $data = json_decode($transfer, true);
    $bt_data = json_decode($manage_bt, true);
    $before_data = json_decode($before, true);

    # --- delete booking manage --- #
    if ($manage_id != false && $manage_id > 0) {
        if (!empty($before_data)) {
            for ($i = 0; $i < count($before_data); $i++) {
                if ((in_array($before_data[$i], $bt_data) == false)) {
                    $response = $manageObj->delete_manage_booking($before_data[$i], $manage_id);
                }
            }
        }
    }
    # --- update booking transfer manage --- #
    $arrange = 1;
    if ($manage_id != false && $manage_id > 0 && !empty($bt_data)) {
        for ($i = 0; $i < count($bt_data); $i++) {
            $response = $manageObj->update_manage_booking($manage_id, $arrange, 0, $bt_data[$i]);
            $arrange++;
        }
    }
    # --- insert booking transfer manage --- #
    if ($manage_id != false && $manage_id > 0 && !empty($data)) {
        for ($i = 0; $i < count($data); $i++) {
            $response = $manageObj->insert_manage_booking($arrange, $manage_id, $data[$i]);
            $arrange++;
        }
    }

    echo $response;
} else {
    echo $response = FALSE;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['travel_date'])) {
    // get value from ajax
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';

    # --- show list boats booking --- #
    $first_booking = array();
    $bookings = $manageObj->showlistboats('list', 0, $travel_date, 'all', 'all', 'all', 'all', 'all', '', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value booking --- #
            if (in_array($booking['id'], $first_booking) == false) {
                $first_booking[] = $booking['id'];
                $bo_id[$booking['mange_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                $adult[$booking['mange_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $child[$booking['mange_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $infant[$booking['mange_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $foc[$booking['mange_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                $total[$booking['mange_id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];

                $arr_bo[$booking['mange_id']]['id'][] = !empty($booking['id']) ? $booking['id'] : 0;
                $arr_bo[$booking['mange_id']]['check'][] = !empty($booking['check_id']) ? $booking['check_id'] : 0;
                $arr_bo[$booking['mange_id']]['travel_date'][] = !empty($booking['travel_date']) ? $booking['travel_date'] : '';
                $arr_bo[$booking['mange_id']]['text_date'][] = !empty($booking['travel_date']) ? date("d/m/Y", strtotime($booking['travel_date'])) : '';
                $arr_bo[$booking['mange_id']]['cus_name'][] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $arr_bo[$booking['mange_id']]['product_name'][] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $arr_bo[$booking['mange_id']]['voucher_no'][] = !empty($booking['voucher_no']) ? $booking['voucher_no'] : $booking['book_full'];
                $arr_bo[$booking['mange_id']]['adult'][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : '-';
                $arr_bo[$booking['mange_id']]['child'][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : '-';
                $arr_bo[$booking['mange_id']]['infant'][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : '-';
                $arr_bo[$booking['mange_id']]['foc'][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : '-';
                $arr_bo[$booking['mange_id']]['discount'][] = !empty($booking['discount']) ? $booking['discount'] : '-';
                $arr_bo[$booking['mange_id']]['cot'][] = !empty($booking['total_paid']) ? $booking['total_paid'] : '-';
                $arr_bo[$booking['mange_id']]['time_pickup'][] = !empty($booking['start_pickup']) ? !empty($booking['end_pickup']) ? date('H:i', strtotime($booking['start_pickup'])) . '-' .  date('H:i', strtotime($booking['end_pickup'])) : date('H:i', strtotime($booking['start_pickup'])) : '00:00';
                $arr_bo[$booking['mange_id']]['car'][] = !empty($booking['car_name']) ? $booking['car_name'] : '-';
                $arr_bo[$booking['mange_id']]['agent_name'][] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                $arr_bo[$booking['mange_id']]['room_no'][] = !empty($booking['room_no']) ? $booking['room_no'] : '';
                $arr_bo[$booking['mange_id']]['note'][] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
                if ($booking['pickup_type'] == 1) {
                    $text_hotel = (!empty($booking['pickup_name'])) ? '<b>Pickup : </b>' . $booking['pickup_name'] . $booking['zonep_name'] . '</br>' : '<b>Pickup : </b>' . $booking['outside'] . $booking['zonep_name'] . '</br>';
                    $text_hotel .= (!empty($booking['dropoff_name'])) ? '<b>Dropoff : </b>' . $booking['dropoff_name'] . $booking['zoned_name'] : '<b>Dropoff : </b>' . $booking['outside_dropoff']  . $booking['zoned_name'];
                    $arr_bo[$booking['mange_id']]['text_hotel'][] = $text_hotel;
                } else {
                    $arr_bo[$booking['mange_id']]['text_hotel'][] = 'เดินทางมาเอง';
                }
            }
        }
    }
    # --- show list boats manage --- #
    $first_manage = array();
    $manages = $manageObj->show_manage_boat($travel_date, 'all');
    if (!empty($manages)) {
        foreach ($manages as $manage) {
            if (in_array($manage['id'], $first_manage) == false) {
                $first_manage[] = $manage['id'];
                $mange['id'][] = !empty($manage['id']) ? $manage['id'] : 0;
                $mange['color_id'][] = !empty($manage['color_id']) ? $manage['color_id'] : 0;
                $mange['color_name'][] = !empty($manage['color_name_th']) ? $manage['color_name_th'] : '';
                $mange['color_hex'][] = !empty($manage['color_hex']) ? $manage['color_hex'] : '';
                $mange['time'][] = !empty($manage['time']) ? date('H:i', strtotime($manage['time'])) : '00:00';
                $mange['boat_id'][] = !empty($manage['boat_id']) ? $manage['boat_id'] : 0;
                $mange['boat_name'][] = !empty($manage['boat_id']) ? !empty($manage['boat_name']) ? $manage['boat_name'] : '' : $manage['outside_boat'];
                $mange['guide_id'][] = !empty($manage['guide_id']) ? $manage['guide_id'] : 0;
                $mange['guide_name'][] = !empty($manage['guide_name']) ? $manage['guide_name'] : '';
                $mange['note'][] = !empty($manage['note']) ? $manage['note'] : '';
                $mange['outside_boat'][] = !empty($manage['outside_boat']) ? $manage['outside_boat'] : '';
            }
        }
    }
?>
    <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1">
        <div class="col-4 text-left text-bold h4"></div>
        <div class="col-4 text-center text-bold h4"><?php echo !empty($travel_date) ? date('j F Y', strtotime($travel_date)) : ''; ?></div>
        <div class="col-4 text-right mb-50"></div>
    </div>

    <?php if (!empty($mange['id'])) { ?>
        <textarea id="array_booking" hidden><?php echo !empty($arr_bo) ? json_encode($arr_bo, true) : ''; ?></textarea>
        <table class="table table-striped text-uppercase table-vouchure-t2">
            <thead class="bg-light">
                <tr>
                    <th>ชื่อเรือ</th>
                    <th>ไกด์</th>
                    <th class="text-center">Booking</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Audlt</th>
                    <th class="text-center">Children</th>
                    <th class="text-center">Infant</th>
                    <th class="text-center">FOC</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($mange['id']); $i++) { ?>
                    <tr onclick="modal_detail(<?php echo $mange['id'][$i]; ?>, '<?php echo addslashes($mange['boat_name'][$i]); ?>', '<?php echo $travel_date; ?>', '<?php echo !empty($travel_date) ? date('j F Y', strtotime($travel_date)) : ''; ?>');" data-toggle="modal" data-target="#modal-detail">
                        <td><?php echo $mange['boat_name'][$i]; ?></td>
                        <td><?php echo !empty($mange['guide_name'][$i]) ? $mange['guide_name'][$i] : ''; ?></td>
                        <td class="text-center"><?php echo !empty($bo_id[$mange['id'][$i]]) ? count($bo_id[$mange['id'][$i]]) : ''; ?></td>
                        <td class="text-center"><?php echo !empty($total[$mange['id'][$i]]) ? array_sum($total[$mange['id'][$i]]) : ''; ?></td>
                        <td class="text-center"><?php echo !empty($adult[$mange['id'][$i]]) ? array_sum($adult[$mange['id'][$i]]) : ''; ?></td>
                        <td class="text-center"><?php echo !empty($child[$mange['id'][$i]]) ? array_sum($child[$mange['id'][$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($infant[$mange['id'][$i]]) ? array_sum($infant[$mange['id'][$i]]) : 0; ?></td>
                        <td class="text-center"><?php echo !empty($foc[$mange['id'][$i]]) ? array_sum($foc[$mange['id'][$i]]) : 0; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    <input type="hidden" id="name_img" name="name_img" value="<?php echo 'Check in - ' . date('j F Y', strtotime($travel_date)); ?>">
<?php
} else {
    echo false;
}

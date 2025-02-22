<?php

use Mpdf\Tag\Em;

require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();
$times = date("H:i:s");

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['type']) && !empty($_POST['date'])) {

    $first_zone = array();
    $first_driver = array();
    $first_book = array();
    $first_trans = array();
    $bookings = $manageObj->showlisttransfers('all', 1, $_POST['date'], 'all', 'all', 'all', 'all', 'all', 'all', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value booking --- #
            if (in_array($booking['zonep_id'], $first_zone) == false) {
                $first_zone[] = $booking['zonep_id'];
                $mange_zone[$booking['province_id']]['id'][] = !empty($booking['zonep_id']) ? $booking['zonep_id'] : 0;
                $mange_zone[$booking['province_id']]['name'][] = !empty($booking['zonep_name']) ? $booking['zonep_name'] : '';
            }
            # --- get value booking --- #
            if (in_array($booking['mange_id'], $first_driver) == false && !empty($booking['mange_id'])) {
                $first_driver[] = $booking['mange_id'];
                $mange_trans['id'][] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
                $mange_trans['car_name'][] = !empty($booking['car_name']) ? $booking['car_name'] : '';
                $mange_trans['driver'][] = !empty($booking['driver_id']) ? $booking['driver_id'] : 0;
                $mange_trans['driver_name'][] = !empty($booking['driver_name']) ? $booking['driver_name'] : '';
                $mange_trans['license'][] = !empty($booking['license']) ? $booking['license'] : '';
                $mange_trans['seat'][] = !empty($booking['seat']) ? $booking['seat'] : '-';
                // $mange_trans['total'][] = $booking['bt_adult'] + $booking['bt_child'] + $booking['bt_infant'] + $booking['bt_foc'];
            }
            # --- get value booking --- #
            if (in_array($booking['id'], $first_book) == false) {
                $first_book[] = $booking['id'];
                $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
                $adult[] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
                $child[] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
                $infant[] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
                $foc[] = !empty($booking['bt_foc']) ? $booking['bt_foc'] : 0;
                // $total[$booking['zonep_id']][] = $booking['bt_adult'] + $booking['bt_child'] + $booking['bt_infant'] + $booking['bt_foc'];}
                # --- get value transfer --- #
                if (in_array($booking['id'], $first_trans) == false) {
                    $first_trans[] = $booking['id'];
                    $bt_id[$booking['mange_id']][] = !empty($booking['bt_id']) ? $booking['bt_id'] : 0;
                    $bt_adult[$booking['mange_id']][] = !empty($booking['bt_adult']) ? $booking['bt_adult'] : 0;
                    $bt_child[$booking['mange_id']][] = !empty($booking['bt_child']) ? $booking['bt_child'] : 0;
                    $bt_infant[$booking['mange_id']][] = !empty($booking['bt_infant']) ? $booking['bt_infant'] : 0;
                    $bt_foc[$booking['mange_id']][] = !empty($booking['bt_foc']) ? $booking['bt_foc'] : 0;
                    $bt_total[$booking['mange_id']][] = $booking['bt_adult'] + $booking['bt_child'] + $booking['bt_infant'] + $booking['bt_foc'];
                }
            }
        }
    }
?>
    <div class="text-center">
        <h5 class="card-title text-danger"><?php echo date('j F Y', strtotime($_POST['date'])); ?></h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-sm">
            <thead class="table-primary">
                <tr>
                    <th class="text-center" width="20%"></th>
                    <th class="text-center" width="20%">จำนวนคนทั้งหมด</th>
                    <th class="text-center" width="15%">AD</th>
                    <th class="text-center" width="15%">CHD</th>
                    <th class="text-center" width="15%">INF</th>
                    <th class="text-center" width="15%">FOC</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mange_trans['id'])) {
                    for ($i = 0; $i < count($mange_trans['id']); $i++) { ?>
                        <tr>
                            <td><a href=".?pages=order-driver/list&date_travel_booking=<?php echo $_POST['date']; ?>&search_driver=<?php echo $mange_trans['driver'][$i]; ?>">
                                    <?php echo $mange_trans['car_name'][$i]; ?>
                                    <?php echo $mange_trans['driver_name'][$i]; ?>
                                </a>
                            </td>
                            <td class="text-center"><?php echo !empty($bt_total[$mange_trans['id'][$i]]) ? array_sum($bt_total[$mange_trans['id'][$i]]) : 0; ?></td>
                            <td class="text-center"><?php echo !empty($bt_adult[$mange_trans['id'][$i]]) ? array_sum($bt_adult[$mange_trans['id'][$i]]) : 0; ?></td>
                            <td class="text-center"><?php echo !empty($bt_child[$mange_trans['id'][$i]]) ? array_sum($bt_child[$mange_trans['id'][$i]]) : 0; ?></td>
                            <td class="text-center"><?php echo !empty($bt_infant[$mange_trans['id'][$i]]) ? array_sum($bt_infant[$mange_trans['id'][$i]]) : 0; ?></td>
                            <td class="text-center"><?php echo !empty($bt_foc[$mange_trans['id'][$i]]) ? array_sum($bt_foc[$mange_trans['id'][$i]]) : 0; ?></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <div class="table-responsive" hidden>
        <table class="table table-striped table-sm">
            <thead class="table-primary">
                <tr>
                    <th class="text-center" width="34%" colspan="2">Phuket</th>
                    <th class="text-center" width="33%" colspan="2">Khaolak</th>
                    <th class="text-center" width="33%" colspan="2">Karbi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($mange_zone[66]['name']) || isset($mange_zone[65]['name']) || isset($mange_zone[64]['name'])) {
                    $count = max(
                        isset($mange_zone[66]['name']) ? count($mange_zone[66]['name']) : 0,
                        isset($mange_zone[65]['name']) ? count($mange_zone[65]['name']) : 0,
                        isset($mange_zone[64]['name']) ? count($mange_zone[64]['name']) : 0
                    );
                    for ($i = 0; $i < $count; $i++) {
                        $zone[66][$i] = (!empty($mange_zone[66]['id'][$i]) && !empty($mange_trans[$mange_zone[66]['id'][$i]]['total'])) ? array_sum($mange_trans[$mange_zone[66]['id'][$i]]['total']) : 0;
                        $zone[65][$i] = (!empty($mange_zone[65]['id'][$i]) && !empty($mange_trans[$mange_zone[65]['id'][$i]]['total'])) ? array_sum($mange_trans[$mange_zone[65]['id'][$i]]['total']) : 0;
                        $zone[64][$i] = (!empty($mange_zone[64]['id'][$i]) && !empty($mange_trans[$mange_zone[64]['id'][$i]]['total'])) ? array_sum($mange_trans[$mange_zone[64]['id'][$i]]['total']) : 0;
                ?>
                        <tr>
                            <td><?php echo !empty($mange_zone[66]['name'][$i]) ? $mange_zone[66]['name'][$i] : ''; ?></td>
                            <td><?php echo ($zone[66][$i]) ? $zone[66][$i] : ''; ?></td>
                            <td><?php echo !empty($mange_zone[65]['name'][$i]) ? $mange_zone[65]['name'][$i] : ''; ?></td>
                            <td><?php echo ($zone[65][$i]) ? $zone[65][$i] : ''; ?></td>
                            <td><?php echo !empty($mange_zone[64]['name'][$i]) ? $mange_zone[64]['name'][$i] : ''; ?></td>
                            <td><?php echo ($zone[64][$i]) ? $zone[64][$i] : ''; ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="font-weight-bolder text-danger">
                        <td><?php echo !empty($zone[66]) ? array_sum($zone[66]) > 0 ? 'รวม' : '' : ''; ?></td>
                        <td><?php echo !empty($zone[66]) ? array_sum($zone[66]) > 0 ? array_sum($zone[66]) : '' : ''; ?></td>
                        <td><?php echo !empty($zone[65]) ? array_sum($zone[65]) > 0 ? 'รวม' : '' : ''; ?></td>
                        <td><?php echo !empty($zone[65]) ? array_sum($zone[65]) > 0 ? array_sum($zone[65]) : '' : ''; ?></td>
                        <td><?php echo !empty($zone[64]) ? array_sum($zone[64]) > 0 ? 'รวม' : '' : ''; ?></td>
                        <td><?php echo !empty($zone[64]) ? array_sum($zone[64]) > 0 ? array_sum($zone[64]) : '' : ''; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo false;
}

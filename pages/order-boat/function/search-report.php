<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();
$times = date("H:i:s");

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['type']) && !empty($_POST['date'])) {

    $first_boat = array();
    $first_bpr = array();
    $first_book = array();
    $bookings = $manageObj->showlistboats('list', 0, $_POST['date'], 'all', 'all', 'all', 'all', 'all', '', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value booking --- #
            if (in_array($booking['mange_id'], $first_boat) == false && !empty($booking['boat_id'])) {
                $first_boat[] = $booking['mange_id'];
                $mange_boat['id'][] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
                $mange_boat['boat'][] = !empty($booking['boat_id']) ? $booking['boat_id'] : 0;
                $mange_boat['name'][] = !empty($booking['boat_name']) ? $booking['boat_name'] : '';
                $mange_boat['guide_id'][] = !empty($booking['guide_id']) ? $booking['guide_id'] : 0;
                $mange_boat['guide'][] = !empty($booking['guide_name']) ? $booking['guide_name'] : '';
                $mange_boat['color_hex'][] = !empty($booking['color_hex']) ? $booking['color_hex'] : '';
            }
            # --- get value booking --- #
            if (in_array($booking['id'], $first_book) == false) {
                $first_book[] = $booking['id'];
                // $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
                // $adult[] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                // $child[] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                // $infant[] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                // $foc[] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                // $total[] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];

                $mange_boat[$booking['mange_id']]['bo_id'][] = !empty($booking['id']) ? $booking['id'] : 0;
                // $mange_boat[$booking['mange_id']]['adult'][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                // $mange_boat[$booking['mange_id']]['child'][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                // $mange_boat[$booking['mange_id']]['infant'][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                // $mange_boat[$booking['mange_id']]['foc'][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                // $mange_boat[$booking['mange_id']]['total'][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];

                $mange_product[$booking['product_id']]['bo_id'][] = !empty($booking['id']) ? $booking['id'] : 0;
            }
            # --- get value booking rates --- #
            if ((in_array($booking['bpr_id'], $first_bpr) == false) && !empty($booking['bpr_id'])) {
                $first_bpr[] = $booking['bpr_id'];
                $bpr_id[$booking['id']][] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
                $category_id[$booking['id']][] = !empty($booking['category_id']) ? $booking['category_id'] : 0;
                $category_name[$booking['id']][] = !empty($booking['category_name']) ? $booking['category_name'] : 0;
                $category_cus[$booking['id']][] = !empty($booking['category_cus']) ? $booking['category_cus'] : 0;
                $adult[$booking['id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $child[$booking['id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $infant[$booking['id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $foc[$booking['id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;

                $mange_boat[$booking['mange_id']]['adult'][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $mange_boat[$booking['mange_id']]['child'][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $mange_boat[$booking['mange_id']]['infant'][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $mange_boat[$booking['mange_id']]['foc'][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                $mange_boat[$booking['mange_id']]['total'][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
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
                    <th width="20%">ไกด์</th>
                    <th width="20%">เรือ</th>
                    <th class="text-center" width="20%">จำนวนคนทั้งหมด</th>
                    <th class="text-center" width="10%">AD</th>
                    <th class="text-center" width="10%">CHD</th>
                    <th class="text-center" width="10%">INF</th>
                    <th class="text-center" width="10%">FOC</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mange_boat['id'])) {
                    for ($i = 0; $i < count($mange_boat['id']); $i++) {
                        $id = $mange_boat['id'][$i]; ?>
                        <tr>
                            <td><a href=".?pages=order-guide/list&date_travel_form=<?php echo $_POST['date']; ?>&search_guide=<?php echo $mange_boat['guide_id'][$i]; ?>"><?php echo $mange_boat['guide'][$i]; ?></a></td>
                            <td><a href=".?pages=order-boat/list&date_travel_booking=<?php echo $_POST['date']; ?>&search_boat=<?php echo $mange_boat['boat'][$i]; ?>"><?php echo $mange_boat['name'][$i]; ?></a></td>
                            <td class="text-center"><?php echo !empty($mange_boat[$id]['total']) ? array_sum($mange_boat[$id]['total']) : 0; ?></td>
                            <td class="text-center"><?php echo !empty($mange_boat[$id]['adult']) ? array_sum($mange_boat[$id]['adult']) : 0; ?></td>
                            <td class="text-center"><?php echo !empty($mange_boat[$id]['child']) ? array_sum($mange_boat[$id]['child']) : 0; ?></td>
                            <td class="text-center"><?php echo !empty($mange_boat[$id]['infant']) ? array_sum($mange_boat[$id]['infant']) : 0; ?></td>
                            <td class="text-center"><?php echo !empty($mange_boat[$id]['foc']) ? array_sum($mange_boat[$id]['foc']) : 0; ?></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <div class="card-body p-0" hidden>
        <?php if (!empty($mange_boat['id'])) {
            for ($i = 0; $i < count($mange_boat['id']); $i++) {
                $id = $mange_boat['id'][$i]; ?>
                <div class="row text-center mx-0">
                    <div class="col-3 row border-top border-right text-left py-50 pb-1">
                        <div class="col-8">
                            <h5 class="card-text text-warning mb-0 mt-75"><?php echo $mange_boat['guide'][$i]; ?></h5>
                            <h4 class="font-weight-bolder mb-0" style="color: <?php echo $mange_boat['color_hex'][$i]; ?>;">
                                <?php echo $mange_boat['name'][$i]; ?>
                            </h4>
                        </div>
                        <div class="col-4 text-right h3">
                            <small class="card-text text-muted mb-0">จำนวนคนทั้งหมด</small>
                            <?php echo !empty($mange_boat[$id]['total']) ? array_sum($mange_boat[$id]['total']) : 0; ?>
                        </div>
                    </div>
                    <!-- <div class="col-2 border-top border-right py-50 pb-1">
                        <small class="card-text text-muted mb-0">Booking</small>
                        <h4 class="font-weight-bolder mb-0"><?php echo !empty($mange_boat[$id]['bo_id']) ? count($mange_boat[$id]['bo_id']) : 0; ?></h4>
                    </div>
                    <div class="col-2 border-top border-right py-50 pb-1">
                        <small class="card-text text-muted mb-0">Total</small>
                        <h4 class="font-weight-bolder mb-0"><?php echo !empty($mange_boat[$id]['total']) ? array_sum($mange_boat[$id]['total']) : 0; ?></h4>
                    </div>
                    <div class="col-1 border-top border-right py-50 pb-1">
                        <small class="card-text text-muted mb-0">AD</small>
                        <h4 class="font-weight-bolder mb-0"><?php echo !empty($mange_boat[$id]['adult']) ? array_sum($mange_boat[$id]['adult']) : 0; ?></h4>
                    </div>
                    <div class="col-1 border-top border-right py-50 pb-1">
                        <small class="card-text text-muted mb-0">CHD</small>
                        <h4 class="font-weight-bolder mb-0"><?php echo !empty($mange_boat[$id]['child']) ? array_sum($mange_boat[$id]['child']) : 0; ?></h4>
                    </div>
                    <div class="col-1 border-top border-right py-50 pb-1">
                        <small class="card-text text-muted mb-0">INF</small>
                        <h4 class="font-weight-bolder mb-0"><?php echo !empty($mange_boat[$id]['infant']) ? array_sum($mange_boat[$id]['infant']) : 0; ?></h4>
                    </div>
                    <div class="col-1 border-top py-50 pb-1">
                        <small class="card-text text-muted mb-0">FOC</small>
                        <h4 class="font-weight-bolder mb-0"><?php echo !empty($mange_boat[$id]['foc']) ? array_sum($mange_boat[$id]['foc']) : 0; ?></h4>
                    </div> -->
                </div>
        <?php }
        } ?>
    </div>
<?php
} else {
    echo false;
}

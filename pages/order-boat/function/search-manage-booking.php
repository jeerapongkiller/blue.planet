<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search" && isset($_POST['date_travel_booking'])) {
    // get value from ajax
    $travel = !empty($_POST['date_travel_booking']) ? $_POST['date_travel_booking'] : '0000-00-00';
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $type = !empty($_POST['type']) ? $_POST['type'] : 'not';
    $search_boat = !empty($_POST['search_boat']) ? $_POST['search_boat'] : 'all';
    $search_status = $_POST['search_status'] != "" ? $_POST['search_status'] : 'all';
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 'all';
    $search_product = $_POST['search_product'] != "" ? $_POST['search_product'] : 'all';
    $search_island = $_POST['search_island'] != "" ? $_POST['search_island'] : 'all';
    $search_voucher_no = $_POST['voucher_no'] != "" ? $_POST['voucher_no'] : '';
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';

    $first_bo = array();
    $first_bpr = array();
    $first_prod = array();
    $first_manage_bo = array();
    $bookings = $manageObj->showlistboats('manage', 0, $travel, $search_boat, 'all', $search_status, $search_agent, $search_island, $search_product, $search_voucher_no, $refcode, '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value Programe --- #
            if (in_array($booking['product_id'], $first_prod) == false) {
                $first_prod[] = $booking['product_id'];
                $programe_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                $darken[] = !empty($booking['island_darken']) ? $booking['island_darken'] : 0;
                $programe_name[] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $programe_type[] = !empty($booking['pg_type_name']) ? $booking['pg_type_name'] : '';
            }
            # --- get value booking --- #
            if (in_array($booking['id'], $first_bo) == false) {
                $first_bo[] = $booking['id'];
                $bo_id[$booking['product_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                $product_name[$booking['id']] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $book_full[$booking['id']] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                $voucher_no[$booking['id']] = !empty(!empty($booking['voucher_no_agent'])) ? $booking['voucher_no_agent'] : '';
                $agent_name[$booking['id']] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                $cus_name[$booking['id']] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $nation_name[$booking['id']] = !empty($booking['nation_name']) ? $booking['nation_name'] : '';
                $note[$booking['id']] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
                $mange_id[$booking['id']] = !empty($booking['mange_id']) ? $booking['mange_id'] : 0;
                $language[$booking['id']] = !empty(!empty($booking['lang_name'])) ? $booking['lang_name'] : '';

                $travel_date[] = !empty(!empty($booking['travel_date'])) ? $booking['travel_date'] : '0000-00-00';
                // $adult[] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                // $child[] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                // $infant[] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                // $foc[] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                // $category_name[] = !empty($booking['category_name']) ? $booking['category_name'] : '';
                $booktye_name[] = !empty($booking['booktye_name']) ? $booking['booktye_name'] : '';
                $hotel_name[] = !empty($booking['pickup_id']) ? $booking['pickup_name'] : '';
                $outside[] = !empty($booking['outside']) ? $booking['outside'] : '';
            }
            # --- get value manage booking --- #
            if (($booking['mange_id'] == $manage_id && $booking['mange_id'] > 0) && in_array($booking['id'], $first_manage_bo) == false) {
                $first_manage_bo[] = $booking['id'];
                $manage_bo[] = !empty($booking['id']) ? $booking['id'] : 0;
                // $manage_adult[] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                // $manage_child[] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                // $manage_infant[] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                // $manage_foc[] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                $manage_book_full[] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                $manage_voucher_no[] = !empty(!empty($booking['voucher_no_agent'])) ? $booking['voucher_no_agent'] : '';
                $manage_agent_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                $manage_cus_name[] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $manage_product_name[] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                // $manage_category_name[] = !empty($booking['category_name']) ? $booking['category_name'] : '';
                $manage_booktye_name[] = !empty($booking['booktye_name']) ? $booking['booktye_name'] : '';
                $manage_hotel_name[] = !empty($booking['pickup_id']) ? $booking['pickup_name'] : '';
                $manage_note[] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
            }
            # --- get value rates --- #
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
            }
        }
    }
?>
    <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75">
        <div class="col-lg-12 col-xl-12 text-center text-bold h4">
            <?php echo date('j F Y', strtotime($travel)) ?>
        </div>
    </div>
    <div class="row border-top text-center mx-0">
        <div class="col-4 border-right py-1">
            <p class="card-text text-muted mb-0 text-center">จำนวนคนที่เลือก</p>
            <h3 class="font-weight-bolder mb-0"><span id="toc-true"></span></h3>
        </div>
        <div class="col-2 border-right py-1">
            <p class="card-text text-muted mb-0">Adult</p>
            <h3 class="font-weight-bolder mb-0" id="adult-sum"></h3>
        </div>
        <div class="col-2 border-right py-1">
            <p class="card-text text-muted mb-0">Children</p>
            <h3 class="font-weight-bolder mb-0" id="child-sum"></h3>
        </div>
        <div class="col-2 border-right py-1">
            <p class="card-text text-muted mb-0">Infant</p>
            <h3 class="font-weight-bolder mb-0" id="infant-sum"></h3>
        </div>
        <div class="col-2 py-1">
            <p class="card-text text-muted mb-0">FOC</p>
            <h3 class="font-weight-bolder mb-0" id="foc-sum"></h3>
        </div>
    </div>
    <?php
    if (!empty($programe_id)) {
        for ($a = 0; $a < count($programe_id); $a++) {
    ?>
            <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75">
                <div class="col-lg-12 col-xl-12 text-center text-bold h4"><?php echo $programe_name[$a]; ?></div>
            </div>
            <table class="table">
                <thead <?php echo !empty($darken[$a]) ? 'bgcolor="#' . $darken[$a] . '" style="color: #FFF"' : 'class="table-dark"'; ?>>
                    <tr>
                        <th class="cell-fit" width="2%">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input dt-checkboxes" type="checkbox" id="<?php echo 'checkbo_all' . $programe_id[$a]; ?>" name="<?php echo 'checkbo_all' . $programe_id[$a]; ?>" onclick="checkbox('booking', <?php echo $programe_id[$a]; ?>);">
                                <label class="custom-control-label" for="<?php echo 'checkbo_all' . $programe_id[$a]; ?>"></label>
                            </div>
                        </th>
                        <th width="15%">Category</th>
                        <th width="20%">Name</th>
                        <th class="cell-fit text-center" width="2%">Total</th>
                        <th class="cell-fit text-center" width="2%">A</th>
                        <th class="cell-fit text-center" width="2%">C</th>
                        <th class="cell-fit text-center" width="2%">INF</th>
                        <th class="cell-fit text-center" width="2%">FOC</th>
                        <th class="text-nowrap" width="15%">Agent</th>
                        <th class="text-nowrap" width="15%">V/C</th>
                        <th>REMARKE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($b = 0; $b < count($bo_id[$programe_id[$a]]); $b++) {
                        $id = $bo_id[$programe_id[$a]][$b];
                        if ($mange_id[$id] == 0) {
                            $class_tr = ($b % 2 == 1) ? 'table-active' : '';
                    ?>
                            <tr class="<?php echo $class_tr; ?>">
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input dt-checkboxes checkbox-<?php echo $programe_id[$a]; ?> checkbox-bookings" type="checkbox" id="checkbox<?php echo $id; ?>" name="bo_id[]" value="<?php echo $id; ?>" onclick="sum_checkbox();">
                                        <label class="custom-control-label" for="checkbox<?php echo $id; ?>"></label>
                                    </div>
                                </td>
                                <td><span class="fw-bold"><?php if (!empty($category_name[$id])) {
                                                                for ($c = 0; $c < count($category_name[$id]); $c++) {
                                                                    echo $c > 0 ? ', ' . $category_name[$id][$c] : $category_name[$id][$c];
                                                                }
                                                            } ?></span></td>
                                <td><span class="fw-bold"><?php echo !empty($language) ? $cus_name[$id] . ' (' . $language[$id] . ')' : $cus_name[$id]; ?></span></td>
                                <td class="text-center" id="toc-bookings<?php echo $id; ?>"><?php echo array_sum($adult[$id]) + array_sum($child[$id]) + array_sum($infant[$id]) + array_sum($foc[$id]); ?></td>
                                <td class="text-center" id="adult<?php echo $id; ?>"><?php echo array_sum($adult[$id]); ?></td>
                                <td class="text-center" id="child<?php echo $id; ?>"><?php echo array_sum($child[$id]); ?></td>
                                <td class="text-center" id="infant<?php echo $id; ?>"><?php echo array_sum($infant[$id]); ?></td>
                                <td class="text-center" id="foc<?php echo $id; ?>"><?php echo array_sum($foc[$id]); ?></td>
                                <td><?php echo $agent_name[$id]; ?></td>
                                <td><span class="fw-bold"><?php echo !empty($voucher_no[$id]) ? $voucher_no[$id] : $book_full[$id]; ?></span></td>
                                <td><?php echo $note[$id]; ?></td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
    <?php }
    } ?>

    <?php if (!empty($manage_bo)) { ?>
        <div class="divider divider-dark">
            <div class="divider-text">
                <h3 class="text-bold mb-0">จัดเรือ</h3>
            </div>
        </div>
        <input type="hidden" id="before_managebo" name="before_managebo" value="<?php echo json_encode($manage_bo, true); ?>">
        <table class="table" id="list-group">
            <thead class="table-dark">
                <tr>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input dt-checkboxes" type="checkbox" id="checkmanage_all" name="checkmanage_all" onclick="checkbox('manage');" checked>
                            <label class="custom-control-label" for="checkmanage_all"></label>
                        </div>
                    </th>
                    <th>Programe</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th class="cell-fit text-center">Total</th>
                    <th class="cell-fit text-center">A</th>
                    <th class="cell-fit text-center">C</th>
                    <th class="cell-fit text-center">INF</th>
                    <th class="cell-fit text-center">FOC</th>
                    <th class="text-nowrap">Agent</th>
                    <th class="text-nowrap">V/C</th>
                    <th>REMARKE</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($c = 0; $c < count($manage_bo); $c++) {
                    $class_tr = ($c % 2 == 1) ? 'table-active' : ''; ?>
                    <tr class="<?php echo $class_tr; ?>">
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input dt-checkboxes checkbox-manage" type="checkbox" id="checkbox<?php echo $manage_bo[$c]; ?>" name="manage_bo[]" value="<?php echo $manage_bo[$c]; ?>" onclick="sum_checkbox();" checked>
                                <label class="custom-control-label" for="checkbox<?php echo $manage_bo[$c]; ?>"></label>
                            </div>
                        </td>
                        <td><?php echo $product_name[$manage_bo[$c]]; ?></td>
                        <td><span class="fw-bold"><?php if (!empty($category_name[$manage_bo[$c]])) {
                                                        for ($t = 0; $t < count($category_name[$manage_bo[$c]]); $t++) {
                                                            echo $t > 0 ? ', ' . $category_name[$manage_bo[$c]][$t] : $category_name[$manage_bo[$c]][$t];
                                                        }
                                                    } ?></span></td>
                        <td><span class="fw-bold"><?php echo !empty($language) ? $manage_cus_name[$c] . ' (' . $language[$manage_bo[$c]] . ')' : $manage_cus_name[$c]; ?></span></td>
                        <td class="text-center" id="toc-manage<?php echo $manage_bo[$c]; ?>"><?php echo array_sum($adult[$manage_bo[$c]]) + array_sum($child[$manage_bo[$c]]) + array_sum($infant[$manage_bo[$c]]) + array_sum($foc[$manage_bo[$c]]); ?></td>
                        <td class="text-center" id="adult<?php echo $manage_bo[$c]; ?>"><?php echo array_sum($adult[$manage_bo[$c]]); ?></td>
                        <td class="text-center" id="child<?php echo $manage_bo[$c]; ?>"><?php echo array_sum($child[$manage_bo[$c]]); ?></td>
                        <td class="text-center" id="infant<?php echo $manage_bo[$c]; ?>"><?php echo array_sum($infant[$manage_bo[$c]]); ?></td>
                        <td class="text-center" id="foc<?php echo $manage_bo[$c]; ?>"><?php echo array_sum($foc[$manage_bo[$c]]); ?></td>
                        <td><?php echo $agent_name[$manage_bo[$c]]; ?></td>
                        <td><span class="fw-bold"><?php echo !empty($voucher_no[$manage_bo[$c]]) ? $voucher_no[$manage_bo[$c]] : $book_full[$manage_bo[$c]]; ?></span></td>
                        <td><?php echo $note[$manage_bo[$c]]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    <hr>
    <div class="d-flex justify-content-between">
        <span></span>
        <button type="submit" class="btn btn-primary" onclick="submit_booking_manage('<?php echo $type; ?>', <?php echo $manage_id; ?>);">Submit</button>
    </div>
<?php
} else {
    echo false;
}
?>
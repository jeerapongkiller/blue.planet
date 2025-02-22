<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Manage.php';

$manageObj = new Manage();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $show_return = $_POST['show_return'] != "" ? $_POST['show_return'] : 1;
    $search_return = $_POST['search_return'] != "" ? $_POST['search_return'] : 1;
    $search_date_travel = $_POST['search_date_travel'] != "" ? $_POST['search_date_travel'] : $today;
    $search_product = $_POST['search_product'] != "" ? $_POST['search_product'] : 'all';

    $first_manage = [];
    $first_bo = [];
    $first_bt = [];
    # --- get data --- #
    $manages = $manageObj->showlisttransfers('list', $search_return, $search_date_travel, $search_product, 'all');
    foreach ($manages as $manage) {
        if (in_array($manage['mange_id'], $first_manage) == false) {
            $first_manage[] = $manage['mange_id'];
            $mange['id'][] = !empty($manage['mange_id']) ? $manage['mange_id'] : 0;
            $mange['driver_name'][] = !empty($manage['driver_id']) ? $manage['driver_name'] : $manage['outside_driver'];
        }

        if (in_array($manage['id'], $first_bo) == false && !empty($manage['id'])) {
            $first_bo[] = $manage['id'];
            $book['id'][$manage['mange_id']][] = !empty($manage['id']) ? $manage['id'] : 0;
            $book['product_name'][$manage['mange_id']][] = !empty($manage['product_name']) ? $manage['product_name'] : '';
            $book['pier_name'][$manage['mange_id']][] = !empty($manage['pier_name']) ? $manage['pier_name'] : '';
            $book['cus_name'][$manage['mange_id']][] = !empty($manage['cus_name']) ? $manage['cus_name'] : '';
            $book['voucher_no'][$manage['mange_id']][] = !empty($manage['voucher_no_agent']) ? $manage['voucher_no_agent'] : '';
            $book['book_full'][$manage['mange_id']][] = !empty($manage['book_full']) ? $manage['book_full'] : '';
            $book['bp_note'][$manage['mange_id']][] = !empty($manage['bp_note']) ? $manage['bp_note'] : '';

            $book['start_pickup'][$manage['mange_id']][] = !empty($manage['start_pickup']) && $manage['start_pickup']  != '00:00:00' ? date('H:i', strtotime($manage['start_pickup'])) : '00:00';
            $book['end_pickup'][$manage['mange_id']][] = !empty($manage['end_pickup']) && $manage['end_pickup']  != '00:00:00' ? date('H:i', strtotime($manage['end_pickup'])) : '00:00';
            $book['hotel_name'][$manage['mange_id']][] = !empty($manage['hotel_name']) ? $manage['hotel_name'] : 'ไม่ได้ระบุ';
            $book['room_no'][$manage['mange_id']][] = !empty($manage['room_no']) ? $manage['room_no'] : 'ไม่ได้ระบุ';
            $book['bt_adult'][$manage['mange_id']][] = !empty($manage['bt_adult']) ? $manage['bt_adult'] : 0;
            $book['bt_child'][$manage['mange_id']][] = !empty($manage['bt_child']) ? $manage['bt_child'] : 0;
            $book['bt_infant'][$manage['mange_id']][] = !empty($manage['bt_infant']) ? $manage['bt_infant'] : 0;
            $book['bt_foc'][$manage['mange_id']][] = !empty($manage['bt_foc']) ? $manage['bt_foc'] : 0;
        }
    }
    if (!empty($mange['id'])) {
?>
        <div class="content-header">
            <div class="pl-1">
                <a href="./?pages=manage-transfer/print&action=print&show_return=<?php echo $show_return; ?>&return=<?php echo $search_return; ?>&date_travel=<?php echo $search_date_travel; ?>&product=<?php echo $search_product; ?>" target="_blank" class="btn btn-info">Print</a>
                <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="download_image();" hidden>Image</button></a>
                <a href="javascript:void(0);" class="btn btn-info disabled" hidden>Download as PDF</a>
            </div>
        </div>
        <hr class="pb-0 pt-0">
        <div id="div-driver-job-image" style="background-color: #FFF;">
            <!-- Body starts -->
            <?php
            for ($i = 0; $i < count($mange['id']); $i++) {
                if (!empty($book['product_name'][$mange['id'][$i]])) {
            ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="logo-wowandaman"><img src="app-assets/images/logo/logo-500.png" alt="wow andaman"></div>
                            <div class="bg-light-purple vouchure-hearder">
                                <h4 id="text-retrun-h4"><?php echo $show_return == 1 ? 'ใบงานจัดรถ Pick Up' : 'ใบงานจัดรถ Drop Off'; ?></h4>
                                <p><?php echo $book['product_name'][$mange['id'][$i]][0]; ?></p>
                            </div>
                            <div class="card-body text-right">
                                <div class="badge-light"><?php echo $mange['driver_name'][$i]; ?></div>
                                <div class="badge-purple"><?php echo date('j F Y', strtotime($search_date_travel)); ?></div>
                            </div>

                            <table class="table table-striped text-uppercase table-vouchure-t2">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Time</th>
                                        <th>Hotel</th>
                                        <th>Room</th>
                                        <th>Client</th>
                                        <th class="text-center">A</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">Inf</th>
                                        <th class="text-center">FOC</th>
                                        <th class="text-center">Vouchure</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($a = 0; $a < count($book['id'][$mange['id'][$i]]); $a++) { ?>
                                        <tr>
                                            <td><?php echo $book['start_pickup'][$mange['id'][$i]][$a]; ?></td>
                                            <td><?php echo $book['hotel_name'][$mange['id'][$i]][$a]; ?></td>
                                            <td><?php echo $book['room_no'][$mange['id'][$i]][$a]; ?></td>
                                            <td><?php echo $book['cus_name'][$mange['id'][$i]][$a]; ?></td>
                                            <td class="text-center"><?php echo $book['bt_adult'][$mange['id'][$i]][$a]; ?></td>
                                            <td class="text-center"><?php echo $book['bt_child'][$mange['id'][$i]][$a]; ?></td>
                                            <td class="text-center"><?php echo $book['bt_infant'][$mange['id'][$i]][$a]; ?></td>
                                            <td class="text-center"><?php echo $book['bt_foc'][$mange['id'][$i]][$a]; ?></td>
                                            <td class="text-center"><?php echo !empty($book['voucher_no'][$mange['id'][$i]][$a]) ? $book['voucher_no'][$mange['id'][$i]][$a] : $book['book_full'][$mange['id'][$i]][$a]; ?></td>
                                            <td><?php echo $book['bp_note'][$mange['id'][$i]][$a]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <div class="text-center mt-2 mb-5">
                                <div class="badge-light-purple"><b class="text-danger">TOTAL <?php echo array_sum($book['bt_adult'][$mange['id'][$i]]) + array_sum($book['bt_child'][$mange['id'][$i]]) + array_sum($book['bt_infant'][$mange['id'][$i]]) + array_sum($book['bt_foc'][$mange['id'][$i]]); ?></b> <?php echo array_sum($book['bt_adult'][$mange['id'][$i]]); ?> <?php echo array_sum($book['bt_child'][$mange['id'][$i]]); ?> <?php echo array_sum($book['bt_infant'][$mange['id'][$i]]); ?> <?php echo array_sum($book['bt_foc'][$mange['id'][$i]]); ?> </div>
                            </div>

                            <div class="card-body invoice-padding py-0 bg-danger invoice-border">
                                <input type="hidden" name="mange_id" value="<?php echo $mange['id'][$i]; ?>" data-pier="<?php echo $book['pier_name'][$mange['id'][$i]][0]; ?>">
                                <h2 class="text-center pt-2 pb-2 text-white" id="<?php echo 'text-retrun' . $mange['id'][$i]; ?>"><?php echo $show_return == 1 ? 'รับลูกค้าส่ง' . $book['pier_name'][$mange['id'][$i]][0] : 'รับ' . $book['pier_name'][$mange['id'][$i]][0] . 'ส่งลูกค้าที่โรงแรม'; ?></h2>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
            <!-- Body ends -->
            <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
        </div>
<?php }
} ?>
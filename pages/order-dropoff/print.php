<?php
require_once 'controllers/Order.php';

$today = date("Y-m-d");
$orderObj = new Order();

if (isset($_GET['action']) && $_GET['action'] == "print") {
    // get value from ajax
    $search_period_driver = !empty($_GET['search_period_driver']) ? $_GET['search_period_driver'] : 'today';
    $date_travel_driver = !empty($_GET['date_travel_driver']) ? $_GET['date_travel_driver'] : $today;
    $search_car = !empty($_GET['search_car']) ? $_GET['search_car'] : 'all';
    $search_trans_type = !empty($_GET['search_trans_type']) ? $_GET['search_trans_type'] : 'all';

    $first_btr_id = array();
    $first_order = array();
    $sum_programe = 0;
    $sum_ad = 0;
    $sum_chd = 0;
    $sum_inf = 0;
    $sum_foc = 0;
    # --- get data --- #
    $orders = $orderObj->showlisttransfers('order', 2, $search_period_driver, $date_travel_driver, 'all', $search_car, $search_trans_type, 'all');
    if (!empty($orders)) {
        foreach ($orders as $order) {
            if (in_array($order['btr_id'], $first_btr_id) == false) {
                $first_btr_id[] = $order['btr_id'];
                $order_btr_id[$order['order_id']][] = !empty($order['btr_id']) ? $order['btr_id'] : 0;
                $order_product_name[$order['order_id']][] = !empty($order['product_name']) ? $order['product_name'] : '';
                $order_agent_name[$order['order_id']][] = !empty($order['comp_name']) ? $order['comp_name'] : '';
                $order_cus_name[$order['order_id']][] = !empty($order['cus_name']) ? $order['cus_name'] : '';
                $order_adult[$order['order_id']][] = !empty($order['bt_adult']) ? $order['bt_adult'] : 0;
                $order_child[$order['order_id']][] = !empty($order['bt_child']) ? $order['bt_child'] : 0;
                $order_infant[$order['order_id']][] = !empty($order['bt_infant']) ? $order['bt_infant'] : 0;
                $order_foc[$order['order_id']][] = !empty($order['bt_foc']) ? $order['bt_foc'] : 0;
                $order_pickup[$order['order_id']][] = !empty($order['pickup_name']) ? $order['pickup_name'] : 'ไม่ได้ระบุ';
                $order_hotel_pickup[$order['order_id']][] = empty($order['hotel_pickup']) ? !empty($order['hotel_name_th']) ? $order['hotel_name_th'] : 'ไม่ได้ระบุ' : $order['hotel_pickup'];
                $order_pickup_time[$order['order_id']][] = !empty($order['start_pickup']) ? date('H:i', strtotime($order['start_pickup'])) . '-' . date('H:i', strtotime($order['end_pickup'])) : '';
                $order_voucher_no[$order['order_id']][] = !empty($order['voucher_no_agent']) ? $order['voucher_no_agent'] : '';
                $order_roomon[$order['order_id']][] = !empty($order['room_no']) ? $order['room_no'] : 'ไม่ได้ระบุ';
                $order_dropoff[$order['order_id']][] = !empty($order['dropoff_name']) ? $order['dropoff_name'] : 'ไม่ได้ระบุ';
                $order_hotel_dropoff[$order['order_id']][] = empty($order['hotel_dropoff']) ? !empty($order['dhotel_name_th']) ? $order['dhotel_name_th'] : 'ไม่ได้ระบุ' : $order['hotel_dropoff'];
                $order_payment[$order['order_id']][] = !empty($order['bopay_id']) && $order['bopay_id'] == 4 ? number_format($order['total_paid']) : '-';
                $order_bp_note[$order['order_id']][] = !empty($order['bp_note']) ? $order['bp_note'] : '';
                $order_bt_note[$order['order_id']][] = !empty($order['bt_note']) ? $order['bt_note'] : '';
                $order_transfer_type[$order['order_id']][] = !empty($order['transfer_type']) ? $order['transfer_type'] : 0;
                # --- set array body order --- #
                $order_body[$order['order_id']]['btr_id'][] = !empty($order['btr_id']) ? $order['btr_id'] : '';
                $order_body[$order['order_id']]['book_full'][] = !empty($order['book_full']) ? $order['book_full'] : '';
                $order_body[$order['order_id']]['product_name'][] = !empty($order['product_name']) ? $order['product_name'] : '';
                $order_body[$order['order_id']]['adult'][] = !empty($order['bt_adult']) ? $order['bt_adult'] : 0;
                $order_body[$order['order_id']]['child'][] = !empty($order['bt_child']) ? $order['bt_child'] : 0;
                $order_body[$order['order_id']]['infant'][] = !empty($order['bt_infant']) ? $order['bt_infant'] : 0;
                $order_body[$order['order_id']]['foc'][] = !empty($order['bt_foc']) ? $order['bt_foc'] : 0;
                $order_body[$order['order_id']]['pickup_name'][] = !empty($order['pickup_name']) ? $order['pickup_name'] : '';
                $order_body[$order['order_id']]['hotel_pickup'][] = empty($order['hotel_pickup']) ? !empty($order['hotel_name_th']) ? $order['hotel_name_th'] : 'ไม่ได้ระบุ' : $order['hotel_pickup'];
                $order_body[$order['order_id']]['room_no'][] = !empty($order['room_no']) ? $order['room_no'] : '';
                $order_body[$order['order_id']]['pickup_time'][] = !empty($order['start_pickup']) ? date('H:i', strtotime($order['start_pickup'])) . '-' . date('H:i', strtotime($order['end_pickup'])) : '';
                $order_body[$order['order_id']]['note'][] = !empty($order['bt_note']) ? $order['bt_note'] : '';
                $order_body[$order['order_id']]['transfer_type'][] = !empty($order['transfer_type']) ? $order['transfer_type'] == 2 ? !empty($order['carc_name']) ? 'Private ' . ' (' . $order['carc_name'] . ')' : 'Private' : 'Join' : '';
                # --- sum value --- #
                $name_img = 'Driver Order (All)';
                $sum_programe++;
                $sum_ad = $order['bt_adult'] + $sum_ad;
                $sum_chd = $order['bt_child'] + $sum_chd;
                $sum_inf = $order['bt_infant'] + $sum_inf;
                $sum_foc = $order['bt_foc'] + $sum_foc;
            }

            if (in_array($order['order_id'], $first_order) == false && !empty($order['order_id'])) {
                $first_order[] = $order['order_id'];
                $order_id[] = !empty($order['order_id']) ? $order['order_id'] : 0;
                $order_driver_name[] = empty($order['order_driver_id']) ? !empty($order['order_driver_name']) ? $order['order_driver_name'] : '' : $order['driver_fname'] . ' ' . $order['driver_lname'] . ' (' . $order['driver_telephone'] . ')';
                $order_car_name[] = empty($order['order_car_id']) ? !empty($order['order_car_name']) ? $order['order_car_name'] : '' : $order['car_name'] . ' ' . $order['car_registration']  . ' - ' . $order['carte_name'];
                $order_guide_name[] = empty($order['order_guide_id']) ? !empty($order['order_guide_name']) ? $order['order_guide_name'] : '' : $order['guide_name'];
                $order_percent[] = !empty($order['order_percent']) ? $order['order_percent'] : 0;
                $order_price[] = !empty($order['order_price']) ? $order['order_price'] : 0;
                $order_note[] = !empty($order['order_note']) ? $order['order_note'] : '';
                # --- set array head order --- #
                $order_array[$order['order_id']]['id'] = !empty($order['order_id']) ? $order['order_id'] : 0;
                $order_array[$order['order_id']]['car_id'] = !empty($order['order_car_id']) ? $order['order_car_id'] : 0;
                $order_array[$order['order_id']]['driver_id'] = !empty($order['order_driver_id']) ? $order['order_driver_id'] : 0;
                $order_array[$order['order_id']]['guide_id'] = !empty($order['order_guide_id']) ? $order['order_guide_id'] : 0;
                $order_array[$order['order_id']]['car_name'] = !empty($order['order_car_name']) ? $order['order_car_name'] : '';
                $order_array[$order['order_id']]['driver_name'] = !empty($order['order_driver_name']) ? $order['order_driver_name'] : '';
                $order_array[$order['order_id']]['guide_name'] = !empty($order['order_guide_name']) ? $order['order_guide_name'] : '';
                $order_array[$order['order_id']]['price'] = !empty($order['order_price']) ? $order['order_price'] : '';
                $order_array[$order['order_id']]['percent'] = !empty($order['order_percent']) ? $order['order_percent'] : '';
                $order_array[$order['order_id']]['note'] = !empty($order['order_note']) ? $order['order_note'] : '';
            }
        }
    }
?>
    <!-- Header starts -->
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-6">
                <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="150"></span>
            </div>
            <div class="col-6">
                <span class="float-right" style="color: #000;">
                    <?php echo $main_document; ?>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body pb-0">
        <div class="text-center card-text">
            <h4 class="font-weight-bolder">ใบจัดรถขารส่ง (Drop Off)</h4>
            <h5 class="font-weight-bolder">
                <?php echo date('j F Y', strtotime($date_travel_driver)); ?>
            </h5>
        </div>
    </div>
    </br>
    <!-- Header ends -->
    <!-- Body starts -->
    <?php
    if (!empty($order_id)) {
        for ($i = 0; $i < count($order_id); $i++) {
    ?>
            <div>
                <table>
                    <thead>
                        <tr>
                            <td colspan="12">
                                <b>Driver :</b> <?php echo $order_car_name[$i]; ?>
                                <?php if (!empty($order_note[$i])) { ?>
                                    <div class="col-md-12 mt-25 pl-0">
                                        <b>Note :</b> <?php echo nl2br($order_note[$i]); ?>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">Pickup</th>
                            <th class="text-center">Room</th>
                            <th class="text-center">Pick Up Time</th>
                            <th class="text-center">Voucher No.</th>
                            <th class="text-center">Programe</th>
                            <th class="text-center">Customer's Name</th>
                            <th class="text-center">AD</th>
                            <th class="text-center">CHD</th>
                            <th class="text-center">INF</th>
                            <th class="text-center">FOC</th>
                            <th class="text-center">Dropoff</th>
                            <th class="text-center">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($order_btr_id[$order_id[$i]])) {
                            for ($a = 0; $a < count($order_btr_id[$order_id[$i]]); $a++) {
                                $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                        ?>
                                <tr class="<?php echo $class_tr; ?>">
                                    <td class="text-center"><?php echo $order_pickup[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_roomon[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_pickup_time[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_voucher_no[$order_id[$i]][$a]; ?></td>
                                    <td><?php echo $order_product_name[$order_id[$i]][$a]; ?></td>
                                    <td><?php echo $order_cus_name[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_adult[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_child[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_infant[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_foc[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_dropoff[$order_id[$i]][$a]; ?></td>
                                    <td class="text-center"><?php echo $order_transfer_type[$order_id[$i]][$a] != 0 ? $order_transfer_type[$order_id[$i]][$a] == 1 ? 'Join' : 'Private' : ''; ?></td>
                                </tr>
                                <tr class="<?php echo $class_tr; ?>">
                                    <td colspan="6"><?php echo '<b>Note (Transfer) : </b>' . $order_bt_note[$order_id[$i]][$a]; ?></td>
                                    <td colspan="6"><?php echo '<b>Note (Programe) : </b>' . $order_bp_note[$order_id[$i]][$a]; ?></td>
                                </tr>
                        <?php
                            }
                        } ?>
                    </tbody>
                </table>
                </br>
            </div>
            <!-- Body ends -->
        <?php } ?>
        <div>
            <table>
                <thead>
                    <tr>
                        <!-- <th class="text-center">PROGRAME</th> -->
                        <th class="text-center">ADULT</th>
                        <th class="text-center">CHILD</th>
                        <th class="text-center">INFANT</th>
                        <th class="text-center">FOC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- <td class="text-center"><?php echo $sum_programe; ?></td> -->
                        <td class="text-center"><?php echo $sum_ad; ?></td>
                        <td class="text-center"><?php echo $sum_chd; ?></td>
                        <td class="text-center"><?php echo $sum_inf; ?></td>
                        <td class="text-center"><?php echo $sum_foc; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php
    }
    ?>
    <input type="hidden" id="file_name" name="file_name" value="<?php echo $file_name; ?>" />
<?php
}
?>
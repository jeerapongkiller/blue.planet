<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$orderObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $search_period_driver = $_POST['search_period_driver'] != "" ? $_POST['search_period_driver'] : 'today';
    $date_travel_driver = $_POST['date_travel_driver'] != "" ? $_POST['date_travel_driver'] : $today;
    $search_car = $_POST['search_car'] != "" ? $_POST['search_car'] : 'all';
    $search_trans_type = $_POST['search_trans_type'] != "" ? $_POST['search_trans_type'] : 'all';

    $first_bt_id = array();
    $first_order = array();
    $sum_programe = 0;
    $sum_ad = 0;
    $sum_chd = 0;
    $sum_inf = 0;
    $sum_foc = 0;
    $name_img = '';
    # --- get data --- #
    $orders = $orderObj->showlisttransfers('order', 2, 0, $search_period_driver, $date_travel_driver, 'all', $search_car, $search_trans_type, 'all');
    if (!empty($orders)) {
        foreach ($orders as $order) {
            if (in_array($order['bt_id'], $first_bt_id) == false) {
                $first_bt_id[] = $order['bt_id'];
                $order_bt_id[$order['order_id']][] = !empty($order['bt_id']) ? $order['bt_id'] : 0;
                $order_bot_id[$order['order_id']][] = !empty($order['bot_id']) ? $order['bot_id'] : 0;
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
                # --- sum value --- #
                $name_img = 'Driver Order (' . date('j F Y', strtotime($date_travel_driver)) . ')';
                $sum_programe++;
                $sum_ad = $order['bt_adult'] + $sum_ad;
                $sum_chd = $order['bt_child'] + $sum_chd;
                $sum_inf = $order['bt_infant'] + $sum_inf;
                $sum_foc = $order['bt_foc'] + $sum_foc;
            }

            if (in_array($order['order_id'], $first_order) == false && !empty($order['order_id'])) {
                $first_order[] = $order['order_id'];
                $order_id[] = !empty($order['order_id']) ? $order['order_id'] : 0;
                $order_driver_name[] = empty($order['driver_id']) ? !empty($order['order_driver_name']) ? $order['order_driver_name'] : '' : $order['driver_fname'] . ' ' . $order['driver_lname'] . ' (' . $order['driver_telephone'] . ')';
                $order_car_name[] = empty($order['car_id']) ? !empty($order['order_car_name']) ? $order['order_car_name'] : '' : $order['car_name'] . ' ' . $order['car_registration'];
                $order_guide_name[] = empty($order['guide_id']) ? !empty($order['order_guide_name']) ? $order['order_guide_name'] : '' : $order['guide_name'];
                $order_percent[] = !empty($order['order_percent']) ? $order['order_percent'] : 0;
                $order_price[] = !empty($order['order_price']) ? $order['order_price'] : 0;
                $order_note[] = !empty($order['order_note']) ? $order['order_note'] : '';
            }
        }
    }
?>
    <div class="content-header">
        <div class="pl-1">
            <a href="./?pages=order-dropoff/print&action=print&search_period_driver=<?php echo $search_period_driver; ?>&date_travel_driver=<?php echo $date_travel_driver; ?>&search_car=<?php echo $search_car; ?>&search_trans_type=<?php echo $search_trans_type; ?>" target="_blank" class="btn btn-info">Print</a>
            <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="download_image();">Image</button></a>
            <a href="javascript:void(0);" class="btn btn-info disabled" hidden>Download as PDF</a>
        </div>
    </div>
    <hr class="pb-0 pt-0">
    <div id="div-driver-job-image" style="background-color: #FFF;">
        <!-- Header starts -->
        <div class="card-body pb-0">
            <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0 mb-1">
                <div>
                    <span class="brand-logo"><img src="app-assets/images/logo/logo-500.png" height="150"></span>
                </div>
                <div>
                    <span style="color: #000;">
                        <?php echo $main_document; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body pb-0">
            <div class="text-center card-text">
                <h4 class="font-weight-bolder">ใบจัดรถขาส่ง (Drop Off)</h4>
                <div class="badge badge-pill badge-light-danger">
                    <h5 class="m-0 pl-1 pr-1 text-danger"><?php echo date('j F Y', strtotime($date_travel_driver)); ?></h5>
                </div>
            </div>
        </div>
        </br>
        <!-- Header ends -->
        <!-- Body starts -->
        <?php
        if (!empty($order_id)) {
            for ($i = 0; $i < count($order_id); $i++) {
        ?>
                <div class="card-body pb-50 pt-0">
                    <div class="row card-text align-items-center">
                        <div class="col-md-9 text-left">
                            <?php if (!empty($order_car_name[$i])) { ?>
                                <div class="avatar bg-light-warning bg-darken-4">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-car-front-fill" viewBox="0 0 16 16">
                                            <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679c.033.161.049.325.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.807.807 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2H6ZM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17 1.247 0 3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z" />
                                        </svg>
                                    </div>
                                </div>
                            <?php echo $order_car_name[$i];
                            } ?>

                            <?php if (!empty($order_driver_name[$i])) { ?>
                                <div class="avatar bg-light-warning bg-darken-4 ml-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        </svg>
                                    </div>
                                </div>
                            <?php echo $order_driver_name[$i];
                            } ?>

                            <?php if (!empty($order_guide_name[$i])) { ?>
                                <div class="avatar bg-light-warning bg-darken-4 ml-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                        </svg>
                                    </div>
                                </div>
                            <?php echo $order_guide_name[$i];
                            } ?>

                            <?php if (!empty($order_price[$i])) { ?>
                                <div class="avatar bg-light-warning bg-darken-4 ml-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                            <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                        </svg>
                                    </div>
                                </div>
                            <?php echo number_format($order_price[$i]);
                            } ?>

                            <?php if (!empty($order_percent[$i])) { ?>
                                <div class="avatar bg-light-warning bg-darken-4 ml-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-percent" viewBox="0 0 16 16">
                                            <path d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0zM4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                                        </svg>
                                    </div>
                                </div>
                            <?php echo $order_percent[$i];
                            } ?>
                        </div>
                        <?php if (!empty($order_note[$i])) { ?>
                            <div class="col-md-4 text-left">
                                <?php echo nl2br($order_note[$i]); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-info bg-darken-2 text-white">
                            <tr>
                                <th class="text-center">Pickup</th>
                                <th class="text-center">Room</th>
                                <th class="text-center">Pick Up Time</th>
                                <th class="text-center">Voucher No.</th>
                                <th class="text-center">Programe</th>
                                <th class="text-center">CUSTOMER'S NAME</th>
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
                            if (!empty($order_bt_id[$order_id[$i]])) {
                                for ($a = 0; $a < count($order_bt_id[$order_id[$i]]); $a++) {
                                    $class_tr = ($a % 2 == 1) ? 'table-active' : '';
                            ?>
                                    <tr class="<?php echo $class_tr; ?>">
                                        <td>
                                            <table class="mange">
                                                <tr>
                                                    <td class=" text-success pr-1">Zone: </td>
                                                    <td><?php echo $order_pickup[$order_id[$i]][$a]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class=" text-success pr-1">Hotel: </td>
                                                    <td><?php echo $order_hotel_pickup[$order_id[$i]][$a]; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center"><?php echo $order_roomon[$order_id[$i]][$a]; ?></td>
                                        <td class="text-center text-nowrap"><?php echo $order_pickup_time[$order_id[$i]][$a]; ?></td>
                                        <td class="text-center"><?php echo $order_voucher_no[$order_id[$i]][$a]; ?></td>
                                        <td><?php echo $order_product_name[$order_id[$i]][$a]; ?></td>
                                        <td><?php echo $order_cus_name[$order_id[$i]][$a]; ?></td>
                                        <td class="text-center"><?php echo $order_adult[$order_id[$i]][$a]; ?></td>
                                        <td class="text-center"><?php echo $order_child[$order_id[$i]][$a]; ?></td>
                                        <td class="text-center"><?php echo $order_infant[$order_id[$i]][$a]; ?></td>
                                        <td class="text-center"><?php echo $order_foc[$order_id[$i]][$a]; ?></td>
                                        <td>
                                            <table class="mange">
                                                <tr>
                                                    <td class=" text-success pr-1">Zone: </td>
                                                    <td><?php echo $order_dropoff[$order_id[$i]][$a]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class=" text-success pr-1">Hotel: </td>
                                                    <td><?php echo $order_hotel_dropoff[$order_id[$i]][$a]; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center"><?php echo $order_transfer_type[$order_id[$i]][$a] != 0 ? $order_transfer_type[$order_id[$i]][$a] == 1 ? 'Join' : 'Private' : ''; ?></td>
                                    </tr>
                                    <tr class="<?php echo $class_tr; ?>">
                                        <td colspan="6"><?php echo '<span class="text-danger">Note (Transfer) : </span>' . $order_bt_note[$order_id[$i]][$a]; ?></td>
                                        <td colspan="6"><?php echo '<span class="text-danger">Note (Programe) : </span>' . $order_bp_note[$order_id[$i]][$a]; ?></td>
                                    </tr>
                            <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                    </br>
                </div>
                </br>
                <!-- Body ends -->
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-danger bg-lighten-5 text-danger">
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
            <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
    </div>
<?php }
    } ?>
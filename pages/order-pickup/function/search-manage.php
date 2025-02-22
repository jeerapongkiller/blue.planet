<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$orderObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $search_period_manage = !empty($_POST['search_manage_period']) ? $_POST['search_manage_period'] : 'custom';
    $date_travel_form_manage = $_POST['search_travel_manage'] != "" ? $_POST['search_travel_manage'] : $today;
    $search_product_manage = !empty($_POST['search_product']) ? $_POST['search_product'] : 'all';
    $search_zone_manage = !empty($_POST['search_zone']) ? $_POST['search_zone'] : 'all';
    $search_transfer_type = !empty($_POST['search_transfer_type']) ? $_POST['search_transfer_type'] : 'all';

    $first_bt = array();
    # --- get data --- #
    $orders = $orderObj->showlisttransfers('manage', 1, $manage_id, $search_period_manage, $date_travel_form_manage, $search_product_manage, 'all', $search_transfer_type, $search_zone_manage);
    if (!empty($orders)) {
        foreach ($orders as $order) {
            if (in_array($order['bt_id'], $first_bt) == false) {
                $first_bt[] = $order['bt_id'];
                $bo_id[] = !empty($order['id']) ? $order['id'] : 0;
                $bt_id[] = !empty($order['bt_id']) ? $order['bt_id'] : 0;
                $order_id[] = !empty($order['order_id']) ? $order['order_id'] : 0;
                
                $book_full[] = !empty($order['book_full']) ? $order['book_full'] : '';
                $product_name[] = !empty(!empty($order['product_name'])) ? $order['product_name'] : '';
                $adult[] = !empty($order['bpr_adult']) ? $order['bpr_adult'] : '0';
                $child[] = !empty($order['bpr_child']) ? $order['bpr_child'] : '0';
                $infant[] = !empty($order['bpr_infant']) ? $order['bpr_infant'] : '0';
                $foc[] = !empty($order['bpr_foc']) ? $order['bpr_foc'] : '0';
                $pickup_name[] = !empty($order['pickup_name']) ? $order['pickup_name'] : '';
                $hotel_pickup[] = empty($order['hotel_pickup']) ? !empty($order['hotel_name_th']) ? $order['hotel_name_th'] : 'ไม่ได้ระบุ' : $order['hotel_pickup'];
                $room_no[] = !empty($order['room_no']) ? $order['room_no'] : 'ไม่ได้ระบุ';
                $start_pickup[] = !empty($order['start_pickup']) ? date('H:i', strtotime($order['start_pickup'])) : '';
                $end_pickup[] = !empty($order['end_pickup']) ? date('H:i', strtotime($order['end_pickup'])) : '';
                $bt_note[] = !empty($order['bt_note']) ? $order['bt_note'] : '';
                $transfer_type[] = !empty($order['transfer_type']) ? $order['transfer_type'] == 2 ? !empty($order['carc_name']) ? 'Private ' . ' (' . $order['carc_name'] . ')' : 'Private' : 'Join' : '';
            }
            $order_retrun[$order['bt_id']][] = !empty($order['order_retrun']) ? $order['order_retrun'] : 0;
        }
    }

    if (!empty($bt_id)) {
        for ($i = 0; $i < count($bt_id); $i++) {
            $bg_light = $transfer_type[$i] == 'Join' ? 'bg-light-info' : 'bg-light-warning';
            $text_light = $transfer_type[$i] == 'Join' ? 'text-info' : 'text-warning';

            $res_transfer = false;
            if (!empty($manage_id)) {
                $res_transfer = ($order_id[$i] == $manage_id) ? true : false;
            } else {
                if ((!empty($order_id[$i])) && (in_array(1, $order_retrun[$bt_id[$i]])) == true) {
                    $res_transfer = false;
                } else {
                    $res_transfer = true;
                }
            }

            if ($res_transfer == true) {
                echo !empty($manage_id) ? '<input type="hidden" name="before_bt_id[]" value="' . $bt_id[$i] . '" />' : '';
?>
                <li class="list-group-item draggable mt-1" data-booking="<?php echo $bt_id[$i]; ?>" data-adult="<?php echo $adult[$i]; ?>" data-child="<?php echo $child[$i]; ?>" data-infant="<?php echo $infant[$i]; ?>" data-foc="<?php echo $foc[$i]; ?>">
                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5 mb-0">
                        <div class="card-header card-img-top <?php echo $bg_light; ?> p-50">
                            <h5 class="<?php echo $text_light; ?> text-darken-4 mb-0"><?php echo $book_full[$i]; ?> </h5>
                            <h5 class="<?php echo $text_light; ?> text-darken-4 mb-0 text-right"><?php echo $transfer_type[$i]; ?></h5>
                        </div>
                        <div class="card-body pb-50">
                            <table class="w-100">
                                <tr>
                                    <td width="60%" rowspan="2">
                                        <dl class="row mt-1 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Program : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo $product_name[$i]; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Pickup : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo $pickup_name[$i]; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Hotel : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo $hotel_pickup[$i]; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Room No : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo $room_no[$i]; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Time : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo $start_pickup[$i] . '-' . $end_pickup[$i]; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Note : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo nl2br($bt_note[$i]); ?></dd>
                                        </dl>
                                    </td>
                                    <td height="30px">
                                        <div class="text-center">
                                            <div class="badge badge-light-warning mr-50 mt-1">
                                                <h6 class="m-0 text-warning"> AD : <?php echo $adult[$i]; ?></h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning"> CHD : <?php echo $child[$i]; ?></h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning"> INF : <?php echo $infant[$i]; ?></h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning"> FOC : <?php echo $foc[$i]; ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">
                                        <div class="display-3 text-success"><?php echo $adult[$i] + $child[$i] + $infant[$i] + $foc[$i]; ?> <h5 class="d-inline-block">PAX</h5>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
<?php
            }
        }
    }
}

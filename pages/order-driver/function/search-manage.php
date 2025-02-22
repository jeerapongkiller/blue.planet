<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $search_return_manage = !empty($_POST['manage_return']) ? $_POST['manage_return'] : 1;
    $search_travel_manage = $_POST['date_travel_manage'] != "" ? $_POST['date_travel_manage'] : $today;
    $search_product_manage = !empty($_POST['search_product_manage']) ? $_POST['search_product_manage'] : 'all';

    $first_trans = [];
    $first_bo = [];
    $first_pickup = [];
    $first_dropoff = [];
    # --- get data --- #
    $transfers = $manageObj->showlisttransfers('manage', $search_return_manage, $search_travel_manage, $search_product_manage, 'all');
    if (!empty($transfers)) {
        foreach ($transfers as $transfer) {
            if ((in_array($transfer['id'], $first_bo) == false) && !empty($transfer['id'])) {
                $first_bo[] = $transfer['id'];
                $bo_id[] = !empty($transfer['id']) ? $transfer['id'] : 0;
                $bpr_adult[] = !empty($transfer['bpr_adult']) ? $transfer['bpr_adult'] : 0;
                $bpr_child[] = !empty($transfer['bpr_child']) ? $transfer['bpr_child'] : 0;
                $bpr_infant[] = !empty($transfer['bpr_infant']) ? $transfer['bpr_infant'] : 0;
                $bpr_foc[] = !empty($transfer['bpr_foc']) ? $transfer['bpr_foc'] : 0;
                $outside[] = !empty($transfer['outside']) ? $transfer['outside'] : '';
                $room_no[] = !empty($transfer['room_no']) ? $transfer['room_no'] : '';
                $voucher_no[] = !empty($transfer['voucher_no_agent']) ? $transfer['voucher_no_agent'] : '';
                $booktye_name[] = !empty($transfer['booktye_name']) ? $transfer['booktye_name'] : '';
                $book_full[] = !empty($transfer['book_full']) ? $transfer['book_full'] : '';
                $product_name[] = !empty($transfer['product_name']) ? $transfer['product_name'] : '';
                $company_name[] = !empty($transfer['comp_name']) ? $transfer['comp_name'] : '';
                $cus_name[] = !empty($transfer['cus_name']) ? $transfer['cus_name'] : '';
                $bp_note[] = !empty($transfer['bp_note']) ? $transfer['bp_note'] : '';
            }

            if ((in_array($transfer['bt_id'], $first_trans) == false) && !empty($transfer['bt_id'])) {
                $first_trans[] = $transfer['bt_id'];
                $book_trans[$transfer['id']]['bt_id'][] = !empty($transfer['bt_id']) ? $transfer['bt_id'] : 0;
                $book_trans[$transfer['id']]['hotel_name'][] = !empty($transfer['hotel_name']) ? $transfer['hotel_name'] : 'ไม่ได้ระบุ';
                $book_trans[$transfer['id']]['zone_name'][] = !empty($transfer['zone_name']) ? $transfer['zone_name'] : 'ไม่ได้ระบุ';
                $book_trans[$transfer['id']]['type'][] = !empty($transfer['transfer_type']) ? $transfer['transfer_type'] : 0;
                $book_trans[$transfer['id']]['include'][] = !empty($transfer['include_type']) ? $transfer['include_type'] : 0;
                $book_trans[$transfer['id']]['return'][] = !empty($transfer['return_type']) ? $transfer['return_type'] : 0;
                $book_trans[$transfer['id']]['start_pickup'][] = !empty($transfer['start_pickup']) && $transfer['start_pickup'] != '00:00:00' ? date('H:i', strtotime($transfer['start_pickup'])) : '00:00';
                $book_trans[$transfer['id']]['end_pickup'][] = !empty($transfer['end_pickup']) && $transfer['end_pickup'] != '00:00:00' ? date('H:i', strtotime($transfer['end_pickup'])) : '00:00';
                $book_trans[$transfer['id']]['mange_id'][] = !empty($transfer['mange_id']) ? $transfer['mange_id'] : 0;
            }

            if ((in_array($transfer['bt_id'], $first_pickup) == false) && !empty($transfer['bt_id']) && $transfer['return_type'] == 1) {
                $first_pickup[] = $transfer['bt_id'];
                $tran_pickup[$transfer['id']]['bt_id'][] = !empty($transfer['bt_id']) ? $transfer['bt_id'] : 0;
                $tran_pickup[$transfer['id']]['mange_id'][] = !empty($transfer['mange_id']) ? $transfer['mange_id'] : 0;
            }

            if ((in_array($transfer['bt_id'], $first_dropoff) == false) && !empty($transfer['bt_id']) && $transfer['return_type'] == 2) {
                $first_dropoff[] = $transfer['bt_id'];
                $tran_dropoff[$transfer['id']]['bt_id'][] = !empty($transfer['bt_id']) ? $transfer['bt_id'] : 0;
                $tran_dropoff[$transfer['id']]['mange_id'][] = !empty($transfer['mange_id']) ? $transfer['mange_id'] : 0;
            }
        }
    }
    if (!empty($bo_id)) {
        for ($i = 0; $i < count($bo_id); $i++) {
            $bg_light = $book_trans[$bo_id[$i]]['type'][0] == 1 ? 'bg-light-info' : 'bg-light-warning';
            $text_light = $book_trans[$bo_id[$i]]['type'][0] == 1 ? 'text-info' : 'text-warning';

            $res_transfer = false;
            if (!empty($manage_id)) {
                if ($search_return_manage == 1 && $tran_pickup[$bo_id[$i]]['mange_id'][0] == $manage_id) {
                    $bt_id = $tran_pickup[$bo_id[$i]]['bt_id'][0];
                    $res_transfer = true;
                } elseif ($search_return_manage == 2 && $tran_dropoff[$bo_id[$i]]['mange_id'][0] == $manage_id) {
                    $bt_id = $tran_dropoff[$bo_id[$i]]['bt_id'][0];
                    $res_transfer = true;
                }
            } else {
                if ($search_return_manage == 1 && $tran_pickup[$bo_id[$i]]['mange_id'][0] == 0) {
                    $bt_id = $tran_pickup[$bo_id[$i]]['bt_id'][0];
                    $res_transfer = true;
                } elseif ($search_return_manage == 2 && $tran_dropoff[$bo_id[$i]]['mange_id'][0] == 0) {
                    $bt_id = $tran_dropoff[$bo_id[$i]]['bt_id'][0];
                    $res_transfer = true;
                }
            }

            if ($res_transfer == true) {
                $hotel_pickup = '';
                if (!empty($book_trans[$bo_id[$i]]['bt_id'])) {
                    $check_pickup = '';
                    for ($b = 0; $b < count($book_trans[$bo_id[$i]]['bt_id']); $b++) {
                        if ($book_trans[$bo_id[$i]]['return'][$b] == 1) {
                            $hotel_pickup .= $check_pickup != '' ? '</br>' : '';
                            $hotel_pickup .= $book_trans[$bo_id[$i]]['hotel_name'][$b] . ', ' . $book_trans[$bo_id[$i]]['zone_name'][$b] . ' ' . $book_trans[$bo_id[$i]]['start_pickup'][$b] . '-' . $book_trans[$bo_id[$i]]['end_pickup'][$b];
                            $check_pickup = $book_trans[$bo_id[$i]]['hotel_name'][$b];
                        } elseif ($book_trans[$bo_id[$i]]['return'][$b] == 2 && $book_trans[$bo_id[$i]]['hotel_name'][$b] != $check_pickup) {
                            $hotel_pickup .= '</br> Dropoff : ' . $book_trans[$bo_id[$i]]['hotel_name'][$b];
                        }
                    }
                }
                echo !empty($manage_id) ? '<input type="hidden" name="before_bt_id[]" value="' . $bt_id . '" />' : '';
?>
                <li class="list-group-item draggable mt-1" data-booking="<?php echo $bt_id; ?>" data-adult="<?php echo $bpr_adult[$i]; ?>" data-child="<?php echo $bpr_child[$i]; ?>" data-infant="<?php echo $bpr_infant[$i]; ?>" data-foc="<?php echo $bpr_foc[$i]; ?>">
                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5 mb-0">
                        <div class="card-header card-img-top <?php echo $bg_light; ?> p-50">
                            <h5 class="<?php echo $text_light; ?> text-darken-4 mb-0"><?php echo $product_name[$i]; ?> </h5>
                            <h5 class="<?php echo $text_light; ?> text-darken-4 mb-0 text-right"><?php echo $hotel_pickup; ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="w-100">
                                <tr>
                                    <td width="50%" rowspan="2">
                                        <dl class="row mt-1 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1"><?php echo !empty($voucher_no[$i]) ? 'Voucher No.' : 'Booking No.'; ?> : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo !empty($voucher_no[$i]) ? $voucher_no[$i] : $book_full[$i]; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Agent : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo $company_name[$i]; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Customer Name : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo $cus_name[$i]; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Transfer Type : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo $book_trans[$bo_id[$i]]['type'][0] == 1 ? 'Join' : 'Private'; ?></dd>
                                        </dl>
                                        <dl class="row mt-50 mb-0">
                                            <dt class="col-sm-4 text-nowrap p-0 pl-1">Note : </dt>
                                            <dd class="col-sm-8 mb-0"><?php echo nl2br($bp_note[$i]); ?></dd>
                                        </dl>
                                    </td>
                                    <td height="30px">
                                        <div class="text-center">
                                            <div class="badge badge-light-warning mr-50 mt-1">
                                                <h6 class="m-0 text-warning"> AD : <?php echo $bpr_adult[$i]; ?></h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning"> CHD : <?php echo $bpr_child[$i]; ?></h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning"> INF : <?php echo $bpr_infant[$i]; ?></h6>
                                            </div>
                                            <div class="badge badge-light-warning mr-50">
                                                <h6 class="m-0 text-warning"> FOC : <?php echo $bpr_foc[$i]; ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle">
                                        <div class="display-3 text-success"><?php echo $bpr_adult[$i] + $bpr_child[$i] + $bpr_infant[$i] + $bpr_foc[$i]; ?> <h5 class="d-inline-block">PAX</h5>
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

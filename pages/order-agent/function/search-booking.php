<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$bookingObj = new Order();
$today = date("Y-m-d");

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['agent_id']) && !empty($_POST['travel_date'])) {
    // get value from ajax
    $agent_id = $_POST['agent_id'] != "" ? $_POST['agent_id'] : 0;
    $travel_date = $_POST['travel_date'] != "" ? $_POST['travel_date'] : '0000-00-00';
    // $search_status = $_POST['search_status'] != "" ? $_POST['search_status'] : 'all';
    // $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 'all';
    // $search_product = $_POST['search_product'] != "" ? $_POST['search_product'] : 'all';
    // $search_voucher_no = $_POST['voucher_no'] != "" ? $_POST['voucher_no'] : '';
    // $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    // $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $first_booking = array();
    $first_ext = array();
    $first_bpr = array();
    $bookings = $bookingObj->showlistboats('agent', $agent_id, $travel_date, 'all', 'all', 'all', 'all', 'all', '', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value booking --- #
            if (in_array($booking['id'], $first_booking) == false) {
                $first_booking[] = $booking['id'];
                $bo_id[] = !empty($booking['id']) ? $booking['id'] : 0;
                $agent_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                // $adult[] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                // $child[] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                // $infant[] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                // $foc[] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                // $rate_adult[] = !empty($booking['rate_adult']) ? $booking['rate_adult'] : 0;
                // $rate_child[] = !empty($booking['rate_child']) ? $booking['rate_child'] : 0;
                $cot[] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
                $start_pickup[] = !empty($booking['start_pickup']) ? date('H:i', strtotime($booking['start_pickup'])) : '00:00:00';
                $end_pickup[] = !empty($booking['end_pickup']) ? date('H:i', strtotime($booking['end_pickup'])) : '00:00:00';
                $car_name[] = !empty($booking['car_name']) ? $booking['car_name'] : '';
                $cus_name[] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $telephone[] = !empty($booking['telephone']) ? $booking['telephone'] : '';
                $book_full[] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                $voucher_no[] = !empty($booking['voucher_no_agent']) ? $booking['voucher_no_agent'] : '';
                $pickup_type[] = !empty($booking['pickup_type']) ? $booking['pickup_type'] : 0;
                $room_no[] = !empty($booking['room_no']) ? $booking['room_no'] : '-';
                $hotel_pickup[] = !empty($booking['pickup_name']) ? $booking['pickup_name'] : $booking['outside'];
                $zone_pickup[] = !empty($booking['zonep_name']) ? ' (' . $booking['zonep_name'] . ')' : '';
                $hotel_dropoff[] = !empty($booking['dropoff_name']) ? $booking['dropoff_name'] : $booking['outside_dropoff'];
                $zone_dropoff[] = !empty($booking['zoned_name']) ? ' (' . $booking['zoned_name'] . ')' : '';
                $bp_note[] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
                $product_name[] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $total[] = $booking['booktye_id'] == 1 ? ($booking['bpr_adult'] * $booking['rate_adult']) + ($booking['bpr_child'] * $booking['rate_child']) + ($booking['rate_infant'] * $booking['rate_infant']) : $booking['rate_private'];
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
            # --- get value booking extra chang --- #
            if ((in_array($booking['bec_id'], $first_ext) == false) && !empty($booking['bec_id'])) {
                $first_ext[] = $booking['bec_id'];
                $bec_id[$booking['id']][] = !empty($booking['bec_id']) ? $booking['bec_id'] : 0;
                $bec_name[$booking['id']][] = !empty($booking['bec_name']) ? $booking['bec_name'] : $booking['extra_name'];
                $bec_type[$booking['id']][] = !empty($booking['bec_type']) ? $booking['bec_type'] : 0;
                $bec_adult[$booking['id']][] = !empty($booking['bec_adult']) ? $booking['bec_adult'] : 0;
                $bec_child[$booking['id']][] = !empty($booking['bec_child']) ? $booking['bec_child'] : 0;
                $bec_infant[$booking['id']][] = !empty($booking['bec_infant']) ? $booking['bec_infant'] : 0;
                $bec_privates[$booking['id']][] = !empty($booking['bec_privates']) ? $booking['bec_privates'] : 0;
                $bec_rate_adult[$booking['id']][] = !empty($booking['bec_rate_adult']) ? $booking['bec_rate_adult'] : 0;
                $bec_rate_child[$booking['id']][] = !empty($booking['bec_rate_child']) ? $booking['bec_rate_child'] : 0;
                $bec_rate_infant[$booking['id']][] = !empty($booking['bec_rate_infant']) ? $booking['bec_rate_infant'] : 0;
                $bec_rate_private[$booking['id']][] = !empty($booking['bec_rate_private']) ? $booking['bec_rate_private'] : 0;
                $bec_rate_total[$booking['id']][] = $booking['bec_type'] > 0 ? $booking['bec_type'] == 1 ? (($booking['bec_adult'] * $booking['bec_rate_adult']) + ($booking['bec_child'] * $booking['bec_rate_child']) + ($booking['bec_infant'] * $booking['bec_rate_infant'])) : ($booking['bec_privates'] * $booking['bec_rate_private']) : 0;
            }
        }
    }
?>
    <div class="modal-header">
        <h4 class="modal-title"><span class="text-success"><?php echo $agent_name[0]; ?></span> (<?php echo date('j F Y', strtotime($travel_date)); ?>)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body text-black" id="order-agent-image-table" style="background-color: #fff;">

        <div class="row mb-50">
            <span class="col-6 brand-logo"><img src="app-assets/images/logo/logo-500.png" height="50"></span>
            <span class="col-6 text-right" style="color: #000;">
                บริษัท บลู แพลนเน็ต ฮอลิเดย์ จํากัด </br>
                124/343 หมู่ที่ 5 ตำบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000
            </span>
        </div>

        <div class="text-center mt-1 mb-1">
            <h4 class="font-weight-bolder text-black">Re Confirm Agent</h4>
            <h4>
                <div class="badge badge-pill badge-light-warning">
                    <b class="text-danger"><?php echo $agent_name[0]; ?></b> <span class="text-danger">(<?php echo date('j F Y', strtotime($travel_date)); ?>)</span>
                </div>
            </h4>
        </div>

        <table class="table table-striped text-uppercase table-vouchure-t2  text-black">
            <thead class="bg-light">
                <tr>
                    <th width="7%">Time</th>
                    <th width="14%">Programe</th>
                    <th width="15%">Name</th>
                    <th width="5%">V/C</th>
                    <th width="20%">Hotel</th>
                    <th width="5%">Room</th>
                    <th class="text-center" width="1%">A</th>
                    <th class="text-center" width="1%">C</th>
                    <th class="text-center" width="1%">Inf</th>
                    <th class="text-center" width="1%">FOC</th>
                    <!-- <th class="text-center">รวม</th> -->
                    <th width="5%">COT</th>
                    <th width="8%">Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_tourist = 0;
                $total_adult = 0;
                $total_child = 0;
                $total_infant = 0;
                $total_foc = 0;
                if (!empty($bo_id)) {
                    for ($i = 0; $i < count($bo_id); $i++) {
                        $id = $bo_id[$i];
                        $total_tourist = $total_tourist + array_sum($adult[$id]) + array_sum($child[$id]) + array_sum($infant[$id]) + array_sum($foc[$id]);
                        $total_adult = $total_adult + array_sum($adult[$id]);
                        $total_child = $total_child + array_sum($child[$id]);
                        $total_infant = $total_infant + array_sum($infant[$id]);
                        $total_foc = $total_foc + array_sum($foc[$id]); ?>
                        <tr>
                            <td class="text-center"><?php echo $start_pickup[$i] . ' - ' . $end_pickup[$i]; ?></td>
                            <td><?php echo $product_name[$i]; ?></td>
                            <td><?php echo !empty($telephone[$i]) ? $cus_name[$i] . ' <br>(' . $telephone[$i] . ')' : $cus_name[$i]; ?></td>
                            <td><?php echo !empty($voucher_no[$i]) ? $voucher_no[$i] : $book_full[$i]; ?></td>
                            <td style="padding: 5px;">
                                <?php if ($pickup_type[$i] == 1) {
                                    echo (!empty($hotel_pickup[$i])) ? '<b>Pickup : </b>' . $hotel_pickup[$i] . $zone_pickup[$i] : '';
                                    echo (!empty($hotel_dropoff[$i])) ? '</br><b>Dropoff : </b>' . $hotel_dropoff[$i] . $zone_dropoff[$i] : '';
                                } else {
                                    echo 'เดินทางมาเอง';
                                } ?>
                            </td>
                            <td><?php echo $room_no[$i]; ?></td>
                            <td class="text-center"><?php echo array_sum($adult[$id]); ?></td>
                            <td class="text-center"><?php echo array_sum($child[$id]); ?></td>
                            <td class="text-center"><?php echo array_sum($infant[$id]); ?></td>
                            <td class="text-center"><?php echo array_sum($foc[$id]); ?></td>
                            <!-- <td class="text-center"><?php echo !empty($bec_rate_total[$bo_id[$i]]) ? number_format($total[$i] + array_sum($bec_rate_total[$bo_id[$i]])) : number_format($total[$i]); ?></td> -->
                            <td class="text-nowrap"><b class="text-danger"><?php echo !empty($cot[$i]) ? number_format($cot[$i]) : ''; ?></b></td>
                            <td><b class="text-info">
                                    <?php if (!empty($bec_id[$bo_id[$i]])) {
                                        for ($e = 0; $e < count($bec_name[$bo_id[$i]]); $e++) {
                                            echo $e == 0 ? $bec_name[$bo_id[$i]][$e] : ' : ' . $bec_name[$bo_id[$i]][$e];
                                            // if ($bec_type[$bo_id[$i]][$e] == 1) {
                                            //     echo 'A ' . $bec_adult[$bo_id[$i]][$e] . ' X ' . $bec_rate_adult[$bo_id[$i]][$e];
                                            //     echo !empty($bec_child[$bo_id[$i]][$e]) ? ' C ' . $bec_child[$bo_id[$i]][$e] . ' X ' . $bec_rate_child[$bo_id[$i]][$e] : '';
                                            // } elseif ($bec_type[$bo_id[$i]][$e] == 2) {
                                            //     echo $bec_privates[$bo_id[$i]][$e] . ' X ' . $bec_rate_total[$bo_id[$i]][$e] . ' ';
                                            // }
                                        }
                                    }
                                    echo !empty($bp_note[$i]) ? ' / ' . $bp_note[$i] : ''; ?>
                                </b>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>

        <div class="text-center mt-1 pb-2">
            <h4>
                <div class="badge badge-pill badge-light-warning">
                    <b class="text-danger">TOTAL <?php echo $total_tourist; ?></b> |
                    Adult : <?php echo $total_adult; ?>
                    Child : <?php echo $total_child; ?>
                    Infant : <?php echo $total_infant; ?>
                    FOC : <?php echo $total_foc; ?>
                </div>
            </h4>
        </div>
    </div>
    <input type="hidden" id="name_img" value="<?php echo 'Re Confirm Agent - ' . $agent_name[0] . ' (' . date('j F Y', strtotime($travel_date)) . ')'; ?>">
    <div class="modal-footer">
        <a href="./?pages=order-agent/print&action=print&search_period=today&agent_id=<?php echo $agent_id; ?>&travel_date=<?php echo $travel_date; ?>" target="_blank" class="btn btn-info">Print</a>
        <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="download_image();">Image</button></a>
    </div>
<?php
} else {
    echo false;
}

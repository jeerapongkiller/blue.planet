<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $date_travel_manage = !empty($_POST['date_travel_manage']) ? $_POST['date_travel_manage'] : $tomorrow = new DateTime('tomorrow');
    $search_product = !empty($_POST['search_product']) ? $_POST['search_product'] : 'all';
    $search_status = $_POST['search_status'] != "" ? $_POST['search_status'] : 'all';
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 'all';
    $search_product = $_POST['search_product'] != "" ? $_POST['search_product'] : 'all';
    $search_voucher_no = $_POST['voucher_no'] != "" ? $_POST['voucher_no'] : '';
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $first_bo = array();
    $first_prod = array();
    $first_cus = array();
    $bookings = $manageObj->showlistboats('list', 0, $date_travel_manage, $search_product, 'all', $search_status, $search_agent, $search_product, $search_voucher_no, $refcode, $name, '');
    # --- Check products --- #
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value Programe --- #
            if (in_array($booking['product_id'], $first_prod) == false) {
                $first_prod[] = $booking['product_id'];
                $programe_id[] = !empty($booking['product_id']) ? $booking['product_id'] : 0;
                $programe_name[] = !empty($booking['product_name']) ? $booking['product_name'] : '';
                $programe_type[] = !empty($booking['pg_type_name']) ? $booking['pg_type_name'] : '';
            }
            # --- get value booking --- #
            if (in_array($booking['id'], $first_bo) == false) {
                $first_bo[] = $booking['id'];
                $bo_id[$booking['product_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                $status_by_name[$booking['id']] = !empty($booking['status_by']) ? $booking['stabyFname'] . ' ' . $booking['stabyLname'] : '';
                $status[$booking['id']] = '<span class="badge badge-pill ' . $booking['booksta_class'] . ' text-capitalized"> ' . $booking['booksta_name'] . ' </span>';
                $category_name[$booking['id']] = !empty($booking['category_name']) ? $booking['category_name'] : '';
                $adult[$booking['id']] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $child[$booking['id']] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $infant[$booking['id']] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $foc[$booking['id']] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                $cate_transfer[$booking['id']] = !empty($booking['category_transfer']) ? $booking['category_transfer'] : 0;
                $hotel_name[$booking['id']] = !empty($booking['hotel_name']) ? $booking['hotel_name'] : '';
                $room_no[$booking['id']] = !empty($booking['room_no']) ? $booking['room_no'] : '';
                $start_pickup[$booking['id']] = !empty($booking['start_pickup']) && $booking['start_pickup'] != '00:00' ? $booking['start_pickup'] : '00:00';
                $outside[$booking['id']] = !empty($booking['outside']) ? $booking['outside'] : '';
                $sender[$booking['id']] = !empty($booking['sender']) ? $booking['sender'] : '';
                $note[$booking['id']] = !empty($booking['bp_note']) ? $booking['bp_note'] : '';
                $bp_id[$booking['id']] = !empty($booking['bp_id']) ? $booking['bp_id'] : 0;
                $cot[$booking['id']] = !empty($booking['cot']) ? $booking['cot'] : 0;
                $book_full[$booking['id']] = !empty($booking['book_full']) ? $booking['book_full'] : '';
                $voucher_no[$booking['id']] = !empty(!empty($booking['voucher_no_agent'])) ? $booking['voucher_no_agent'] : '';
                $travel_date[$booking['id']] = !empty(!empty($booking['travel_date'])) ? $booking['travel_date'] : '0000-00-00';
                $product_name[$booking['id']] = !empty(!empty($booking['product_name'])) ? $booking['product_name'] : '';
                $agent_name[$booking['id']] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
            }
            # --- get value customer --- #
            if (in_array($booking['cus_id'], $first_cus) == false) {
                $first_cus[] = $booking['cus_id'];
                $cus_id[$booking['id']][] = !empty($booking['cus_id']) ? $booking['cus_id'] : 0;
                $cus_name[$booking['id']][] = !empty($booking['cus_name']) ? $booking['cus_name'] : '';
                $passport[$booking['id']][] = !empty($booking['id_card']) ? $booking['id_card'] : '';
                $birth_date[$booking['id']][] = !empty($booking['birth_date']) && $booking['birth_date'] != '0000-00-00' ? date('j F Y', strtotime($booking['birth_date'])) : '';
                $nation_name[$booking['id']][] = !empty($booking['nation_name']) ? $booking['nation_name'] : '';
            }
        }
    }
    if (!empty($programe_id)) {
        for ($a = 0; $a < count($programe_id); $a++) {
?>
            <div class="card-body pt-0 p-50">
                <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75">
                    <div class="col-lg-12 col-xl-12 text-center text-bold h4"><?php echo $programe_name[$a] . ' (' . $programe_type[$a] . ')'; ?></div>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th class="cell-fit text-center">STATUS</th>
                            <th class="text-nowrap">TRAVEL DATE</th>
                            <th class="text-nowrap">TIME</th>
                            <th>HOTEL</th>
                            <th class="text-nowrap">ROOM</th>
                            <th class="text-nowrap">Name</th>
                            <th>A</th>
                            <th>C</th>
                            <th>INF</th>
                            <th>FOC</th>
                            <th class="text-nowrap">AGENT</th>
                            <!-- <th class="text-nowrap">SENDER</th> -->
                            <th class="text-nowrap">V/C</th>
                            <th class="text-nowrap">COT</th>
                            <th>REMARKE</th>
                        </tr>
                    </thead>
                    <?php if ($bookings) { ?>
                        <tbody>
                            <?php
                            $total_tourist = 0;
                            $total_adult = 0;
                            $total_child = 0;
                            $total_infant = 0;
                            $total_foc = 0;
                            for ($i = 0; $i < count($bo_id[$programe_id[$a]]); $i++) {
                                $total_tourist = $total_tourist + $adult[$bo_id[$programe_id[$a]][$i]] + $child[$bo_id[$programe_id[$a]][$i]] + $infant[$bo_id[$programe_id[$a]][$i]] + $foc[$bo_id[$programe_id[$a]][$i]];
                                $total_adult = $total_adult + $adult[$bo_id[$programe_id[$a]][$i]];
                                $total_child = $total_child + $child[$bo_id[$programe_id[$a]][$i]];
                                $total_infant = $total_infant + $infant[$bo_id[$programe_id[$a]][$i]];
                                $total_foc = $total_foc + $foc[$bo_id[$programe_id[$a]][$i]];
                            ?>
                                <tr>
                                    <td><?php echo $status[$bo_id[$programe_id[$a]][$i]]; ?></td>
                                    <td><span class="text-nowrap"><?php echo (!empty($bp_id[$bo_id[$programe_id[$a]][$i]])) ? date('j F Y', strtotime($travel_date[$bo_id[$programe_id[$a]][$i]])) : 'ไม่มีสินค้า'; ?></span></td>
                                    <td><?php echo !empty($start_pickup[$bo_id[$programe_id[$a]][$i]]) ? date("H:i", strtotime($start_pickup[$bo_id[$programe_id[$a]][$i]])) : '00:00'; ?></td>
                                    <td><?php echo $cate_transfer[$bo_id[$programe_id[$a]][$i]] > 0 ? (!empty($hotel_name[$bo_id[$programe_id[$a]][$i]])) ? $hotel_name[$bo_id[$programe_id[$a]][$i]] : $outside[$bo_id[$programe_id[$a]][$i]] : 'No Transfer'; ?></td>
                                    <td><?php echo (!empty($room_no[$bo_id[$programe_id[$a]][$i]])) ? $room_no[$bo_id[$programe_id[$a]][$i]] : ''; ?></td>
                                    <td><?php echo !empty($cus_name[$bo_id[$programe_id[$a]][$i]][0]) ? !empty($nation_name[$bo_id[$programe_id[$a]][$i]][0]) ? $cus_name[$bo_id[$programe_id[$a]][$i]][0] . ' (' . $nation_name[$bo_id[$programe_id[$a]][$i]][0] . ')' : $cus_name[$bo_id[$programe_id[$a]][$i]][0] : ''; ?></td>
                                    <td class="text-center"><?php echo $adult[$bo_id[$programe_id[$a]][$i]]; ?></td>
                                    <td class="text-center"><?php echo $child[$bo_id[$programe_id[$a]][$i]]; ?></td>
                                    <td class="text-center"><?php echo $infant[$bo_id[$programe_id[$a]][$i]]; ?></td>
                                    <td class="text-center"><?php echo $foc[$bo_id[$programe_id[$a]][$i]]; ?></td>
                                    <td><?php echo $agent_name[$bo_id[$programe_id[$a]][$i]]; ?></a></td>
                                    <!-- <td><?php echo $sender[$bo_id[$programe_id[$a]][$i]]; ?></a></td> -->
                                    <td><?php echo !empty($voucher_no[$bo_id[$programe_id[$a]][$i]]) ? $voucher_no[$bo_id[$programe_id[$a]][$i]] : $book_full[$bo_id[$programe_id[$a]][$i]]; ?></td>
                                    <td class="text-nowrap"><?php echo number_format($cot[$bo_id[$programe_id[$a]][$i]]); ?></td>
                                    <td><?php echo $note[$bo_id[$programe_id[$a]][$i]]; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
<?php }
    }
} else {
    echo false;
}

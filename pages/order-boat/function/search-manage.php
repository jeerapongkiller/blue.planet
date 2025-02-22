<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $search_manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $date_travel_booking = !empty($_POST['date_travel_booking']) ? $_POST['date_travel_booking'] : $today;
    $search_product = !empty($_POST['search_product']) ? $_POST['search_product'] : 'all';
    $search_status = $_POST['search_status'] != "" ? $_POST['search_status'] : 'all';
    $search_agent = $_POST['search_agent'] != "" ? $_POST['search_agent'] : 'all';
    $search_product = $_POST['search_product'] != "" ? $_POST['search_product'] : 'all';
    $search_voucher_no = $_POST['voucher_no'] != "" ? $_POST['voucher_no'] : '';
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $first_bo = array();
    # --- get data --- #
    $boats = $manageObj->showlistboats('manage', $search_manage_id, $date_travel_booking, $search_product, 'all', $search_status, $search_agent, $search_product, $search_voucher_no, $refcode, $name, '');
    # --- get value booking boat --- #
    if (!empty($boats)) {
        foreach ($boats as $boat) {
            if (in_array($boat['id'], $first_bo) == false && !empty($boat['id'])) {
                $first_bo[] = $boat['id'];
                $bo_id[] = !empty($boat['id']) ? $boat['id'] : 0;
                $bpr_adult[] = !empty($boat['bpr_adult']) ? $boat['bpr_adult'] : 0;
                $bpr_child[] = !empty($boat['bpr_child']) ? $boat['bpr_child'] : 0;
                $bpr_infant[] = !empty($boat['bpr_infant']) ? $boat['bpr_infant'] : 0;
                $bpr_foc[] = !empty($boat['bpr_foc']) ? $boat['bpr_foc'] : 0;
                $outside[] = !empty($boat['outside']) ? $boat['outside'] : '';
                $room_no[] = !empty($boat['room_no']) ? $boat['room_no'] : '';
                $voucher_no[] = !empty($boat['voucher_no_agent']) ? $boat['voucher_no_agent'] : '';
                $booktye_id[] = !empty($boat['booktye_id']) ? $boat['booktye_id'] : '';
                $booktye_name[] = !empty($boat['booktye_name']) ? $boat['booktye_name'] : '';
                $book_full[] = !empty($boat['book_full']) ? $boat['book_full'] : '';
                $product_name[] = !empty($boat['product_name']) ? $boat['product_name'] : '';
                $company_name[] = !empty($boat['comp_name']) ? $boat['comp_name'] : '';
                $cus_name[] = !empty($boat['cus_name']) ? $boat['cus_name'] : '';
                $bp_note[] = !empty($boat['bp_note']) ? $boat['bp_note'] : '';
            }
        }
    }
    if (!empty($bo_id)) {
        for ($i = 0; $i < count($bo_id); $i++) {
            $bg_light = $booktye_id[$i] == 1 ? 'bg-light-info' : 'bg-light-warning';
            $text_light = $booktye_id[$i] == 1 ? 'text-info' : 'text-warning';
            echo $search_manage_id > 0 ? '<input type="hidden" name="before_bo_id[]" value="' . $bo_id[$i] . '" />' : '';
?>
            <li class="list-group-item draggable mt-1" data-booking="<?php echo $bo_id[$i]; ?>" data-adult="<?php echo $bpr_adult[$i]; ?>" data-child="<?php echo $bpr_child[$i]; ?>" data-infant="<?php echo $bpr_infant[$i]; ?>" data-foc="<?php echo $bpr_foc[$i]; ?>">
                <div class="card shadow-none bg-transparent border-secondary border-lighten-5 mb-0">
                    <div class="card-header card-img-top <?php echo $bg_light; ?> p-50">
                        <h5 class="<?php echo $text_light; ?> text-darken-4 mb-0"><?php echo $product_name[$i]; ?> </h5>
                        <h5 class="<?php echo $text_light; ?> text-darken-4 mb-0 text-right">
                            <?php echo $company_name[$i]; ?>
                        </h5>
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
                                        <dt class="col-sm-4 text-nowrap p-0 pl-1">Customer Name : </dt>
                                        <dd class="col-sm-8 mb-0"><?php echo $cus_name[$i]; ?></dd>
                                    </dl>
                                    <dl class="row mt-50 mb-0">
                                        <dt class="col-sm-4 text-nowrap p-0 pl-1">Booking Type : </dt>
                                        <dd class="col-sm-8 mb-0"><?php echo $booktye_name[$i]; ?></dd>
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
<?php }
    }
}

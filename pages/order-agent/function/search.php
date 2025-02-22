<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$orderObj = new Order();
$today = date("Y-m-d");

function check_in($var)
{
    return ($var > 0);
}

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['travel_date'])) {
    // get value from ajax
    $travel_date = $_POST['travel_date'] != "0000-00-00" ? $_POST['travel_date'] : '0000-00-00';

    $first_booking = array();
    $first_company = array();
    $first_bpr = array();
    $bookings = $orderObj->showlistboats('agent', 0, $travel_date, 'all', 'all', 'all', 'all', 'all', '', '', '', '');
    if (!empty($bookings)) {
        foreach ($bookings as $booking) {
            # --- get value agent --- #
            if ((in_array($booking['comp_id'], $first_company) == false) && !empty($booking['comp_id'])) {
                $first_company[] = $booking['comp_id'];
                $agent_id[] = !empty($booking['comp_id']) ? $booking['comp_id'] : 0;
                $agent_name[] = !empty($booking['comp_name']) ? $booking['comp_name'] : '';
                $confirm_id[] = !empty($booking['confirm_id']) ? $booking['confirm_id'] : 0;
            }
            # --- get value booking --- #
            if ((in_array($booking['id'], $first_booking) == false) && !empty($booking['comp_id'])) {
                $first_booking[] = $booking['id'];
                $bo_id[$booking['comp_id']][] = !empty($booking['id']) ? $booking['id'] : 0;
                // $adult[$booking['comp_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                // $child[$booking['comp_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                // $infant[$booking['comp_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                // $foc[$booking['comp_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                // $total_tourist[$booking['comp_id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
                $cot[$booking['comp_id']][] = !empty($booking['total_paid']) ? $booking['total_paid'] : 0;
            }
            # --- get value rates --- #
            if ((in_array($booking['bpr_id'], $first_bpr) == false) && !empty($booking['bpr_id'])) {
                $first_bpr[] = $booking['bpr_id'];
                $bpr_id[$booking['comp_id']][] = !empty($booking['bpr_id']) ? $booking['bpr_id'] : 0;
                $category_id[$booking['comp_id']][] = !empty($booking['category_id']) ? $booking['category_id'] : 0;
                $category_name[$booking['comp_id']][] = !empty($booking['category_name']) ? $booking['category_name'] : 0;
                $category_cus[$booking['comp_id']][] = !empty($booking['category_cus']) ? $booking['category_cus'] : 0;
                $adult[$booking['comp_id']][] = !empty($booking['bpr_adult']) ? $booking['bpr_adult'] : 0;
                $child[$booking['comp_id']][] = !empty($booking['bpr_child']) ? $booking['bpr_child'] : 0;
                $infant[$booking['comp_id']][] = !empty($booking['bpr_infant']) ? $booking['bpr_infant'] : 0;
                $foc[$booking['comp_id']][] = !empty($booking['bpr_foc']) ? $booking['bpr_foc'] : 0;
                $total_tourist[$booking['comp_id']][] = $booking['bpr_adult'] + $booking['bpr_child'] + $booking['bpr_infant'] + $booking['bpr_foc'];
            }
        }
    }
?>

    <div class="d-flex justify-content-between align-items-center header-actions mx-1 row mt-75 pt-1">
        <div class="col-4 text-left text-bold h4"></div>
        <div class="col-4 text-center text-bold h4"><?php echo date('j F Y', strtotime($travel_date)); ?></div>
        <div class="col-4 text-right mb-50"></div>
    </div>

    <?php if (!empty($agent_id)) {
        if (!empty($agent_id) && !empty($confirm_id)) {
            $checkall = count($agent_id) == count(array_filter($confirm_id, "check_in")) ? 'checked' : '';
        }
    ?>
        <table class="table table-striped text-uppercase table-vouchure-t2">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" width="1%">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input dt-checkboxes" type="checkbox" id="checkall<?php echo strtotime($travel_date); ?>" onclick="checkbox(<?php echo strtotime($travel_date); ?>);" <?php echo !empty($checkall) ? $checkall : ''; ?> />
                            <label class="custom-control-label" for="checkall<?php echo strtotime($travel_date); ?>"></label>
                        </div>
                    </th>
                    <th>ชื่อเอเยนต์</th>
                    <th class="text-center">Booking</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Audlt</th>
                    <th class="text-center">Children</th>
                    <th class="text-center">Infant</th>
                    <th class="text-center">FOC</th>
                    <th class="text-center">COT</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($agent_id); $i++) { ?>
                    <tr <?php echo $confirm_id[$i] > 0 ? 'class="table-success"' : ''; ?>>
                        <td class="text-center">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input dt-checkboxes checkbox-<?php echo strtotime($travel_date); ?>" type="checkbox" id="checkbox<?php echo strtotime($travel_date) . '-' . $agent_id[$i]; ?>" data-travel="<?php echo $travel_date; ?>" data-check="<?php echo $confirm_id[$i]; ?>" data-confirm="<?php echo $confirm_id[$i]; ?>" value="<?php echo $agent_id[$i]; ?>" onclick="submit_check_in('only', this);" <?php echo $confirm_id[$i] > 0 ? 'checked' : ''; ?> />
                                <label class="custom-control-label" for="checkbox<?php echo strtotime($travel_date) . '-' . $agent_id[$i]; ?>"></label>
                            </div>
                        </td>
                        <td onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail"><?php echo $agent_name[$i]; ?></td>
                        <td class="text-center" onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail"><?php echo !empty($bo_id[$agent_id[$i]]) ? count($bo_id[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center" onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail"><?php echo !empty($total_tourist[$agent_id[$i]]) ? array_sum($total_tourist[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center" onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail"><?php echo !empty($adult[$agent_id[$i]]) ? array_sum($adult[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center" onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail"><?php echo !empty($child[$agent_id[$i]]) ? array_sum($child[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center" onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail"><?php echo !empty($infant[$agent_id[$i]]) ? array_sum($infant[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center" onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail"><?php echo !empty($foc[$agent_id[$i]]) ? array_sum($foc[$agent_id[$i]]) : 0; ?></td>
                        <td class="text-center" onclick="modal_detail(<?php echo $agent_id[$i]; ?>, '<?php echo addslashes($agent_name[$i]); ?>', '<?php echo $travel_date; ?>');" data-toggle="modal" data-target="#modal-detail"><?php echo !empty($cot[$agent_id[$i]]) ? number_format(array_sum($cot[$agent_id[$i]])) : 0; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

<?php
} else {
    echo false;
}

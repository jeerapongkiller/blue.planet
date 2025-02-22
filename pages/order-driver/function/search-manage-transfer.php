<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['date_travel'])) {
    // get value from ajax
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $date_travel = !empty($_POST['date_travel']) ? $_POST['date_travel'] : '0000-00-00';
    $manage_return = !empty($_POST['manage_return']) ? $_POST['manage_return'] : 0;

    $first_manage = [];
    # --- get data --- #
    $manages = $manageObj->show_manage_transfer($date_travel, $manage_return);
?>
    <option value="0" data-driver="0" data-car="0" data-guide="0" data-outside_driver="" data-outside_car="" data-outside_guide="">กรุญาเลือกเรือที่เปิดแล้ว...</option>
    <?php
    if (!empty($manages)) {
        foreach ($manages as $manage) {
            if (in_array($manage['id'], $first_manage) == false) {
                $first_manage[] = $manage['id'];
                $select = $manage['id'] == $manage_id ? 'selected' : '';
    ?>
                <option value="<?php echo $manage['id']; ?>" data-driver="<?php echo $manage['driver_id']; ?>" data-car="<?php echo $manage['car_id']; ?>" data-guide="<?php echo $manage['guide_id']; ?>" data-outside_driver="<?php echo $manage['outside_driver']; ?>" data-outside_car="<?php echo $manage['outside_car']; ?>" data-outside_guide="<?php echo $manage['outside_guide']; ?>" <?php echo $select; ?>>
                    <?php echo $manage['driver_name']; ?>
                </option>
<?php
            }
        }
    }
}

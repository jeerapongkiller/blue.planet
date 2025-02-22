<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Order.php';

$manageObj = new Order();

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['date_travel'])) {
    // get value from ajax
    $manage_id = !empty($_POST['manage_id']) ? $_POST['manage_id'] : 0;
    $date_travel = !empty($_POST['date_travel']) ? $_POST['date_travel'] : '0000-00-00';

    $first_manage = [];
    # --- get data --- #
    $manages = $manageObj->show_manage_boat($date_travel);
?>
    <option value="0" data-color="0" data-boat="0" data-guide="0" data-captain="0" data-crewf="0" data-crews="0" data-time="" data-outside_boat="" data-outside_guide="" data-outside_captain="">กรุญาเลือกเรือที่เปิดแล้ว...</option>
    <?php
    if (!empty($manages)) {
        foreach ($manages as $manage) {
            if (in_array($manage['id'], $first_manage) == false) {
                $first_manage[] = $manage['id'];
                $select = $manage['id'] == $manage_id ? 'selected' : '';
    ?>
                <option value="<?php echo $manage['id']; ?>" data-color="<?php echo $manage['color_id']; ?>" data-boat="<?php echo $manage['boat_id']; ?>" data-guide="<?php echo $manage['guide_id']; ?>" data-captain="<?php echo $manage['captain_id']; ?>" data-crewf="<?php echo $manage['crew_first_id']; ?>" data-crews="<?php echo $manage['crew_second_id']; ?>" data-time="<?php echo !empty($manage['time']) ? date('H:i', strtotime($manage['time'])) : '00:00'; ?>" data-outside_boat="<?php echo $manage['outside_boat']; ?>" data-outside_guide="<?php echo $manage['outside_guide']; ?>" data-outside_captain="<?php echo $manage['outside_captain']; ?>" <?php echo $select; ?>>
                    <?php echo $manage['boat_name']; ?>
                </option>
<?php
            }
        }
    }
}

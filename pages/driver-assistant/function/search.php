<?php
require_once '../../../config/env.php';
require_once '../../../controllers/DriverAssistant.php';

$drv_assObj = new Driver_Assistant();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : '';
    $first_name = $_POST['first_name'] != "" ? $_POST['first_name'] : '';
    $last_name = $_POST['last_name'] != "" ? $_POST['last_name'] : '';
    $nickname = $_POST['nickname'] != "" ? $_POST['nickname'] : '';
    $sex = $_POST['sex'] != "" ? $_POST['sex'] : '';

    $drivers_ass = $drv_assObj->search($is_approved, $id_card, $first_name, $last_name, $nickname, $sex);
?>
    <table class="driver-assistant-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Full Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Telephone</th>
                <th class="cell-fit"></th>
            </tr>
        </thead>
        <?php if ($drivers_ass) { ?>
            <tbody>
                <?php
                foreach ($drivers_ass as $driver_ass) {
                    $is_approved = $driver_ass['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $driver_ass['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $sex = $driver_ass['sex'] == 1 ? 'Male' : 'Female';
                    $fullname = $driver_ass['first_name'] . ' (' . $driver_ass['nickname'] . ') ' . $driver_ass['last_name'];
                    $href = 'href="./?pages=driver-assistant/edit&id=' . $driver_ass['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo $fullname; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $sex; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $drv_assObj->get_age($driver_ass['birth_date']); ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $driver_ass['telephone']; ?></a></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $drivers_ass = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Driver.php';

$drvObj = new Driver();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $number_plate = $_POST['number_plate'] != "" ? $_POST['number_plate'] : '';
    $seat = $_POST['seat'] != "" ? $_POST['seat'] : 'all';

    $drivers = $drvObj->search($is_approved, $name, $number_plate, $seat);
?>
    <table class="driver-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>ชื่อ</th>
                <th>เบอร์โทร</th>
                <th>ป้ายทะเบียน</th>
                <th>ที่นั่ง</th>
                <th class="cell-fit"></th>
            </tr>
        </thead>
        <?php if ($drivers) { ?>
            <tbody>
                <?php
                foreach ($drivers as $driver) {
                    $is_approved = $driver['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $driver['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                ?>
                    <tr>
                        <td>
                            <a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>">
                                <span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span>
                            </a>
                        </td>
                        <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"><?php echo $driver['name']; ?></a></td>
                        <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"><?php echo $driver['telephone']; ?></a></td>
                        <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"><?php echo $driver['number_plate']; ?></a></td>
                        <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"><?php echo $driver['seat']; ?></a></td>
                        <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $drivers = false;
}

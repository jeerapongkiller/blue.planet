<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Captain.php';

$capObj = new Captain();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $sex = $_POST['sex'] != "" ? $_POST['sex'] : '';

    $captains = $capObj->search($is_approved, $id_card, $name, $sex);
?>
    <table class="captain-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Full Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th class="cell-fit">Telephone</th>
            </tr>
        </thead>
        <?php if ($captains) { ?>
            <tbody>
                <?php
                foreach ($captains as $captain) {
                    $is_approved = $captain['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $captain['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $sex = $captain['sex'] == 1 ? 'Male' : 'Female';
                ?>
                    <tr>
                        <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><?php echo $captain['name']; ?></a></td>
                        <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><?php echo $sex; ?></a></td>
                        <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><?php echo $capObj->get_age($captain['birth_date']); ?></a></td>
                        <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><?php echo $captain['telephone']; ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $drivers_ass = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Crew.php';

$crewObj = new Crew();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $id_card = $_POST['id_card'] != "" ? $_POST['id_card'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $sex = $_POST['sex'] != "" ? $_POST['sex'] : '';

    $crews = $crewObj->search($is_approved, $id_card, $name, $sex);
?>
    <table class="crew-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Full Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th class="cell-fit">Telephone</th>
            </tr>
        </thead>
        <?php if ($crews) { ?>
            <tbody>
                <?php
                foreach ($crews as $crew) {
                    $is_approved = $crew['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $crew['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $sex = $crew['sex'] == 1 ? 'Male' : 'Female';
                ?>
                    <tr>
                        <td><a href="./?pages=crew/edit&id=<?php echo $crew['id']; ?>" style="color:#6E6B7B"><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a href="./?pages=crew/edit&id=<?php echo $crew['id']; ?>" style="color:#6E6B7B"><?php echo $crew['name']; ?></a></td>
                        <td><a href="./?pages=crew/edit&id=<?php echo $crew['id']; ?>" style="color:#6E6B7B"><?php echo $sex; ?></a></td>
                        <td><a href="./?pages=crew/edit&id=<?php echo $crew['id']; ?>" style="color:#6E6B7B"><?php echo $crewObj->get_age($crew['birth_date']); ?></a></td>
                        <td><a href="./?pages=crew/edit&id=<?php echo $crew['id']; ?>" style="color:#6E6B7B"><?php echo $crew['telephone']; ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $crews = false;
}

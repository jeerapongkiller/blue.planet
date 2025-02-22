<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Zone.php';

$plaObj = new Zone();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $places = $plaObj->search($is_approved, $name);
?>
    <table class="place-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Country</th>
                <th class="cell-fit">Edit</th>
                <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                    <th class="cell-fit">Delete</th>
                <?php } ?>
            </tr>
        </thead>
        <?php if ($places) { ?>
            <tbody>
                <?php
                foreach ($places as $place) {
                    $is_approved = $place['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $place['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                ?>
                    <tr>
                        <td><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></td>
                        <td><?php echo $place['name']; ?></td>
                        <td></td>
                        <td class="text-center"><a href="./?pages=zone/edit&id=<?php echo $place['id']; ?>"><i class="far fa-edit"></i></a></td>
                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                            <td class="text-center"><a href="javascript:void(0)" onclick="deletePlace(<?php echo $place['id']; ?>);"><i class="far fa-trash-alt"></i></a></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $place = false;
}

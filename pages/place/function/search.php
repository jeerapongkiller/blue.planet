<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Place.php';

$plaObj = new Place();

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
                <th>Province</th>
                <th class="cell-fit"></th>
            </tr>
        </thead>
        <?php if ($places) { ?>
            <tbody>
                <?php
                foreach ($places as $place) {
                    $is_approved = $place['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $place['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=place/edit&id=' . $place['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo $place['name']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $place['provincesNameEN'] . " (" . $place['provincesNameTH'] . ")"; ?></a></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $place = false;
}

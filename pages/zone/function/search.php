<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Zone.php';

$zoneObj = new Zone();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $zones = $zoneObj->search($is_approved, $name);
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
        <?php if ($zones) { ?>
            <tbody>
                <?php
                foreach ($zones as $zone) {
                    $is_approved = $zone['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $zone['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=zone/edit&id=' . $zone['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo !empty($zone['name']) ? !empty($zone['name_th']) ? $zone['name'] . ' (' . $zone['name_th'] . ')' : $zone['name'] : ''; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo !empty($zone['pov_nameen']) ? !empty($zone['pov_nameth']) ? $zone['pov_nameen'] . ' (' . $zone['pov_nameth'] . ')' : $zone['pov_nameen'] : ''; ?></a></td>
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

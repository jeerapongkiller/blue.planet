<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Boat.php';

$boatObj = new Boat();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $type = $_POST['type'] != "" ? $_POST['type'] : '';
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $boats = $boatObj->search($is_approved, $type, $refcode, $name);
?>
    <table class="boat-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Ref. Code</th>
                <th>Boat Type</th>
                <th class="cell-fit">Capacity</th>
            </tr>
        </thead>
        <?php if ($boats) { ?>
            <tbody>
                <?php
                foreach ($boats as $boat) {
                    $is_approved = $boat['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $boat['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=boat/edit&id=' . $boat['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo $boat['name']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $boat['refcode']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $boat['typeName']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $boat['capacity']; ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $boats = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Hotel.php';

$hotObj = new Hotel();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $zone = $_POST['zone'] != "" ? $_POST['zone'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $hotels = $hotObj->search($is_approved, $zone, $name);
?>
    <table class="hotel-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Telephone</th>
                <th>Zone</th>
                <th class="cell-fit"></th>
            </tr>
        </thead>
        <?php if ($hotels) { ?>
            <tbody>
                <?php
                foreach ($hotels as $hotel) {
                    $is_approved = $hotel['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $hotel['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=hotel/edit&id=' . $hotel['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo !empty($hotel['name']) ? !empty($hotel['name_th']) ? $hotel['name'] . " (" . $hotel['name_th'] . ")" : $hotel['name'] : ''; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $hotel['telephone']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo !empty($hotel['zone_name']) ? !empty($hotel['zone_nameth']) ? $hotel['zone_name'] . " (" . $hotel['zone_nameth'] . ")" : $hotel['zone_name'] : ''; ?></a></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $hotel = false;
}

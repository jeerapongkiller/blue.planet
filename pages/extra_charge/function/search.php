<?php
require_once '../../../config/env.php';
require_once '../../../controllers/ExtraCharge.php';

$extraObj = new ExtraCharge();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $extras = $extraObj->search($is_approved, $name);
?>
    <table class="extra-charge-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th class="cell-fit">Adult (ราคาผู้ใหญ่)</th>
                <th class="cell-fit">Children (ราคาเด็ก)</th>
                <th class="cell-fit">Infant (ราคาทารก)</th>
                <th class="cell-fit">Private (ราคารวม, ราคาเหมา)</th>
            </tr>
        </thead>
        <?php if ($extras) { ?>
            <tbody>
                <?php
                foreach ($extras as $extra) {
                    $is_approved = $extra['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $extra['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=extra_charge/edit&id=' . $extra['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo $extra['name']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo number_format($extra['rate_adult']); ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo number_format($extra['rate_child']); ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo number_format($extra['rate_infant']); ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo number_format($extra['rate_total']); ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $extras = false;
}

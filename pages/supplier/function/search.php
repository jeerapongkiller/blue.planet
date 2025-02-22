<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Supplier.php';

$supObj = new Supplier();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $tat_license = $_POST['tat_license'] != "" ? $_POST['tat_license'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $suppliers = $supObj->search($is_approved, $tat_license, $name);
?>
    <table class="supplier-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th class="cell-fit">Status</th>
                <th>TAT License</th>
                <th>Name</th>
                <th>Email</th>
                <th>Telephone</th>
            </tr>
        </thead>
        <?php if ($suppliers) { ?>
            <tbody>
                <?php
                foreach ($suppliers as $supplier) {
                    $is_approved = $supplier['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $supplier['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=supplier/edit&id=' . $supplier['id'] . '" style="color:#6E6B7B" ';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo $supplier['tat_license']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $supplier['name']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $supplier['email']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $supplier['telephone']; ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $suppliers = false;
}

<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Branch.php';

$branObj = new Branch();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $branches = $branObj->search($is_approved, $name);
?>
    <table class="branch-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th class="cell-fit">Status</th>
                <th>Name</th>
            </tr>
        </thead>
        <?php if ($branches) { ?>
            <tbody>
                <?php
                foreach ($branches as $branch) {
                    $is_approved = $branch['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $branch['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=branch/edit&id=' . $branch['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo $branch['name']; ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $branches = false;
}

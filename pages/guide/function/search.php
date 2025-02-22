<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Guide.php';

$guideObj = new Guide();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $guides = $guideObj->search($is_approved, $name);
?>
    <table class="guide-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Telephone</th>
                <th class="cell-fit"></th>
            </tr>
        </thead>
        <?php if ($guides) { ?>
            <tbody>
                <?php
                foreach ($guides as $guide) {
                    $is_approved = $guide['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $guide['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=guide/edit&id=' . $guide['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo $guide['name']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $guide['telephone']; ?></a></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $guides = false;
}

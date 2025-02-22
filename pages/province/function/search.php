<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Province.php';

$plaObj = new Province();

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
                <th class="cell-fit"></th>
              
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
                                            <td><a href="./?pages=province/edit&id=<?php echo $place['id']; ?>" style="color:#6E6B7B"><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a href="./?pages=province/edit&id=<?php echo $place['id']; ?>" style="color:#6E6B7B"><?php echo $place['name_en']; ?></a></td>
                                            <td><a href="./?pages=province/edit&id=<?php echo $province['id']; ?>" style="color:#6E6B7B"><?php echo $place['countryNameEN'] . " (" . $place['countryNameTH'] . ")"; ?></a></td>
                                            <td><a href="./?pages=province/edit&id=<?php echo $place['id']; ?>" style="color:#6E6B7B"></a></td>

                                        </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $place = false;
}

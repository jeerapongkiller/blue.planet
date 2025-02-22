<?php
require_once '../../../config/env.php';
require_once '../../../controllers/BoatType.php';

$boat_typeObj = new Boats_type();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $boats_type = $boat_typeObj->search($name);
?>
    <table class="boat-type-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th class="cell-fit"></th>
            </tr>
        </thead>
        <?php if ($boats_type) { ?>
            <tbody>
                <?php
                foreach ($boats_type as $boat_type) {
                    $href = 'href="./?pages=boat-type/edit&id=' . $boat_type['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><?php echo $boat_type['name']; ?></a></td>
                         <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $boats_type = false;
}

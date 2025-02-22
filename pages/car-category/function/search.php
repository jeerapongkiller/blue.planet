<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarCategory.php';

$car_categoryObj = new Cars_category();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $cars_category = $car_categoryObj->search($name);
?>
    <table class="car-category-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>Capacity</th>
                <th class="cell-fit"></th>
            </tr>
        </thead>
        <?php if ($cars_category) { ?>
            <tbody>
                <?php
                foreach ($cars_category as $car) {
                    $href = 'href="./?pages=car-category/edit&id=' . $car['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><?php echo $car['name']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $car['capacity']; ?></a></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $cars_category = false;
}

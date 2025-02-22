<?php
require_once '../../../config/env.php';
require_once '../../../controllers/CarType.php';

$car_typeObj = new Car_type();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $category = $_POST['category'] != "" ? $_POST['category'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $cars_type = $car_typeObj->search($category, $name);
?>
    <table class="car-type-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th class="cell-fit"></th>
            </tr>
        </thead>
        <?php if ($cars_type) { ?>
            <tbody>
                <?php
                foreach ($cars_type as $car_type) {
                    $href = 'href="./?pages=car-type/edit&id=' . $car_type['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><?php echo $car_type['name']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $car_type['categoryName']; ?></a></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $cars_type = false;
}

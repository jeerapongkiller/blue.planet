<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Car.php';

$carObj = new Car();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $registration = $_POST['registration'] != "" ? $_POST['registration'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $cars = $carObj->search($is_approved, $registration, $name);
?>
    <table class="car-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Car Registration</th>
                <th class="cell-fit">capacity</th>
            </tr>
        </thead>
        <?php if ($cars) { ?>
            <tbody>
                <?php
                foreach ($cars as $car) {
                    $is_approved = $car['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $car['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=car/edit&id=' . $car['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                        <td><a <?php echo $href; ?>><?php echo $car['name']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $car['car_registration']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $car['capacity']; ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $cars = false;
}

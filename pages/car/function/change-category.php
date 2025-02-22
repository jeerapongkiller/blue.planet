<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Car.php';

$carObj = new Car();

if (isset($_POST['action']) && isset($_POST['category'])) {
    // get value from ajax
    $category = $_POST['category'] != "" ? $_POST['category'] : '';

    $types = $carObj->change_category($category);

?>
    <label for="type">Type</label>
    <select class="form-control select2" id="type" name="type">
        <?php
        $types = $carObj->change_category($category);
        if ($types == false) {
            echo '<option value=""> Please Select ... </option>';
        } else {
            foreach ($types as $type) {
                $type_selected = $type['id'] == $_POST['type_id'] ? 'selected' : '';
                echo '<option value="' . $type['id'] . '" ' . $type_selected . '>' . $type['name'] . '</option>';
            }
        }
        ?>
    </select>
<?php
} else {
?>
    <label for="type">Type</label>
    <select class="form-control select2" id="type" name="type">
        <option value="">Plese Select ...</option>
    </select>
<?php
}

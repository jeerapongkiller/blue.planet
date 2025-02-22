<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Product.php';

$prodObj = new Product();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $refcode = $_POST['refcode'] != "" ? $_POST['refcode'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $supplier = $_POST['supplier'] != "" ? $_POST['supplier'] : '';
    $province = $_POST['province'] != "" ? $_POST['province'] : '';
    $products_type = 1;

    $products = $prodObj->search($is_approved, $refcode, $name, $supplier, $province, $products_type);
?>
    <table class="product-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>Reference #</th>
                <th>Name</th>
                <th>Supplier</th>
                <th>Province</th>
                <th class="cell-fit"></th>

            </tr>
        </thead>
        <?php if ($products) { ?>
            <tbody>
                <?php
                foreach ($products as $product) {
                    $is_approved = $product['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $product['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                ?>
                     <tr>
                                            <td><a href="./?pages=tour/edit&id=<?php echo $product['id']; ?>" style="color:#6E6B7B"><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a href="./?pages=tour/edit&id=<?php echo $product['id']; ?>" style="color:#6E6B7B"><?php echo $product['refcode']; ?></a></td>
                                            <td><a href="./?pages=tour/edit&id=<?php echo $product['id']; ?>" style="color:#6E6B7B"><?php echo $product['name']; ?></a></td>
                                            <td><a href="./?pages=tour/edit&id=<?php echo $product['id']; ?>" style="color:#6E6B7B"><?php echo $product['compName']; ?></a></td>
                                            <td><a href="./?pages=tour/edit&id=<?php echo $product['id']; ?>" style="color:#6E6B7B"><?php echo $product['provNameEN'] . " (" . $product['provNameTH'] . ")"; ?></a></td>
                                          

                                            <td><a href="./?pages=tour/edit&id=<?php echo $product['id']; ?>" style="color:#6E6B7B"></a></td>

                                        </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $products = false;
}

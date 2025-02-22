<?php
require_once 'controllers/Product.php';

$prodObj = new Product();
$products = $prodObj->showlist(1);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- products list start -->
            <section class="app-product-list">
                <!-- products filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="product-search-form" name="product-search-form" method="post" enctype="multipart/form-data">
                        <div class="d-flex align-items-center mx-50 row pt-0 pb-2">
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="is_approved">Status</label>
                                    <select class="form-control select2" id="is_approved" name="is_approved">
                                        <option value="all">All</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="refcode">Reference #</label>
                                    <input type="text" class="form-control" id="refcode" name="refcode" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Tour Name</label>
                                    <input type="text" class="form-control" id="name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- products filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="product-search-table">
                        <table class="product-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Reference #</th>
                                    <th>Name</th>
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
                                            <td><a href="./?pages=tour/edit&id=<?php echo $product['id']; ?>" style="color:#6E6B7B"></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- products list ends -->
        </div>
    </div>
</div>
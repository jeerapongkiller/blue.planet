<?php
require_once 'controllers/Supplier.php';

$supObj = new Supplier();
$suppliers = $supObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- suppliers list start -->
            <section class="app-supplier-list">
                <!-- suppliers filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="supplier-search-form" name="supplier-search-form" method="post" enctype="multipart/form-data">
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
                                    <label class="form-label" for="tat_license">TAT License</label>
                                    <input type="text" class="form-control" id="tat_license" name="tat_license" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Supplier Name</label>
                                    <input type="text" class="form-control" id="name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- suppliers filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="supplier-search-table">
                        <table class="supplier-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th class="cell-fit">Status</th>
                                    <th>TAT License</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                </tr>
                            </thead>
                            <?php if ($suppliers) { ?>
                                <tbody>
                                    <?php
                                    foreach ($suppliers as $supplier) {
                                        $is_approved = $supplier['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $supplier['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $href = 'href="./?pages=supplier/edit&id=' . $supplier['id'] . '" style="color:#6E6B7B" ';
                                    ?>
                                        <tr>
                                            <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $supplier['tat_license']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $supplier['name']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $supplier['email']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $supplier['telephone']; ?></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- suppliers list ends -->

        </div>
    </div>
</div>
<?php
require_once 'controllers/Review.php';

$reObj = new Review();
$reviews = $reObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- review list start -->
            <section class="app-supplier-list">
                <!-- review filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="review-search-form" name="review-search-form" method="post" enctype="multipart/form-data">
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

                            <div class="col-md-5 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="products">Product</label>
                                    <select class="form-control select2" id="products" name="products">
                                        <option value="all">All</option>
                                        <?php
                                        $products = $reObj->show_product();
                                        foreach ($products as $product) {
                                        ?>
                                            <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- review filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="review-search-table">
                        <table class="review-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Product</th>
                                    <th>Review Text</th>
                                    <th class="cell-fit"></th>

                                </tr>
                            </thead>
                            <?php if ($reviews) { ?>
                                <tbody>
                                    <?php
                                    foreach ($reviews as $review) {
                                        $is_approved = $review['status'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $review['status'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $fullname = $review['name_review'] . '  ' . $review['lastname_review'];

                                    ?>
                                        <tr>
                                            <td><a href="./?pages=review/edit&id=<?php echo $review['id']; ?>" style="color:#6E6B7B"><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a href="./?pages=review/edit&id=<?php echo $review['id']; ?>" style="color:#6E6B7B"><?php echo $fullname; ?></a></td>
                                            <td><a href="./?pages=review/edit&id=<?php echo $review['id']; ?>" style="color:#6E6B7B"><?php echo $review['email_review']; ?></a></td>
                                            <td><a href="./?pages=review/edit&id=<?php echo $review['id']; ?>" style="color:#6E6B7B"><?php echo $review['proName']; ?></a></td>
                                            <td><a href="./?pages=review/edit&id=<?php echo $review['id']; ?>" style="color:#6E6B7B"><?php echo $review['review_text']; ?></a></td>
                                            <td><a href="./?pages=review/edit&id=<?php echo $review['id']; ?>" style="color:#6E6B7B"></a></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- review assistant list ends -->

        </div>
    </div>
</div>
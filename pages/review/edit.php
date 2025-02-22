<?php
require_once 'controllers/Review.php';

$reObj = new Review();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $review = $reObj->get_data($id);
    if ($review == false) {
        $close_conn = $reObj->close();
        header('location:./?pages=review/list');
    }
} else {
    header('location:./?pages=review/list');
}
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Review</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=review/list">Review List</a></li>
                                <li class="breadcrumb-item active"><?php echo $review['proName']; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Validation -->
            <section class="bs-validation">
                <div class="row">
                    <!-- jQuery Validation -->
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h4 class="card-title">review</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="review-edit-form" name="review-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="review_id" name="review_id" value="<?php echo $review['reID']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $review['status'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $review['name_review']; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $review['lastname_review']; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $review['email_review']; ?>" readonly />
                                            </div>
                                        </div>



                                        <div class="col-md-5 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="address">Review</label>
                                                <textarea class="form-control" id="address" name="address" rows="2" readonly><?php echo $review['review_text']; ?></textarea>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="address">Position</label>

                                                <?php for ($i = 1; $i <= $review['position_review']; $i++) { ?>
                                                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="star fill" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-star-fill b-icon bi text-warning">
                                                        <g>
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </g>
                                                    </svg>

                                                <?php } ?>
                                                <?php
                                                if ($review['position_review'] < 5) {
                                                    for ($i = $review['position_review']; $i < 5; $i++) { ?>
                                                    
                                                <svg data-v-1134b199="" xmlns="http://www.w3.org/2000/svg" width="21px" height="21px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-warning feather feather-star"><polygon data-v-1134b199="" points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                <?php }
                                                }
                                                ?>

                                               
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="address">Tourist guide</label>

                                                <?php for ($i = 1; $i <= $review['guide_review']; $i++) { ?>
                                                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="star fill" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-star-fill b-icon bi text-warning">
                                                        <g>
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </g>
                                                    </svg>

                                                <?php } ?>
                                                <?php
                                                if ($review['guide_review'] < 5) {
                                                    for ($i = $review['guide_review']; $i < 5; $i++) { ?>
                                                    
                                                <svg data-v-1134b199="" xmlns="http://www.w3.org/2000/svg" width="21px" height="21px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-warning feather feather-star"><polygon data-v-1134b199="" points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                <?php }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="address">Price</label>

                                                <?php for ($i = 1; $i <= $review['price_review']; $i++) { ?>
                                                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="star fill" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-star-fill b-icon bi text-warning">
                                                        <g>
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </g>
                                                    </svg>

                                                <?php } ?>
                                                <?php
                                                if ($review['price_review'] < 5) {
                                                    for ($i = $review['price_review']; $i < 5; $i++) { ?>
                                                    
                                                <svg data-v-1134b199="" xmlns="http://www.w3.org/2000/svg" width="21px" height="21px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-warning feather feather-star"><polygon data-v-1134b199="" points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                <?php }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="address">Quality</label>
                                                <?php for ($i = 1; $i <= $review['quality_review']; $i++) { ?>
                                                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="star fill" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-star-fill b-icon bi text-warning">
                                                        <g>
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </g>
                                                    </svg>

                                                <?php } ?>
                                                <?php
                                                if ($review['quality_review'] < 5) {
                                                    for ($i = $review['quality_review']; $i < 5; $i++) { ?>
                                                    
                                                <svg data-v-1134b199="" xmlns="http://www.w3.org/2000/svg" width="21px" height="21px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-warning feather feather-star"><polygon data-v-1134b199="" points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                <?php }
                                                }
                                                ?>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <!-- <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteReview(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?> -->
                                    </div>
                                    <div id="div-driver"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /jQuery Validation -->
                </div>
            </section>
            <!-- /Validation -->

        </div>
    </div>
</div>

<?php
$close_conn = $reObj->close();
?>
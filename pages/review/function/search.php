<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Review.php';

$reObj = new Review();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $products = $_POST['products'] != "" ? $_POST['products'] : '';

    $reviews = $reObj->search($is_approved, $products);
?>
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
<?php
} else {
    echo $drivers_ass = false;
}

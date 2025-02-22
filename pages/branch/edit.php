<?php
require_once 'controllers/Branch.php';

$branObj = new Branch();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $branch = $branObj->get_data($id);
    if ($branch == false) {
        $close_conn = $branObj->close();
        header('location:./?pages=branch/list');
    }
} else {
    header('location:./?pages=branch/list');
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
                        <h2 class="content-header-title float-left mb-0">Branch</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=branch/list">Branch List</a></li>
                                <li class="breadcrumb-item active"><?php echo $branch['name']; ?></li>
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
                            <div class="card-body">
                                <form id="branch-edit-form" name="branch-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="branch_id" name="branch_id" value="<?php echo $branch['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $branch['is_approved'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $branch['name']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteBranch(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
                                    </div>
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
$close_conn = $branObj->close();
?>
<?php
require_once 'controllers/Supplier.php';

$supObj = new Supplier();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $sup = $supObj->get_data($id);
    if ($sup == false) {
        $close_conn = $supObj->close();
        header('location:./?pages=supplier/list');
    }
} else {
    header('location:./?pages=supplier/list');
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
                        <h2 class="content-header-title float-left mb-0">Supplier</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=supplier/list">Supplier List</a></li>
                                <li class="breadcrumb-item active"><?php echo $sup['name']; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Vertical Wizard -->
            <section class="bs-validation">
                <div class="row">
                    <!-- jQuery Validation -->
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h4 class="card-title">supplier</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="supplier-edit-form" name="supplier-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="company_id" name="company_id" value="<?php echo $sup['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $sup['is_approved'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="tat_license">TAT License</label>
                                                <input type="text" class="form-control" id="tat_license" name="tat_license" value="<?php echo $sup['tat_license']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Supplier Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $sup['name']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="text" id="email" name="email" class="form-control" value="<?php echo $sup['email']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telephone">Telephone</label>
                                                <input type="text" id="telephone" name="telephone" class="form-control" value="<?php echo $sup['telephone']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="address">Address</label>
                                                <textarea class="form-control" id="address" name="address" rows="2"><?php echo $sup['address']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="contact_person">Contact Person</label>
                                                <textarea class="form-control" id="contact_person" name="contact_person" rows="2"><?php echo $sup['contact_person']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="note">Note</label>
                                                <textarea class="form-control" id="note" name="note" rows="2"><?php echo $sup['note']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>Logo</label>
                                                <?php if (!empty($sup['logo'])) { ?>
                                                    <div class="form-group mt-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="delete_logo" name="delete_logo[]" value="1" />
                                                            <label class="custom-control-label" for="delete_logo">Delete</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="before_logo" name="before_logo[]" class="form-control" value="<?php echo $sup['logo']; ?>" />
                                                    <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                        <img src="<?php echo $hostPageUrl; ?>/uploads/companies/logo/<?php echo $sup['logo']; ?>" class="img-fluid product-img" alt="Logo" />
                                                    </div>
                                                <?php } ?>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo" name="logo[]" />
                                                    <label class="custom-file-label" for="logo">Choose logo file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteSupplier(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /jQuery Validation -->
                </div>
            </section>
            <!-- /Vertical Wizard -->
        </div>
    </div>
</div>

<?php
$close_conn = $supObj->close();
?>
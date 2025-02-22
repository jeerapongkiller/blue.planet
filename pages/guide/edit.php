<?php
require_once 'controllers/Guide.php';

$guideObj = new Guide();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $guide = $guideObj->get_data($id);
    $languages = $guideObj->languagelist();
    if ($guide == false) {
        $close_conn = $guideObj->close();
        header('location:./?pages=guide/list');
    }
} else {
    header('location:./?pages=guide/list');
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
                        <h2 class="content-header-title float-left mb-0">Guide</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=guide/list">Guide List</a></li>
                                <li class="breadcrumb-item active"><?php echo $guide['name']; ?></li>
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
                                <h4 class="card-title">guide</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="guide-edit-form" name="guide-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="guide_id" name="guide_id" value="<?php echo $guide['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $guide['is_approved'] == 1 ? 'checked' : ''; ?>
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
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $guide['name']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telephone">Telephone</label>
                                                <input type="text" id="telephone" name="telephone" class="form-control" value="<?php echo $guide['telephone']; ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <h3>Language</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        foreach ($languages as $language) {
                                            $language_item = 'language' . $language['id'];
                                            $checked = $guideObj->check_language($guide['id'], $language['id']);
                                            $languages_checked = $checked == 'true' ? 'checked' : '';
                                        ?>
                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <?php if ($checked == 'true') { ?>
                                                            <input type="hidden" id="before_language" name="before_language[]" value="<?php echo $language['id']; ?>">
                                                        <?php } ?>
                                                        <input type="hidden" id="languages" name="languages[]" value="<?php echo $language['id']; ?>">
                                                        <input type="checkbox" class="custom-control-input" id="<?php echo $language_item; ?>" name="language[]" value="<?php echo $language['id']; ?>" <?php echo $languages_checked; ?> />
                                                        <label class="custom-control-label" for="<?php echo $language_item; ?>"><?php echo $language['name_eng']; ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>Image</label>
                                                <?php if (!empty($guide['pic'])) { ?>
                                                    <div class="form-group mt-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="delete_pic" name="delete_pic[]" value="1" />
                                                            <label class="custom-control-label" for="delete_pic">Delete</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="before_pic" name="before_pic[]" class="form-control" value="<?php echo $guide['pic']; ?>" />
                                                    <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                        <img src="storage/uploads/guide/pic/<?php echo $guide['pic']; ?>" class="img-fluid product-img" alt="Pic" />
                                                    </div>
                                                <?php } ?>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="pic" name="pic[]" />
                                                    <label class="custom-file-label" for="pic">Choose image file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteGuide(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
                                    </div>
                                    <div id="div-test"></div>
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
$close_conn = $guideObj->close();
?>
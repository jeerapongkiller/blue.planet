<?php
require_once 'controllers/Province.php';

$plaObj = new Province();

if (!empty($_GET['id']) && $_GET['id'] > 0) {

    $id = $_GET['id'];
    
    $province = $plaObj->get_data($id);
    if ($province == false) {
        $close_conn = $plaObj->close();
        header('location:./?pages=province/list');
    }
} else {
    header('location:./?pages=province/list');
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
                        <h2 class="content-header-title float-left mb-0">Province</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=province/list">Province List</a></li>
                                <li class="breadcrumb-item active"><?php echo $province['name_en']; ?></li>
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
                                <h4 class="card-title">place</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="place-edit-form" name="place-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="province_id" name="province_id" value="<?php echo $province['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $province['is_approved'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <!-- <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $pickup_checked = $province['pickup'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="pickup" name="pickup" value="1" <?php echo $pickup_checked; ?> />
                                                    <label class="custom-control-label" for="pickup">Pickup</label>
                                                </div>
                                            </div> -->
                                        </div>
                                        <!-- <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $dropoff_checked = $province['dropoff'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="dropoff" name="dropoff" value="1" <?php echo $dropoff_checked; ?> />
                                                    <label class="custom-control-label" for="dropoff">Location</label>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name_en">Name EN</label>
                                                <input type="text" class="form-control" id="name_en" name="name_en" value="<?php echo $province['name_en']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name_th">Name TH</label>
                                                <input type="text" class="form-control" id="name_th" name="name_th" value="<?php echo $province['name_th']; ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                        <label for="country">Country</label>
                                        <select class="form-control select2" id="country" name="country">
                                            <?php
                                            $countrys = $plaObj->show_country();
                                            foreach ($countrys as $country) {
                                                $country_selected = $country['id'] == $province['country'] ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $country['id']; ?>" <?php echo $country_selected; ?>><?php echo $country['name_en'] . " (" . $country['name_th'] . ")"; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>Image</label>
                                                <?php if (!empty($province['pic'])) { ?>
                                                    <div class="form-group mt-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="delete_pic" name="delete_pic[]" value="1" />
                                                            <label class="custom-control-label" for="delete_pic">Delete</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="before_pic" name="before_pic[]" class="form-control" value="<?php echo $province['pic']; ?>" />
                                                    <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                        <img src="<?php echo $hostPageUrl; ?>/storage/uploads/province/pic/<?php echo $province['pic']; ?>" class="img-fluid product-img" alt="Pic" />
                                                    </div>
                                                <?php } ?>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="pic" name="pic[]" />
                                                    <label class="custom-file-label" for="pic">Choose image file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deletePlace(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
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
$close_conn = $plaObj->close();
?>
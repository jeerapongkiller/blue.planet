<?php
require_once 'controllers/Place.php';

$plaObj = new Place();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $place = $plaObj->get_data($id);
    if ($place == false) {
        $close_conn = $plaObj->close();
        header('location:./?pages=place/list');
    }
} else {
    header('location:./?pages=place/list');
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
                        <h2 class="content-header-title float-left mb-0">Place</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=place/list">Place List</a></li>
                                <li class="breadcrumb-item active"><?php echo $place['name']; ?></li>
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
                                    <input type="hidden" class="form-control" id="place_id" name="place_id" value="<?php echo $place['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $place['is_approved'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $pickup_checked = $place['pickup'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="pickup" name="pickup" value="1" <?php echo $pickup_checked; ?> />
                                                    <label class="custom-control-label" for="pickup">Pickup</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $dropoff_checked = $place['dropoff'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="dropoff" name="dropoff" value="1" <?php echo $dropoff_checked; ?> />
                                                    <label class="custom-control-label" for="dropoff">Dropoff</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $place['name']; ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="province">Province</label>
                                            <select class="form-control select2" id="province" name="province">
                                                <option value="">--Please choose an Province--</option>
                                                <?php
                                                $provinces = $plaObj->show_province();
                                                foreach ($provinces as $province) {
                                                    $country_selected = $province['id'] == $place['provinces'] ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $province['id']; ?>" <?php echo $country_selected; ?>><?php echo $province['name_en'] . " (" . $province['name_th'] . ")"; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="zone">Zone</label>
                                            <select class="form-control select2" id="zone" name="zone">
                                            <option value="">--Please choose an Zone--</option>
                                                <?php
                                                $zones = $plaObj->show_zone();
                                                foreach ($zones as $zone) {
                                                    $country_selected = $zone['id'] == $place['zones'] ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $zone['id']; ?>" <?php echo $country_selected; ?>><?php echo $zone['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        </div>
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
$close_conn = $plaObj->close();
?>
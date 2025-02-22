<?php
require_once 'controllers/Boat.php';

$boatObj = new Boat();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $boats = $boatObj->get_data($id);
    if ($boats == false) {
        $close_conn = $boatObj->close();
        header('location:./?pages=boat/list');
    }
} else {
    header('location:./?pages=boat/list');
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
                        <h2 class="content-header-title float-left mb-0">Boat</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=boat/list">Boat List</a></li>
                                <li class="breadcrumb-item active"><?php echo $boats['name']; ?></li>
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
                                <h4 class="card-title">User</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="boat-edit-form" name="boat-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="boat_id" name="boat_id" value="<?php echo $boats['id']; ?>" />
                                    <input type="hidden" class="form-control" id="type_id" name="type_id" value="<?php echo $boats['boat_type_id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $boats['is_approved'] == 1 ? 'checked' : ''; ?>
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
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $boats['name']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="refcode">Ref. Code</label>
                                                <input type="text" class="form-control" id="refcode" name="refcode" value="<?php echo $boats['refcode']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="capacity">Capacity</label>
                                                <input type="text" class="form-control" id="capacity" name="capacity" value="<?php echo $boats['capacity']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="type">Type</label>
                                                <select class="form-control select2" id="type" name="type">
                                                    <?php
                                                    $types = $boatObj->showtype();
                                                    foreach ($types as $type) {
                                                        $types_selected = $type['id'] == $boats['boat_type_id'] ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $type['id']; ?>" <?php echo $types_selected; ?>><?php echo $type['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteBoat(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
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
$close_conn = $boatObj->close();
?>
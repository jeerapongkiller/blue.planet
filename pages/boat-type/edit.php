<?php
require_once 'controllers/BoatType.php';

$boat_typeObj = new Boats_type();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $boat_type = $boat_typeObj->get_data($id);
    if ($boat_type == false) {
        $close_conn = $boat_typeObj->close();
        header('location:./?pages=boat-type/list');
    }
} else {
    header('location:./?pages=boat-type/list');
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
                        <h2 class="content-header-title float-left mb-0">Boat Type</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=boat-type/list">Boat Type List</a></li>
                                <li class="breadcrumb-item active"><?php echo $boat_type['name']; ?></li>
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
                                <form id="boat-type-edit-form" name="boat-type-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="boat_type_id" name="boat_type_id" value="<?php echo $boat_type['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $boat_type['name']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <!-- <button type="button" class="btn btn-danger" onclick="deleteCar(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button> -->
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
$close_conn = $boat_typeObj->close();
?>
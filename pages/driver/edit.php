<?php
require_once 'controllers/Driver.php';

$drvObj = new Driver();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $driver = $drvObj->get_data($id);
    if ($driver == false) {
        $close_conn = $drvObj->close();
        header('location:./?pages=driver/list');
    }
} else {
    header('location:./?pages=driver/list');
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
                        <h2 class="content-header-title float-left mb-0">Driver</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=driver/list">Driver List</a></li>
                                <li class="breadcrumb-item active"><?php echo $driver['name']; ?></li>
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
                                <h4 class="card-title">driver</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="driver-edit-form" name="driver-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $driver['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $driver['is_approved'] == 1 ? 'checked' : ''; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">ชื่อ</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $driver['name']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telephone">เบอร์โทร</label>
                                                <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $driver['telephone']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="number_plate">ป้ายทะเบียน</label>
                                                <input type="text" class="form-control" id="number_plate" name="number_plate" value="<?php echo $driver['number_plate']; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-12">
                                            <label for="seat">ที่นั่ง</label>
                                            <select class="form-control select2" id="seat" name="seat">
                                                <option value="0" <?php echo $driver['seat'] == '0' ? 'selected' : ''; ?>>กรุญาเลือกจำนวนที่นั่ง...</option>
                                                <option value="10" <?php echo $driver['seat'] == '10' ? 'selected' : ''; ?>>10</option>
                                                <option value="12" <?php echo $driver['seat'] == '12' ? 'selected' : ''; ?>>12</option>
                                                <option value="13" <?php echo $driver['seat'] == '13' ? 'selected' : ''; ?>>13</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteDriver(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } else {
                                            echo '<span></span>';
                                        } ?>
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
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
$close_conn = $drvObj->close();
?>
<?php
require_once 'controllers/Crew.php';

$crewObj = new Crew();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $crew = $crewObj->get_data($id);
    if ($crew == false) {
        $close_conn = $crewObj->close();
        header('location:./?pages=crew/list');
    }
} else {
    header('location:./?pages=crew/list');
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
                        <h2 class="content-header-title float-left mb-0">Crew</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=crew/list">Crew List</a></li>
                                <li class="breadcrumb-item active"><?php echo $crew['first_name'].' '.$crew['last_name']; ?></li>
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
                                <h4 class="card-title">crew</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="crew-edit-form" name="crew-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="crew_id" name="crew_id" value="<?php echo $crew['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $crew['is_approved'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="id_card">ID Card</label>
                                                <input type="text" class="form-control" id="id_card" name="id_card" value="<?php echo $crew['id_card']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $crew['name']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="birth_date">Birth Date</label>
                                                <input type="text" id="birth_date" name="birth_date" class="form-control flatpickr-basic"  value="<?php echo $crew['birth_date']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="gender">Gender</label>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="gender-male" name="gender" class="custom-control-input" value="1" <?php echo $crew['sex'] == 1 ? 'checked' : '' ; ?> />
                                                    <label class="custom-control-label" for="gender-male">Male</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="gender-female" name="gender" class="custom-control-input" value="2" <?php echo $crew['sex'] == 2 ? 'checked' : '' ; ?> />
                                                    <label class="custom-control-label" for="gender-female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telephone">Telephone</label>
                                                <input type="text" id="telephone" name="telephone" class="form-control" value="<?php echo $crew['telephone']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="address">Address</label>
                                                <textarea class="form-control" id="address" name="address" rows="2"><?php echo $crew['address']; ?></textarea>
                                            </div>
                                        </div>
                                    </div><div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>Image</label>
                                                <?php if (!empty($crew['pic'])) { ?>
                                                    <div class="form-group mt-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="delete_pic" name="delete_pic[]" value="1" />
                                                            <label class="custom-control-label" for="delete_pic">Delete</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="before_pic" name="before_pic[]" class="form-control" value="<?php echo $crew['pic']; ?>" />
                                                    <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                        <img src="<?php echo $hostPageUrl; ?>/storage/uploads/crew/pic/<?php echo $crew['pic']; ?>" class="img-fluid product-img" alt="Pic" />
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
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deletecrew(<?php echo $crew['id']; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
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
$close_conn = $crewObj->close();
?>
<?php
require_once 'controllers/Province.php';

$plaObj = new Province();

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
                                <li class="breadcrumb-item active">Create</li>
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
                                <form id="place-create-form" name="place-create-form" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" checked />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="pickup" name="pickup" value="1" checked />
                                                    <label class="custom-control-label" for="pickup">Pickup</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="dropoff" name="dropoff" value="1" checked />
                                                    <label class="custom-control-label" for="dropoff">Location</label>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name EN</label>
                                                <input type="text" class="form-control" id="name_en" name="name_en" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name TH</label>
                                                <input type="text" class="form-control" id="name_th" name="name_th" />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                        <label for="country">Country</label>
                                        <select class="form-control select2" id="country" name="country">
                                            <?php
                                            $countrys = $plaObj->show_country();
                                            foreach ($countrys as $country) {
                                            ?>
                                                <option value="<?php echo $country['id']; ?>"><?php echo $country['name_en'] . " (" . $country['name_th'] . ")"; ?></option>
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
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="pic" name="pic[]" />
                                                    <label class="custom-file-label" for="pic">Choose image file</label>
                                                </div>
                                            </div>
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
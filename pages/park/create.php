<?php
require_once 'controllers/Park.php';

$parObj = new Park();

?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Park</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=zone/list">Park List</a></li>
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
                                <form id="park-create-form" name="park-create-form" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" checked />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-header">
                                        <h5 class="mb-0">ราคาชาวต่างชาติ</h5>
                                        <!-- <small class="text-muted">Please fill out.</small> -->
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="rate_adult_eng">Adult</label>
                                            <input type="text" id="rate_adult_eng" name="rate_adult_eng" class="form-control numeral-mask" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="rate_child_eng">Child</label>
                                            <input type="text" id="rate_child_eng" name="rate_child_eng" class="form-control numeral-mask" />
                                        </div>
                                    </div>
                                    <div class="content-header">
                                        <h5 class="mb-0">ราคาชาวไทย</h5>
                                        <!-- <small class="text-muted">Please fill out.</small> -->
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="rate_adult_th">Adult</label>
                                            <input type="text" id="rate_adult_th" name="rate_adult_th" class="form-control numeral-mask" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="rate_child_th">Child</label>
                                            <input type="text" id="rate_child_th" name="rate_child_th" class="form-control numeral-mask" />
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
$close_conn = $parObj->close();
?>
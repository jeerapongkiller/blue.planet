<?php
require_once 'controllers/ExtraCharge.php';

$extraObj = new ExtraCharge();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Extra Charge</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=extra_charge/list">Extra Charge List</a></li>
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
                                <h4 class="card-title">driver</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="extra-charge-create-form" name="extra-charge-create-form" method="post" enctype="multipart/form-data">
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
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name (ชื่อ)</label>
                                                <input type="text" class="form-control" id="name" name="name" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="unit">Unit Private (หน่วยรวม, เหมา, หรืออื่นๆ)</label>
                                                <input type="text" class="form-control" id="unit" name="unit" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="rate_adult">Adult (ผู้ใหญ่)</label>
                                                <input type="text" class="form-control numeral-mask" id="rate_adult" name="rate_adult" value="0" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="rate_child">Children (เด็ก)</label>
                                                <input type="text" class="form-control numeral-mask" id="rate_child" name="rate_child" value="0" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="rate_infant">Infant (ทารก)</label>
                                                <input type="text" class="form-control numeral-mask" id="rate_infant" name="rate_infant" value="0" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="rate_total">Private (รวม, เหมา, หรืออื่นๆ)</label>
                                                <input type="text" class="form-control numeral-mask" id="rate_total" name="rate_total" value="0" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="detail">Detail</label>
                                                <textarea class="form-control" name="detail" id="detail" rows="5"></textarea>
                                            </div>
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
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <span></span>
                                        <button class="btn btn-primary btn-submit">
                                            <span class="align-middle d-sm-inline-block d-none">Submit</span>
                                        </button>
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
$close_conn = $extraObj->close();
?>
<?php
require_once 'controllers/Driver.php';

$drvObj = new Driver();
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
                                <form id="driver-create-form" name="driver-create-form" method="post" enctype="multipart/form-data">
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
                                                <label class="form-label" for="name">ชื่อ</label>
                                                <input type="text" class="form-control" id="name" name="name" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telephone">เบอร์โทร</label>
                                                <input type="text" class="form-control" id="telephone" name="telephone" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="number_plate">ป้ายทะเบียน</label>
                                                <input type="text" class="form-control" id="number_plate" name="number_plate" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-12">
                                            <label for="seat">ที่นั่ง</label>
                                            <select class="form-control select2" id="seat" name="seat">
                                                <option value="0">กรุญาเลือกจำนวนที่นั่ง...</option>
                                                <option value="10">10</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <span></span>
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
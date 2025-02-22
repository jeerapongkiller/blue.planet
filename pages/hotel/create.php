<?php
require_once 'controllers/Hotel.php';

$hotObj = new Hotel();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Hotel</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=hotel/list">Hotel List</a></li>
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
                                <h4 class="card-title">hotel</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="hotel-create-form" name="hotel-create-form" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" checked />
                                                    <label class="custom-control-label" for="is_approved">Active (เปิดใช้งาน)</label>
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
                                                <label class="form-label" for="name_th">Name Thai (ชื่อไทย)</label>
                                                <input type="text" class="form-control" id="name_th" name="name_th" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telephone">Telephone (โทรศัพท์)</label>
                                                <input type="text" class="form-control" id="telephone" name="telephone" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email (อีเมล์)</label>
                                                <input type="text" class="form-control" id="email" name="email" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="zone">Zone (โซน)</label>
                                            <select class="form-control select2" id="zone" name="zone">
                                                <option value="">Please choose an Zone</option>
                                                <?php
                                                $zones = $hotObj->show_zone();
                                                foreach ($zones as $zone) {
                                                ?>
                                                    <option value="<?php echo $zone['id']; ?>"><?php echo $zone['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-3">
                                            <div class="form-group">
                                                <label class="d-block" for="address">Address (ที่อยู่)</label>
                                                <textarea class="form-control" id="address" name="address" rows="5"></textarea>
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
$close_conn = $hotObj->close();
?>
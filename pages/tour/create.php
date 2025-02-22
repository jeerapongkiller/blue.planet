<?php
include_once('controllers/Product.php');

$prodObj = new Product();
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Program</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=tour/list">Program List</a></li>
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
                                <form id="product-detail-create-form" name="product-detail-create-form" method="post" enctype="multipart/form-data">
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
                                        <div class="form-group col-md-2">
                                            <label class="form-label" for="refcode">Reference #</label>
                                            <input type="text" id="refcode" name="refcode" class="form-control" value="<?php echo $prodObj->random_refcode(); ?>" readonly />
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label class="form-label" for="name">ชื่อโปรแกรม (Program Name)</label>
                                            <input type="text" id="name" name="name" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="form-label" for="pax">จำนวน นทท. ในแต่ละรอบ (Pax max)</label>
                                            <input type="text" id="pax" name="pax" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="d-block" for="note">Note</label>
                                            <textarea class="form-control" id="note" name="note" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <div class="form-group">
                                                <label for="Park">อุทยาน (Park)</label>
                                                <select class="form-control select2" id="park" name="park">
                                                <option value="">Please Select Park...</option>
                                                <?php
                                                $parks = $prodObj->showpark();
                                                foreach ($parks as $park) {
                                                ?>
                                                    <option value="<?php echo $park['id']; ?>"><?php echo $park['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span></span>
                                        <button type="submit" class="btn btn-primary btn-submit" name="submit" value="Submit">Submit</button>
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
$close_conn = $prodObj->close();
?>
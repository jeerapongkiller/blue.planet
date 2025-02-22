 <?php
    require_once 'controllers/ExtraCharge.php';

    $extraObj = new ExtraCharge();

    if (!empty($_GET['id']) && $_GET['id'] > 0) {
        $id = $_GET['id'];
        $extra = $extraObj->get_data($id);
        if ($extra == false) {
            $close_conn = $extraObj->close();
            header('location:./?pages=extra_charge/list');
        }
    } else {
        header('location:./?pages=extra_charge/list');
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
                         <h2 class="content-header-title float-left mb-0">Extra Charge</h2>
                         <div class="breadcrumb-wrapper">
                             <ol class="breadcrumb">
                                 <li class="breadcrumb-item"><a href="./?pages=extra_charge/list">Extra Charge List</a></li>
                                 <li class="breadcrumb-item active"><?php echo $extra['name']; ?></li>
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
                                <h4 class="card-title">Extra Charge</h4>
                            </div> -->
                             <div class="card-body">
                                 <form id="extra-charge-edit-form" name="extra-charge-edit-form" method="post" enctype="multipart/form-data">
                                     <input type="hidden" class="form-control" id="extra_id" name="extra_id" value="<?php echo $extra['id']; ?>" />
                                     <div class="row">
                                         <div class="col-md-2 col-12">
                                             <div class="form-group">
                                                 <div class="custom-control custom-checkbox">
                                                     <?php $is_approved_checked = $extra['is_approved'] == 1 ? 'checked' : ''; ?>
                                                     <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                     <label class="custom-control-label" for="is_approved">Active</label>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="col-md-3 col-12">
                                             <div class="form-group">
                                                 <label class="form-label" for="name">Name</label>
                                                 <input type="text" class="form-control" id="name" name="name" value="<?php echo $extra['name']; ?>" />
                                             </div>
                                         </div>
                                         <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="unit">Unit Private (หน่วยรวม, เหมา, หรืออื่นๆ)</label>
                                                <input type="text" class="form-control" id="unit" name="unit" value="<?php echo $extra['unit']; ?>" />
                                            </div>
                                        </div>
                                     </div>
                                     <div class="row">
                                         <div class="col-md-3 col-12">
                                             <div class="form-group">
                                                 <label class="form-label" for="rate_adult">Adult (ผู้ใหญ่)</label>
                                                 <input type="text" class="form-control numeral-mask" id="rate_adult" name="rate_adult" value="<?php echo number_format($extra['rate_adult']); ?>" />
                                             </div>
                                         </div>
                                         <div class="col-md-3 col-12">
                                             <div class="form-group">
                                                 <label class="form-label" for="rate_child">Children (เด็ก)</label>
                                                 <input type="text" class="form-control numeral-mask" id="rate_child" name="rate_child" value="<?php echo number_format($extra['rate_child']); ?>" />
                                             </div>
                                         </div>
                                         <div class="col-md-3 col-12">
                                             <div class="form-group">
                                                 <label class="form-label" for="rate_infant">Infant (ทารก)</label>
                                                 <input type="text" class="form-control numeral-mask" id="rate_infant" name="rate_infant" value="<?php echo number_format($extra['rate_infant']); ?>" />
                                             </div>
                                         </div>
                                         <div class="col-md-3 col-12">
                                             <div class="form-group">
                                                 <label class="form-label" for="rate_total">Private (รวม, เหมา, หรืออื่นๆ)</label>
                                                 <input type="text" class="form-control numeral-mask" id="rate_total" name="rate_total" value="<?php echo number_format($extra['rate_total']); ?>" />
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="col-md-6 col-12">
                                             <div class="form-group">
                                                 <label class="d-block" for="detail">Detail</label>
                                                 <textarea class="form-control" id="detail" name="detail" rows="5"><?php echo $extra['detail']; ?></textarea>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="col-md-3 col-12">
                                             <div class="form-group">
                                                 <label>Image</label>
                                                 <?php if (!empty($extra['pic'])) { ?>
                                                     <div class="form-group mt-1">
                                                         <div class="custom-control custom-checkbox">
                                                             <input type="checkbox" class="custom-control-input" id="delete_pic" name="delete_pic[]" value="1" />
                                                             <label class="custom-control-label" for="delete_pic">Delete</label>
                                                         </div>
                                                     </div>
                                                     <input type="hidden" id="before_pic" name="before_pic[]" class="form-control" value="<?php echo $extra['pic']; ?>" />
                                                     <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                         <img src="<?php echo $hostPageUrl; ?>/uploads/extra_charge/pic/<?php echo $extra['pic']; ?>" class="img-fluid product-img" alt="Pic" />
                                                     </div>
                                                 <?php } ?>
                                                 <div class="custom-file">
                                                     <input type="file" class="custom-file-input" id="pic" name="pic[]" />
                                                     <label class="custom-file-label" for="pic">Choose image file</label>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <hr />
                                     <div class="d-flex justify-content-between">
                                         <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteExtraCharge(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
                                         <button class="btn btn-primary btn-submit" type="submit">
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
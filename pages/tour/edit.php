<?php
require_once 'controllers/Product.php';

$prodObj = new Product();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $prod = $prodObj->get_data($id, 1);
    if ($prod == false) {
        $close_conn = $prodObj->close();
        header('location:./?pages=tour/list');
    }
} else {
    header('location:./?pages=tour/list');
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
                        <h2 class="content-header-title float-left mb-0">Tour</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=tour/list">Tour List</a></li>
                                <li class="breadcrumb-item active"><?php echo $prod['name']; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <!-- Vertical Wizard -->
            <section class="horizontal-wizard">
                <div class="bs-stepper horizontal-wizard-example">
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#tour-details">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">1</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Tour Details</span>
                                    <span class="bs-stepper-subtitle">Please fill out</span>
                                </span>
                            </button>
                        </div>
                        <div class="step" data-target="#time-zone">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Time Zone</span>
                                    <span class="bs-stepper-subtitle">Please fill out</span>
                                </span>
                            </button>
                        </div>
                        <div class="step" data-target="#period">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">3</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Category & Period</span>
                                    <span class="bs-stepper-subtitle">Please fill out</span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="bs-stepper-content">
                        <!-- Tour Details -->
                        <div id="tour-details" class="content">
                            <div class="content-header">
                                <h5 class="mb-0">Program Details</h5>
                                <!-- <small class="text-muted">Please fill out.</small> -->
                            </div>
                            <form id="product-detail-edit-form" name="product-detail-edit-form" method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" id="product_id" name="product_id" value="<?php echo $prod['id']; ?>" />
                                <div class="row">
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked = $prod['is_approved'] == 1 ? 'checked' : ''; ?> />
                                                <label class="custom-control-label" for="is_approved">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label class="form-label" for="refcode">Reference #</label>
                                        <input type="text" id="refcode" name="refcode" class="form-control" value="<?php echo $prod['refcode']; ?>" readonly />
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label class="form-label" for="name">Program Name</label>
                                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $prod['name']; ?>" />
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-label" for="pax">Pax max</label>
                                        <input type="text" id="pax" name="pax" class="form-control" value="<?php echo $prod['pax']; ?>" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="d-block" for="note">Note</label>
                                        <textarea class="form-control" id="note" name="note" rows="5"><?php echo $prod['note']; ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="island_id">เกาะ (Island)</label>
                                        <select class="form-control select2" id="island_id" name="island_id">
                                            <option value="0">Please Select Island...</option>
                                            <?php
                                            $islands = $prodObj->showisland();
                                            foreach ($islands as $island) {
                                                $selected = $island['id'] == $prod['island_id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $island['id']; ?>" <?php echo $selected; ?>><?php echo $island['name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="Park">อุทยาน (Park)</label>
                                        <select class="form-control select2" id="park" name="park">
                                            <option value="">Please Select Park...</option>
                                            <?php
                                            $parks = $prodObj->showpark();
                                            foreach ($parks as $park) {
                                                $park_selected = $park['id'] == $prod['park_id'] ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $park['id']; ?>" <?php echo $park_selected; ?>><?php echo $park['name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span></span>
                                    <button type="submit" class="btn btn-primary btn-submit" name="submit" value="Submit">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- Time Zone Details -->
                        <div id="time-zone" class="content">
                            <div class="content-header">
                                <h5 class="mb-0">Time Zone</h5>
                                <!-- <small class="text-muted">Please fill out.</small> -->
                            </div>
                            <form id="time-zone-form" name="time-zone-form" method="post" enctype="multipart/form-data">
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">โซน (Zone)</th>
                                                <th class="text-center">เวลา (Time)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            $zones = $prodObj->showzone($id);
                                            foreach ($zones as $zone) {
                                                $no++;
                                            ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php echo $no; ?>
                                                        <input type="hidden" name="zone_id[]" value="<?php echo $zone['id']; ?>">
                                                    </td>
                                                    <td>
                                                        <h5 class="text-center">
                                                            <?php echo $zone['name']; ?><br>
                                                            <input type="hidden" name="time_zone_id[]" value="<?php echo $zone['tz_id']; ?>">
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <table class="table-borderless">
                                                            <tr style="background: none;">
                                                                <td width="45%">
                                                                    <input type="text" id="<?php echo 'start' . $zone['id']; ?>" name="<?php echo 'start' . $zone['id']; ?>" class="form-control time-mask text-left" placeholder="HH:MM" value="<?php echo !empty($zone['start_pickup']) && $zone['start_pickup'] != '00:00:00' ? $zone['start_pickup'] : ''; ?>" />
                                                                </td>
                                                                <td width="10%" align="center"> - </td>
                                                                <td width="45%">
                                                                    <input type="text" id="<?php echo 'end' . $zone['id']; ?>" name="<?php echo 'end' . $zone['id']; ?>" class="form-control time-mask text-left" placeholder="HH:MM" value="<?php echo !empty($zone['end_pickup']) && $zone['end_pickup'] != '00:00:00' ? $zone['end_pickup'] : ''; ?>" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between">
                                    <span></span>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- Period -->
                        <div id="period" class="content">
                            <div class="content-header mb-0">
                                <h5 class="mb-0 text-uppercase">Category & Period</h5>
                            </div>

                            <!-- Modal Add Category -->
                            <div class="modal-size-lg d-inline-block">
                                <div class="modal fade text-left" id="modal-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel17">Add Category</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="product-category-form" name="product-category-form" method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <input type="hidden" id="product_id" name="product_id" value="<?php echo $prod['id']; ?>" />
                                                        <input type="hidden" id="category_id" name="category_id" value="" />
                                                        <input type="hidden" id="category_action" name="category_action" value="" />
                                                        <div class="form-group col-md-6">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="category_is_approved" name="category_is_approved" value="1" />
                                                                <label class="custom-control-label" for="category_is_approved">Active</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="in_transfer" name="in_transfer" value="1" />
                                                                <label class="custom-control-label" for="in_transfer">Included Transfer</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-group">
                                                                <label class="form-label" for="category_name">Category Name</label>
                                                                <input type="text" class="form-control" id="category_name" name="category_name" value="" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="customer">Customer Type</label>
                                                            <select class="form-control select2" id="customer" name="customer">
                                                                <option value="">Please Select Customer...</option>
                                                                <option value="1">Thai</option>
                                                                <option value="2">Foreign</option>
                                                                <option value="3">Thai + Foreign</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="form-label" for="cate_detail">Detail </label>
                                                            <textarea class="form-control" name="cate_detail" id="cate_detail" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between">
                                                        <div><button type="button" class="btn btn-danger" id="delete-category" onclick="deleteCategory()">Delete</button></div>
                                                        <div><button type="submit" class="btn btn-primary">Submit</button></div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Add Period -->
                            <div class="modal-size-lg d-inline-block">
                                <div class="modal fade text-left" id="modal-period" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel17">Add Period</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="product-period-form" name="product-period-form" method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <input type="hidden" id="period_category_id" name="period_category_id" value="" />
                                                        <input type="hidden" id="period_id" name="period_id" value="" />
                                                        <input type="hidden" id="period_action" name="period_action" value="" />
                                                        <input type="hidden" id="period_status" name="period_status" value="FALSE" />
                                                        <div class="form-group col-md-2">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="period_is_approved" name="period_is_approved" value="1" />
                                                                <label class="custom-control-label" for="period_is_approved">Active</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="period_from_date">Period Date (From)</label></br>
                                                                <input type="text" class="form-control" id="period_from_date" name="period_from_date" value="" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="period_to_date">Period Date (To)</label></br>
                                                                <input type="text" class="form-control" id="period_to_date" name="period_to_date" value="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between">
                                                        <div><button type="button" class="btn btn-danger" id="delete-period" onclick="deletePeriod()">Delete</button></div>
                                                        <div><button type="submit" class="btn btn-primary">Submit</button></div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $categorys = $prodObj->show_category($id);
                            if ($categorys) {
                                foreach ($categorys as $category) {
                                    $cate_is_approved = $category['is_approved'] == 1 ? 'Active' : 'Inactive';
                                    $cate_is_approved_class = $category['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                    $arr_category[$category['id']]['id'] = $category['id'];
                                    $arr_category[$category['id']]['name'] = $category['name'];
                                    $arr_category[$category['id']]['is_approved'] = $category['is_approved'];
                                    $arr_category[$category['id']]['transfer'] = $category['transfer'];
                                    $arr_category[$category['id']]['customer'] = $category['customer'];
                                    $arr_category[$category['id']]['detail'] = $category['detail'];
                            ?>
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                        <div class="card-header bg-light-secondary pt-1 pb-1">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-category" onclick='modal_category("edit", <?php echo json_encode($arr_category[$category["id"]]); ?>);'>
                                                <h4 class="card-title"><?php echo $category['name']; ?> <span class="lead collapse-title"><span class="badge badge-pill <?php echo $cate_is_approved_class; ?> text-capitalized"><?php echo $cate_is_approved; ?></span></h4>
                                            </a>
                                            <a href="javascript:void(0);" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-period" onclick="modal_period('create', '<?php echo $category['id']; ?>');">
                                                <i data-feather="plus" class="mr-25"></i>
                                                <span>Add Period</span>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive mt-2">
                                                <table class="table table-bordered table-striped">
                                                    <?php
                                                    $periods = $prodObj->show_period($category['id']);
                                                    if ($periods) {
                                                        foreach ($periods as $period) {
                                                            $period_is_approved = $period['is_approved'] == 1 ? 'Active' : 'Inactive';
                                                            $period_is_approved_class = $period['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                                            $href = 'href="javascript:void(0);" style="color:#6E6B7B" data-toggle="modal" data-target="#modal-period" onclick="modal_period(
                                                                \'edit\',
                                                                ' . $category['id'] . ',
                                                                ' . $period['id'] . ',
                                                                ' . $period['is_approved'] . ',
                                                                \'' . $period['period_from'] . '\',
                                                                \'' . $period['period_to'] . '\'
                                                            );"';
                                                    ?>
                                                            <tr>
                                                                <td><a <?php echo $href; ?>><?php echo date('j F Y', strtotime($period['period_from'])) . ' - ' . date('j F Y', strtotime($period['period_to'])); ?></a></td>
                                                                <td class="text-center"><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $period_is_approved_class; ?> text-capitalized"><?php echo $period_is_approved; ?></a></span></td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>

                            <hr class="mt-3">

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-category" onclick="modal_category('create')">
                                <i data-feather='plus' class="mr-15"></i>
                                Add Category
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Vertical Wizard -->

        </div>
    </div>
</div>

<?php
$close_conn = $prodObj->close();
?>
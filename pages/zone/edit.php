<?php
require_once 'controllers/Zone.php';

$zoneObj = new Zone();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $zone = $zoneObj->get_data($id);
    if ($zone == false) {
        $close_conn = $zoneObj->close();
        header('location:./?pages=zone/list');
    }
} else {
    header('location:./?pages=zone/list');
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
                        <h2 class="content-header-title float-left mb-0">Zone</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=zone/list">Zone List</a></li>
                                <li class="breadcrumb-item active"><?php echo $zone['name']; ?></li>
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
                                <h4 class="card-title">zone</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="zone-edit-form" name="zone-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo !empty($zone['is_approved']) ? 'checked' : ''; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active (เปิดใช้งาน)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12" hidden>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="pickup" name="pickup" value="1" checked />
                                                    <label class="custom-control-label" for="pickup">Pickup</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12" hidden>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="dropoff" name="dropoff" value="1" checked />
                                                    <label class="custom-control-label" for="dropoff">Dropoff</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name (ชื่อ)</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $zone['name']; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name_th">Name Thai (ชื่อไทย)</label>
                                                <input type="text" class="form-control" id="name_th" name="name_th" value="<?php echo $zone['name_th']; ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-12">
                                            <label for="province">Province (จังหวัด)</label>
                                            <select class="form-control select2" id="province" name="province">
                                                <option value="">Please choose an Province</option>
                                                <?php
                                                $provinces = $zoneObj->show_province();
                                                foreach ($provinces as $province) {
                                                    $selected_prov = $province['id'] == $zone['provinces'] ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $province['id']; ?>" <?php echo $selected_prov; ?>><?php echo $province['name_en'] . " (" . $province['name_th'] . ")"; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <table>
                                                <tr>
                                                    <td width="100%" colspan="3"><label for="start_pickup">Pickup Time (เวลารับ)</label></td>
                                                </tr>
                                                <tr>
                                                    <td width="45%">
                                                        <input type="text" id="start_pickup" name="start_pickup" class="form-control time-mask text-left" placeholder="HH:MM" value="<?php echo date("H:i", strtotime($zone['start_pickup'])); ?>" />
                                                    </td>
                                                    <td width="10%" align="center"> - </td>
                                                    <td width="45%">
                                                        <input type="text" id="end_pickup" name="end_pickup" class="form-control time-mask text-left" placeholder="HH:MM" value="<?php echo date("H:i", strtotime($zone['end_pickup'])); ?>" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteZone(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
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
$close_conn = $zoneObj->close();
?>
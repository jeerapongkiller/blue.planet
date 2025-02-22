<?php
require_once 'controllers/Agent.php';

$agObj = new Agent();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $ag = $agObj->get_data($id);
    if ($ag == false) {
        $close_conn = $agObj->close();
        header('location:./?pages=agent/list');
    }
} else {
    header('location:./?pages=agent/list');
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
                        <h2 class="content-header-title float-left mb-0">Agent</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=agent/list">Agent List</a></li>
                                <li class="breadcrumb-item active"><?php echo $ag['name']; ?></li>
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
                        <div class="step" data-target="#agent-details">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">1</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Agent Details</span>
                                    <span class="bs-stepper-subtitle">Please fill out</span>
                                </span>
                            </button>
                        </div>
                        <div class="step" data-target="#agent-user">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Program Rate</span>
                                    <span class="bs-stepper-subtitle">Please fill out</span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="bs-stepper-content">
                        <!-- Agent Details -->
                        <div id="agent-details" class="content">
                            <div class="content-header">
                                <h5 class="mb-0">Agent Details</h5>
                            </div>
                            <form id="agent-edit-form" name="agent-edit-form" method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" id="company_id" name="company_id" value="<?php echo $ag['id']; ?>" />
                                <div class="row">
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <?php $is_approved_checked = $ag['is_approved'] == 1 ? 'checked' : ''; ?>
                                                <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                <label class="custom-control-label" for="is_approved">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="tat_license">TAT License</label>
                                            <input type="text" class="form-control" id="tat_license" name="tat_license" value="<?php echo $ag['tat_license']; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="name">Agent Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $ag['name']; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="text" id="email" name="email" class="form-control" value="<?php echo $ag['email']; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="telephone">Telephone</label>
                                            <input type="text" id="telephone" name="telephone" class="form-control" value="<?php echo $ag['telephone']; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12" hidden>
                                        <label for="sale_id">Sale</label>
                                        <select class="form-control select2" id="sale_id" name="sale_id">
                                            <option value="">Please Select Sale...</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="sale_id" name="sale_id" value="0">
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label class="d-block" for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="2"><?php echo $ag['address']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label class="d-block" for="contact_person">Contact Person</label>
                                            <textarea class="form-control" id="contact_person" name="contact_person" rows="2"><?php echo $ag['contact_person']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label class="d-block" for="note">Note</label>
                                            <textarea class="form-control" id="note" name="note" rows="2"><?php echo $ag['note']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label>Logo</label>
                                            <?php if (!empty($ag['logo'])) { ?>
                                                <div class="form-group mt-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="delete_logo" name="delete_logo[]" value="1" />
                                                        <label class="custom-control-label" for="delete_logo">Delete</label>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="before_logo" name="before_logo[]" class="form-control" value="<?php echo $ag['logo']; ?>" />
                                                <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                    <img src="<?php echo $hostPageUrl; ?>/uploads/companies/logo/<?php echo $ag['logo']; ?>" class="img-fluid product-img" alt="Logo" />
                                                </div>
                                            <?php } ?>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logo" name="logo[]" />
                                                <label class="custom-file-label" for="logo">Choose logo file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                        <button type="button" class="btn btn-danger" onclick="deleteAgent(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                    <?php } ?>
                                    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- Agent User -->
                        <div id="agent-user" class="content">
                            <div class="content-header">
                                <h5 class="mb-0">Programs Rate</h5>
                            </div>

                            <form id="product-rates-form" name="product-rates-form" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="company_id" name="company_id" value="<?php echo $id; ?>">
                                <?php
                                $programs = $agObj->showprograms(1);
                                if ($programs) {
                                    foreach ($programs as $program) {
                                ?>
                                        <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                            <div class="card-header bg-light-secondary pt-50 pb-50 pl-1">
                                                <h5 class="card-title"><?php echo $program['name']; ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <?php
                                                $categorys = $agObj->showcategory($program["id"]);
                                                if ($categorys) {
                                                    foreach ($categorys as $category) {
                                                ?>
                                                        <h6 class="mt-1"><?php echo $category["name"]; ?></h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
                                                                <?php
                                                                $periods = $agObj->showperiod($category['id']);
                                                                if ($categorys) {
                                                                    foreach ($periods as $period) {
                                                                ?>
                                                                        <tr>
                                                                            <td colspan="4">
                                                                                <?php echo date('j F Y', strtotime($period['period_from'])) . ' - ' . date('j F Y', strtotime($period['period_to'])); ?>
                                                                                <input type="hidden" id="period_id" name="period_id[]" value="<?php echo $period['id']; ?>">
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $rates = $agObj->showrates($period['id'], $id);
                                                                        if ($rates) {
                                                                            foreach ($rates as $rate) {
                                                                        ?>
                                                                                <input type="hidden" id="rate_id" name="rate_id[<?php echo $period['id']; ?>]" value="<?php echo $rate['rate_id']; ?>">
                                                                                <tr>
                                                                                    <td>Adult
                                                                                        <input type="text" class="form-control numeral-mask" id="rate_adult" name="rate_adult[<?php echo $period['id']; ?>]" value="<?php echo number_format($rate['rate_adult']); ?>" />
                                                                                    </td>
                                                                                    <td>Children
                                                                                        <input type="text" class="form-control numeral-mask" id="rate_child" name="rate_child[<?php echo $period['id']; ?>]" value="<?php echo number_format($rate['rate_child']); ?>" />
                                                                                    </td>
                                                                                    <td>Infant
                                                                                        <input type="text" class="form-control numeral-mask" id="rate_infant" name="rate_infant[<?php echo $period['id']; ?>]" value="<?php echo number_format($rate['rate_infant']); ?>" />
                                                                                    </td>
                                                                                    <td>Private
                                                                                        <input type="text" class="form-control numeral-mask" id="rate_private" name="rate_private[<?php echo $period['id']; ?>]" value="<?php echo number_format($rate['rate_private']); ?>" />
                                                                                    </td>
                                                                                </tr>
                                                                            <?php }
                                                                        } else { ?>
                                                                            <input type="hidden" id="rate_id" name="rate_id[<?php echo $period['id']; ?>]" value="0">
                                                                            <tr>
                                                                                <td>Adult
                                                                                    <input type="text" class="form-control numeral-mask" id="rate_adult" name="rate_adult[<?php echo $period['id']; ?>]" value="0" />
                                                                                </td>
                                                                                <td>Children
                                                                                    <input type="text" class="form-control numeral-mask" id="rate_child" name="rate_child[<?php echo $period['id']; ?>]" value="0" />
                                                                                </td>
                                                                                <td>Infant
                                                                                    <input type="text" class="form-control numeral-mask" id="rate_infant" name="rate_infant[<?php echo $period['id']; ?>]" value="0" />
                                                                                </td>
                                                                                <td>Private
                                                                                    <input type="text" class="form-control numeral-mask" id="rate_private" name="rate_private[<?php echo $period['id']; ?>]" value="0" />
                                                                                </td>
                                                                            </tr>
                                                                <?php }
                                                                    }
                                                                } ?>
                                                            </table>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                                <div id="show-div"></div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span></span>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </section>
            <!-- /Vertical Wizard -->

        </div>
    </div>
</div>

<?php
$close_conn = $agObj->close();
?>
<?php
require_once 'controllers/BankAccount.php';

$bankaccObj = new BankAccount();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $account = $bankaccObj->get_data($id);
    if ($account == false) {
        $close_conn = $bankaccObj->close();
        header('location:./?pages=bank-account/list');
    }
} else {
    header('location:./?pages=bank-account/list');
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
                        <h2 class="content-header-title float-left mb-0">Bank Account</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=bank-account/list">Bank Account List</a></li>
                                <li class="breadcrumb-item active"><?php echo $account['account_name']; ?></li>
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
                                <h4 class="card-title">User</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="bank-account-edit-form" name="bank-account-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="account_id" name="account_id" value="<?php echo $account['id']; ?>" />
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $account['is_approved'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="bank">Bank</label>
                                                <select class="form-control select2" id="bank" name="bank">
                                                    <?php
                                                    $banks = $bankaccObj->showbank();
                                                    foreach ($banks as $bank) {
                                                        $banks_selected = $bank['id'] == $account['bank_id'] ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $bank['id']; ?>" <?php echo $banks_selected; ?>><?php echo $bank['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name Bank Account</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $account['account_name']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="no">No Bank Account</label>
                                                <input type="text" class="form-control" id="no" name="no" value="<?php echo $account['account_no']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteAccount(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
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
$close_conn = $bankaccObj->close();
?>
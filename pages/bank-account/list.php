<?php
require_once 'controllers/BankAccount.php';

$bankAccObj = new BankAccount();
$bankaccs = $bankAccObj->showlist($_SESSION["supplier"]["role_id"]);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- bank account list start -->
            <section class="app-user-list">
                <!-- bank account filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="bank-account-search-form" name="bank-account-search-form" method="post" enctype="multipart/form-data">
                        <div class="d-flex align-items-center mx-50 row pt-0 pb-2">
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="is_approved">Status</label>
                                    <select class="form-control select2" id="is_approved" name="is_approved">
                                        <option value="all">All</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Account Name</label>
                                    <input type="text" class="form-control" id="name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="no">Account No</label>
                                    <input type="text" class="form-control" id="no" name="no" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="bank">Bank</label>
                                    <select class="form-control select2" id="bank" name="bank">
                                        <option value="all">All</option>
                                        <?php
                                        $banks = $bankAccObj->showbank();
                                        foreach ($banks as $bank) {
                                        ?>
                                            <option value="<?php echo $bank['id']; ?>"><?php echo $bank['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- bank account filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="bank-account-search-table">
                        <table class="bank-account-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th class="cell-fit">Status</th>
                                    <th>Account Name</th>
                                    <th>Account No</th>
                                    <th>Bank</th>
                                </tr>
                            </thead>
                            <?php if ($bankaccs) { ?>
                                <tbody>
                                    <?php
                                    foreach ($bankaccs as $bankacc) {
                                        $is_approved = $bankacc['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $bankacc['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $href = 'href="./?pages=bank-account/edit&id=' . $bankacc['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td>
                                                <a <?php echo $href; ?>>
                                                    <span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a <?php echo $href; ?>>
                                                    <?php echo $bankacc['account_name']; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a <?php echo $href; ?>>
                                                    <?php echo $bankacc['account_no']; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a <?php echo $href; ?>>
                                                    <?php echo $bankacc['bnkName']; ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- bank account list ends -->

        </div>
    </div>
</div>
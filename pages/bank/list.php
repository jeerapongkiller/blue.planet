<?php
require_once 'controllers/Bank.php';

$bankObj = new Bank();
$banks = $bankObj->showlist($_SESSION["supplier"]["role_id"]);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- bank list start -->
            <section class="app-user-list">
                <!-- bank filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="bank-search-form" name="bank-search-form" method="post" enctype="multipart/form-data">
                        <div class="d-flex align-items-center mx-50 row pt-0 pb-2">
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- bank filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="bank-search-table">
                        <table class="bank-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th class="cell-fit">Name</th>
                                </tr>
                            </thead>
                            <?php if ($banks) { ?>
                                <tbody>
                                    <?php
                                    foreach ($banks as $bank) {
                                        $href = 'href="./?pages=bank/edit&id=' . $bank['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td>
                                                <a <?php echo $href; ?>>
                                                    <?php echo $bank['name']; ?>
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
            <!-- bank list ends -->

        </div>
    </div>
</div>
<?php
require_once 'controllers/Captain.php';

$capObj = new Captain();
$captains = $capObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- captain list start -->
            <section class="app-supplier-list">
                <!-- captain filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="captain-search-form" name="captain-search-form" method="post" enctype="multipart/form-data">
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
                                    <label class="form-label" for="id_card">ID Card</label>
                                    <input type="text" class="form-control" id="id_card" name="id_card" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="sex">Gender</label>
                                    <select class="form-control select2" id="sex" name="sex">
                                        <option value="all">All</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- captain filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="captain-search-table">
                        <table class="captain-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Full Name</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                    <th class="cell-fit">Telephone</th>
                                </tr>
                            </thead>
                            <?php if ($captains) { ?>
                                <tbody>
                                    <?php
                                    foreach ($captains as $captain) {
                                        $is_approved = $captain['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $captain['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $sex = $captain['sex'] == 1 ? 'Male' : 'Female';
                                    ?>
                                        <tr>
                                            <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><?php echo $captain['name']; ?></a></td>
                                            <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><?php echo $sex; ?></a></td>
                                            <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><?php echo $capObj->get_age($captain['birth_date']); ?></a></td>
                                            <td><a href="./?pages=captain/edit&id=<?php echo $captain['id']; ?>" style="color:#6E6B7B"><?php echo $captain['telephone']; ?></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- captain assistant list ends -->

        </div>
    </div>
</div>
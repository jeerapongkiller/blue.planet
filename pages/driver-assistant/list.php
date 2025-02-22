<?php
require_once 'controllers/DriverAssistant.php';

$drv_assObj = new Driver_Assistant();
$drivers_ass = $drv_assObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- drivers assistant list start -->
            <section class="app-supplier-list">
                <!-- drivers assistant filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="driver-assistant-search-form" name="driver-assistant-search-form" method="post" enctype="multipart/form-data">
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
                                    <label class="form-label" for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="nickname">Nickname</label>
                                    <input type="text" class="form-control" id="nickname" name="nickname" />
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
                <!-- drivers assistant filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="driver-assistant-search-table">
                        <table class="driver-assistant-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Full Name</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                    <th>Telephone</th>
                                    <th class="cell-fit"></th>
                                </tr>
                            </thead>
                            <?php if ($drivers_ass) { ?>
                                <tbody>
                                    <?php
                                    foreach ($drivers_ass as $driver_ass) {
                                        $is_approved = $driver_ass['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $driver_ass['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $sex = $driver_ass['sex'] == 1 ? 'Male' : 'Female';
                                        $fullname = $driver_ass['first_name'] . ' (' . $driver_ass['nickname'] . ') ' . $driver_ass['last_name'];
                                        $href = 'href="./?pages=driver-assistant/edit&id=' . $driver_ass['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $fullname; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $sex; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $drv_assObj->get_age($driver_ass['birth_date']); ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $driver_ass['telephone']; ?></a></td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- drivers assistant list ends -->

        </div>
    </div>
</div>
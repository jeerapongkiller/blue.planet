<?php
require_once 'controllers/Driver.php';

$drvObj = new Driver();
$drivers = $drvObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- drivers list start -->
            <section class="app-supplier-list">
                <!-- drivers filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="driver-search-form" name="driver-search-form" method="post" enctype="multipart/form-data">
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
                                    <label class="form-label" for="name">ชื่อ</label>
                                    <input type="text" class="form-control" id="name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="number_plate">ป้ายทะเบียน</label>
                                    <input type="text" class="form-control" id="number_plate" name="number_plate" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="seat">ที่นั่ง</label>
                                    <select class="form-control select2" id="seat" name="seat">
                                        <option value="all">all</option>
                                        <option value="10">10</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- drivers filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="driver-search-table">
                        <table class="driver-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>ชื่อ</th>
                                    <th>เบอร์โทร</th>
                                    <th>ป้ายทะเบียน</th>
                                    <th>ที่นั่ง</th>
                                    <th class="cell-fit"></th>
                                </tr>
                            </thead>
                            <?php if ($drivers) { ?>
                                <tbody>
                                    <?php
                                    foreach ($drivers as $driver) {
                                        $is_approved = $driver['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $driver['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                    ?>
                                        <tr>
                                            <td>
                                                <a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>">
                                                    <span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span>
                                                </a>
                                            </td>
                                            <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"><?php echo $driver['name']; ?></a></td>
                                            <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"><?php echo $driver['telephone']; ?></a></td>
                                            <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"><?php echo $driver['number_plate']; ?></a></td>
                                            <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"><?php echo $driver['seat']; ?></a></td>
                                            <td><a href="./?pages=driver/edit&id=<?php echo $driver['id']; ?>" style="color:#6E6B7B"></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- drivers list ends -->

        </div>
    </div>
</div>
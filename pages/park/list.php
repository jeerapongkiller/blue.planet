<?php
require_once 'controllers/Park.php';

$plaObj = new Park();
$parks = $plaObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- place list start -->
            <section class="app-supplier-list">
                <!-- place filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="place-search-form" name="place-search-form" method="post" enctype="multipart/form-data">
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
                <!-- place filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="place-search-table">
                        <table class="place-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th class="cell-fit"></th>
                                </tr>
                            </thead>
                            <?php if ($parks) { ?>
                                <tbody>
                                    <?php
                                    foreach ($parks as $park) {
                                        $is_approved = $park['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $park['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $href = 'href="./?pages=park/edit&id=' . $park['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $park['name']; ?></a></td>
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
            <!-- place assistant list ends -->

        </div>
    </div>
</div>
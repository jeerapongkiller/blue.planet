<?php
require_once 'controllers/CategoryItems.php';

$plaObj = new CategotyItems();
$categoryitems = $plaObj->showlist();
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
                                    <th>Create Date</th>
                                    <th class="cell-fit">Edit</th>
                                    <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                        <th class="cell-fit">Delete</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <?php if ($categoryitems) { ?>
                                <tbody>
                                    <?php
                                    foreach ($categoryitems as $categoryitem) {
                                        $is_approved = $categoryitem['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $categoryitem['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                    ?>
                                        <tr>
                                            <td><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></td>
                                            <td><?php echo $categoryitem['name']; ?></td>
                                            <td><?php echo date('j F Y', strtotime($categoryitem['created_at'])); ?></td>
                                            <td class="text-center"><a href="./?pages=category-items/edit&id=<?php echo $categoryitem['id']; ?>"><i data-feather='edit'></i></a></td>
                                            <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                                <td class="text-center"><a href="javascript:void(0)" onclick="deletePlace(<?php echo $categoryitem['id']; ?>);"><i data-feather='trash-2'></i></a></td>
                                            <?php } ?>
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
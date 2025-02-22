<?php
require_once 'controllers/Boat.php';

$boatObj = new Boat();
$boats = $boatObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- boats list start -->
            <section class="app-user-list">
                <!-- boats filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="boat-search-form" name="boat-search-form" method="post" enctype="multipart/form-data">
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
                                    <label for="type">Boat Type</label>
                                    <select class="form-control select2" id="type" name="type">
                                        <option value="all">All</option>
                                        <?php
                                        $types = $boatObj->showtype();
                                        foreach ($types as $type) {
                                        ?>
                                            <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                                        <?php
                                        }
                                        ?>
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
                                <div class="form-group">
                                    <label class="form-label" for="refcode">Ref. Code</label>
                                    <input type="text" class="form-control" id="refcode" name="refcode" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- boats type filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="boat-search-table">
                        <table class="boat-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Ref. Code</th>
                                    <th>Boat Type</th>
                                    <th class="cell-fit">Capacity</th>
                                </tr>
                            </thead>
                            <?php if ($boats) { ?>
                                <tbody>
                                    <?php
                                    foreach ($boats as $boat) {
                                        $is_approved = $boat['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $boat['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $href = 'href="./?pages=boat/edit&id=' . $boat['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $boat['name']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $boat['refcode']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $boat['typeName']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $boat['capacity']; ?></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- boats type list ends -->

        </div>
    </div>
</div>
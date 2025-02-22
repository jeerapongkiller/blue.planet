<?php
require_once 'controllers/BoatType.php';

$boat_typeObj = new Boats_type();
$boats_type = $boat_typeObj->showlist($_SESSION["supplier"]["role_id"]);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- boats type list start -->
            <section class="app-user-list">
                <!-- boats type filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="boat-type-search-form" name="boat-type-search-form" method="post" enctype="multipart/form-data">
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
                <!-- boats type filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="boatd-datatable pt-0" id="boat-type-search-table">
                        <table class="boat-type-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th class="cell-fit"></th>
                                </tr>
                            </thead>
                            <?php if ($boats_type) { ?>
                                <tbody>
                                    <?php
                                    foreach ($boats_type as $boat_type) {
                                        $href = 'href="./?pages=boat-type/edit&id=' . $boat_type['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td><a <?php echo $href; ?>><?php echo $boat_type['name']; ?></a></td>
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
            <!-- boats type list ends -->

        </div>
    </div>
</div>
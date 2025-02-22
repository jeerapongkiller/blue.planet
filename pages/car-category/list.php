<?php
require_once 'controllers/CarCategory.php';

$car_categoryObj = new Cars_category();
$cars = $car_categoryObj->showlist($_SESSION["supplier"]["role_id"]);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- cars category list start -->
            <section class="app-user-list">
                <!-- cars category filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="car-category-search-form" name="car-category-search-form" method="post" enctype="multipart/form-data">
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
                <!-- cars category filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="car-category-search-table">
                        <table class="car-category-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Capacity</th>
                                    <th class="cell-fit"></th>
                                </tr>
                            </thead>
                            <?php if ($cars) { ?>
                                <tbody>
                                    <?php
                                    foreach ($cars as $car) {
                                        $href = 'href="./?pages=car-category/edit&id=' . $car['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td><a <?php echo $href; ?>><?php echo $car['name']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $car['capacity']; ?></a></td>
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
            <!-- cars category list ends -->

        </div>
    </div>
</div>
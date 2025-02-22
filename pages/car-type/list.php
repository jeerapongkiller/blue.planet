<?php
require_once 'controllers/CarType.php';

$car_typeObj = new Car_type();
$cars_type = $car_typeObj->showlist($_SESSION["supplier"]["role_id"]);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- cars type list start -->
            <section class="app-user-list">
                <!-- cars type filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="car-type-search-form" name="car-type-search-form" method="post" enctype="multipart/form-data">
                        <div class="d-flex align-items-center mx-50 row pt-0 pb-2">
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="role">Category</label>
                                    <select class="form-control select2" id="category" name="category">
                                        <option value="all">All</option>
                                        <?php
                                        $categorys = $car_typeObj->showcategory();
                                        foreach ($categorys as $category) {
                                        ?>
                                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
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
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- cars type filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="car-type-search-table">
                        <table class="car-type-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th class="cell-fit"></th>
                                </tr>
                            </thead>
                            <?php if ($cars_type) { ?>
                                <tbody>
                                    <?php
                                    foreach ($cars_type as $car_type) {
                                        $href = 'href="./?pages=car-type/edit&id=' . $car_type['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td><a <?php echo $href; ?>><?php echo $car_type['name']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $car_type['categoryName']; ?></a></td>
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
            <!-- cars type list ends -->

        </div>
    </div>
</div>
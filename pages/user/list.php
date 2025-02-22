<?php
require_once 'controllers/User.php';

$userObj = new User();
$users = $userObj->showlist($_SESSION["supplier"]["role_id"]);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- users list start -->
            <section class="app-user-list">
                <!-- users filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="user-search-form" name="user-search-form" method="post" enctype="multipart/form-data">
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
                                    <label for="role">Role</label>
                                    <select class="form-control select2" id="role" name="role">
                                        <option value="all">All</option>
                                        <?php
                                        $roles = $userObj->showrole($_SESSION["supplier"]["role_id"]);
                                        foreach ($roles as $role) {
                                        ?>
                                            <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- users filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="user-search-table">
                        <table class="user-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th class="cell-fit">Status</th>
                                    <th>User</th>
                                    <th>Full name</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <?php if ($users) { ?>
                                <tbody>
                                    <?php
                                    foreach ($users as $user) {
                                        $is_approved = $user['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $user['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $href = 'href="./?pages=user/edit&id=' . $user['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td>
                                                <a <?php echo $href; ?>>
                                                    <span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span>
                                                </a>
                                            </td>
                                            <td><a <?php echo $href; ?>><?php echo $user['username']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $user['firstname'] . " " . $user['lastname']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo $user['roleName']; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo !empty($user['dpmtName']) ? $user['dpmtName'] : '-'; ?></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- users list ends -->

        </div>
    </div>
</div>
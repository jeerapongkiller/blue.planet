<?php
require_once 'controllers/User.php';

$userObj = new User();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?pages=user/list">User List</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Validation -->
            <section class="bs-validation">
                <div class="row">
                    <!-- jQuery Validation -->
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h4 class="card-title">User</h4>
                            </div> -->
                            <div class="card-body">
                                <form id="user-create-form" name="user-create-form" method="post" enctype="multipart/form-data">
                                    <div id="div-show"></div>
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" checked />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                                            <div class="form-group">
                                                <label class="form-label" for="password">Password</label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input type="password" class="form-control form-control-merge" id="password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="confirm-password">Confirm Password</label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input type="password" class="form-control form-control-merge" id="confirm-password" name="confirm-password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="confirm-password" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <div id="div-role">
                                                    <select class="form-control select2" id="role" name="role">
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
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="department">department</label>
                                                <div id="div-role">
                                                    <select class="form-control select2" id="department" name="department">
                                                        <option value=""></option>
                                                        <?php
                                                        $dpms = $userObj->showdepartment();
                                                        foreach ($dpms as $dpm) {
                                                        ?>
                                                            <option value="<?php echo $dpm['id']; ?>"><?php echo $dpm['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="text" id="email" name="email" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telephone">Telephone</label>
                                                <input type="text" id="telephone" name="telephone" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>Photo</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="photo" name="photo[]" />
                                                    <label class="custom-file-label" for="photo">Choose photo file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-1 mb-1">
                                        <div class="col-md-12">
                                            <p>Permissions</p>
                                        </div>
                                        <?php
                                        $permissions = $userObj->showpermissions();
                                        foreach ($permissions as $permission) {
                                        ?>
                                            <div class="form-group col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="<?php echo 'permission' . $permission['id']; ?>" name="permissions[]" value="<?php echo $permission['id']; ?>" <?php // echo $checked_day; 
                                                                                                                                                                                                                            ?> />
                                                    <label class="custom-control-label" for="<?php echo 'permission' . $permission['id']; ?>"><?php echo $permission['name']; ?></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /jQuery Validation -->
                </div>
            </section>
            <!-- /Validation -->

        </div>
    </div>
</div>

<?php
$close_conn = $userObj->close();
?>
<?php
require_once 'controllers/User.php';

$userObj = new User();

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $user = $userObj->get_data($id);
    if ($user == false) {
        $close_conn = $userObj->close();
        header('location:./?pages=user/list');
    }
} else {
    header('location:./?pages=user/list');
}
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
                                <li class="breadcrumb-item active"><?php echo $user['username']; ?></li>
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
                                <form id="user-edit-form" name="user-edit-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user['id']; ?>" />
                                    <div id="div-show"></div>
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php $is_approved_checked = $user['is_approved'] == 1 ? 'checked' : ''; ?>
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" <?php echo $is_approved_checked; ?> />
                                                    <label class="custom-control-label" for="is_approved">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" readonly="readonly" />
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
                                                <select class="form-control select2" id="role" name="role">
                                                    <?php
                                                    $roles = $userObj->showrole($_SESSION["supplier"]["role_id"]);
                                                    foreach ($roles as $role) {
                                                        $role_selected = $role['id'] == $user['role_id'] ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $role['id']; ?>" <?php echo $role_selected; ?>><?php echo $role['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
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
                                                            $dpm_selected = $dpm['id'] == $user['department_id'] ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $dpm['id']; ?>" <?php echo $dpm_selected; ?>><?php echo $dpm['name']; ?></option>
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
                                                <input type="text" id="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telephone">Telephone</label>
                                                <input type="text" id="telephone" name="telephone" class="form-control" value="<?php echo $user['telephone']; ?>" />
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="dob">DOB</label>
                                                <input type="text" class="form-control" name="dob" id="dob" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>Profile pic</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="customFile" />
                                                    <label class="custom-file-label" for="customFile">Choose profile pic</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="d-block">Gender</label>
                                                <div class="custom-control custom-radio my-50">
                                                    <input type="radio" id="validationRadiojq1" name="validationRadiojq" class="custom-control-input" />
                                                    <label class="custom-control-label" for="validationRadiojq1">Male</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="validationRadiojq2" name="validationRadiojq" class="custom-control-input" />
                                                    <label class="custom-control-label" for="validationRadiojq2">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label class="d-block" for="validationBio">Bio</label>
                                                <textarea class="form-control" id="validationBio" name="validationBiojq" rows="3"></textarea>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>Photo</label>
                                                <?php if (!empty($user['photo'])) { ?>
                                                    <div class="form-group mt-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="delete_photo" name="delete_photo[]" value="1" />
                                                            <label class="custom-control-label" for="delete_photo">Delete</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="before_photo" name="before_photo[]" class="form-control" value="<?php echo $user['photo']; ?>" />
                                                    <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                        <img src="<?php echo $hostPageUrl; ?>/uploads/users/admin/<?php echo $user['photo']; ?>" class="img-fluid product-img" alt="photo" />
                                                    </div>
                                                <?php } ?>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="photo" name="photo[]" />
                                                    <label class="custom-file-label" for="photo">Choose Photo file</label>
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
                                            $checked_perms = $userObj->check_perms($id, $permission['id']) > 0 ? 'checked' : '';
                                        ?>
                                            <div class="form-group col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="<?php echo 'permission' . $permission['id']; ?>" name="permissions[]" value="<?php echo $permission['id']; ?>" <?php echo $checked_perms; ?> />
                                                    <label class="custom-control-label" for="<?php echo 'permission' . $permission['id']; ?>"><?php echo $permission['name']; ?></label>
                                                </div>
                                            </div>
                                        <?php
                                            echo $checked_perms == 'checked' ? '<input type="hidden" name="default_perms[]" value="' . $permission['id'] . '" />' : '';
                                        } ?>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                        <?php if ($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) { ?>
                                            <button type="button" class="btn btn-danger" onclick="deleteUser(<?php echo $id; ?>);"><i data-feather='trash-2'></i> Delete</button>
                                        <?php } ?>
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
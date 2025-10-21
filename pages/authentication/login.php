<?php
require_once 'controllers/Auth.php';
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="tours management system by shambhala.travel">
    <meta name="keywords" content="tours management system">
    <meta name="author" content="Blue Planet">
    <title>Supplier Login - Blue Planet</title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">

    <?php include 'layouts/authentication/login-head.php'; ?>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <!-- Login v1 -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="brand-logo">
                                    <img src="app-assets/images/logo/logo.svg" width="150">
                                    <!-- <h4 class="brand-text text-primary ml-1">BLUE<small class="d-block">PLANET</small></h4> -->
                                </a>

                                <form class="auth-login-form mt-2" id="frmlogin" name="frmlogin" action="" method="POST" novalidate>
                                    <input class="form-control" type="hidden" id="pages" name="pages" value="user/list">
                                    <div class="form-group">
                                        <label for="auth_username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="auth_username" name="auth_username" placeholder="Username" aria-describedby="auth_username" tabindex="1" autofocus />
                                    </div>

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="auth_password">Password</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="auth_password" name="auth_password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="auth_password" />
                                            <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" name="submit" class="btn btn-primary btn-block" tabindex="4" value="Sign in">

                                    <div class="my-2">
                                        <hr>
                                    </div>

                                    <div class="auth-footer-btn d-flex justify-content-center">
                                        <div class="col-sm-12 text-center">
                                            © <?php echo date("Y"); ?> Develop by <a href="https://shambhala.travel" target="_blank">shambhala.travel</a>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!-- /Login v1 -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <?php include 'layouts/authentication/login-footer.php'; ?>

    <!-- BEGIN: Login-->
    <?php
    if (isset($_POST["submit"])) {
        $username_signin = $_POST['auth_username'];
        $password_signin = $_POST['auth_password'];
        // $redirect_page = $_POST['pages'];

        $auth = new Auth();
        $response = $auth->check_login($username_signin, $password_signin);

        // if ($response != false && $response > 0) {
        //     $redirect_page = ($_SESSION["supplier"]["department_id"] == 5) ? 'order-job/list' : 'booking/list';
        //     header('location:./?pages=' . $redirect_page);
        // }
        if ($response != false && $response > 0) {
            $permission_pages = [
                1 => 'booking/list',
                3 => 'manage-transfer/list',
                4 => 'order-booking/list',
                5 => 'invoice/list',
                6 => 'report/list',
                7 => 'tour/list',
                8 => 'agent/list',
                9 => 'car/list',
                10 => 'user/list',
            ];

            $redirect_page = '';

            foreach ($permission_pages as $perm_id => $page) {
                if (in_array($perm_id, $_SESSION["supplier"]["permission"])) {
                    $redirect_page = "?pages=$page";
                    break;
                }
            }

            if ($_SESSION["supplier"]["id"] == 1) {
                $redirect_page = '?pages=booking/list';
            }

            header("Location: ./$redirect_page");
        } else {
            echo '
                <script type="text/javascript">
                    $(document).ready(function(){
                        Swal.fire({
                            // title: "Username or Password is incorrect",
                            text: "Username or Password is incorrect!",
                            icon: "error",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            },
                            buttonsStyling: false
                        })
                    });
                </script>
                ';
        }
    }
    ?>
    <!-- END: Login-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>
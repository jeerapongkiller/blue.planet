<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <!-- <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                    <a class="dropdown-item" href="javascript:void(0);" data-language="en"><i class="flag-icon flag-icon-us"></i>English</a>
                    <a class="dropdown-item" href="javascript:void(0);" data-language="th"><i class="flag-icon flag-icon-th"></i>Thai</a>
                </div>
            </li> -->
            <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li> -->
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder"><?php echo $_SESSION["supplier"]["fullname"]; ?></span>
                        <span class="user-status"><?php echo $_SESSION["supplier"]["role_name"]; ?></span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="app-assets/images/avatars/user.jpg" alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="./?pages=user/edit&id=<?php echo $_SESSION["supplier"]["id"]; ?>"><i class="mr-50" data-feather="user"></i>Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="./"><i class="mr-50" data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
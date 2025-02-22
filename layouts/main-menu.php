<?php $guide_menu = (!empty($_SESSION["supplier"]["department_id"]) && $_SESSION["supplier"]["department_id"] == 5) ? 'hidden' : '';  ?>

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="javascript:void(0);"><span class="brand-logo">
                        <img src="app-assets/images/logo/logo.png" height="24"></span>
                    <h5 class="brand-text text-center">BLUE<small class="d-block">PLANET</small></h5></span>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="navigation-header <?php echo $guide_menu; ?>"><span data-i18n="Booking">Booking</span><i data-feather="more-horizontal"></i></li>
            <li class="nav-item <?php echo $guide_menu; ?> <?php echo ((strstr($_GET['pages'], "booking/")) && (strstr($_GET['pages'], "report-booking/") == false)) ? 'active' : ''; ?>">
                <a class="d-flex align-items-center" href="./?pages=booking/list"><i data-feather='briefcase'></i><span class="menu-title text-truncate" data-i18n="booking">Booking</span></a>
            </li>

            <li class="navigation-header <?php echo $guide_menu; ?>"><span data-i18n="mangement">การจัดการ</span><i data-feather="more-horizontal"></i></li>
            <li class="nav-item <?php echo $guide_menu; ?>"><a class="d-flex align-items-center" href="#"><i data-feather='briefcase'></i><span class="menu-title text-truncate" data-i18n="order-driver">จัดรถ</span></a>
                <ul class="menu-content">
                    <li class="nav-item <?php echo ((strstr($_GET['pages'], "order-driver/manage"))) ? 'active' : ''; ?>"><a class="d-flex align-items-center" href="./?pages=order-driver/manage"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="order-driver">เปิดรถ</span></a>
                    </li>
                    <li class="nav-item <?php echo ((strstr($_GET['pages'], "order-driver/list"))) ? 'active' : ''; ?>"><a class="d-flex align-items-center" href="./?pages=order-driver/list"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="order-driver">ใบงานรถ</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?php echo $guide_menu; ?>"><a class="d-flex align-items-center" href="#"><i data-feather='briefcase'></i><span class="menu-title text-truncate" data-i18n="order-boat">จัดเรือ</span></a>
                <ul class="menu-content">
                    <li class="nav-item <?php echo ((strstr($_GET['pages'], "order-boat/manage"))) ? 'active' : ''; ?>"><a class="d-flex align-items-center" href="./?pages=order-boat/manage"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="order-driver">เปิดเรือ</span></a>
                    </li>
                    <li class="nav-item <?php echo ((strstr($_GET['pages'], "order-boat/list"))) ? 'active' : ''; ?>"><a class="d-flex align-items-center" href="./?pages=order-boat/list"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="order-driver">ใบงานเรือ</span></a>
                    </li>
                    <li class="nav-item" hidden><a class="d-flex align-items-center" href="./?pages=order-boat/check-in"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="order-driver">Check IN</span></a>
                    </li>
                </ul>
            </li>

            <li class="navigation-header"><span data-i18n="order">ใบงาน</span><i data-feather="more-horizontal"></i></li>
            <li class="nav-item <?php echo ((strstr($_GET['pages'], "order-guide/"))) ? 'active' : ''; ?>">
                <a class="d-flex align-items-center" href="./?pages=order-guide/list"><i data-feather='briefcase'></i><span class="menu-title text-truncate" data-i18n="order-guide">ใบไกด์</span></a>
            </li>
            <li class="nav-item <?php echo ((strstr($_GET['pages'], "order-job/"))) ? 'active' : ''; ?>">
                <a class="d-flex align-items-center" href="./?pages=order-job/list"><i data-feather='briefcase'></i><span class="menu-title text-truncate" data-i18n="order-job">ใบหน้างาน</span></a>
            </li>
            <li class="nav-item <?php echo $guide_menu; ?> <?php echo ((strstr($_GET['pages'], "order-agent/"))) ? 'active' : ''; ?>">
                <a class="d-flex align-items-center" href="./?pages=order-agent/list"><i data-feather='briefcase'></i><span class="menu-title text-truncate" data-i18n="confirm-agent">RE Confirm Agent</span></a>
            </li>

            <li class="navigation-header <?php echo $guide_menu; ?>"><span data-i18n="accounting">Accounting</span><i data-feather="more-horizontal"></i></li>
            <li class="nav-item <?php echo $guide_menu; ?>"><a class="d-flex align-items-center" href="#"><i data-feather="briefcase"></i><span class="menu-title text-truncate" data-i18n="invoice">Invoice</span></a>
                <ul class="menu-content">
                    <li class="<?php echo ((strstr($_GET['pages'], "invoice/create"))) ? 'active' : ''; ?>"><a class="d-flex align-items-center" href="./?pages=invoice/create"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="invoice">สร้าง Invoice</span></a>
                    </li>
                    <li class="<?php echo ((strstr($_GET['pages'], "invoice/list"))) ? 'active' : ''; ?>"><a class="d-flex align-items-center" href="./?pages=invoice/list"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="invoice">Invoice List</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?php echo $guide_menu; ?>"><a class="d-flex align-items-center" href="#"><i data-feather="briefcase"></i><span class="menu-title text-truncate" data-i18n="receipt">Receipt</span></a>
                <ul class="menu-content">
                    <li class="<?php echo ((strstr($_GET['pages'], "receipt/create"))) ? 'active' : ''; ?>"><a class="d-flex align-items-center" href="./?pages=receipt/create"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="receipt">สร้าง Receipt</span></a>
                    </li>
                    <li class="<?php echo ((strstr($_GET['pages'], "receipt/list"))) ? 'active' : ''; ?>"><a class="d-flex align-items-center" href="./?pages=receipt/list"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="receipt">Receipt List</span></a>
                    </li>
                </ul>
            </li>

            <?php if (($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) && empty($guide_menu)) { ?>
                <li class="navigation-header"><span data-i18n="Report">Report</span><i data-feather="more-horizontal"></i></li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "report/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=report/list"><i data-feather='file-text'></i><span class="menu-title text-truncate" data-i18n="Report">Report</span></a>
                </li>
            <?php } ?>

            <li class="navigation-header <?php echo $guide_menu; ?>"><span data-i18n="Product">Programe</span><i data-feather="more-horizontal"></i></li>
            <li class="nav-item <?php echo $guide_menu; ?> <?php echo (strstr($_GET['pages'], "tour/")) ? 'active' : ''; ?>">
                <a class="d-flex align-items-center" href="./?pages=tour/list"><i data-feather='package'></i><span class="menu-title text-truncate" data-i18n="Tour">Programe</span></a>
            </li>

            <?php if (($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) && empty($guide_menu)) { ?>
                <li class="navigation-header"><span data-i18n="Supplier &amp; Agent">Supplier &amp; Agent</span><i data-feather="more-horizontal"></i></li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "agent/") && (strstr($_GET['pages'], "order-agent/") == false)) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=agent/list"><i data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Agent">Agent</span></a>
                </li>
            <?php } ?>

            <?php if (($_SESSION["supplier"]["role_id"] == 1 || $_SESSION["supplier"]["role_id"] == 2) && empty($guide_menu)) { ?>
                <li class="navigation-header"><span data-i18n="Configuration">Configuration</span><i data-feather="more-horizontal"></i></li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "branch/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=branch/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="branch">สาขา</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Car">Car</span></a>
                    <ul class="menu-content">
                        <li <?php echo (strstr($_GET['pages'], "car/")) ? 'class="active"' : ''; ?>><a class="d-flex align-items-center" href="./?pages=car/list"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Car List">Car List</span></a>
                        </li>
                        <li <?php echo (strstr($_GET['pages'], "car-category/")) ? 'class="active"' : ''; ?>><a class="d-flex align-items-center" href="./?pages=car-category/list"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Car Category">Car Category</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Boat">Boat</span></a>
                    <ul class="menu-content">
                        <li <?php echo (strstr($_GET['pages'], "boat/") && (strstr($_GET['pages'], "order-boat") == false) && (strstr($_GET['pages'], "order-job-boat") == false)) ? 'class="active"' : ''; ?>><a class="d-flex align-items-center" href="./?pages=boat/list"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Boat List">Boat List</span></a>
                        </li>
                        <li <?php echo (strstr($_GET['pages'], "boat-type/")) ? 'class="active"' : ''; ?>><a class="d-flex align-items-center" href="./?pages=boat-type/list"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Boat Type">Boat Type</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "driver/") && (strstr($_GET['pages'], "order-driver") == false)) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=driver/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Driver">Driver</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "captain/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=captain/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Captain">Captain</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "crew/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=crew/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Crew">Crew</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "guide/")) && (strstr($_GET['pages'], "order-guide/") == false) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=guide/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Guide">Guide</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "province/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=province/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Province">Province</span></a>
                </li>

                <li class="nav-item <?php echo (strstr($_GET['pages'], "hotel/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=hotel/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Hotel">Hotel</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "zone/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=zone/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Zone">Zone</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "park/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=park/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Park">Park</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "extra_charge/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=extra_charge/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Extra Charge">Extra Charge</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "category-items/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=category-items/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Category Items">Category Items</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "bank/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=bank/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Bank">Bank</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "bank-account/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=bank-account/list"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Bank Account">Bank Account</span></a>
                </li>
                <li class="navigation-header"><span data-i18n="User">User</span><i data-feather="more-horizontal"></i></li>
                <li class="nav-item <?php echo (strstr($_GET['pages'], "user/")) ? 'active' : ''; ?>">
                    <a class="d-flex align-items-center" href="./?pages=user/list"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="User">User</span></a>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>
<div class="header navbar navbar-inverse navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <div class="navbar-inner">
            <div class="container-fluid">
                <a href="/" class="brand">
                    &nbsp;&nbsp;&nbsp;<b>网心工单系统</b>
                </a>
                <ul class="nav pull-right">
                    <li class="dropdown user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img alt="" src="/img/avatar1_small.jpg">
                        <span class="username">Bob Nilson</span>
                        <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="extra_profile.html"><i class="icon-user"></i> My Profile</a></li>
                            <li><a href="page_calendar.html"><i class="icon-calendar"></i> My Calendar</a></li>
                            <li><a href="inbox.html"><i class="icon-envelope"></i> My Inbox(3)</a></li>
                            <li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>
                            <li class="divider"></li>
                            <li><a href="extra_lock.html"><i class="icon-lock"></i> Lock Screen</a></li>
                            <li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
                <!-- END TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- END TOP NAVIGATION BAR -->
    </div>
<div class="clearfix">
</div>
<div class="page-container row-fluid">
    <div class="page-sidebar">
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <li>
                <div class="sidebar-toggler hidden-phone"></div>
            </li>
            {!! sidebar_build_menu(config_file('menu')) !!}
        </ul>
    </div>

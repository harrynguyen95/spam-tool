<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>SS</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Sik51</b> Spamer</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu" style="min-height: 50px;">
                    <?php $user = auth()->guard('web')->user(); ?>

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="min-height: 50px;">
                        <img src="{{ cxl_asset('backend/dist/img/admin.jpg') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{!! $user ? $user->name : "" !!}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ cxl_asset('backend/dist/img/admin.jpg') }}" class="img-circle" alt="User Image">

                            <p>
                                {!! $user ? $user->name : "" !!} - Admin
                                <small>Member since 2021</small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/user/profile" class="btn btn-default btn-flat">{{ t('Profile') }}</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

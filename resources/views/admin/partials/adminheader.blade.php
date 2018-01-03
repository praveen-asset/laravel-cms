<header class="main-header">
    <!-- Logo -->
    <a href="javascript:void(0)" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Admin</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b> Panel</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- <img src="{{ asset('admintheme/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image"> -->
                        <span class="hidden-xs">Administrator <i class="fa fa-angle-down pull-right"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                           <!--  <img src="{{ asset('admintheme/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image"> -->
                            <p>
                                {{ ucfirst(Auth::user()->first_name) }} 
                                {{ ucfirst(Auth::user()->last_name) }}<br>
                                {{ Auth::user()->email }}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url('admin/profile') }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                
            </ul>
        </div>
    </nav>
</header>

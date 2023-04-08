<nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <!-- ============================================================== -->
    <!-- Logo -->
    <!-- ============================================================== -->
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ route('admin.index')}}">
            <!-- Logo icon --><b class="hidden-lg-up">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img src="{{ url('public/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="hidden-lg-down">
                <!-- dark Logo text -->
                <img src="{{ url('public/assets/images/logo-white.png') }}" alt="homepage" class="dark-logo">
            </span>
        </a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav me-auto">
            <!-- This is  -->
            <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            <!-- <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li> -->
            <!-- ============================================================== -->
            
        </ul>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
        <ul class="navbar-nav my-lg-0">
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- User Profile -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown u-pro">
                <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="{{ url('public/assets/images/users/2.jpg') }}" alt="user" class=""> 
				<span class="hidden-md-down">{{ (!empty(Auth::user()->name))?Auth::user()->name:'' }} &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                <div class="dropdown-menu dropdown-menu-end animated flipInY">
				
                    <!-- text-->
					<a href="{{ route('admin.edit.profile',['id'=>Auth::user()->id]) }}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
						<a href="{{ route('admin.change.password',['id'=>Auth::user()->id]) }}" class="dropdown-item"><i class="ti-settings"></i> Change Password</a>
			        <div class="dropdown-divider"></div>
                    <!-- text-->
                   <!-- <a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>-->
                    <!-- text-->
                    <!-- text-->
                    <a href="{{ route('admin.auth.logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                    <!-- text-->
                </div>
            </li>
        </ul>
    </div>
</nav>
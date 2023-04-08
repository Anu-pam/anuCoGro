<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User Profile-->
        <div class="user-profile">
            <div class="user-pro-body">
                <div><img src="{{ url('public/assets/images/users/2.jpg') }}" alt="user-img" class="img-circle"></div>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $user->name }} <span class="caret"></span></a>
                    <div class="dropdown-menu animated flipInY">
                        <!-- text-->
                        <a href="{{ route('admin.edit.profile',['id'=>Auth::user()->id]) }}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
						<a href="{{ route('admin.change.password',['id'=>Auth::user()->id]) }}" class="dropdown-item"><i class="ti-settings"></i> Change Password</a>
                        <!-- text-->
                        <!--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>-->
                        <!-- text-->
                        <!--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>-->
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <!--<a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>-->
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="{{ route('admin.auth.logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                        <!-- text-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <div class="hide-menu text-center">
                        <div id="eco-spark"></div>
                        <small>TOTAL EARNINGS - JUNE 2018</small>
                        <h4>$2,478.00</h4>
                    </div>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{ route('admin.dashboard') }}" aria-expanded="false"><i class="icon-speedometer text-danger"></i><span class="hide-menu">Dashboard</span></a></li>
				<li> <a class="waves-effect waves-dark" href="{{ route('admin.users.list') }}" aria-expanded="false"><i class="ti-user text-danger"></i><span class="hide-menu">Users</span></a></li>
				<li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-speedometer"></i><span class="hide-menu">Services & Category <!--<span class="badge rounded-pill bg-cyan ms-auto">4</span></span>--></a>
                    <ul aria-expanded="false" class="collapse">
                        <!--<li><a href="eco-dashboard.html">Dashboard </a></li>-->
                        <li><a href="{{ route('admin.services.category.list') }}">Service Category</a></li>
						<li><a href="{{ route('admin.services.list') }}">Services</a></li>
                        <!--<li><a href="eco-products-detail.html">Products Details</a></li>
                        <li><a href="eco-products-edit.html">Products Edit</a></li>
                        <li><a href="eco-products-orders.html">Products Orders</a></li>
                        <li><a href="eco-products-cart.html">Products Cart</a></li>
                        <li><a href="eco-products-checkout.html">Products Cehckout</a></li>-->
                    </ul>
                </li>
				<li> <a class="waves-effect waves-dark" href="{{ route('admin.contactus.list') }}" aria-expanded="false"><i class="ti-user text-danger"></i><span class="hide-menu">Contact Us</span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
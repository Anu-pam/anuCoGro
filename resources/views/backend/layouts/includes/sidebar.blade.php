<aside class="left-sidebar">
<!-- Sidebar scroll-->
<div class="scroll-sidebar">
	<!-- Sidebar navigation-->
	<nav class="sidebar-nav">
		<ul id="sidebarnav">
			<li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><img src="../assets/images/users/1.jpg" alt="user-img" class="img-circle"><span class="hide-menu">Mark Jeckson</span></a>
				<ul aria-expanded="false" class="collapse">
					<li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
					<li><a href="javascript:void(0)"><i class="ti-wallet"></i> My Balance</a></li>
					<li><a href="javascript:void(0)"><i class="ti-email"></i> Inbox</a></li>
					<li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
					<li><a href="javascript:void(0)"><i class="fa fa-power-off"></i> Logout</a></li>
				</ul> 
			</li>
			<li class="nav-small-cap">--- PERSONAL</li>
			<li> <a class="waves-effect waves-dark" href="{{ route('admin.dashboard') }}" aria-expanded="false"><i class="icon-speedometer"></i><span class="hide-menu">Dashboard <span class="badge rounded-pill bg-cyan ms-auto">4</span></span></a>
			<li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-align-left"></i><span class="hide-menu">Master List</span></a>
                <ul aria-expanded="false" class="collapse">
			    	<li><a href="{{ route('admin.users.list') }}">Staff Management</a></li>
                    <li><a href="{{ route('admin.services.category.list') }}">Professional Type</a></li>
					<li><a href="{{ route('admin.services.list') }}">Global Services</a></li>
					<li><a href="{{ route('admin.setting.create') }}">Settings</a></li>
                    
                </ul>
            </li>
			<!-- <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Staffs</span></a>
                <ul aria-expanded="false" class="collapse">
                    <li><a href="{{ route('admin.users.list') }}">Staff Management</a></li>
                    <li><a href="#">Roles Management</a></li>
                    
                </ul>
             </li> -->
			
			 <!-- <li> <a class="waves-effect waves-dark" href="{{ route('admin.services.list') }}" aria-expanded="false"><i class="ti-layout-grid2"></i></i><span class="hide-menu">Services <span class="badge rounded-pill bg-cyan ms-auto">4</span></span></a> -->
			 <li> <a class="waves-effect waves-dark" href="{{ route('admin.customerlist.list') }}" aria-expanded="false"><i class="ti-user text-danger"></i></i><span class="hide-menu">Customer <span class="badge rounded-pill bg-cyan ms-auto">4</span></span></a>
			 <li> <a class="waves-effect waves-dark" href="{{ route('admin.professionalist.list') }}" aria-expanded="false"><i class="ti-user text-danger"></i></i><span class="hide-menu">Professionals <span class="badge rounded-pill bg-cyan ms-auto">4</span></span></a>
			 <li> <a class="waves-effect waves-dark" href="{{ route('admin.contactus.list') }}" aria-expanded="false"><i class="ti-headphone text-danger"></i></i><span class="hide-menu">Contact Us <span class="badge rounded-pill bg-cyan ms-auto">4</span></span></a>
			 <li> <a class="waves-effect waves-dark" href="{{ route('admin.orders.list') }}" aria-expanded="false"><i class="ti-bar-chart text-danger"></i></i><span class="hide-menu">Bookings <span class="badge rounded-pill bg-cyan ms-auto">4</span></span></a>
			 <li> <a class="waves-effect waves-dark" href="{{ route('admin.review.list') }}" aria-expanded="false"><i class="ti-star text-danger"></i></i><span class="hide-menu">Review <span class="badge rounded-pill bg-cyan ms-auto">4</span></span></a>
			
		</ul>
	</nav>
	<!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->
</aside>
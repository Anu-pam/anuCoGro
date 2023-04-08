<header id="header" class="fixed-top">
  <div class="container custom-container">
	<div class="row justify-content-md-center align-items-md-center">
	  <div class="logo col-md-3 col-xl-2 d-flex justify-content-start align-items-center">
		<a href="{{ url('') }}">
		  <img class="img-fluid logo-img" src="{{ url('public/front/assets/images/logo-white.png') }}" alt="Groom Me">
		  <img class="img-fluid logo-sticky" src="{{ url('public/front/assets/images/logo.png') }}" alt="Groom Me">
		</a>
	  </div>
	  <div class="col-md-9 col-xl-10 px-lg-3 p-0">
		<div class="mobile-menu"></div>
		<nav id="main-menu">
		  <ul>
			<!-- <li><a href="#" class="selected">Home</a></li> -->
			<li><a href="{{ url('/') }}">Home</a></li>
			<li><a href="{{ url('/about-us') }}">About Us</a></li>
			<!-- <li><a href="#">Services
				<i class="fas fa-angle-down ml-2"></i>
			  </a>
			  <ul>
				<li><a href="#">Barber</a></li>
				<li><a href="#">Hairstylist</a></li>
				<li><a href="#">Nails</a></li>
				<li><a href="#">Makeup</a></li>
				<li><a href="#">Lash/Eyebrows</a></li>
				<li><a href="#">Massage</a></li>
				<li><a href="#">Hair Removal</a></li>
				<li><a href="#">Facials</a></li>
				<li><a href="#">Spray Tan</a></li>
			  </ul>
			</li> -->
			<li><a href="{{ url('/become-a-partner') }}">Become a Partner</a></li>
			<li><a href="{{ url('/faq') }}">Faq</a></li>
			<li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
		  </ul>
		</nav>
	  </div>
	</div>
  </div>
</header>
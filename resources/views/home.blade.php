@extends('layouts.app')
@section('content')
<!-- Banner -->
<div id="banner" class="overlay">
  <img src="{{ url('public/front/assets/images/banner/banner.jpg') }}" alt="Start Up For Your App" class="img-fluid">
  <div class="description absolute-center">
	<div class="container">
	  <div class="row">
		<div class="col-lg-6">
		  <img class="img-fluid d-none" src="assets/images/mobile-half.png" alt="Image">
		</div>
		<div class="col-lg-6">
		  <h1>GROOM<br /> TIME!! </h1>
		  <p>An app that effortlessly connects customers with cosmetic industry professionals.</p>
		  <a href="#" class="btn btn-outline-secondary btn-icon mr-sm-3 mr-md-4">
			<span class="icon"><i class="fab fa-apple"></i></span>
			<span>get it on<br />app store</span></a>
		  <a href="#" class="btn btn-outline-secondary btn-icon btn-android">
			<span class="icon"><i class="fab fa-android"></i></span>
			<span>get it on<br />
			  google play</span></a>
		</div>
	  </div>
	</div>
  </div>
</div>
<!-- Banner -->
<!-- Content -->
<div id="content">
  <!-- Our Services -->
  <section class="section our-services bg-pattern pb-0">
	<div class="container position-relative">
	  <div class="section-head">
		<h2 class="h1">Our Services</h2>
		<p>Groom Me offers a wide range of services in the hair and cosmetic industry. <br/>Below is a list of services we currently offer.</p>
	  </div>
	  <ul class="services-list">
		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/salon.png') }}" alt="Barber">
			</span>
			<div class="content-block">
			  <h5>Barber</h5>
			  <p>The Barber is one whose business is cutting and dressing hair, shaving and trimming beards, and
				performing related services.</p>
			</div>
		  </div>
		</li>

		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/bun.png') }}" alt="Hairstylist">
			</span>
			<div class="content-block">
			  <h5>Hairstylist</h5>
			  <p>The Hairstylist is a person whose occupation is the cutting and arranging of hair, a person who
				does creative cutting and styling of hair.</p>
			</div>
		  </div>
		</li>

		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/nail-polish.png') }}" alt="nails">
			</span>
			<div class="content-block">
			  <h5>nails</h5>
			  <p>A manicure or pedicure is a mostly cosmetic beauty treatment for the fingernails or toenails
				performed at home or at a nail salon.</p>
			</div>
		  </div>
		</li>

		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/makeup.png') }}" alt="makeup">
			</span>
			<div class="content-block">
			  <h5>makeup</h5>
			  <p>Makeup artists are experts at using make-up compounds to tint, conceal, or otherwise alter a
				person’s look for the purpose of beatification.</p>
			</div>
		  </div>
		</li>

		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/mascara.png') }}" alt="lashes/eyebrows">
			</span>
			<div class="content-block">
			  <h5>lashes/eyebrows</h5>
			  <p>
				An eyelash technician specialises in treatment that improves the appearance of our lashes as well as
				applying lash extensions and tinting.
				Microblading is a technique that creates semipermanent eyebrow tattoos. It uses a pen-like tool with
				tiny needles that add pigment to someone’s eyebrows. Microbladed eyebrows usually last about just
				over one year.
			  </p>
			</div>
		  </div>
		</li>

		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/body-massage.png') }}" alt="massage">
			</span>
			<div class="content-block">
			  <h5>massage</h5>
			  <p>A massage therapist is a trained individual who is licensed or certified to therapeutically
				manipulate the muscles and other soft tissues of the body using both hands or instrument.</p>
			</div>
		  </div>
		</li>

		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/hair-removal.png') }}" alt="hair removal">
			</span>
			<div class="content-block">
			  <h5>hair removal</h5>
			  <p>Hair Removal, also known as epilation or depilation, is the deliberate removal of body hair or head
				hair. Hair typically grows all over the human body and can vary in thickness and length across human
				populations.</p>
			</div>
		  </div>
		</li>

		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/facial-treatment.png') }}" alt="facials">
			</span>
			<div class="content-block">
			  <h5>facials</h5>
			  <p>A facial is defined as a beauty treatment that is designed to exfoliate, invigorate or treat the
				skin or face.</p>
			</div>
		  </div>
		</li>

		<li class="item">
		  <div class="list-item">
			<span class="icon-circle">
			  <img class="img-fluid" src="{{ url('public/front/assets/images/spray.png') }}" alt="spray tan">
			</span>
			<div class="content-block">
			  <h5>spray tan</h5>
			  <p>A spray tan is a beauty treatment in which the body is sprayed with a product containing chemicals
				that react with the skin to produce an artificial suntan.</p>
			</div>
		  </div>
		</li>

	  </ul>
	  <figure class="figure text-center mb-0">
		<img class="img-fluid" src="{{ url('public/front/assets/images/mobile-flat.png') }}" alt="Mobile">
	  </figure>
	</div>
  </section>
  <!-- /Our Services -->
  <!-- Choose Me -->
  <section class="section choose-me">
	<div class="container-fluid p-0 owl-carousel slideshow owl-theme">
	  <div class="row no-gutters justify-content-md-center match-height">
		<div class="col-md-6 order-md-2 column">
		  <div class="description bg-primary h-100 d-md-flex align-items-md-center">
			<div class="inner">
			  <h2>Why groom me?</h2>
			  <p>Tired of booking appointments? </p>
			  <p>Choose your service and let the appointments come to you.</p>
			</div>
		  </div>
		</div>
		<div class="col-md-6 order-md-1 column">
		  <figure class="figure2 mb-0">
			<img class="img-fluid" src="{{ url('public/front/assets/images/image1.jpg') }}" alt="Image">
		  </figure>
		</div>
	  </div>

	  <div class="row no-gutters justify-content-md-center match-height">
		<div class="col-md-6 order-md-2 column">
		  <div class="description bg-primary h-100 d-md-flex align-items-md-center">
			<div class="inner">
			  <h2>Are you satisfied?</h2>
			  <p>Have you had enough of trying out different salon/spa or barber services, only to be disappointed?
			  </p>
			  <p>Now you can browse a list of professionals in your area that have been rated by other customers and
				eliminate the guessing game.</p>
			</div>
		  </div>
		</div>
		<div class="col-md-6 order-md-1 column">
		  <figure class="figure2 mb-0">
			<img class="img-fluid" src="{{ url('public/front/assets/images/image2.jpg') }}" alt="Image">
		  </figure>
		</div>
	  </div>

	  <div class="row no-gutters justify-content-md-center match-height">
		<div class="col-md-6 order-md-2 column">
		  <div class="description bg-primary h-100 d-md-flex align-items-md-center">
			<div class="inner">
			  <h2>Hassle Free</h2>
			  <p>You can now sit back and book appointments conveniently with this app by locating your nearest
				professional with the highest ratings, let us do the research for you.</p>
			</div>
		  </div>
		</div>
		<div class="col-md-6 order-md-1 column">
		  <figure class="figure2 mb-0">
			<img class="img-fluid" src="{{ url('public/front/assets/images/image3.jpg') }}" alt="Image">
		  </figure>
		</div>
	  </div>

	  <div class="row no-gutters justify-content-md-center match-height">
		<div class="col-md-6 order-md-2 column">
		  <div class="description bg-primary h-100 d-md-flex align-items-md-center">
			<div class="inner">
			  <h2>Safety</h2>
			  <p>With the ongoing concern of Covid-19,limit your exposure to crowded salons/spas and barbershops
				byenjoying one on one appointments in the safety of your own home, or by booking dedicated on the
				spot appointments at your nearest salon/spa or barber shop.</p>
			</div>
		  </div>
		</div>
		<div class="col-md-6 order-md-1 column">
		  <figure class="figure2 mb-0">
			<img class="img-fluid" src="{{ url('public/front/assets/images/image4.jpg') }}" alt="Image">
		  </figure>
		</div>
	  </div>
	</div>
  </section>
  <!-- /Choose Me -->
  <!-- Screenshots -->
  <section class="section screenshots pb-sm-0">
	<div class="container pb-sm-5">
	  <div class="section-head">
		<h2 class="h1">Screenshots</h2>
		<p>The Groom Me App is available for download, we have included screenshots of our app below.</p>
	  </div>
	</div>
	<div class="owl-carousel slideshow-2 owl-theme">
	  <div class="screenshot-image">
		<img class="img-fluid" src="{{ url('public/front/assets/images/screenshot/1.png') }}" alt="Image">
	  </div>
	  <div class="screenshot-image">
		<img class="img-fluid" src="{{ url('public/front/assets/images/screenshot/3.png') }}" alt="Image">
	  </div>
	  <div class="screenshot-image">
		<img class="img-fluid" src="{{ url('public/front/assets/images/screenshot/4.png') }}" alt="Image">
	  </div>
	  <div class="screenshot-image">
		<img class="img-fluid" src="{{ url('public/front/assets/images/screenshot/5.png') }}" alt="Image">
	  </div>
	  <div class="screenshot-image">
		<img class="img-fluid" src="{{ url('public/front/assets/images/screenshot/6.png') }}" alt="Image">
	  </div>
	  <div class="screenshot-image">
		<img class="img-fluid" src="{{ url('public/front/assets/images/screenshot/7.png') }}" alt="Image">
	  </div>
	  <div class="screenshot-image">
		<img class="img-fluid" src="{{ url('public/front/assets/images/screenshot/8.png') }}" alt="Image">
	  </div>
	</div>
  </section>
  <!-- /Screenshots -->
  <!-- Download App -->
  <section class="section download-app pb-0">
	<div class="container text-center text-md-left">
	  <div class="row align-items-md-center">
		<div class="col-md-6 col-lg-4 col-xl-5 order-md-2">
		  <h3>Download our app</h3>
		  <p>Our App gives you access to your favorite
			professional’s salon services in your area.
		  </p>
		  <a href="#" class="btn-download mr-3 mr-lg-4" target="_blank"><img class="img-fluid"
			  src="{{ url('public/front/assets/images/app-store.png') }}" alt="App Store"></a>
		  <a href="#" class="btn-download" target="_blank"><img class="img-fluid"
			  src="{{ url('public/front/assets/images/google-play.png') }}" alt="Google Play"></a>
		</div>
		<div class="col-md-6 col-lg-5 col-xl-5 order-md-1">
		  <div class="figure3">
			<img class="img-fluid" src="{{ url('public/front/assets/images/screenshot/1.png') }}" alt="Screenshot">
			<img class="img-fluid image2 wow bounceInLeft" src="{{ url('public/front/assets/images/screenshot/1.png') }}" alt="Screenshot">
		  </div>
		</div>
	  </div>
	</div>
  </section>
  <!-- /Download App -->
</div>
<!-- /content -->
@endsection
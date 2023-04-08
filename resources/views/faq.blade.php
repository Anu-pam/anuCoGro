@extends('layouts.app')
@section('content')
<!-- Banner -->
<div id="banner" class="style2 overlay">
  <img src="{{ url('public/front/assets/images/banner/faq.jpg') }}" alt="FAQ" class="img-fluid">
  <div class="description absolute-center">
	<div class="container text-center">
	  <h1 class="mb-0">FAQs</h1>
	</div>
  </div>
</div>
<!-- Banner -->
<!-- Content -->
<div id="content">
  <!-- Faq -->
  <section class="section faq">
	<div class="container">
	  <div class="section-head">
		<h3>Frequently Asked Questions</h3>
		<p>Starting to use a new product or service might be a bit confusing and we’re happy to assist our customers
		  and partners when
		  they take their first steps with Groom Me. Below you can find the answers to the most frequently asked
		  questions we’re receiving
		  from our customers and partners.</p>
	  </div>
	  <div class="accordion" id="faqGroomMe">
		<div class="card">
		  <div class="card-header" id="headingOne">
			<h5 class="mb-0">
			  <a href="#" class="clearfix" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
				aria-controls="collapseOne">
				How to request a service?
				<i class="arrow float-right"></i>
			  </a>
			</h5>
		  </div>

		  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>
				To request a service, follow the steps below:<br />
				-When opening the app, click ‘Live Mobile’ and or ‘Live Stationary’. The app will then list your
				service professional’s location via GPS;<br />
				-If you need to change the location, type in your exact address.<br />
				-Click ‘Request (your service professional’s name)’.<br />
				-Choose the service that your service professional provides.<br />
				-Click on ‘Checkout and your total will be calculated.<br />
				-Confirm your order, and the map will provide you with a detailed time and the exact route to your
				location.
			  </p>
			</div>
		  </div>
		</div>
		<div class="card">
		  <div class="card-header" id="headingTwo">
			<h5 class="mb-0">
			  <a class="clearfix collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
				aria-expanded="false" aria-controls="collapseTwo">
				How are the fees calculated?
				<i class="icon arrow float-right"></i>
			  </a>
			</h5>
		  </div>
		  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>The fees are calculated into the price of the service. All professionals are responsible for
				setting their own prices which may vary between each professional.
			  </p>
			  <p>Fees are solely dependent of the types of services provided by your service professional.
				There is a % fee on all transactions. The fee is subject to change at any given time but is a
				standard fee that applies to all services.
			  </p>
			</div>
		  </div>
		</div>
		<div class="card">
		  <div class="card-header" id="headingThree">
			<h5 class="mb-0">
			  <a class="clearfix collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
				aria-expanded="false" aria-controls="collapseThree">
				Can I take I book a service professional outside of Ontario?
				<i class="icon arrow float-right"></i>
			  </a>
			</h5>
		  </div>
		  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>No. As of right now, Groom Me is focused on providing services within the GTA and surrounding areas
				in Ontario. We will be looking to expand our services in the near future.
			  </p>
			</div>
		  </div>
		</div>
		<div class="card">
		  <div class="card-header" id="headingFour">
			<h5 class="mb-0">
			  <a href="#" class="clearfix" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
				aria-controls="collapseFour">
				Is it possible to book future appointments?
				<i class="arrow float-right"></i>
			  </a>
			</h5>
		  </div>

		  <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>Yes. We understand the importance of booking future appointments for our customers. With the
				‘Scheduling’ feature, it allows customers to choose to book in-home services or in-shop services
				with your favourite service professionals.
			  </p>
			</div>
		  </div>
		</div>
		<div class="card">
		  <div class="card-header" id="headingFive">
			<h5 class="mb-0">
			  <a href="#" class="clearfix" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
				aria-controls="collapseFive">
				What is a cancellation fee? <i class="arrow float-right"></i>
			  </a>
			</h5>
		  </div>

		  <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>At Groom Me we appreciate our partners’ time and we always compensate the lost time spent on the
				road.
				A cancellation fee of $10 CAD will be charged to the customer for any cancelled appointments.
				This compensates our partners for any commute fees and inconveniences.
			  </p>
			</div>
		  </div>
		</div>
		<div class="card">
		  <div class="card-header" id="headingSix">
			<h5 class="mb-0">
			  <a href="#" class="clearfix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true"
				aria-controls="collapseSix">
				How do I choose the right service professional?
				<i class="arrow float-right"></i>
			  </a>
			</h5>
		  </div>

		  <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>This is the brilliance of the app. Service professionals have been rated by past customer
				experiences.
				This gives the customer a peace of mind when making their selection.
			  </p>
			</div>
		  </div>
		</div>

		<div class="card">
		  <div class="card-header" id="headingSeven">
			<h5 class="mb-0">
			  <a href="#" class="clearfix" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true"
				aria-controls="collapseSeven">
				How can I get free service?
				<i class="arrow float-right"></i>
			  </a>
			</h5>
		  </div>

		  <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>Easy, with each transaction made on the app you can earn ‘Groom Me Rewards’.
				Use these rewards to pay for your next service.
			  </p>
			</div>
		  </div>
		</div>
		<div class="card">
		  <div class="card-header" id="headingEight">
			<h5 class="mb-0">
			  <a href="#" class="clearfix" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true"
				aria-controls="collapseEight">
				How to change the language settings on the app?
				<i class="arrow float-right"></i>
			  </a>
			</h5>
		  </div>

		  <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>Groom Me app automatically sets the language based on the language settings of your device.
				In order to change the language of the application, you will need to change the language settings on
				your smartphone.
			  </p>
			</div>
		  </div>
		</div>
		<div class="card">
		  <div class="card-header" id="headingNine">
			<h5 class="mb-0">
			  <a href="#" class="clearfix" data-toggle="collapse" data-target="#collapseNine" aria-expanded="true"
				aria-controls="collapseNine">
				Can I pay in cash?
				<i class="arrow float-right"></i>
			  </a>
			</h5>
		  </div>

		  <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>No. Payments are made in advance and held by Groom Me until the customer has clicked the ‘Complete
				Service Button’.
				We give 12 hrs to dispute the service, if not, Groom Me will complete the transaction on the
				customer’s behalf.
			  </p>
			</div>
		  </div>
		</div>
		<div class="card">
		  <div class="card-header" id="headingTen">
			<h5 class="mb-0">
			  <a href="#" class="clearfix" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true"
				aria-controls="collapseTen">
				How can I become a Groom Me Partner?
				<i class="arrow float-right"></i>
			  </a>
			</h5>
		  </div>

		  <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#faqGroomMe">
			<div class="card-body">
			  <p>To become a partner, please complete the ‘become a partner’ form on our website: goommetech.com
			  </p>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </section>
  <!-- /Faq -->
</div>
<!-- /content -->
@endsection
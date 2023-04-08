@extends('layouts.app')
@section('content')
<!-- Banner -->

<div id="banner" class="overlay dark-2">
  <img src="{{ url('public/front/assets/images/banner/email-confirmation.jpg') }}" alt="Start Up For Your App" class="img-fluid">
  <div class="description absolute-center">
	<div class="container">
	  <div class="row">
		<div class="col-lg-8 text-lg-left text-center">
		  <h1 class="font-weight-bold">Thanks for your<br /> email confirmation! </h1>
		  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit ut aliquam, purus sit amet luctus venenatis, The point of using Lorem Ipsum is that it has a more-or-less normal.</p>
          <a href="#" class="btn btn-success btn-rounded">More Info</a>
		</div>
	  </div>
	</div>
  </div>
</div>
<!-- Banner -->
<!-- Content -->
<div id="content">
<!-- Section -->
<section class="section">
	<div class="container text-center">
		<div class="section-head">
			<h2 class="h2">Find the perfect services in the hair and cosmetic industry</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit ut aliquam, purus sit amet luctus venenatis, lectus magna fringilla urna, porttitor</p>
			<a href="#" class="btn btn-primary btn-rounded">Click here <i class="fa fa-long-arrow-alt-right ml-2"></i></a>
		</div>
	</div>
</section>
<!-- /Section -->
</div>
<!-- /content -->
@endsection

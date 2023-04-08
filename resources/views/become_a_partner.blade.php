@extends('layouts.app')
@section('content')
<!-- Banner -->
<div id="banner" class="style2 overlay">
  <img src="{{ url('public/front/assets/images/banner/become-a-partner.jpg') }}" alt="Become a Partner" class="img-fluid">
  <div class="description absolute-center">
	<div class="container text-center">
	  <h1 class="mb-0">Become a Partner</h1>
	</div>
  </div>
</div>
<!-- Banner -->
<!-- Content -->
<div id="content">
  <!-- Become a Partner -->
  <section class="section become-a-partner bg-light">
	<div class="container">
	  <div class="section-head">
		<h3>Grow Your Business With Us</h3>
	  </div>
	  <form action="{{ route('partner.post') }}" method="post" class="form box-shadow p-4 p-md-5" id="professional-form">
	  @csrf
		<div class="row">
		  <div class="col-md-6">
			<div class="form-group">
			  <label class="icon" for="name"><i class="fas fa-user"></i></label>
			  <input class="form-control" type="text" name="name" id="name" placeholder="Name" value="{{ old('name') }}" required data-parsley-error-message="The name field is required."/>
			  @if($errors->has('name')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('name') }}</span> @endif
			</div>
		  </div>
		  <div class="col-md-6">
			<div class="form-group">
			  <label class="icon" for="business"><i class="fa fa-suitcase-rolling"></i></label>
			  <input class="form-control" type="text" name="business" id="business" placeholder="Business" value="{{ old('business') }}" required />
			  @if($errors->has('business')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('business') }}</span> @endif
			</div>
		  </div>
		</div>
		<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			  <label class="icon" for="email"><i class="fas fa-envelope"></i></label>
			  <input class="form-control" type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required />
			  @if($errors->has('email')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('email') }}</span> @endif
			</div>
		  </div>
		  
		  <div class="col-md-6">
			<div class="form-group">
			  <label class="icon" for="phone"><i class="fas fa-mobile-alt"></i></label>
			  <input class="form-control" type="tel" name="phone" id="phone" placeholder="Phone"  value="{{ old('phone') }}" required data-parsley-type="number" />
			  @if($errors->has('phone')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('phone') }}</span> @endif
			</div>
		  </div>
		</div>
		<div class="row">
		  <div class="col-md-6">
			<div class="form-group">
			  <label class="icon" for="address"><i class="fa fa-map-marker-alt"></i></label>
			  <input class="form-control" type="text" name="address" id="address" placeholder="Address" value="{{ old('address') }}" required />
			  @if($errors->has('address')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('address') }}</span> @endif
			</div>
		  </div>
		  <div class="col-md-6">
			<div class="form-group">
			  <label class="icon" for="city"><i class="fa fa-map-marker-alt"></i></label>
			  <input class="form-control" type="text" name="city" id="city" placeholder="City" value="{{ old('city') }}" required />
			  @if($errors->has('city')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('city') }}</span> @endif
			</div>
		  </div>
		  <div class="col-md-6">
			<div class="form-group">
			  <label class="icon" for="postcode"><i class="fa fa-map-marker-alt"></i></label>
			  <input class="form-control" type="text" name="postcode" id="postcode" placeholder="Postal Code" value="{{ old('postcode') }}" required />
			  @if($errors->has('postcode')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('postcode') }}</span> @endif
			</div>
		  </div>
		 
		  
		  <div class="col-md-6 d-none">
			<div class="form-group">
			  <label class="icon" for="service"><i class="fa fa-gift-card"></i></label>
			  <input class="form-control" type="text" name="service" id="service" placeholder="Service Provided" />
			</div>
		  </div>
		</div>
		
		<div class="form-group">
		  <textarea name="message" id="message" class="form-control" placeholder="Comments"></textarea>
		</div>
		<div class="row">
		 <div class="col-md-6 captcha">
			<span>{!! captcha_img() !!}</span>
				<button type="button" class="btn btn-primary btn-sm" class="reload" id="reload">
				&#x21bb;
				</button>
		  </div>
		  <div class="col-md-6">
		  <div class="form-group">
		    <label class="icon" for="captcha"><i class="fas fa-user-secret"></i></label>
			<input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" id="captcha" required>
			@if($errors->has('captcha')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('captcha') }}</span> @endif
			</div>
		  </div>
		</div>
		<input type="hidden" name="latitude" id="latitude"/>
		<input type="hidden" name="longitude" id="longitude"/>
		<button type="submit" class="btn btn-primary btn-block">Submit</button>
	  </form>
	</div>
  </section>
  <!-- /Become a Partner -->
</div>
<!-- /content -->
@endsection
@section('extrascript')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCm6mWmbHn1gBp0BtAVEhA3jZjY9J0blrQ&libraries=places"></script>
    <script type="text/javascript">
	   $(document).ready(function() {
			$('#professional-form').parsley();
		});
         function initialize() {
			  var input = document.getElementById('address');
			  var options = {
				types: ['address'],
				componentRestrictions: {
				  country: 'ca'
				}
			  };
			  autocomplete = new google.maps.places.Autocomplete(input, options);
			  autocomplete.addListener('place_changed', function () {
				var place = autocomplete.getPlace();
				// place variable will have all the information you are looking for.
				 
				  document.getElementById("latitude").value = place.geometry['location'].lat();
				  document.getElementById("longitude").value = place.geometry['location'].lng();
				});
			}
         google.maps.event.addDomListener(window, "load", initialize);
	     $('#reload').click(function () {
			$.ajax({
				type: 'GET',
				url: "{{ route('reload-captcha') }}",
				success: function (data) {
					$(".captcha span").html(data.captcha);
				}
			});
    });
    </script>

@endsection

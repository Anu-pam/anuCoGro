@extends('backend.layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Edit Customer User</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.customerlist.list') }}">Customer User List</a></li>
				<li class="breadcrumb-item active">Edit Customer User</li>
			</ol>
			
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
	<div class="col-12">
	   <div class="card">
			<div class="card-body">
				<h4 class="card-title">Edit Customer User</h4>
				<form method="post" action="{{ route('admin.customerlist.update',['id'=>$getUser->id])}}" enctype="multipart/form-data" id="staff-form">
				@csrf
				@if($errors->any())
					<div class="alert alert-danger" role="alert">
						{{ $errors->first() }}
					</div>
				@endif
					<div class="row">
						<div class="col-md-6">
						    <label class="form-label">Name</label>
							<input class="form-control" type="text" name="name" placeholder="Enter Name" value="{{ !empty($getUser->name) ? $getUser->name : ''}}" required data-parsley-error-message="The name field is required.">
                            @if($errors->has('name')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('name') }}</span> @endif
						</div>
						<div class="col-md-6">
						    <label class="form-label">Email</label>
							<input class="form-control" type="email" name="email" placeholder="Enter Email" value="{{ !empty($getUser->email) ? $getUser->email : ''}}" required data-parsley-error-message="The email should be a valid email.">
							@if($errors->has('email')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('email') }}</span> @endif
         
						</div>
						

						<div class="col-md-6 mt-3">
							<div class="form-group">
								<label class="form-label">Image Upload</label>
								<input type="file" class="form-control" name="image" onChange="preview_image(event,'display_image')">
								<img src="{{ !empty($getUser->userProfileImages->image) ? url('public'.$getUser->userProfileImages->image) : url('public/assets/images/users/2.jpg')   }}" height="50px" width="50px" id="display_image">
							</div>
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Location</label>
							<input class="form-control" type="text" name="address" id="address" placeholder="Enter Location" required data-parsley-error-message="The location field is required." value="{{ !empty($getUser->userCustomerDetails->location) ? $getUser->userCustomerDetails->location : old('address') }}">
                            @if($errors->has('address')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('address') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">City</label>
							<input class="form-control" type="text" name="city" id="city" placeholder="Enter City" required data-parsley-error-message="The city field is required." value="{{ !empty($getUser->userCustomerDetails->city) ? $getUser->userCustomerDetails->city : old('city') }}">
                            @if($errors->has('city')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('city') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Postal Code</label>
							<input class="form-control" type="text" name="postcode" id="postcode" placeholder="Enter Postal Code" required data-parsley-error-message="The postal code field is required." value="{{ !empty($getUser->userCustomerDetails->postcode) ? $getUser->userCustomerDetails->postcode  : old('postcode') }}" value="{{ old('city') }}">
                            @if($errors->has('postcode')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('postcode') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Phone No</label>
							<input class="form-control" type="text" name="phone" placeholder="Enter Phone No" required data-parsley-error-message="The phone no field is required." value="{{ !empty($getUser->userCustomerDetails->phone_no) ? $getUser->userCustomerDetails->phone_no  : old('phone') }}">
                            @if($errors->has('phone')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('phone') }}</span> @endif
						</div>
					
						<div class="col-12">
							<div class="d-md-flex align-items-center mt-3">
								<a href="{{ route('admin.customerlist.list')}}" class="btn btn-dark">Cancel</a>
								<div class="ms-auto mt-3 mt-md-0">
								<input type="hidden" name="latitude" id="latitude" value="{{ !empty($getUser->userCustomerDetails->latitude) ? $getUser->userCustomerDetails->latitude : '' }}"/>
		                        <input type="hidden" name="longitude" id="longitude" value="{{ !empty($getUser->userCustomerDetails->longitude) ? $getUser->userCustomerDetails->longitude : '' }}"/>
									<button type="submit"
										class="btn btn-primary text-white">Submit</button>
								</div>
							</div>
						</div>
						
						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->

@endsection
@section('extrascript')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCm6mWmbHn1gBp0BtAVEhA3jZjY9J0blrQ&libraries=places"></script>
    <script>
       $(document).ready(function() {
			$('#staff-form').parsley();
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
		});

    </script>
@endsection
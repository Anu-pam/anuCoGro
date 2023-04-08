@extends('backend.layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Professional User</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.professionalist.list') }}">Professional List</a></li>
				<li class="breadcrumb-item active">New Professional User</li>
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
				<h4 class="card-title">New Professional User</h4>
				<form method="post" action="{{ route('admin.professionalist.store')}}" enctype="multipart/form-data" id="staff-form">
				@csrf
				@if($errors->any())
					<div class="alert alert-danger" role="alert">
						{{ $errors->first() }}
					</div>
				@endif
					<div class="row">
						<div class="col-md-6">
						    <label class="form-label">Name</label>
							<input class="form-control" type="text" name="name" placeholder="Enter Name" required data-parsley-error-message="The name field is required." value="{{ old('name') }}">
                            @if($errors->has('name')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('name') }}</span> @endif
						</div>
						<div class="col-md-6">
						    <label class="form-label">Email</label>
							<input class="form-control" type="email" name="email" placeholder="Enter Email" required data-parsley-error-message="The email should be a valid email." value="{{ old('email') }}">
                            @if($errors->has('email')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('email') }}</span> @endif
						</div>
						
						<div class="col-md-6 mt-3">
						    <label class="form-label">Password</label>
							<input class="form-control" type="password" name="password" id="password" placeholder="Enter Password" required data-parsley-error-message="The password field is required." value="{{ old('password') }}">
                            @if($errors->has('password')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('password') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Confirm Password</label>
							<input class="form-control" type="password" name="confirm_password" placeholder="Enter Confirm Password" required data-parsley-equalto="#password">
                             @if($errors->has('confirm_password')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('confirm_password') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Business</label>
							<input class="form-control" type="text" name="business" placeholder="Enter Business" required data-parsley-error-message="The business field is required." value="{{ old('business') }}">
                             @if($errors->has('business')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('business') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3 d-none">
						      <div class="form-group">
                                    <label class="form-label">Select Role</label>
                                    <select class="form-select col-12" id="inlineFormCustomSelectRole" name="role"
									 <option value="">Select Role</option>
									  @if(!empty($roles[0]))
										  @foreach($roles as $role)
									          <option value="{{ $role->id }}">{{ $role->name }}</option>
									      @endforeach
									  @endif
                                    </select>
									@if($errors->has('role')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('role') }}</span> @endif
                                </div>
						</div>
						<div class="col-md-6 mt-3">
							<div class="form-group">
								<label class="form-label">Image Upload</label>
								<input type="file" class="form-control" name="image" onChange="preview_image(event,'display_image')" >
								<img src="{{ url('public/assets/images/users/2.jpg') }}" height="50px" width="50px" id="display_image">
							</div>
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Location</label>
							<input class="form-control" type="text" name="address" id="address" placeholder="Enter Location" required data-parsley-error-message="The location field is required." value="{{ old('address') }}">
                            @if($errors->has('address')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('address') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">City</label>
							<input class="form-control" type="text" name="city" id="city" placeholder="Enter City" required data-parsley-error-message="The city field is required." value="{{ old('city') }}">
                            @if($errors->has('city')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('city') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Postal Code</label>
							<input class="form-control" type="text" name="postcode" id="postcode" placeholder="Enter Postal Code" required data-parsley-error-message="The postal code field is required." value="{{ old('postcode') }}" value="{{ old('city') }}">
                            @if($errors->has('postcode')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('postcode') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Phone No</label>
							<input class="form-control" type="text" name="phone" placeholder="Enter Phone No" required data-parsley-error-message="The phone no field is required." value="{{ old('phone') }}">
                            @if($errors->has('phone')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('phone') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Comment</label>
							<textarea class="form-control" name="message" placeholder="Enter Comment"></textarea>
						</div>
						
						
						<div class="col-12">
							<div class="d-md-flex align-items-center mt-3">
							<input type="hidden" name="latitude" id="latitude"/>
		                    <input type="hidden" name="longitude" id="longitude"/>
								<a href="{{ route('admin.professionalist.list')}}" class="btn btn-dark">Cancel</a>
								<div class="ms-auto mt-3 mt-md-0">
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
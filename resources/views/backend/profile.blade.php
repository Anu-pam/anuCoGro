@extends('backend.layouts.app')
@section('content')
@php $userProfileImage = \App\Models\Image::where('parent_id',$getProfile->id)->where('type','user_profile')->first(); @endphp
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">User Profile</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item active">User Profile Update</li>
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
				<h4 class="card-title">User Profile Update</h4>
				<form method="post" action="{{ route('admin.profile.update',['id'=>$getProfile->id])}}" enctype="multipart/form-data">
				@csrf
				@if($errors->any())
					<div class="alert alert-danger" role="alert">
						{{ $errors->first() }}
					</div>
				@endif
				      <div class="row">
						<div class="col-md-6">
						    <label class="form-label">Name</label>
							<input class="form-control" type="text" name="name" placeholder="Enter Name" value="{{ !empty($getProfile->name) ? $getProfile->name : ''}}">
                            @if($errors->has('name')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('name') }}</span> @endif
						</div>
						<div class="col-md-6">
						    <label class="form-label">Email</label>
							<input class="form-control" type="text" placeholder="Enter Name" value="{{ !empty($getProfile->email ) ? $getProfile->email  : ''}}" disabled>
                        </div>
						<div class="col-md-6 mt-3">
							<div class="form-group">
								<label class="form-label">Image Upload</label>
								<input type="file" class="form-control" name="image" onChange="preview_image(event,'display_image')">
								<img src="{{ !empty($userProfileImage->image) ? url('public'.$userProfileImage->image) : url('public/assets/images/users/2.jpg')   }}" height="50px" width="50px" id="display_image">
							</div>
						</div>
						
						<div class="col-12">
							<div class="d-md-flex align-items-center mt-3">
								<a href="{{ route('admin.dashboard')}}" class="btn btn-dark">Cancel</a>
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
    <script>
       

    </script>
@endsection
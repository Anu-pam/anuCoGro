@extends('backend.layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">User Change Password</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item active">User Change Password</li>
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
				<h4 class="card-title">User Change Password</h4>
				<form method="post" action="{{ route('admin.change.password.update',['id'=>$getProfile->id])}}" enctype="multipart/form-data">
				@csrf
				@if($errors->any())
					<div class="alert alert-danger" role="alert">
						{{ $errors->first() }}
					</div>
				@endif
				      <div class="row">
						<div class="col-md-6">
						    <label class="form-label">Email</label>
							<input class="form-control" type="text" placeholder="Enter Name" value="{{ !empty($getProfile->email ) ? $getProfile->email  : ''}}" disabled>
                        </div>
						<div class="col-md-6">
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Password</label>
							<input class="form-control" type="password" name="password" placeholder="Enter Password" value="{{ old('password') }}">
                            @if($errors->has('password')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('password') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
						    <label class="form-label">Confirm Password</label>
							<input class="form-control" type="password" name="password_confirmation" placeholder="Enter Confirm Password">
                            
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
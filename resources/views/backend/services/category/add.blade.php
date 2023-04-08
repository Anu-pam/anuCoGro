@extends('backend.layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Professional Types</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.services.category.list') }}">Professional Types</a></li>
				<li class="breadcrumb-item active">New Professional Type</li>
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
				<h4 class="card-title">New Professional Type</h4>
				<form method="post" action="{{ route('admin.services.category.store')}}" enctype="multipart/form-data" id="category-form">
				@csrf
				@if($errors->any())
					<div class="alert alert-danger" role="alert">
						{{ $errors->first() }}
					</div>
				@endif
					<div class="row">
						<div class="col-md-6">
						    <label class="form-label">Name</label>
							<input class="form-control" type="text" name="name" placeholder="Enter Name" required data-parsley-error-message="The name field is required.">
                            @if($errors->has('name')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('name') }}</span> @endif
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Image Upload</label>
								<input type="file" class="form-control" name="image" onChange="preview_image(event,'display_image')" >
								<img src="{{ url('public/assets/images/users/2.jpg') }}" height="50px" width="50px" id="display_image">
							</div>
						</div>
						<div class="col-md-6">
						      <div class="form-group">
                                    <label class="form-label">Select Status</label>
                                    <select class="form-select col-12" id="inlineFormCustomSelect" name="status">
                                        <option value="1">Active</option>
                                        <option value="2">InActive</option>
                                    </select>
                                </div>
						</div>
						<div class="col-md-6">
						<label class="form-label">&nbsp;</label>
						   <div class="form-check">
								<input class="form-check-input" type="checkbox" name="show_on_header"
									id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
									Show On Header
								</label>
							</div>
						</div>
						<div class="col-12">
							<div class="d-md-flex align-items-center mt-3">
								<a href="{{ route('admin.services.category.list')}}" class="btn btn-dark">Cancel</a>
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
        $(document).ready(function() {
			$('#category-form').parsley();
		});

    </script>
@endsection
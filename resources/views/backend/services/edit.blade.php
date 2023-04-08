@extends('backend.layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Sevices</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.services.list') }}">Sevices</a></li>
				<li class="breadcrumb-item active">Edit Sevices</li>
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
				<h4 class="card-title">Edit Sevices</h4>
				<form method="post" action="{{ route('admin.services.update',['id'=>$getService->id])}}" enctype="multipart/form-data" id="service-form">
				@csrf
				@if($errors->any())
					<div class="alert alert-danger" role="alert">
						{{ $errors->first() }}
					</div>
				@endif
					<div class="row">
					<div class="col-md-4">
						  <div class="form-group">
								<label class="form-label">Select Services Category</label>
								<select class="form-select col-12" id="inlineFormCustomSelect" name="category" required data-parsley-error-message="The category field is required.">
								  <option value="">Select Category</option>
								   @if(!empty($getServicesCategories[0]))
									   @foreach($getServicesCategories as $category)
										  <option value="{{ $category->id }}" {{ (!empty($getService->category_id) && ($getService->category_id == $category->id)) ? 'selected' : ''}}>{{ $category->name }}</option>
									   @endforeach
								   @endif
								</select>
								@if($errors->has('category')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('category') }}</span> @endif
							</div>
						</div>
						<div class="col-md-2">
						      <div class="form-group">
                                    <label class="form-label">Select Gender</label>
                                    <select class="form-select col-12" id="inlineFormCustomSelect1" name="gender">
                                        <option value="1" {{ (!empty($getService->gender) && ($getService->gender == 1)) ? 'selected' : ''}}>Men</option>
                                        <option value="2" {{ (!empty($getService->gender) && ($getService->gender == 2)) ? 'selected' : ''}}>Women</option>
                                    </select>
                                </div>
						</div>
						<div class="col-md-6">
						    <label class="form-label">Name</label>
							<input class="form-control" type="text" name="name" placeholder="Enter Name" value="{{ !empty($getService->name) ? $getService->name : old('name')}}" required data-parsley-error-message="The name field is required.">
                            @if($errors->has('name')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('name') }}</span> @endif
						</div>
						<div class="col-md-6">
						    <label class="form-label">Minimum Price</label>
							<input class="form-control" type="text" name="min_price" id="min_price" placeholder="Enter Minimum Price" value="{{ !empty($getService->min_price) ? $getService->min_price : old('min_price')}}" required data-parsley-type="number">
                            @if($errors->has('min_price')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('min_price') }}</span> @endif
						</div>
						<div class="col-md-6">
						    <label class="form-label">Maximum Price</label>
							<input class="form-control" type="text" name="max_price" id="max_price" placeholder="Enter Maximum Price" value="{{ !empty($getService->max_price) ? $getService->max_price : old('max_price')}}" required data-parsley-type="number">
                            @if($errors->has('max_price')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('max_price') }}</span> @endif
						</div>
						<div class="col-md-6 mt-3">
							<div class="form-group">
								<label class="form-label">Image Upload</label>
								<input type="file" class="form-control" name="image" onChange="preview_image(event,'display_image')" >
								<img src="{{ !empty($getService->serviceImages->image) ? url('public'.$getService->serviceImages->image) : url('public/assets/images/users/2.jpg')   }}" height="50px" width="50px" id="display_image">
							</div>
						</div>
						<div class="col-md-6 mt-3">
						      <div class="form-group">
                                    <label class="form-label">Select Status</label>
                                    <select class="form-select col-12" id="inlineFormCustomSelect" name="status">
                                        <option value="1" {{ (!empty($getService->status) && ($getService->status == 1)) ? 'selected' : ''}}>Active</option>
                                        <option value="2" {{ (!empty($getService->status) && ($getService->status == 2)) ? 'selected' : ''}}>InActive</option>
                                    </select>
                                </div>
						</div>
						<div class="col-md-6">
						<label class="form-label">&nbsp;</label>
						   <div class="form-check">
								<input class="form-check-input" type="checkbox" name="show_on_header"
									id="flexCheckDefault" {{ (!empty($getService->show_on_header) && ($getService->show_on_header == 1)) ? 'checked' : ''}}>
								<label class="form-check-label" for="flexCheckDefault">
									Show On Header
								</label>
							</div>
						</div>
						<div class="col-12">
							<div class="d-md-flex align-items-center mt-3">
								<a href="{{ route('admin.services.list')}}" class="btn btn-dark">Cancel</a>
								<div class="ms-auto mt-3 mt-md-0">
									<button type="submit"
										class="btn btn-primary text-white" id="form_service_submit">Submit</button>
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
		   
			$('#service-form').parsley().on('submit',function(e){
				var min_price_val = $('#min_price').val();
				$('#max_price').attr('data-parsley-min',min_price_val);
				$('#max_price').parsley().validate();
			});
			$('#max_price').on('keyup',function(e){
				var min_price_val = $('#min_price').val();
				$(this).attr('data-parsley-min',min_price_val);
				$(this).parsley().validate();
			});
			$('#min_price').on('keyup',function(e){
				var min_price_val = $('#min_price').val();
				$('#max_price').attr('data-parsley-min',min_price_val);
				$('#max_price').parsley().validate();
			});
			$('#form_service_submit').on('click',function(e){
				var min_price_val = $('#min_price').val();
				$('#max_price').attr('data-parsley-min',min_price_val);
				$('#max_price').parsley().validate();
			});
			
		});
    </script>
@endsection
@extends('backend.layouts.app')
@section('content')
<?php
if(!empty($data['range']->value)){
$range=json_decode($data['range']->value);
$timing=json_decode($data['timing']->value);
}
?>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Settings</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item active">Settings</li>
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
				<!-- <h4 class="card-title">Setting</h4> -->
				<form method="post" action="{{ route('admin.setting.store')}}" enctype="multipart/form-data" id="tax-form">
				@csrf
				@if($errors->any())
					<div class="alert alert-danger" role="alert">
						{{ $errors->first() }}
					</div> 
				@endif
				<h3><strong>Calculate estimate time</strong></h3>
				
				<div class="row">
					<div class="col-md-6">					
						<div class="form-group">
						    <label class="form-label">0 - 1 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[0]) ? $range[0] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						    <label class="form-label">1 - 2 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[1]) ? $range[1] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>	
						</div>
				    </div>
					<div class="row">
					<div class="col-md-6">		
						<div class="form-group">
						    <label class="form-label">2 - 3 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[2]) ? $range[2] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
						</div>
					<div class="col-md-6">
						<div class="form-group">
						    <label class="form-label">3 - 4 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[3]) ? $range[3] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
						</div>
				    </div>
					<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
						    <label class="form-label">4 - 5 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[4]) ? $range[4] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
						</div>
					<div class="col-md-6">
						<div class="form-group">
						    <label class="form-label">5 - 6 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[5]) ? $range[5] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
						</div>
				    </div>
					<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
						    <label class="form-label">6 - 7  kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[6]) ? $range[6] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
						</div>
					<div class="col-md-6">
						<div class="form-group">
						    <label class="form-label">7 - 8 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[7]) ? $range[7] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
						</div>
				    </div>
					<div class="row m-b-30">
					<div class="col-md-6">	
						<div class="form-group">
						    <label class="form-label">8 - 9 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[8]) ? $range[8] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
						</div>
					<div class="col-md-6">
						<div class="form-group">
						    <label class="form-label">9 - 10 kilometer(Km) </label>
							<input class="form-control" type="number" name="range[]" value="{{ !empty($range[9]) ? $range[9] : '' }}" placeholder="Enter minutes" required data-parsley-error-message="The Minutes field is required.">
                            @if($errors->has('range')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('range') }}</span> @endif
						</div>
						</div>
				    </div>
					<h3><strong>Calculate Tax</strong></h3>
					<div class="row m-b-30">
						<div class="col-md-6">	
							<div class="form-group">
								<label class="form-label">Calculate Tax (%)</label>
								<input class="form-control" type="number" name="tax" value="{{ !empty($data['tax']->value) ? $data['tax']->value : '' }}" placeholder="Enter Tax Value" required data-parsley-error-message="The Tax field is required.">
								@if($errors->has('tax')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('tax') }}</span> @endif
							</div>
						</div>
						<div class="col-md-6">	
							<div class="form-group">
								<label class="form-label">Calculate Tax Name</label>
								<input class="form-control" type="text" name="taxname" value="{{ !empty($data['tax']->taxName) ? $data['tax']->taxName : '' }}" placeholder="Enter Tax Value" required data-parsley-error-message="The Tax field is required.">
								@if($errors->has('taxname')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('taxname') }}</span> @endif
							</div>
						</div>
				    </div>

					<h3><strong>Transaction Tax</strong></h3>
					<div class="row m-b-30">
						<div class="col-md-6">	
							<div class="form-group">
								<label class="form-label">Transaction Tax (%)</label>
								<input class="form-control" type="number" name="transactionTax" value="{{ !empty($data['transactionTax']->value) ? $data['transactionTax']->value : '' }}" placeholder="Enter Tax Value" required data-parsley-error-message="The Tax field is required.">
								@if($errors->has('tax')) <span class="text-danger"> <i class="fa fa-warning"></i> {{ $errors->first('tax') }}</span> @endif
							</div>
						</div>
				    </div>
					
					<h3><strong>Professional Working Time</strong></h3>
					<div class="row m-b-30" >
						<div class="col-md-6">	
							<div class="form-group">
								<label class="form-label">Start Time</label>
								<select class="form-control" name="timing[]">
								@foreach(config('variable.start_time') as $index=>$start)
								 @if(!empty($timing[0]))
								 <option value="{{ $timing[0] }}"  {{ $timing[0] == $index ? 'selected' : '' }}>{{ $start }}</option>
								 @else
								 <option value="{{ $index }}">{{ $start }}</option>
								@endif
							    @endforeach
								</select>
							
							</div>
						</div>
						<div class="col-md-6">	
							<div class="form-group">
								<label class="form-label">Stop Time</label>
								<select class="form-control" name="timing[]">
								@foreach(config('variable.stop_time') as $index=>$stop)
								@if(!empty($timing[1]))
								 <option value="{{ $timing[1] }}"  {{ $timing[1] == $index ? 'selected' : '' }}>{{ $stop }}</option>
								 @else
								 <option value="{{ $index }}">{{ $stop }}</option>
								 @endif
								 @endforeach
								</select>
							
							</div>
						</div>
				    </div>

					<div class="row">
						<div class="col-12">
							<div class="d-md-flex align-items-center mt-3">
								<a href="#" class="btn btn-dark">Cancel</a>
								<div class="ms-auto mt-3 mt-md-0">
									<button type="submit"
										class="btn btn-primary text-white">Update</button>
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
	$('#tax-form').parsley();
});
</script>

@endsection 
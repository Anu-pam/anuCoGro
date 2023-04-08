@extends('backend.layouts.app')
@section('content')
<?php //echo "<pre>";var_dump($getUser);exit;?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"></h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.services.list') }}">Services</a></li>
                <li class="breadcrumb-item active">Service Info</li>
            </ol>
			<a href="{{ route('admin.services.list') }}" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xlg-6">   
	     <div class="form-body">
            <div class="row m-b-20">
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="m-b-30">Service Info</h3>
							 <div class="row">
                                 <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
										    <tr>
                                                <th>Gender</th><td>{{ (!empty($getService->name))?$getService->name:'-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Name</th><td>{{ (!empty($getService->name))?$getService->name:'-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Category</th><td>{{ (!empty($getService->Service_cat->name))? $getService->Service_cat->name :'-' }}</td>
                                            </tr>                                          
                                            <tr>
                                                <th>Status</th><td>{{ ($getService->status == 1) ? 'Active' : 'Deactive' }} </td>
                                            </tr>
                                            <tr>
                                                <th>Show On Header</th><td>{{ ($getService->show_on_header == 1) ? 'Yes' : 'No' }} </td>
                                            </tr>     
                                            <tr>
                                                <th>Min Price</th><td>{{ !empty($getService->min_price) ? $getService->min_price : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>max Price</th><td>{{ !empty($getService->max_price) ? $getService->max_price : '-' }}</td>
                                            </tr>                                
                                        </table>
                                    </div>
                                 </div>                                 
                                 <div class="col-md-6">
                                 <h4 class="m-b-30"><strong>Image</strong></h4>
                                    <img class="img-fluid rounded" src="{{ !empty($getService->serviceImages->image) ? url('public'.$getService->serviceImages->image) : url('public/assets/images/users/2.jpg')}}">
                                  </div>
                             </div>		
                        </div>
                    </div>
                </div>	
            </div>            
        </div>
    </div>
</div>

@endsection
@section('extrastyle')

@endsection
@section('extrascript')
<script>
$("body").on("click",".modal_google_save",function(){
            $(".google-save-item-button").attr('href',$(this).attr('data-href'))
    });
</script>
@endsection
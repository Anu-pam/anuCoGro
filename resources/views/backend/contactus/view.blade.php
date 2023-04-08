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
				<li class="breadcrumb-item"><a href="{{ route('admin.contactus.list') }}">Contact Us List</a></li>
                <li class="breadcrumb-item active">Professional View</li>
            </ol>
			<a href="{{ route('admin.contactus.list') }}" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xlg-6">   
	     <div class="form-body">
            <div class="row m-t-30  m-b-30">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="m-b-30">Contact Us Info</h3>
							 
                            <div class="table-responsive">
                               <table class="table style2">
                                <tr>
                                    <td><b>Name</b></td><td>{{ (!empty($getContact->name))?$getContact->name:'-' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Email Id</b></td><td>{{ (!empty($getContact->email))?$getContact->email:'-' }}</td>
                                </tr>
								<tr>
                                    <td><b>Phone No</b></td><td>{{ !empty($getContact->phone) ? $getContact->phone : '-' }}</td>
                                </tr>
								
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
				
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="m-b-30">&nbsp;</h3>
                            <div class="table-responsive">
								<table class="table style2">
									 <tr>
										<td><b>Message</b></td><td>{{ !empty($getContact->message) ? $getContact->message : '-' }}</td>
									</tr>
									
								  </table>
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
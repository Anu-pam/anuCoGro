@extends('backend.layouts.app')
@section('content')
<?php //echo "<pre>";var_dump($getUser);exit;?>
@php
   $getProfessionalServices = \App\Models\ProfessionalService::where('professional_id',$getUser->id)->get();
   $getOrder = \App\Models\Order::where('customer_id',$getUser->id)->orderBy('order_date','desc')->get();
   $getReview = \App\Models\Review::where('professional_id',$getUser->id)->orderBy('review_time','desc')->get();
   $getProfessionalServices = \App\Models\ProfessionalService::where('professional_id',$getUser->id)->get();
   $getIdentificationDocuments = \App\Models\DocIdentification::where('user_id',$getUser->id)->get();
@endphp
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"></h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.professionalist.list') }}">Professional User List</a></li>
                <li class="breadcrumb-item active">Professional View</li>
            </ol>
			<a href="{{ route('admin.professionalist.list') }}" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>

<div class="row">
<div class="col-lg-4 col-xlg-3 col-md-5">
    <div class="card">
        <div class="card-body">
            <div class="profile-card">
                <div class="profile-img">
                <img src="{{ !empty($getUser->userProfileImages->image) ? url('public'.$getUser->userProfileImages->image) : url('public/assets/images/users/7.jpg') }}" class="img-fluid img-circle">
                </div>
				
                <div class="profile-body">
                    <h4 class="card-title">{{ (!empty($getUser->name))?$getUser->name:'-' }}</h4>
                    <h6 class="card-subtitle text-success">
                        {{ (!empty($getUser->userRole->name))?$getUser->userRole->name:'-' }}                                                                      
                    </h6>
                    <hr>
                    <ul class="list-unstyled mb-0">
                        <li><i class="icon-envelope-open m-r-10"></i>{{ (!empty($getUser->email))?$getUser->email:'-' }}</li>                        
                        <li><i class="icon-phone m-r-10" style="color:#909ba6"></i>{{ !empty($getUser->userProfessionalDetails->phone_no) ? $getUser->userProfessionalDetails->phone_no : '-' }}</li>
                    </ul>
                </div>
            </div>
        </div>           
    </div>
    @php
$latitude = !empty($getUser->userProfessionalDetails->latitude) ? $getUser->userProfessionalDetails->latitude : ''; 
$longitude = !empty($getUser->userProfessionalDetails->longitude) ? $getUser->userProfessionalDetails->longitude : '';
@endphp
@if(!empty($latitude) && ($longitude))
	<div class="card">
		<div class="card-body">
			<input type="hidden" id="latitude" value="{{ !empty($getUser->userProfessionalDetails->latitude) ? $getUser->userProfessionalDetails->latitude : '-' }}">
			<input type="hidden" id="longitude" value="{{ !empty($getUser->userProfessionalDetails->longitude) ? $getUser->userProfessionalDetails->longitude : '-' }}">
			 <div id="map"></div>
	   </div>
	</div>
@endif       
</div>
<div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <ul class="nav nav-tabs profile-tab" role="tablist">
			    <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#services" role="tab">Services</a> </li>
                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#orders" role="tab">Bookings</a> </li>
                <!-- <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#bookings" role="tab">My Bookings</a> </li> -->
                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#reviews" role="tab">Reviews</a> </li>
				<li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab">Documents</a> </li>
            </ul>
            <div class="tab-content">
			<div class="tab-pane active" id="services" role="tabpanel">
                    <div class="card-body">
                    <div class="table-responsive">
				<table class="table table-hover no-wrap mb-0" id="service-table" width="100%">
					<thead>
						<tr>
							<th class="text-center">#</th>							
							<th>Service/Professional Type</th>
                            <th>Price</th>
							<th>Min Price</th>
							<th>Max Price</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>	
					 @if(!empty($getProfessionalServices[0]))
						   @foreach($getProfessionalServices as $professionalServices)
							 @php
							   $getServices = \App\Models\Service::where('id',$professionalServices->service_id)->first();
							 @endphp
							 <tr>
									<td class="text-center">{{ $loop->iteration }}</td>									
									<td class="txt-oflo">
                                        <div class="media">
                                            <img class="img-fluid m-r-10 m-t-5" src="{{ !empty($getServices->serviceImages->image) ? url('public'.$getServices->serviceImages->image) : url('public/assets/images/users/2.jpg')   }}" style="width:25px; height:auto;">
                                            <div class="media-body">
                                            <h6 class="mb-0">{{ !empty($getServices->name) ? $getServices->name : '' }}</h6>
                                            <p class="mb-0"><small>{{ !empty($getServices->Service_cat->name) ? $getServices->Service_cat->name : '' }}</small></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="txt-oflo">{{ $professionalServices->price }}</td>
                                   <!-- <td class="txt-oflo"><img src="{{ !empty($getServices->serviceImages->image) ? url('public'.$getServices->serviceImages->image) : url('public/assets/images/users/2.jpg')   }}" height="50px" width="50px"></td> -->
									<td class="txt-oflo">{{ $getServices->min_price }}</td>
                                    <td class="txt-oflo">{{ $getServices->max_price }}</td>
									<td class="txt-oflo">{{ ($getServices->status == 1) ? 'Active' : 'In Active' }} </td>
								</tr>
						
					       @endforeach
						@else	
								<tr>
								   <td colspan="6" class="text-center"><b>No Order Found</b></td>
								</tr>
						@endif
                                								
					</tbody>
				</table>
			</div>
                    </div>
                </div>
                <div class="tab-pane" id="orders" role="tabpanel">
                    <div class="card-body">
                    <div class="table-responsive">
				<table class="table table-hover no-wrap mb-0" id="config-table" width="100%">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Service</th>
							<th>Customer</th>
							<th>Total Amount</th>
							<th>Booking Date</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>	
					 @if(!empty($getOrder[0]))
						   @foreach($getOrder as $order)
							 @php
							   $getServices = \App\Models\Service::where('id',$order->service_id)->first();
							   $arrOrderStatus = \App\Http\Helpers\Common::getOrderStatus($order->order_status);
							 @endphp
							 <tr>
									<td class="text-center">{{ $loop->iteration }}</td>
									<td class="txt-oflo">{{ !empty($getServices->name) ? $getServices->name : '' }}</td>
									<td class="txt-oflo">{{ !empty($order->customer_name) ? $order->customer_name : '' }}</td>
									<td class="txt-oflo">{{ !empty($order->total_amount) ? $order->total_amount : '' }}</td>
									<td class="txt-oflo">{{ !empty($order->order_date) ? \App\Http\Helpers\Common::dateFormatChange($order->order_date) : '' }}</td>
									<td><span class="badge bg-{{ $arrOrderStatus['color'] }} rounded-pill">{{ $arrOrderStatus['status'] }}</span> </td>
								</tr>
						
					       @endforeach
						@else	
								<tr>
								   <td colspan="6" class="text-center"><b>No Order Found</b></td>
								</tr>
						@endif
                                								
					</tbody>
				</table>
			</div>
                    </div>
                </div>
                <div class="tab-pane" id="bookings" role="tabpanel">
				@if(!empty($getOrder[0]))
			   @foreach($getOrder as $order)
				 @php
				   $getServices = \App\Models\Service::where('id',$order->service_id)->first();
				   $arrOrderStatus = \App\Http\Helpers\Common::getOrderStatus($order->order_status);
				 @endphp
                    <div class="card border mb-0">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <span class="round">
                                <img class="p-2" src="{{ !empty($getServices->serviceImages->image) ? url('public'.$getServices->serviceImages->image) : url('public/assets/images/users/7.jpg') }}" class="img-fluid" alt="user" width="100">
                                </span>
                            </div>
                            <div class="col-md-11 clearfix">
                            <h4><strong>{{ (!empty($getUser->name))?$getUser->name:'-' }} <span class="float-end">${{ !empty($order->total_amount) ? $order->total_amount : 0 }}</span></strong></h4>                            
                            <h5>{{ !empty($getServices->name) ? $getServices->name : '' }}, <small>{{ !empty($order->customer_name) ? $order->customer_name : '' }}</small></h5>                            
                            <p><small>{{ !empty($order->order_date) ? \App\Http\Helpers\Common::dateFormatChange($order->order_date) : '' }}</small></p>                            
                            <span class="badge bg-{{ $arrOrderStatus['color'] }} rounded-pill">{{ $arrOrderStatus['status'] }}</span>
                            </div>    
                        </div>                  
                        </div>
                    </div>
					@endforeach
					@else	
						<tr>
						   <td colspan="6" class="text-center"><b>No Order Found</b></td>
						</tr>
					@endif
                    
                </div>
                <div class="tab-pane" id="reviews" role="tabpanel">
                <div class="comment-widgets m-b-20">
                                <!-- Comment Row -->
						@if(!empty($getReview[0]))
							@php $sumRating = 0; @endphp
						   @foreach($getReview as $review)
							 @php
								$getCustomers = \App\Models\User::where('id',$review->user_id)->first();
								$sumRating = $sumRating + $review->rating;
							 @endphp
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2">
                                        <span class="round">
                                            <img class="p-2" src="{{ !empty($getCustomers->userProfileImages->image) ? url('public'.$getCustomers->userProfileImages->image) : url('public/assets/images/users/7.jpg') }}" alt="service" width="50">
                                        </span>
                                    </div>
                                    <div class="comment-text w-100">
										<div class="rating d-flex justify-content-start align-items-md-center mb-2 font-1rem" id="rating">
												@for($i=1;$i<=5;$i++)
												 @if($i <= $review->rating)
												   @php $checkedClass="checked"; @endphp
											     @else
												   @php $checkedClass=""; @endphp
											     @endif
												  <span class="fa fa-star {{ $checkedClass }}"></span>
											    @endfor
												
											<div class="reviews rating ml-2">
											   <span style="font-size:1.2rem !important; color:#f8c323;" href="#" class="review_count">({{ !empty($review->rating) ? $review->rating : 0 }})</span>
											</div>
										</div>
                                        <h5>{{ $review->user_name }}</h5>
                                        <div class="comment-footer">
                                            <span class="date">{{ date('d M Y h:i:s A',strtotime($review->review_time)) }}</span>
                                            <span class="action-icons d-none">
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-pencil-circle"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-checkbox-marked-circle"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-heart"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <p class="m-b-5 m-t-10">{{ $review->review_text }}</p>
                                    </div>
                                </div>
							@endforeach
							@endif
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row d-none">
                                    <div class="p-2">
                                        <span class="round">
                                            <img class="p-2" src="{{ url('public/assets/images/users/2.jpg') }}" alt="user" width="50">
                                        </span>
                                    </div>
                                    <div class="comment-text active w-100">
                                        <h5>Michael Jorden</h5>
                                        <div class="comment-footer">
                                            <span class="date">April 14, 2016</span>
                                            <span class="action-icons active">
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-pencil-circle"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-checkbox-marked-circle text-success"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-heart text-danger"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <p class="m-b-5 m-t-10">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum
                                            has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row d-none">
                                    <div class="p-2">
                                        <span class="round">
                                            <img class="p-2" src="{{ url('public/assets/images/users/3.jpg') }}" alt="user" width="50">
                                        </span>
                                    </div>
                                    <div class="comment-text w-100">
                                        <h5>Johnathan Doeting</h5>
                                        <div class="comment-footer">
                                            <span class="date">April 14, 2016</span>
                                            <span class="label label-danger">Rejected</span>
                                            <span class="action-icons">
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-pencil-circle"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-checkbox-marked-circle"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-heart"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <p class="m-b-5 m-t-10">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum
                                            has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row d-none">
                                    <div class="p-2">
                                        <span class="round">
                                            <img class="p-2" src="https://sales.statuscrawl.io/public/uploads/users/1640085846.jpg" alt="user" width="50">
                                        </span>
                                    </div>
                                    <div class="comment-text w-100">
                                        <h5>Shiv Kumar Tiwari</h5>
                                        <div class="comment-footer">
                                            <span class="date">April 14, 2016</span>
                                            <span class="label label-info">Pending</span>
                                            <span class="action-icons">
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-pencil-circle"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-checkbox-marked-circle"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="mdi mdi-heart"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <p class="m-b-5 m-t-10">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum
                                            has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                                    </div>
                                </div>
								
								
                            </div>
                </div>
				<div class="tab-pane" id="documents" role="tabpanel">
                    <div class="card-body">
                    <div class="table-responsive">
						<table class="table table-hover no-wrap mb-0" id="config-table" width="100%">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Type</th>
									<th>Image</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>	
							 @if(!empty($getIdentificationDocuments[0]))
								   @foreach($getIdentificationDocuments as $documents)
									 @php
									   $getIdentification = \App\Models\Identification::where('id',$documents->type)->first();
									   $arrIdentificationStatus = \App\Http\Helpers\Common::getIdentificationStatus($documents->status);
									   @endphp
									 <tr>
											<td class="text-center">{{ $loop->iteration }}</td>
											<td class="txt-oflo">{{ !empty($getIdentification->type) ? $getIdentification->type : '' }}</td>
											<td class="txt-oflo">
											<img class="click_img" data-href="{{ !empty($documents->image) ? url('public'.$documents->image) : url('public/assets/images/users/7.jpg') }}" src="{{ !empty($documents->image) ? url('public'.$documents->image) : url('public/assets/images/users/7.jpg') }}" width="50" style="cursor:pointer;">
				                              </td>
											<td class="doc_status" data-id="{{ $documents->id }}" id="change_status_{{ $documents->id }}"><span class="badge bg-{{ $arrIdentificationStatus['color'] }} rounded-pill">{{ $arrIdentificationStatus['status'] }}</span> </td>
											<td class="txt-oflo">
											<a class="btn btn-outline-success btn-sm aproove" id="aproove_{{ $documents->id }}" data-id="{{ $documents->id }}" data-user-id="{{ $documents->user_id }}" href="javascript:;" title="Aproove"><i class="fa fa-check"></i></a>
											<a class="dit btn btn-outline-danger btn-sm reject" id="reject_{{ $documents->id }}" data-id="{{ $documents->id }}" data-user-id="{{ $documents->user_id }}" href="javascript:;" title="Reject"><i class="fa fa-ban"></i></a>
											</td>
										</tr>
								
								   @endforeach
								@else	
										<tr>
										   <td colspan="6" class="text-center"><b>No Documents Found</b></td>
										</tr>
								@endif
																		
							</tbody>
						</table>
					</div>
							</div>
						</div>
            </div>
        </div>
    </div>
</div>
<div class="row d-none">
    <div class="col-lg-12 col-xlg-6">   
	     <div class="form-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="m-b-30">Professional Info</h3>
							 
                            <div class="table-responsive">
                               <table class="table style2">
                                <tr>
                                    <td><b>Name</b></td><td>{{ (!empty($getUser->name))?$getUser->name:'-' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Email Id</b></td><td>{{ (!empty($getUser->email))?$getUser->email:'-' }}</td>
                                </tr>
								<tr>
                                    <td><b>Phone No</b></td><td>{{ !empty($getUser->userProfessionalDetails->phone_no) ? $getUser->userProfessionalDetails->phone_no : '-' }}</td>
                                </tr>
								<tr>
                                    <td><b>Location</b></td><td>{{ !empty($getUser->userProfessionalDetails->location) ? $getUser->userProfessionalDetails->location : '-' }}</td>
                                </tr>
								<tr>
                                    <td><b>City</b></td><td>{{ !empty($getUser->userProfessionalDetails->city) ? $getUser->userProfessionalDetails->city : '-' }}</td>
                                </tr>
								<tr>
                                    <td><b>Postcode</b></td><td>{{ !empty($getUser->userProfessionalDetails->postcode) ? $getUser->userProfessionalDetails->postcode : '-' }}</td>
                                </tr>
								<tr>
                                    <td><b>Latitude</b></td><td>{{ !empty($getUser->userProfessionalDetails->latitude) ? $getUser->userProfessionalDetails->latitude : '-' }}</td>
                                </tr>
								<tr>
                                    <td><b>Longitude</b></td><td>{{ !empty($getUser->userProfessionalDetails->longitude) ? $getUser->userProfessionalDetails->longitude : '-' }}</td>
                                </tr>
								<tr>
                                    <td><b>Message</b></td><td>{{ !empty($getUser->userProfessionalDetails->message) ? $getUser->userProfessionalDetails->message : '-' }}</td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
				
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="m-b-30">Service Info</h3>
                            <div class="table-responsive">
								<table class="table style2">
									 <thead>
									   <tr>     
                                           <th>#</th>									   
										   <th>Service Name</th>
										   <th>Service Category Name</th>
										   <th>Price</th>
									  </tr>
									 </thead>			   								         											
									 <tbody>
									  @if(!empty($getProfessionalServices[0]))
										   @foreach($getProfessionalServices as $professionalService)
											 @php
											   $getServices = \App\Models\Service::where('id',$professionalService->service_id)->first();
											 @endphp
										<tr>
										   <td> {{ $loop->iteration }}</td>
										   <td>{{ !empty($getServices->name) ? $getServices->name : '' }}</td>
										   <td>{{ !empty($getServices->Service_cat->name) ? $getServices->Service_cat->name : '' }}</td>
										   <td>{{ !empty($professionalService->price) ? $professionalService->price : '' }}</td>
										</tr>
									   @endforeach
										@else	
												<tr>
												   <td><b>No Service Found</b></td>
												</tr>
										@endif										
									 </tbody>
								  </table>
								</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!--Bootstrap modal -->
<div class="modal bs-example-modal-lg fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<!-- Modal heading -->
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					Document Image
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
			</div>
			<!-- Modal body with image -->
			<div class="modal-body">
				<img id="display_img" src="gfg.png" class="img-fluid"/>
			</div>
		</div>
	</div>
</div>
@endsection
@section('extrastyle')
<style>		  
		  #map { 
			height: 300px;	
					
		  }	
		  .rating .checked{
			  color: orange;
		  }
					  
		</style>	
@endsection
@section('extrascript')
<script type="text/javascript">

$.ajaxSetup({
	   headers: {
		 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	   }
	});
var map;

function initMap() {							
	var latitude = parseFloat($('#latitude').val()); // YOUR LATITUDE VALUE
	var longitude = parseFloat($('#longitude').val()); // YOUR LONGITUDE VALUE
	var myLatLng = {lat: latitude, lng: longitude};
	
	map = new google.maps.Map(document.getElementById('map'), {
	  center: myLatLng,
	  zoom: 14					
	});
			
	var marker = new google.maps.Marker({
	  position: myLatLng,
	  map: map,
	  //title: 'Hello World'
	  
	  // setting latitude & longitude as title of the marker
	  // title is shown when you hover over the marker
	  title: latitude + ', ' + longitude 
	});			
}
$(function () {
	// responsive table
	$('#config-table').DataTable({
		responsive: true,
	    "bLengthChange": false,
	});
    $('#service-table').DataTable({
        responsive: true,
	    "bLengthChange": false,
        
    });
});
$("body").on("click",".aproove",function(){
	var varId = $(this).attr('data-id');
	$('#aproove_'+varId).html('<i class="fa fa-spinner"></i>');
	var server_url = "{{ route('admin.professionalist.document.status.change')}}";
	var userId = $(this).attr('data-user-id');
	$.ajax({ 
			type: "POST",
			url: server_url,
			data:{
				'varId':varId,
				'userId':userId,
				'varType':'aproove'
				 },
			success: function (info) {
				//console.log(info);return false;
				$('#aproove_'+varId).html('<i class="fa fa-check"></i>');
				if(info.result == 'aproove'){
					$("#change_status_"+varId).html('<span class="badge bg-success rounded-pill">Approved</span>');
				}
				showToastMessage(info.msg,info.status);
				
			}
		});

	});
$("body").on("click",".reject",function(){
	var varId = $(this).attr('data-id');
	$('#reject_'+varId).html('<i class="fa fa-spinner"></i>');
	var userId = $(this).attr('data-user-id');
	var server_url = "{{ route('admin.professionalist.document.status.change')}}";
	$.ajax({
			type: "POST",
			url: server_url,
			data:{
				'varId':varId,
				'userId':userId,
				'varType':'reject'
				 },
			success: function (info) {
				//console.log(info);return false;
				$('#reject_'+varId).html('<i class="fa fa-ban"></i>');
				if(info.result == 'reject'){
					$("#change_status_"+varId).html('<span class="badge bg-danger rounded-pill">Rejected</span>');
				}
				showToastMessage(info.msg,info.status);
				
			}
		});

	});
	$("body").on("click",".click_img",function(e){
		  $('#exampleModal').modal('show', {backdrop: 'static'});
          $("#display_img").attr('src',$(this).attr('data-href'))
        });
function showToastMessage(message,status){
		if(status == 200){
			$.toast({
				heading: 'Success'
				, text: message
				, position: 'top-right'
				, loaderBg: '#00c292'
				, icon: 'success'
				, hideAfter: 3500
				, stack: 6
			});
		}else{
			$.toast({
            heading: 'Success'
            , text: message
            , position: 'top-right'
            , loaderBg: '#e46a76'
            , icon: 'error'
            , hideAfter: 3500
            , stack: 6
        });
		}
	}
//order
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCm6mWmbHn1gBp0BtAVEhA3jZjY9J0blrQ&callback=initMap"
async defer></script>

@endsection
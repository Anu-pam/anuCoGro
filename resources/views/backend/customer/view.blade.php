@extends('backend.layouts.app')
@section('content')
<?php //echo "<pre>";var_dump($getUser);exit;?>
@php
   $getProfessionalServices = \App\Models\ProfessionalService::where('professional_id',$getUser->id)->get();
   $getOrder = \App\Models\Order::where('customer_id',$getUser->id)->orderBy('order_date','desc')->get();
   $getReview = \App\Models\Review::where('user_id',$getUser->id)->orderBy('review_time','desc')->get();
   $getProfessionalServices = \App\Models\ProfessionalService::where('professional_id',$getUser->id)->get();
@endphp
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"></h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.customerlist.list') }}">Customer User List</a></li>
                <li class="breadcrumb-item active">Customer View</li>
            </ol>
			<a href="{{ route('admin.customerlist.list') }}" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i class="fa fa-arrow-left"></i> Back</a>
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
                        <li><i class="icon-phone m-r-10" style="color:#909ba6"></i>{{ !empty($getUser->userCustomerDetails->phone_no) ? $getUser->userCustomerDetails->phone_no : '-' }}</li>
                    </ul>
                </div>
            </div>
        </div>           
    </div>
    @php
$latitude = !empty($getUser->userCustomerDetails->latitude) ? $getUser->userCustomerDetails->latitude : ''; 
$longitude = !empty($getUser->userCustomerDetails->longitude) ? $getUser->userCustomerDetails->longitude : '';
@endphp
@if(!empty($latitude) && ($longitude))
	<div class="card">
		<div class="card-body">
			<input type="hidden" id="latitude" value="{{ !empty($getUser->userCustomerDetails->latitude) ? $getUser->userCustomerDetails->latitude : '-' }}">
			<input type="hidden" id="longitude" value="{{ !empty($getUser->userCustomerDetails->longitude) ? $getUser->userCustomerDetails->longitude : '-' }}">
			 <div id="map"></div>
	   </div>
	</div>
@endif       
</div>
<div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <ul class="nav nav-tabs profile-tab" role="tablist">
			    <!-- <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#services" role="tab">Services</a> </li> -->
                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#orders" role="tab">My Bookings</a> </li>
                <!-- <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#bookings" role="tab">My Bookings</a> </li> -->
                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#reviews" role="tab">My Reviews</a> </li>
            </ul>
            <div class="tab-content">
		    	<!-- <div class="tab-pane active" id="services" role="tabpanel">
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
                </div> -->
                <div class="tab-pane active" id="orders" role="tabpanel">
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
					@endif
                    
                </div>
                <div class="tab-pane" id="reviews" role="tabpanel">
                <div class="comment-widgets m-b-20">
                                <!-- Comment Row -->
						@if(!empty($getReview[0]))
						   @foreach($getReview as $review)
							 @php
							   $getServices = \App\Models\Service::where('id',$review->service_id)->first();
							 @endphp
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2">
                                        <span class="round">
                                            <img class="p-2" src="{{ !empty($getServices->serviceImages->image) ? url('public'.$getServices->serviceImages->image) : url('public/assets/images/users/7.jpg') }}" alt="service" width="50">
                                        </span>
                                    </div>
                                    <div class="comment-text w-100">
                                        <h5>{{ $review->user_name }}</h5>
                                        <div class="comment-footer">
                                            <span class="date">{{ date('d M Y h:i:s A',strtotime($review->review_time)) }}</span>
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
                                        <p class="m-b-5 m-t-10">{{ $review->review_text }}</p>
                                    </div>
                                </div>
							@endforeach
							@endif
                              
                            </div>
                </div>
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
		</style>	
@endsection
@section('extrascript')
<script type="text/javascript">
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
//order
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCm6mWmbHn1gBp0BtAVEhA3jZjY9J0blrQ&callback=initMap"
async defer></script>

@endsection
@extends('backend.layouts.app')
@section('content')
@php 
    $arrayStatus = App\Http\Helpers\Common::getOrderStatus($getOrder['results']->order_status);     
    $taxAndPrice = App\Http\Helpers\Common::TaxWithAmount($getOrder['results']->detail->sum('price'));

   @endphp
<?php //echo "<pre>";var_dump($getUser);exit;?>
<section class="section order-summary">
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"></h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.orders.list') }}">Orders</a></li>
                <li class="breadcrumb-item active">Order Info</li>
            </ol>
			<a href="{{ route('admin.orders.list') }}" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div> 
</div>
<div class="row">
    <div class="col-md-6">
       <h3>Order id<span class="text-success"><strong> #{{ !empty($getOrder['results']->order_id) ? $getOrder['results']->order_id : '-'}}</strong></span></h3>
       <p><small>Issued on {{ (!empty($getOrder['results']->order_date))?App\Http\Helpers\Common::dateFormatChange($getOrder['results']->order_date):'-' }}</small></p>
    </div>
    <div class="col-md-6 text-end">
    <select class="form-select d-inline-block w-auto" id="change_order_status" name="status">
        <option value="" selected="">Change Order Status</option> 
        @foreach(config('variable.order_status') as $index=>$variable)
        <option value="{{ $index }}">{{$variable}}</option>
        @endforeach
        <!-- <option value="1">Pending</option>
        <option value="2">Processing</option>
        <option value="3">Shipped</option>
        <option value="4">Complete</option>
        <option value="5">Cancel</option> -->
    </select>
    </div>
</div>
<div class="row">
    <div class="col-lg-3"> 
        <div class="card">
            <div class="card-body">  
                <div class="order-box">
                    <div class="order-icon">
                    <i class="fa fa-dollar-sign"></i>
                    </div>
                   <div class="order-content">
                    <h4>Payment</h4>
                    <span>Pending</span>
                    <span>Credit Card</span>
                    </div>
                    <div class="order-amount">
                        <h3 class="font-medium">{{ !empty($getOrder['amount']) ? App\Http\Helpers\Common::showTotalAmount($getOrder['amount']) :''}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3"> 
        <div class="card">
            <div class="card-body">  
                <div class="order-box">
                    <div class="order-icon">
                      <i class="far fa-calendar"></i>
                    </div>
                   <div class="order-content">
                    <h4>{{ !empty($getOrder['results']->bookingType) ? App\Http\Helpers\Common::checkbooking($getOrder['results']->bookingType):''}}</h4>
                    <span>Booking Slot</span> 
                    <!-- 10am to 12pm - Wed 30 March  -->
                    <span>{{ (!empty($getOrder['results']->order_date))?App\Http\Helpers\Common::timeFormat($getOrder['results']->created_at):'-' }}  to 12:00 pm - {{ (!empty($getOrder['results']->order_date))?App\Http\Helpers\Common::dayWithDateFormat($getOrder['results']->created_at):'-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3"> 
        <div class="card">
            <div class="card-body">  
                <div class="order-box">
                    <div class="order-icon">
                      <i class="far fa-user-clock"></i>
                    </div>
                   <div class="order-content">
                    <h4>Estimated Time</h4>
                    <span>Average Time</span>
                    <!-- <span>5-10 Minutes</span> -->
                    <span>
                        @if(!empty($getOrder['estimated']))
                        {{ $getOrder['estimated'] }}  {{$getOrder['estimated'] == 'N/A' ? ' ': "- ".($getOrder['estimated'] + 10) }} Minutes
                        @else
                         {{ "N/A" }}
                        @endif
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3"> 
        <div class="card">
            <div class="card-body">  
                <div class="order-box">
                    <div class="order-icon" style="color:{{ $arrayStatus['iconcolor'] }};border-color:{{ $arrayStatus['iconcolor'] }}">
                      <i class="far fa-shield-check"></i>
                    </div>
                   <div class="order-content">
                    <h4>Booking Status</h4>
                    <span class="mb-1">Booked</span>
                    <span class="badge bg-{{ $arrayStatus['color'] }} rounded-pill">{{ $arrayStatus['status'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xlg-6">   
	     <div class="form-body">
            <div class="row">
			<div class="col-md-8">
            <div class="card">
            <div class="card-header"><h4 class="m-b-0"><strong>Order Summary</strong></h4></div>
            <div class="card-body">
            <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Services</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($getOrder['results']->detail as $index=>$detail)
                            <tr>
                                <td> 
                                    <div class="media">
                                    <img class="img-fluid m-r-10 m-t-5" src="{{ App\Http\Helpers\Common::getServiceImageUrl($detail->orderserviceImages) }}" style="width:25px; height:auto;"> 
                                        <div class="media-body">                                        
                                        <h5><strong>{{ !empty($detail->services->name) ? $detail->services->name : '' }}</strong></h5>
                                        <p class="text-muted">{{ !empty($detail->services->Service_cat->name) ? $detail->services->Service_cat->name : '' }}</p>
                                    </div>
                                    </div>
                                </td>
                                <td class="text-end">{{ App\Http\Helpers\Common::showTotalAmount($detail->price) }}</td>
                            </tr>
                        
                            @endforeach

                            <tr>                        
                            <td></td>
                            <td>Sub Total : <span class="float-end">{{ $taxAndPrice['subtotal'] }}</span></td>
                            </tr>
                           @foreach($taxAndPrice['tax'] as $taxs)
                             <tr>                        
                                <td></td>
                                <td>{{$taxs['type']}} ({{ $taxs['tax']}}) : <span class="float-end"> {{  $taxs['price'] }}</span></td>
                            </tr>
                           @endforeach                     
                              
                           
                            <tr>                        
                            <td></td>
                            <th>Total Amount : <span class="text-success float-end"> {{ $taxAndPrice['total'] }}</span></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>	
<div class="col-md-4">
    <div class="card"> 
    <div class="card-header"><h4 class="m-b-0"><strong>Customer Info</strong></h4></div>
        <div class="card-body">   
            <ul class="contact-area">
                @if(!empty($getOrder['results']->costomerName->name))
                <li><h6><i class="fa fa-user-alt"></i><strong>{{ $getOrder['results']->costomerName->name }}</strong></h6></li>
                @endif
                @if(!empty($getOrder['results']->address))
                <li><i class="fa fa-map-marker-alt"></i>{{ $getOrder['results']->address }}</li>
                @endif
                @if(!empty($getOrder['results']->phone_no))
                <li><i class="fa fa-phone fa-rotate-90"></i>{{ $getOrder['results']->phone_no }} </li>
                @endif
                @if(!empty($getOrder['results']->email))
                <li><i class="fa fa-envelope"></i>{{ $getOrder['results']->email }}</li>    
                @endif
            </ul>                            
        </div>
    </div>
    <div class="card">
    <div class="card-header"><h4 class="m-b-0"><strong>Professional Info</strong></h4></div>
        <div class="card-body">
        <ul class="contact-area">
                     
               @if(!empty($getOrder['results']->costomerName->name))
                <li><h6><i class="fa fa-user-alt"></i><strong>{{ $getOrder['results']->ProfessionalUser->name }}</strong></h6></li>
                @endif
                @if(!empty($getOrder['results']->professioinlalAddress->location))
                <li><i class="fa fa-map-marker-alt"></i>{{ $getOrder['results']->professioinlalAddress->location }}</li>
                @endif
                @if(!empty($getOrder['results']->professioinlalAddress->phone_no))
                <li><i class="fa fa-phone fa-rotate-90"></i>{{ $getOrder['results']->professioinlalAddress->phone_no }} </li>
                @endif
                @if(!empty($getOrder['results']->professioinlalAddress->email))
                <li><i class="fa fa-envelope"></i>{{ $getOrder['results']->professioinlalAddress->email }}</li>    
                @endif
        </ul> 
        </div>
    </div>
</div>
</div>            
</div>
</div>
</div>
<div class="card">
    <div class="card-header"><h4 class="m-b-0"><strong>Order Status</strong></h4></div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booking Status</th>
                    <th>Boking Date/time</th>
                    <th>Changed By</th>
                </tr>
            </thead>
            <tbody>
            @foreach($getOrder['results']->orderStatus as $Status)
                <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>
                     @foreach(config('variable.order_status') as $index=>$variable)
                     {{ $Status->order_status == $index ? $variable : '' }}  
                     @endforeach
                     </td>
                     <td>{{ date('d-m-Y H:s:i',strtotime($Status->created_at)) }}</td>
                     <td>{{ !empty($Status->userdetails->name) ? $Status->userdetails->name : ''}}&nbsp;&nbsp; ({{ !empty($Status->userdetails->type) ? $Status->userdetails->type : ''}})</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</section>
@endsection
@section('extrastyle')

@endsection
@section('extrascript')
<script>

$("body").on("change","#change_order_status",function(){
	var dataval = $(this).val();
	$("#statusModal").modal('show', {backdrop: 'static'});
	$('.status-change-item-button').attr('data-id',dataval);
    });
$("body").on("click",".status-change-item-button",function(){
   var $this = $(this);
   var status_id = $this.attr('data-id');
   var order_id = {{ $getOrder['results']->id }};
   var professional_id = {{ $getOrder['results']->professional_id }};
   $this.html('Processing.....');
	$.ajax({
		url:"<?php echo route('admin.orders.status.change') ?>",
		type:"POST",
		data:{
			"_token": "{{ csrf_token() }}",
			"status_id":status_id,
			"order_id": order_id,
			"professional_id": professional_id
		},
		success:function(response){
			$this.html('Yes');
			$("#statusModal").modal('hide');
			showToastMessage(response.msg,response.status);
			window.location.reload();
		}
	})  
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
            heading: 'Error'
            , text: message
            , position: 'top-right'
            , loaderBg: '#e46a76'
            , icon: 'error'
            , hideAfter: 3500
            , stack: 6
        });
		}
	}
</script>
@endsection
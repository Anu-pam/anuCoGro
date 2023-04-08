@extends('backend.layouts.app')
@section('content')
@php 
print_r($getOrder['order_status']);exit;
    $arrayStatus = App\Http\Helpers\Common::getOrderStatus($getOrder->order_status);
@endphp
<?php //echo "<pre>";var_dump($getUser);exit;?>
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
       <h3 class="text-success"><strong>Order id #{{ !empty($getOrder->order_id) ? $getOrder->order_id : '-'}}</strong></h3>
       <p><small>Issued on {{ (!empty($getOrder->order_date))?App\Http\Helpers\Common::dateFormatChange($getOrder->order_date):'-' }}</small></p>
    </div>
    <div class="col-md-6 text-end">
    <select class="form-select d-inline-block w-auto" id="change_order_status" name="status">
        <option value="" selected="">Change Order Status</option>
        <option value="1">Pending</option>
        <option value="2">Processing</option>
        <option value="3">Shipped</option>
        <option value="4">Complete</option>
        <option value="5">Cancel</option>
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
                    <span>Paid</span>
                    <span>Credit Card</span>
                    </div>
                    <div class="order-amount">
                        <h3 class="font-medium">{{ !empty($amount) ? App\Http\Helpers\Common::showTotalAmount($amount) :''}}</h3>
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
                    <h4>{{ !empty($getOrder->bookingType) ? App\Http\Helpers\Common::checkbooking($getOrder->bookingType):''}}</h4>
                    <span>Booking Slot</span> 
                    <!-- 10am to 12pm - Wed 30 March  -->
                    <span>{{ (!empty($getOrder->order_date))?App\Http\Helpers\Common::timeFormat($getOrder->created_at):'-' }}  to 12:00 pm - {{ (!empty($getOrder->order_date))?App\Http\Helpers\Common::dayWithDateFormat($getOrder->created_at):'-' }}</span>
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
                    <span>{{ $estimated }} - {{$estimated + 10 }} Minutes</span>
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
                    <h4>Status</h4>
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
            <div class="row m-b-20">
			<div class="col-md-8">
            <div class="card">
    <div class="card-body">
       <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Service Category</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                   
                     @foreach($getOrder->detail as $index=>$detail)
                     <tr>
                        <td>{{ $index+1 }}</td>
                        <!-- <td> <img class="img-fluid m-r-10 m-t-5" src="{{ (!empty($detail->orderserviceImages->image))?url('/public'. $detail->orderserviceImages->image):'' }}" style="width:25px; height:auto;"> {{ !empty($detail->services->name) ? $detail->services->name : '' }}</td> -->
                        <td> <img class="img-fluid m-r-10 m-t-5" src="{{ App\Http\Helpers\Common::getServiceImageUrl($detail->orderserviceImages) }}" style="width:25px; height:auto;"> {{ !empty($detail->services->name) ? $detail->services->name : '' }}</td>
                        <td>{{ !empty($detail->services->Service_cat->name) ? $detail->services->Service_cat->name : '' }}</td>
                        <td>{{ App\Http\Helpers\Common::showTotalAmount($detail->price) }}</td>
                     <tr>
                   
                     @endforeach
                
                  
                    <tr>                        
                       <th colspan="3"></th>
                        <th>Total Amount : {{ App\Http\Helpers\Common::showTotalAmount($getOrder->detail->sum('price')) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

                    <div class="card d-none">
                        <div class="card-body">
                            <h3 class="m-b-20">Order Info</h3>
						
							 <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Service</th><td>{{ (!empty($getOrder->service->name))?$getOrder->service->name:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Professional Type</th><td>{{ (!empty($getOrder->service->service_cat->name))?$getOrder->service->service_cat->name:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Total Amount</th><td>${{ (!empty($getOrder->total_amount))?$getOrder->total_amount:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Order Date</th><td>{{ (!empty($getOrder->order_date))?App\Http\Helpers\Common::dateFormatChange($getOrder->order_date):'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Order Status</th> 
												<td>
													 <label class="form-label">Change Order Status</label>
													  <select class="form-select" id="change_order_status" name="status">
															<option value="1" {{ (!empty($getOrder->order_status) && ($getOrder->order_status == 1)) ? 'selected' : ''}}>Pending</option>
															<option value="2" {{ (!empty($getOrder->order_status) && ($getOrder->order_status == 2)) ? 'selected' : ''}}>Processing</option>
															<option value="3" {{ (!empty($getOrder->order_status) && ($getOrder->order_status == 3)) ? 'selected' : ''}}>Shipped</option>
															<option value="4" {{ (!empty($getOrder->order_status) && ($getOrder->order_status == 4)) ? 'selected' : ''}}>Complete</option>
															<option value="5" {{ (!empty($getOrder->order_status) && ($getOrder->order_status == 5)) ? 'selected' : ''}}>Cancel</option>
													  </select>
												</td>
                                            </tr>
											                             
                                        </table>
                                    </div>
                           
                        </div>
                    </div>
                </div>	
				<div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="m-b-20">Customer Info</h3>
                            <!-- <h5><strong>Shiv Kumar Tiwari</strong></h5>
							<address><p>659 Yonge St 2nd floor,<br />
                                New Brunswick, Canada-2164<br />
                                +1647-348-9393</p></address>   -->
                                <h5><strong>{{ !empty($getOrder->costomerName->name) ? $getOrder->costomerName->name : '' }}</strong></h5>
							<address>{{ !empty($getOrder->address) ? $getOrder->address : '' }}</br>
                                {{ !empty($getOrder->phone_no) ? $getOrder->phone_no : '' }}</p></address>                         
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="m-b-20">Professional Info</h3>
                            <h5><strong>{{ !empty($getOrder->ProfessionalUser->name) ? $getOrder->ProfessionalUser->name : '' }}</strong></h5>
							<address>{{ !empty($getOrder->professioinlalAddress->location) ? $getOrder->professioinlalAddress->location : '' }}</br>
                                {{ !empty($getOrder->professioinlalAddress->phone_no) ? $getOrder->professioinlalAddress->phone_no : '' }}</p></address>                    
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

$("body").on("change","#change_order_status",function(){
	var dataval = $(this).val();
	$("#statusModal").modal('show', {backdrop: 'static'});
	$('.status-change-item-button').attr('data-id',dataval);
    });
$("body").on("click",".status-change-item-button",function(){
   var $this = $(this);
   var status_id = $this.attr('data-id');
   var order_id = {{ $getOrder->id }};
   var professional_id = {{ $getOrder->professional_id }};
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
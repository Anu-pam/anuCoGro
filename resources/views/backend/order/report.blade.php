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
				<li class="breadcrumb-item"><a href="{{ route('admin.orders.list') }}">Orders</a></li>
                <li class="breadcrumb-item active">Report Info</li>
            </ol>
			<a href="{{ route('admin.orders.list') }}" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i class="fa fa-arrow-left"></i> Back</a>
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
                            <h3 class="m-b-30" class="text-center">Report Info</h3>
							@php 
                                 $arrayStatus = App\Http\Helpers\Common::getOrderStatus($getOrder->order_status);
							  @endphp
							  <div class="row">
							     <div class="col-md-6">
								 <div class="table-responsive">
									<table class="table table-hover">
									     <tr>
											<th>Customer</th><td>{{ (!empty($getOrder->customer_name))?$getOrder->customer_name:'-' }}</td>
										 </tr>
										 <tr>
											<th>Email</th><td>{{ (!empty($getOrder->email))?$getOrder->email:'-' }}</td>
										 </tr>
									</table>
								 </div>
								 </div>
								  <div class="col-md-6">
						            <table class="table table-hover">
									    <tr>
											<th>Order No</th><td>{{ (!empty($getOrder->id))? 'ORD-0000-'.$getOrder->id:'-' }}</td>
										</tr>
										<tr>
											<th>Order Date</th><td>{{ (!empty($getOrder->order_date))?App\Http\Helpers\Common::dateFormatChange($getOrder->order_date):'-' }}</td>
										</tr>
									</table>

								 </div>
							  </div>
							 <div class="row">
                                 <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Service</th><td>{{ (!empty($getOrder->service->name))?$getOrder->service->name:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Professional Type</th><td>{{ (!empty($getOrder->service->service_cat->name))?$getOrder->service->service_cat->name:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Customer Name</th><td>{{ (!empty($getOrder->customer_name))?$getOrder->customer_name:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Email</th><td>{{ (!empty($getOrder->email))?$getOrder->email:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Phone No</th><td>{{ (!empty($getOrder->phone_no))?$getOrder->phone_no:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Total Amount</th><td>{{ (!empty($getOrder->total_amount))?$getOrder->total_amount:'-' }}</td>
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
											<tr>
                                                <th>Payment Method</th><td>{{ (!empty($getOrder->payment->payment_method))?$getOrder->payment->payment_method:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Payment Amount</th><td>{{ (!empty($getOrder->payment->total_amount))?$getOrder->payment->total_amount:'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Payment Date</th><td>{{ (!empty($getOrder->payment->payment_date))?App\Http\Helpers\Common::dateFormatChange($getOrder->payment->payment_date):'-' }}</td>
                                            </tr>
                                             <tr>
                                                <th>Payment status</th><td>{{ (!empty($getOrder->payment->payment_status))? App\Http\Helpers\Common::getPaymentStatus($getOrder->payment->payment_status):'-' }}</td>
                                            </tr>
											<tr>
                                                <th>Response Message</th><td>{{ (!empty($getOrder->payment->response_message))? $getOrder->payment->response_message:'-' }}</td>
                                            </tr>                               
                                        </table>
                                    </div>
                                 </div>                                 
                                 <div class="col-md-6">
                                 <h4 class="m-b-30"><strong>Image</strong></h4>
                                    <img class="img-fluid rounded" src="{{ !empty($getOrder->service->serviceImages->image) ? url('public'.$getOrder->service->serviceImages->image) : url('public/assets/images/users/2.jpg')}}">
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

$("body").on("change","#change_order_status",function(){
	var dataval = $(this).val();
	$("#statusModal").modal('show', {backdrop: 'static'});
	$('.status-change-item-button').attr('data-id',dataval);
    });
$("body").on("click",".status-change-item-button",function(){
   var $this = $(this);
   var status_id = $this.attr('data-id');
   var order_id = {{ $getOrder->id }};
   $this.html('Processing.....');
	$.ajax({
		url:"<?php echo route('admin.orders.status.change') ?>",
		type:"POST",
		data:{
			"_token": "{{ csrf_token() }}",
			"status_id":status_id,
			"order_id": order_id
		},
		success:function(response){
			$this.html('Yes');
			$("#statusModal").modal('hide');
			showToastMessage(response.msg,response.status);
			//window.location.reload();
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
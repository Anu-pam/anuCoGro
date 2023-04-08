@extends('backend.layouts.app')
@section('content')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Orders</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item active">Orders</li>
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
	   <!-- table responsive -->
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Orders</h4>
				<div class="table-responsive m-t-40">
					<table id="config-table" class="table display no-wrap table-hover" width="100%">
						<thead>
							<tr>
							   <th>#</th>
							   <!-- <th>Service</th> -->
							   <th>CUSTOMER</th>
							   <th>PHONE</th>
							   <th>EMAIL</th>
                               <th>TOTAL AMOUNT</th>
							   <th>ORDER DATE</th>
							   <th>Status</th>
							   <th>Action</th>
							</tr>
						</thead>
						<tbody>
						@if(!empty($getObjOrderList[0]))
							@foreach($getObjOrderList as $order)
						      @php 
                                 $arrayStatus = App\Http\Helpers\Common::getOrderStatus($order->order_status);
							  @endphp
							<tr>
							    <td>{{ $loop->iteration }}</td>
								<!-- <td>{{ !empty($order->service->name) ? $order->service->name : '' }}</td> -->
								<td>{{ $order->customer_name }}</td>
								<td>{{ !empty($order->phone) ? $order->phone : '' }}</td>
								<td>{{ !empty($order->email) ? $order->email : '' }}</td>
								<td>${{ $order->total_amount }}</td>
								<td>{{ App\Http\Helpers\Common::dateFormatChange($order->order_date) }}</td>
								<td><span class="badge bg-{{ $arrayStatus['color'] }} rounded-pill">{{ $arrayStatus['status'] }}</span></td>
								<td><a class="btn btn-outline-danger btn-sm remove modal_remove d-none" href="javacript:;" title="Remove" data-bs-toggle="modal" data-bs-target="#removeModal" data-href="{{ route('admin.orders.delete',['id'=>$order->id]) }}"><i class="fa fa-trash"></i></a>&nbsp;<a class="btn btn-outline-info btn-sm" href="{{ route('admin.orders.view',['id'=>$order->id]) }}" title="View" ><i class="fa fa-eye"></i></a>&nbsp;<a class="btn btn-outline-primary btn-sm" href="{{ route('admin.orders.report',['id'=>$order->id]) }}" title="Report" ><i class="fa fa-file"></i></a></td>
								
							</tr>
							@endforeach
							@endif
							
						</tbody>
					</table>
				</div>
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
		$.ajaxSetup({
		   headers: {
			 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		   }
		});
        $(function () {
			// Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });
            // responsive table
            $('#config-table').DataTable({
                responsive: true,
				"bLengthChange": false,
				columnDefs: [ { orderable: false, targets: [5,6] } ],
				
				
            });
        });
		
        
    </script>
@endsection
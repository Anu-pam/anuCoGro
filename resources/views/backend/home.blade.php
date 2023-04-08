@extends('backend.layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Dashboard</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
				<li class="breadcrumb-item active">Dashboard</li>
			</ol>
			
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Info box -->
<!-- ============================================================== -->
<div class="row g-0">
	<div class="col-lg-3 col-md-6">
		<div class="card border mb-0">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<a href="{{ route('admin.orders.list') }}">
						<div class="d-flex no-block align-items-center">
							<div>
								<h3><i class="icon-chart"></i></h3>
								<p class="text-muted">Total Bookings</p>
							</div>
							<div class="ms-auto">
								<h2 class="counter text-primary">{{ $orderCount }}</h2>
							</div>
						</div>
					 </a>
					</div>
					<div class="col-12 d-none">
						<div class="progress">
							<div class="progress-bar bg-primary" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="card border mb-0">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<a href="{{ route('admin.orders.list') }}">
						<div class="d-flex no-block align-items-center">
							<div>
								<h3><i class="mdi mdi-currency-usd"></i></h3>
								<p class="text-muted">Total Revenue</p>
							</div>
							<div class="ms-auto">
								<h2 class="counter text-purple">{{ ($totalRevenue!=0)?number_format($totalRevenue,2):0 }}</h2>
							</div>
						</div>
						</a>
					</div>
					<div class="col-12 d-none">
						<div class="progress">
							<div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="card border mb-0">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<a href="{{ route('admin.orders.list') }}">
						<div class="d-flex no-block align-items-center">
							<div>
								<h3><i class="icon-chart"></i></h3>
								<p class="text-muted">Todays Bookings</p>
							</div>
							<div class="ms-auto">
								<h2 class="counter text-cyan">{{ $orderTodayCount }}</h2>
							</div>
						</div>
						</a>
					</div>
					<div class="col-12 d-none">
						<div class="progress">
							<div class="progress-bar bg-cyan" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="card border mb-0">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<a href="{{ route('admin.orders.list') }}">
						<div class="d-flex no-block align-items-center">
							<div>
								<h3><i class="mdi mdi-currency-usd"></i></h3>
								<p class="text-muted">Todays Revenue</p>
							</div>
							<div class="ms-auto">
								<h2 class="counter text-success">{{ ($todayTotalRevenue!=0)?number_format($todayTotalRevenue,2):0 }}</h2>
							</div>
						</div>
						</a>
					</div>
					<div class="col-12 d-none">
						<div class="progress">
							<div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row g-0">
	<div class="col-lg-3 col-md-6">
		<div class="card border">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<a href="{{ route('admin.users.list') }}">
						<div class="d-flex no-block align-items-center">
							<div>
								<h3><i class="icon-people"></i></h3>
								<p class="text-muted">Total Staffs</p>
							</div>
							<div class="ms-auto">
								<h2 class="counter text-primary">{{ $staffCount }}</h2>
							</div>
						</div>
					 </a>
					</div>
					<div class="col-12 d-none">
						<div class="progress">
							<div class="progress-bar bg-primary" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="card border">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<a href="{{ route('admin.services.category.list') }}">
						<div class="d-flex no-block align-items-center">
							<div>
								<h3><i class="icon-user-follow"></i></h3>
								<p class="text-muted">Total Professional Types</p>
							</div>
							<div class="ms-auto">
								<h2 class="counter text-cyan">{{ $professionalTypeCount }}</h2>
							</div>
						</div>
						</a>
					</div>
					<div class="col-12 d-none">
						<div class="progress">
							<div class="progress-bar bg-cyan" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-lg-3 col-md-6">
		<div class="card border">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<a href="{{ route('admin.professionalist.list') }}">
						<div class="d-flex no-block align-items-center">
							<div>
							<h3><i class="icon-user-follow"></i></h3>
								<p class="text-muted">Total Professionals</p>
							</div>
							<div class="ms-auto">
								<h2 class="counter text-success">{{ $professionalistCount }}</h2>
							</div>
						</div>
						</a>
					</div>
					<div class="col-12 d-none">
						<div class="progress">
							<div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-md-6">
		<div class="card border">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<a href="{{ route('admin.services.list') }}">
						<div class="d-flex no-block align-items-center">
							<div>
								<h3><i class="icon-layers"></i></h3>
								<p class="text-muted">Total Services</p>
							</div>
							<div class="ms-auto">
								<h2 class="counter text-purple">{{ $serviceCount }}</h2>
							</div>
						</div>
						</a>
					</div>
					<div class="col-12 d-none">
						<div class="progress">
							<div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- ============================================================== -->
<!-- End Info box -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Comment - table -->
<!-- ============================================================== -->
<div class="row d-none">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h5 class="card-title">Latest Register Users</h5>
					</div>
					
				</div>
			</div>
			
			<div class="table-responsive">
				<table class="table table-hover no-wrap">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>NAME</th>
							<th>Email</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
					    @if(!empty($getLatestStaff[0]))
							@foreach($getLatestStaff as $results)
						         <tr>
									<td class="text-center">{{ $loop->iteration }}</td>
									<td class="txt-oflo"><a href="{{ (!empty($results['role']) && ($results['role'] == 4)) ? route('admin.professionalist.list') : route('admin.users.list') }}" class="text-primary">{{ $results['name']}}</a></td>
									<td class="txt-oflo">{{ $results['email']}}</td>
									<td>
									   @if($results['role'] == 4)
									    <span class="badge bg-success rounded-pill">Professionalist</span>
									   @else
										  <span class="badge bg-primary rounded-pill">Staff</span> 
									   @endif
									</td>
								</tr>
						    @endforeach
						@else
							<tr>
						       <td colspan="4">NO Data Found</td>
							 </tr>
						@endif
						
						
					</tbody>
				</table>
				
			</div>
			    <div class="text-end p-3">
				   <a href="{{ route('admin.users.list') }}" class="btn btn-primary">View More</a>
				</div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- Table -->
	<!-- ============================================================== -->
	<div class="col-lg-6">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h5 class="card-title">Latest Professionalist</h5>
					</div>
					
				</div>
			</div>
			
			<div class="table-responsive">
				<table class="table table-hover no-wrap">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>NAME</th>
							<th>Email</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
					    @if(!empty($getLatestProfessional[0]))
							@foreach($getLatestProfessional as $results)
						         <tr>
									<td class="text-center">{{ $loop->iteration }}</td>
									<td class="txt-oflo"><a href="{{ route('admin.professionalist.view',['id'=>$results['id']])}}" class="text-primary">{{ $results['name']}}</a></td>
									<td class="txt-oflo">{{ $results['email']}}</td>
									<td>
									   @if($results['role'] == 4)
									    <span class="badge bg-success rounded-pill">Professionalist</span>
									   @else
										  <span class="badge bg-primary rounded-pill">Staff</span> 
									   @endif
									</td>
								</tr>
						    @endforeach
						@else
							<tr>
						       <td colspan="4">NO Data Found</td>
							 </tr>
						@endif
						
						
					</tbody>
				</table>
				
			</div>
			    <div class="text-end p-3">
				   <a href="{{ route('admin.professionalist.list') }}" class="btn btn-primary">View More</a>
				</div>
		</div>
	</div>
	
</div>
<div class="row mb-5">
	
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div>
						<h5 class="card-title">Latest Bookings</h5>
					</div>
					
				</div>
			</div>
			
			<div class="table-responsive">
				<table class="table table-hover no-wrap mb-0">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>CUSTOMER</th>
							<th>CUSTOMER EMAIL</th>
							<th>TOTAL AMOUNT</th>
							<th>ORDER DATE</th>
							<th>STATUS</th>
							<th>PAYMENT METHOD</th>
							<th>PAYMENT STATUS</th>
						</tr>
					</thead>
					<tbody>
						 @if(!empty($getLatestOrders[0]))
							@foreach($getLatestOrders as $results)
						      @php 
                                 $arrayStatus = App\Http\Helpers\Common::getOrderStatus($results['order_status']);
							  @endphp
						         <tr>
									<td class="text-center">{{ $loop->iteration }}</td>
									<td class="txt-oflo">{{ $results['customer_name']}}</td>
									<td class="txt-oflo">{{ $results['email']}}</td>
									<td class="txt-oflo">{{ $results['total_amount']}}</td>
									<td class="txt-oflo"><a href="{{ route('admin.orders.view',['id'=>$results['id']])}}" class="text-primary">{{ App\Http\Helpers\Common::dateFormatChange($results['order_date'])}}</a></td>
									<td><span class="badge bg-{{ $arrayStatus['color'] }} rounded-pill">{{ $arrayStatus['status'] }}</span> </td>
									<td class="txt-oflo">{{ (!empty($results->payment->payment_method))?$results->payment->payment_method:'-' }}</td>
									<td class="txt-oflo">{{ (!empty($results->payment->payment_status))? App\Http\Helpers\Common::getPaymentStatus($results->payment->payment_status):'-' }}</td>
								</tr>
						    @endforeach
						@else
							<tr>
						       <td colspan="9" class="text-center">NO Data Found</td>
							 </tr>
						@endif
						
					</tbody>
				</table>
			</div>
			 <div class="text-end p-3">
			   <a href="{{ route('admin.orders.list') }}" class="btn btn-primary">View More</a>
			</div>
		</div>
		 
	</div>
</div>
<!-- ============================================================== -->
<!-- End Comment - chats -->
<!-- ============================================================== -->

@endsection
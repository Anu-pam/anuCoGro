@extends('backend.layouts.app')
@section('content')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Reviews</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item active">Reviews</li>
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
				<h4 class="card-title">Reviews</h4>
				<div class="table-responsive m-t-40">
					<table id="config-table" class="table display no-wrap table-hover" width="100%">
						<thead>
							<tr>
							   <th>#</th>
							   <th>Prof name</th>
							   <th>User</th>
							   <th>EMAIL</th>
							   <th>Rating</th>
							   <th>Text</th>
                               <th>Review DATE</th>
							   <th>Status</th>
							   <th>Action</th>
							</tr>
						</thead>
						<tbody>
						@if(!empty($getObjReviewList[0]))
							@foreach($getObjReviewList as $review)
						      @php 
                                 $arrayStatus = App\Http\Helpers\Common::getOrderStatus($review->status);
							  @endphp
							<tr>
							    <td>{{ $loop->iteration }}</td>
								<td>{{ !empty($review->ReviewProfUser->name) ? $review->ReviewProfUser->name : '' }}</td>
                                <td>{{ $review->user_name }}</td>
								<td>{{ !empty($review->user_email_id) ? $review->user_email_id : '' }}</td>
								<td>{{ $review->rating }}</td>
								<td><span data-toggle="tooltip" data-placement="top" title="{{ $review->review_text }}">{{ (!empty($review->review_text) && (strlen($review->review_text) > 10)) ? substr($review->review_text,0,10).'...' : $review->review_text }}</span></td>
								<td>{{ App\Http\Helpers\Common::dateFormatChange($review->review_time) }}</td>
								<td>
								   @if($review->status ==1)
								      <span class="badge bg-success rounded-pill">Active</span>
							       @else
									   <span class="badge bg-danger rounded-pill">De Active</span>
								   @endif
							   </td>
								<td><a class="btn btn-outline-danger btn-sm remove modal_remove" href="javacript:;" title="Remove" data-bs-toggle="modal" data-bs-target="#removeModal" data-href="{{ route('admin.review.delete',['id'=>$review->id]) }}"><i class="fa fa-trash"></i></a>&nbsp;<a class="btn btn-outline-info btn-sm d-none" href="{{ route('admin.orders.view',['id'=>$review->id]) }}" title="View" ><i class="fa fa-eye"></i></a></td>
								
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
				columnDefs: [ { orderable: false, targets: [8] } ],
				
				
            });
        });
		
        
    </script>
@endsection
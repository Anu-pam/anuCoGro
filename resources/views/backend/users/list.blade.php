@extends('backend.layouts.app')
@section('content')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">User List</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item active">User List</li>
			</ol>
			<a href="{{ route('admin.users.create')}}" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i class="fa fa-plus"></i> Create New</a>
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
				<h4 class="card-title">User List</h4>
				<div class="table-responsive">
					<table id="config-table" class="table display no-wrap table-hover" width="100%">
						<thead>
							<tr>
							   <th>#</th>
							   <th>Name</th>
							   <th>Email</th>
							   <th>Role</th>
							   <th>Status</th>
							   <th>Action</th>
							</tr>
						</thead>
						<tbody>
						@if(!empty($users[0]))
							@foreach($users as $user)
						      <tr>
							    <td>{{ $loop->iteration }}</td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ !empty($user->userRole->name) ? $user->userRole->name : '-' }}</td>
								<td><input type="checkbox" data-id="{{ $user->id }}" class="js-switch status_change" data-color="#f62d51" data-size="small" {{ ($user->status == 1) ? 'checked' : '' }} /></td>
								<td><a class="edit btn btn-outline-success btn-sm edit" href="{{ route('admin.users.edit',['id'=>$user->id]) }}" title="Edit" ><i class="fa fa-edit"></i></a>&nbsp;<a class="btn btn-outline-danger btn-sm remove modal_remove" href="javacript:;" title="Remove" data-bs-toggle="modal" data-bs-target="#removeModal" data-href="{{ route('admin.users.delete',['id'=>$user->id]) }}"><i class="fa fa-trash"></i></a></td>
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
				columnDefs: [ { orderable: false, targets: [4] } ],
				
				
            });
        });
		
        $("body").on("change",".status_change",function(){
			var status = $(this).prop('checked');
			var userId = $(this).attr('data-id');
			if(status == true) {
               status = 1;
			} else {
			   status = 0;
			}
			var server_url = "{{ route('admin.users.status.change')}}";
			$.ajax({
					type: "POST",
					url: server_url,
					data:{'status':status,
					      'userId':userId
					     },
					success: function (info) {
						//console.log(info);return false;
						showToastMessage(info.msg,info.status);
					}
				});
			
		});
		 $("body").on("change",".show_on_header_change",function(){
			var status = $(this).prop('checked');
			var catId = $(this).attr('data-id');
			if(status == true) {
               status = 1;
			} else {
			   status = 0;
			}
			var server_url = "{{ route('admin.services.category.showonheader.change')}}";
			$.ajax({
					type: "POST",
					url: server_url,
					data:{'status':status,
					      'catId':catId
					     },
					success: function (info) {
						//console.log(info);return false;
						showToastMessage(info.msg,info.status);
					}
				});
			
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
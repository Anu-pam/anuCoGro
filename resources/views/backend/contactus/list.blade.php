@extends('backend.layouts.app')
@section('content')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h4 class="text-themecolor">Contact Us</h4>
	</div>
	<div class="col-md-7 align-self-center text-end">
		<div class="d-flex justify-content-end align-items-center">
			<ol class="breadcrumb justify-content-end">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
				<li class="breadcrumb-item active">Contact Us</li>
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
				<h4 class="card-title">Contact Us</h4>
				<div class="table-responsive m-t-40">
					<table id="config-table" class="table display no-wrap table-hover" width="100%">
						<thead>
							<tr>
							   <th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone No</th>
								<th>Message</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						@if(!empty($getObjContactusList[0]))
							@foreach($getObjContactusList as $contactus)
						      
							<tr>
							    <td>{{ $loop->iteration }}</td>
								<td>{{ $contactus->name }}</td>
								<td>{{ $contactus->email }}</td>
								<td>{{ $contactus->phone }}</td>
								<td>{{ (!empty($contactus->message) && (strlen($contactus->message) > 20)) ? substr($contactus->message,0,20).'...' : $contactus->message }}</td>
								<td><a class="btn btn-outline-danger btn-sm remove modal_remove" href="javacript:;" title="Remove" data-bs-toggle="modal" data-bs-target="#removeModal" data-href="{{ route('admin.contactus.delete',['id'=>$contactus->id]) }}"><i class="fa fa-trash"></i></a>&nbsp;<a class="btn btn-outline-info btn-sm" href="{{ route('admin.contactus.view',['id'=>$contactus->id]) }}" title="View" ><i class="fa fa-eye"></i></a></td>
								
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
				columnDefs: [ { orderable: false, targets: [5] } ],
				
				
            });
        });
		
        $("body").on("change",".status_change",function(){
			var status = $(this).prop('checked');
			var serviceId = $(this).attr('data-id');
			if(status == true) {
               status = 1;
			} else {
			   status = 2;
			}
			var server_url = "{{ route('admin.services.status.change')}}";
			$.ajax({
					type: "POST",
					url: server_url,
					data:{'status':status,
					      'serviceId':serviceId
					     },
					success: function (info) {
						//console.log(info);return false;
						showToastMessage(info.msg,info.status);
					}
				});
			
		});
		 $("body").on("change",".show_on_header_change",function(){
			var status = $(this).prop('checked');
			var serviceId = $(this).attr('data-id');
			if(status == true) {
               status = 1;
			} else {
			   status = 0;
			}
			var server_url = "{{ route('admin.services.showonheader.change')}}";
			$.ajax({
					type: "POST",
					url: server_url,
					data:{'status':status,
					      'serviceId':serviceId
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
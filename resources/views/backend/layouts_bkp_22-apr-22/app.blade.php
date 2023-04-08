<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="_token" content="{{ csrf_token()}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('public/assets/images/favicon.png')}}">
    <title>Groom Me Admin</title>
    @include('backend.layouts.includes.styles')
</head>

<body class="horizontal-nav boxed skin-megna fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Groom Me</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('backend.layouts.includes.header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('backend.layouts.includes.sidebar')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
		 <div id="removeModal" class="modal" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
					</div>
					<div class="modal-body">
						<h4>Delete Confirmation</h4>
						<p>Are you sure you want remove this item?.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info waves-effect text-white text-left" data-bs-dismiss="modal">Close</button>
						<a href="" type="button" class="btn btn-danger waves-effect text-white remove-item remove-item-button">Yes</a>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        @include('backend.layouts.includes.footer')
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    @include('backend.layouts.includes.js')
	<script>
	@if($message = Session::get('success'))
        $.toast({
            heading: 'Success'
            , text: "{{ $message }}"
            , position: 'top-right'
            , loaderBg: '#00c292'
            , icon: 'success'
            , hideAfter: 3500
            , stack: 6
        });
        @endif
        @if($errorMessage = Session::get('error'))
        $.toast({
            heading: 'Error'
            , text: "{{ $errorMessage }}"
            , position: 'top-right'
            , loaderBg: '#e46a76'
            , icon: 'error'
            , hideAfter: 3500
            , stack: 6
        });
        @endif
	    $("body").on("click",".modal_remove",function(){
            $(".remove-item-button").attr('href',$(this).attr('data-href'))
        });
	</script>
	@yield('extrascript')
</body>

</html>
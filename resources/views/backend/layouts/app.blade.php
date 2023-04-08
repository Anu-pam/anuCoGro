<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
   <meta name="_token" content="{{ csrf_token()}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('public/assets/images/favicon.png') }}">
    <title>Groom Me</title>
    @include('backend.layouts.includes.styles')
    @yield('extrastyle')
</head>

<body class="horizontal-nav skin-default fixed-layout">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Groom Me Dashboard</p>
        </div>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
             @include('backend.layouts.includes.header')
        </header>
        <aside class="left-sidebar">
            @include('backend.layouts.includes.sidebar')
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
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
				<div id="googleModal" class="modal" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <h4>Google Drive Save Confirmation</h4>
                                <p>Are you sure you want save this item?.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect text-white text-left" data-bs-dismiss="modal">Close</button>
                                <a href="" type="button" class="btn btn-danger waves-effect text-white google-save-item-button">Yes</a>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
				<div id="statusModal" class="modal" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <h4>Change Status Confirmation</h4>
                                <p>Are you sure you want change status?.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect text-white text-left" data-bs-dismiss="modal">Close</button>
                                <a href="javascript:;" type="button" class="btn btn-danger waves-effect text-white status-change-item-button">Yes</a>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
				<div id="statusErrorModal" class="modal" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <p> Select at least one user?.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect text-white text-left" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
       @include('backend.layouts.includes.footer')
    </div>
	  @include('backend.layouts.includes.js')
    
    <script>
        $(function(){
            $('#chat, #msg, #comment, #todo').perfectScrollbar();
        });
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
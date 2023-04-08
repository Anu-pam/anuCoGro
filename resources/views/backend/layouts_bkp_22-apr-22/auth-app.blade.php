<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>{{ env('APP_NAME') }} Backend Login </title>
    
    <!-- page css -->
    <link href="{{ url('public/dist/css/pages/login-register-lock.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ url('public/dist/css/style.css') }}" rel="stylesheet">
    <style>
        @import url({{ url('public/assets/icons/font-awesome/css/all.css') }});
        @import url({{ url('public/assets/icons/simple-line-icons/css/simple-line-icons.css') }});
        @import url({{ url('public/assets/icons/weather-icons/css/weather-icons.min.css') }});
        @import url({{ url('public/assets/icons/themify-icons/themify-icons.css') }});
        @import url({{ url('public/assets/icons/flag-icon-css/flag-icon.min.css') }});
        @import url({{ url('public/assets/icons/material-design-iconic-font/css/materialdesignicons.min.css') }});
        @import url(https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700);
        @import url(https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700);
    </style>
</head>

<body class="skin-default card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Grrom Me</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    @yield('content')
    
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ url('public/assets/node_modules/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ url('public/assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
    
</body>

</html>
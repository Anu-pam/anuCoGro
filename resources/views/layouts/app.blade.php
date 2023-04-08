<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Page Title & Favicon -->
  <title>{{ (!empty($content['meta_title'])) ? $content['meta_title']: '' }}</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ url('public/front/assets/images/favicon.png') }}" type="image/x-icon" />
  <meta name="description" content="{{ (!empty($content['meta_description'])) ? $content['meta_description'] : '' }}" />
  <meta name="keywords" content= "{{ (!empty($content['meta_keyword'])) ? $content['meta_keyword']: '' }}" />

  <!--stylesherets-->
  <link rel="stylesheet" type="text/css" href="{{ url('public/front/assets/stylesheets/bootstrap.css') }}" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Infant:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" type="text/css" href="{{ url('public/front/assets/stylesheets/owl.carousel.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ url('public/front/assets/stylesheets/animate.min.css') }}" />
  <link href="{{ url('public/front/assets/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ url('public/front/assets/stylesheets/meanmenu.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ url('public/front/assets/stylesheets/main.css') }}" />

  <link rel="stylesheet" href="{{ url('public/front/assets/parsleyjs/parsley.css') }}">
  <!-- Javascript -->
  <script src="{{ url('public/front/assets/javascripts/vendor/head.core.min.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/lt-ie-9.js') }}"></script>
</head>

<body>
  <div id="container">
    <!-- header -->
   @include('layouts.includes.header')
    <!-- /header -->
     @yield('content')
    <!-- Footer -->
	@include('layouts.includes.footer')
    <!-- Footer -->
  </div>
  <!-- Javascript -->
  <script src="{{ url('public/front/assets/javascripts/vendor/jquery-1.11.2.min.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/popper.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/bootstrap.bundle.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/bootstrap.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/jquery-touch-events.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/ofi.browser.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/jquery.matchHeight.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/wow.min.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/owl.carousel.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/meanmenu.js') }}"></script>
  <script src="{{ url('public/front/assets/toast-master/js/jquery.toast.js') }}"></script>
  
  <script src="{{ url('public/front/assets/parsleyjs/parsley.min.js') }}"></script>
  <!-- Custom JS Code for this page -->
  <script src="{{ url('public/front/assets/javascripts/main.js') }}"></script>
  <script src="{{ url('public/front/assets/javascripts/vendor/scrollreveal.js') }}"></script>
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
	</script>
  @yield('extrascript')
</body>

</html>
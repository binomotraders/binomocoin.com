<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Binomo Coin</title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('wallet/images/favicon.png') }}">

    <link href="{{ asset('wallet/css/style.css') }}" rel="stylesheet">

    <!-- Start custom css -->
    @yield('my-style') 
    <!-- End custom css -->
</head>
<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        @include('wallet.layouts.header')

        @yield('page-content')

        @include('wallet.layouts.footer')
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->



    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('wallet/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('wallet/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('wallet/js/custom.min.js') }}"></script>
    <script src="{{ asset('wallet/js/deznav-init.js') }}"></script>  
    
    <!-- Start custom script -->
    @yield('my-script')
    <!-- End custom script -->
</body>
</html>
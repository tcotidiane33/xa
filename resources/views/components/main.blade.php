<!DOCTYPE HTML>
<html>
<head>
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel='stylesheet' type='text/css' />
    <!-- font-awesome icons CSS -->
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <!-- side nav css file -->
    <link href='{{ asset('css/SidebarNav.min.css') }}' media='all' rel='stylesheet' type='text/css'/>
    @stack('styles')
</head>
<body class="cbp-spmenu-push">
    <div class="main-content">
        {{-- @include('partials.sidebar')
        @include('partials.header') --}}

        <!-- main content start-->
        <div id="page-wrapper">
            <div class="main-page">
                @yield('content')
            </div>
        </div>
        <!--footer-->
        {{-- @include('partials.footer') --}}
        <!--//footer-->
    </div>

    <!-- js-->
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('js/classie.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    @stack('scripts')
</body>
</html>

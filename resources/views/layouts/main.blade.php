<!DOCTYPE HTML>
<html>
<head>
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('web/css/bootstrap.css') }}" rel='stylesheet' type='text/css' />

    <!-- Custom CSS -->
    <link href="{{ asset('web/css/style.css') }}" rel='stylesheet' type='text/css' />

    <!-- font-awesome icons CSS -->
    <link href="{{ asset('web/css/font-awesome.css') }}" rel="stylesheet">

    <!-- side nav css file -->
    <link href="{{ asset('web/css/SidebarNav.min.css') }}" media='all' rel='stylesheet' type='text/css'/>

     <!-- Flowbite CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@1.5.3/dist/flowbite.min.css" />

     @stack('styles')
</head>
<body class="cbp-spmenu-push">
    <div class="main-content">
        {{-- @include('admin.partials.sidebar')

        <!-- header-starts -->
        @include('admin.partials.header')
        <!-- //header-ends --> --}}

        <!-- main content start-->
        <main>
            @yield('content')
        </main>

        <!--footer-->
        {{-- @include('admin.partials.footer') --}}
        <!--//footer-->
    </div>

    <!-- js-->
    <script src="{{ asset('web/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('web/js/modernizr.custom.js') }}"></script>

    <!-- Metis Menu -->
    <script src="{{ asset('web/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('web/js/custom.js') }}"></script>

    <!-- side nav js -->
    <script src="{{ asset('web/js/SidebarNav.min.js') }}" type='text/javascript'></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('web/js/bootstrap.js') }}"></script>


	<!-- new added graphs chart js-->

	<!-- Classie --><!-- for toggle left push menu script -->

	<!-- //Classie --><!-- //for toggle left push menu script -->

	<!--scrolling js-->
	<script src="{{ asset('web/js/jquery.nicescroll.js') }}"></script>
	<script src="{{ asset('web/js/scripts.js') }}"></script>
	<!--//scrolling js-->

	<!-- side nav js -->

	<!-- //side nav js -->


	<!-- //for index page weekly sales java script -->

    <!-- Flowbite JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.5.3/dist/flowbite.min.js"></script>

    @stack('scripts')
</body>
</html>

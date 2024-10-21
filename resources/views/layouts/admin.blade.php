<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sibpilot') }}</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/backoffice/vendors/images/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('/backoffice/vendors/images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('/backoffice/vendors/images/favicon-16x16.png') }}" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>

    <!-- ... -->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
    <!-- ... -->

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backoffice/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backoffice/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/vendors/styles/style.css') }}" />


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
        crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
    </script>
    <!-- End Google Tag Manager -->
    {{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = true;

      var pusher = new Pusher('fa0f7a721b5ce846e356', {
        cluster: 'eu'
      });

      var channel = pusher.subscribe('my-channel');
      channel.bind('my-event', function(data) {
        alert(JSON.stringify(data));
      });
    </script> --}}
    @stack('styles')
    <style>
        body {
            background: url('assets/mp6.svg') center/cover fixed;
            overflow-x: hidden;
        }
    </style>
    <style>
        .chat-list {
            background-color: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }

        .chat-list-item {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.3s;
        }

        .chat-list-item:hover {
            background-color: #e9ecef;
        }

        .chat-list-item:last-child {
            border-bottom: none;
        }

        .view-chat-btn {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .view-chat-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    @include('components.partials.admin.pre-loader')

    <div class="header">
        @include('components.partials.search-bar')
        @include('components.partials.header')

    </div>

    {{-- // customeize App setting --}}
    @include('components.partials.right-sidebar')
    {{-- // left side bar  --}}
    @include('components.partials.admin.left-side-bar')

    <div class="mobile-menu-overlay"></div>

    <main>
            @if (session('error'))
                <div class="alert alert-danger mt-6">
                    {{ session('error') }}
                </div>
            @endif
            <div class="main-container">
                @yield('content')
            </div>
    </main>
   
    <!-- welcome modal end -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.5.3/dist/flowbite.min.js"></script>
     <!-- js-->
     {{-- <script src="{{ asset('backoffice/src/js/jquery-1.11.1.min.js') }}"></script> --}}
     {{-- <script src="{{ asset('backoffice/src/js/modernizr.custom.js') }}"></script> --}}
 
     <!-- Metis Menu -->
     {{-- <script src="{{ asset('backoffice/src/js/metisMenu.min.js') }}"></script> --}}
     {{-- <script src="{{ asset('backoffice/src/js/custom.js') }}"></script> --}}
 
     <!-- side nav js -->
     {{-- <script src="{{ asset('backoffice/src/js/SidebarNav.min.js') }}" type='text/javascript'></script> --}}
 
     <!-- Bootstrap Core JavaScript -->
     {{-- <script src="{{ asset('backoffice/src/js/bootstrap.js') }}"></script> --}}
 
     {{-- <script src="{{ asset('backoffice/src/js/Chart.bundle.js') }}"></script> --}}
     {{-- <script src="{{ asset('backoffice/src/js/utils.js') }}"></script> --}}
 
    <!--scrolling js-->
	<script src="{{ asset('backoffice/src/js/jquery.nicescroll.js') }}"></script>
	<script src="{{ asset('backoffice/src/js/scripts.js') }}"></script>
	<!--//scrolling js-->
    <!-- js -->
    <script src="{{ asset('backoffice/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('backoffice/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('backoffice/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('backoffice/vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('backoffice/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backoffice/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backoffice/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backoffice/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backoffice/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backoffice/vendors/scripts/dashboard3.js') }}"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    {{-- @yield('scripts') --}}
    @stack('scripts')

</body>

</html>

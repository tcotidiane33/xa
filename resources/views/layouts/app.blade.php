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
    <link rel="apple-touch-icon" sizes="180x180" href="backoffice/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="backoffice/vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="backoffice/vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="backoffice/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="backoffice/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="backoffice/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="backoffice/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="backoffice/vendors/styles/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>

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
</head>

<body>
    {{-- @include('frontend.components.partials.pre-loader') --}}

    {{-- <div class="header"> --}}
        {{-- @include('frontend.components.partials.search-bar') --}}
        {{-- @include('frontend.components.partials.header') --}}

    {{-- </div> --}}

    {{-- // customeize App setting --}}
    {{-- @include('frontend.components.partials.right-sidebar') --}}
    {{-- // left side bar  --}}
    {{-- @include('frontend.components.partials.left-side-bar') --}}

    {{-- <div class="mobile-menu-overlay"></div> --}}



    <div class="app">
        <main>
            @yield('content')
        </main>
    </div>
    <!-- welcome modal end -->
    <!-- js -->
    <script src="backoffice/vendors/scripts/core.js"></script>
    <script src="backoffice/vendors/scripts/script.min.js"></script>
    <script src="backoffice/vendors/scripts/process.js"></script>
    <script src="backoffice/vendors/scripts/layout-settings.js"></script>
    <script src="backoffice/src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="backoffice/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="backoffice/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="backoffice/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="backoffice/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="backoffice/vendors/scripts/dashboard3.js"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @yield('scripts')
</body>

</html>

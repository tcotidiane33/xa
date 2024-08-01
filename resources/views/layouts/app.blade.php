<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{-- @yield() --}}
            {{-- {{ $slot }} --}}
            <div class="container">
                @yield('content')
            </div>
        </main>
        <script>
            $(document).ready(function() {
                $('.ckeditor').ckeditor();
            });

            $(document).ready(function() {
                $('select[name="client_id"]').on('change', function() {
                    var clientId = $(this).val();

                    if (clientId) {
                        $.ajax({
                            url: '/api/getClientInfo',
                            type: 'GET',
                            data: {
                                q: clientId
                            },
                            success: function(data) {
                                if (data) {
                                    $('input[name="gestionnaire_id"]').val(data.gestionnaire ? data
                                        .gestionnaire.name : 'N/A');
                                    $('input[name="responsable_id"]').val(data.responsable ? data
                                        .responsable.name : 'N/A');
                                    $('input[name="superviseur_id"]').val(data.superviseur ? data
                                        .superviseur.name : 'N/A');

                                    // Gestionnaires supplémentaires
                                    var gestionnairesSelect = $(
                                        'select[name="gestionnaires_ids[]"]');
                                    gestionnairesSelect.empty();
                                    $.each(data.gestionnaires, function(id, name) {
                                        gestionnairesSelect.append(new Option(name, id));
                                    });
                                    gestionnairesSelect.trigger('change');
                                } else {
                                    $('input[name="gestionnaire_id"]').val('N/A');
                                    $('input[name="responsable_id"]').val('N/A');
                                    $('input[name="superviseur_id"]').val('N/A');
                                    $('select[name="gestionnaires_ids[]"]').empty().trigger(
                                        'change');
                                }
                            }
                        });
                    }
                });
            });
        </script>
    </div>
</body>

</html>

@extends('layouts.admin')

@section('content')
    <div class="main-content ">

        <div class="page-wrapper mb-5">
            <div class="container mx-auto mb-3 ">
                <h2 class="text-2xl font-bold mb-6">{{ __('Tableau de bord des clients') }}</h2>

                <!-- Formulaire de filtre -->
                <form method="GET" action="{{ route('clients.index') }}" class="mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Recherche</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">Tous</option>
                                <option value="actif" {{ request('status') == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="inactif" {{ request('status') == 'inactif' ? 'selected' : '' }}>Inactif
                                </option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filtrer</button>
                        </div>
                    </div>
                </form>

                <!-- Liste des clients -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">{{ __('Liste des clients') }}</h2>
                    <div class="mb-4">
                        <a href="{{ route('clients.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fa fa-plus mr-2" aria-hidden="true"></i>Ajouter un client
                        </a>
                    </div>

                    @include('components.basic-table', [
                        'headers' => [
                            'Nom',
                            'Responsable Paie',
                            'Gestionnaire Principal',
                            'Convention Collective',
                            'Est-ce un cabinet ?',
                            'Portefeuille Cabinet',
                            'Actions',
                        ],
                        'rows' => $clients->map(function ($client) {
                            return [
                                'name' => $client->name,
                                'responsable' => $client->responsablePaie
                                    ? $client->responsablePaie->name
                                    : 'Non assigné',
                                'gestionnaire' => $client->gestionnairePrincipal
                                    ? $client->gestionnairePrincipal->name
                                    : 'Non assigné',
                                'convention' => $client->conventionCollective
                                    ? $client->conventionCollective->name
                                    : 'Non assignée',
                                'is_cabinet' => $client->is_cabinet ? 'Oui' : 'Non',
                                'portfolio_cabinet' => $client->portfolioCabinet
                                    ? $client->portfolioCabinet->name
                                    : 'Aucun',
                                'actions' =>
                                    '
                                                        <a href="' .
                                    route('clients.show', $client) .
                                    '" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-3 py-2 text-center me-2 mb-2">Voir</a>
                                                       <hr> <a href="' .
                                    route('clients.edit', $client) .
                                    '" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-2.5 py-2 text-center me-2 mb-2">Modifier</a>
                                                    ',
                            ];
                        }),
                        'rawColumns' => ['actions'],
                    ])
                    <div class="mt-4">
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
            <div class="container mt-3">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Répartition des clients par statut</h3>
                        <div id="clientStatusChart"></div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Évolution du nombre de clients</h3>
                        <div id="clientGrowthChart"></div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Top 5 des conventions collectives</h3>
                        <div id="topConventionsChart"></div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Répartition des clients par gestionnaire principal</h3>
                    <div id="clientsByManagerChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Graphique de répartition des clients par statut
            var clientStatusOptions = {
                series: [{
                    data: [
                        {{ $clients->where('status', 'actif')->count() }},
                        {{ $clients->where('status', 'inactif')->count() }}
                    ]
                }],
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: ['Actif', 'Inactif'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            var clientStatusChart = new ApexCharts(document.querySelector("#clientStatusChart"),
                clientStatusOptions);
            clientStatusChart.render();

            // Graphique d'évolution du nombre de clients
            var clientGrowthOptions = {
                series: [{
                    name: 'Nombre de clients',
                    data: [{{ $clientGrowthData }}]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                },
                xaxis: {
                    categories: [{{ $clientGrowthLabels }}]
                },
                yaxis: {
                    title: {
                        text: 'Nombre de clients'
                    }
                }
            };
            var clientGrowthChart = new ApexCharts(document.querySelector("#clientGrowthChart"),
                clientGrowthOptions);
            clientGrowthChart.render();

            // Graphique des top 5 conventions collectives
            var topConventionsOptions = {
                series: [{
                    data: [{{ $topConventionsData }}]
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: [{{ $topConventionsLabels }}],
                }
            };
            var topConventionsChart = new ApexCharts(document.querySelector("#topConventionsChart"),
                topConventionsOptions);
            topConventionsChart.render();

            // Graphique de répartition des clients par gestionnaire principal
            var clientsByManagerOptions = {
                series: [{
                    // data: [{{ $clientsByManagerData }}]
                    data: [{{ $topConventionsData }}]
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: [{{ $clientsByManagerLabels }}],
                }
            };
            var clientsByManagerChart = new ApexCharts(document.querySelector("#clientsByManagerChart"),
                clientsByManagerOptions);
            clientsByManagerChart.render();
        });
    </script>
@endpush

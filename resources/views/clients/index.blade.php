@extends('layouts.admin')

@section('content')
    <div class="main-content  container mx-auto px-4 py-8 ">
        <div class="row">
            <br>
        </div>
        
        <div class="main-page ">
            <div class="container mx-auto px-4 py-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Tableau de bord des clients') }}</h2>
            
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
            
                <!-- Le reste de votre code pour la liste des clients -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">{{ __('Liste des clients') }}</h2>
                    <div class="mb-4">
                        <a href="{{ route('clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fa fa-plus mr-2" aria-hidden="true"></i>Ajouter un client
                        </a>
                    </div>
            
                </div>
            </div>
            {{-- ======================================= --}}
            {{-- <h2 class="title1">{{ __('Liste des clients') }}</h2>
            <div class="panel-body widget-shadow">
                <div class="mb-4">
                    <a href="{{ route('clients.create') }}" class="btn btn-success btn-flat btn-pri"><i class="fa fa-plus"
                            aria-hidden="true"></i> Ajouter un client</a>
                </div> --}}

                @include('components.basic-table', [
                    'headers' => [
                        'Nom',
                        'Responsable Paie',
                        'Gestionnaire Principal',
                        'Convention Collective',
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
                            'actions' =>
                                '<a href="' .
                                route('clients.edit', $client) .
                                '" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a> ' .
                                '<form action="' .
                                route('clients.destroy', $client) .
                                '" method="POST" style="display:inline;">' .
                                csrf_field() .
                                method_field('DELETE') .
                                '<button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce client ?\')">Supprimer</button>' .
                                '</form>',
                        ];
                    }),
                    'rawColumns' => ['actions'],
                ])
                <div class="mt-4">
                    {{ $clients->links() }}
                </div>
            </div>
           
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
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
    var clientStatusChart = new ApexCharts(document.querySelector("#clientStatusChart"), clientStatusOptions);
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
    var clientGrowthChart = new ApexCharts(document.querySelector("#clientGrowthChart"), clientGrowthOptions);
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
    var topConventionsChart = new ApexCharts(document.querySelector("#topConventionsChart"), topConventionsOptions);
    topConventionsChart.render();

    // Graphique de répartition des clients par gestionnaire principal
    var clientsByManagerOptions = {
        series: [{
            data: [{{ $clientsByManagerData }}]
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
    var clientsByManagerChart = new ApexCharts(document.querySelector("#clientsByManagerChart"), clientsByManagerOptions);
    clientsByManagerChart.render();
});
</script>
@endpush
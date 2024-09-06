<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Tableau de bord des Relations Gestionnaire-Client</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Répartition des Gestionnaires</h2>
            <div id="gestionnairesChart"></div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Top 5 des Gestionnaires</h2>
            <div id="topGestionnairesChart"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Évolution des Relations</h2>
        <div id="evolutionChart"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Graphique de répartition des gestionnaires
            var gestionnairesOptions = {
                series: [{{ $stats['principalCount'] }}, {{ $stats['secondaryCount'] }}],
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: ['Principaux', 'Secondaires'],
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
            new ApexCharts(document.querySelector("#gestionnairesChart"), gestionnairesOptions).render();

            // Graphique du top 5 des gestionnaires
            var topGestionnairesOptions = {
                series: [{
                    data: [
                        @foreach ($stats['topGestionnaires'] as $gestionnaire)
                            {{ $gestionnaire->clients_geres_count }},
                        @endforeach
                    ]
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
                    categories: [
                        @foreach ($stats['topGestionnaires'] as $gestionnaire)
                            "{{ $gestionnaire->name }}",
                        @endforeach
                    ],
                }
            };
            new ApexCharts(document.querySelector("#topGestionnairesChart"), topGestionnairesOptions).render();

            // Graphique d'évolution des relations
            var evolutionOptions = {
                series: [{
                    name: 'Relations',
                    data: [
                        @foreach ($stats['relationsEvolution'] as $evolution)
                            {{ $evolution->count }},
                        @endforeach
                    ]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: [
                        @foreach ($stats['relationsEvolution'] as $evolution)
                            "{{ $evolution->month }}",
                        @endforeach
                    ],
                }
            };
            new ApexCharts(document.querySelector("#evolutionChart"), evolutionOptions).render();
        });
    </script>
@endpush

@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto p-4 pt-6 md:p-6">
        <div class="flex justify-center mb-4">
            <h2 class="text-2xl font-bold">{{ __('Admin Dashboard') }}</h2>
        </div>

        <div class="grid grid-cols-4 gap-4 mb-4">
            <div class="bg-white rounded-lg shadow-md p-2 ml-1">
                <div class="flex items-center">
                    <i class="fa fa-users text-2xl text-gray-500 mr-2"></i>
                    <div>
                        <h5 class="text-lg font-bold">{{ $totalUsers }}</h5>
                        <span class="text-gray-500">Total Utilisateurs</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-2 ml-1">
                <div class="flex items-center">
                    <i class="fa fa-building text-2xl text-gray-500 mr-2"></i>
                    <div>
                        <h5 class="text-lg font-bold">{{ $totalClients }}</h5>
                        <span class="text-gray-500">Total Clients</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-2 ml-1">
                <div class="flex items-center">
                    <i class="fa fa-calendar text-2xl text-gray-500 mr-2"></i>
                    <div>
                        <h5 class="text-lg font-bold">{{ $totalPeriodesPaie }}</h5>
                        <span class="text-gray-500">Périodes de paie</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-2 ml-1">
                <div class="flex items-center">
                    <i class="fa fa-pie-chart text-2xl text-gray-500 mr-2"></i>
                    <div>
                        <h5 class="text-lg font-bold">{{ $successPercentage }}%</h5>
                        <span class="text-gray-500">Taux de réussite</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- ============================================================ --}}

        <div class="max-w-sm w-full md:w-1/2 p-4">
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Statut des traitements de paie</h3>
                <canvas id="traitementsPaieChart"></canvas>
            </div>
        </div>
        <div class="max-w-sm w-full md:w-1/2 p-4">
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Évolution du nombre de clients</h3>
                <canvas id="clientsEvolutionChart"></canvas>
            </div>
        </div>
        
        <div class="max-w-sm w-full p-4">
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Périodes de paie par mois</h3>
                <canvas id="periodespaieChart"></canvas>
            </div>
        </div>
        
        
        <div class="max-w-sm w-full md:w-1/2 p-4">
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-semibold mb-4">Évolution du nombre de clients</h3>
                <div class="mb-4">
                    <label for="startDate" class="block mb-2">Date de début:</label>
                    <input type="date" id="startDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="mb-4">
                    <label for="endDate" class="block mb-2">Date de fin:</label>
                    <input type="date" id="endDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <button id="updateChart" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Mettre à jour</button>
                <canvas id="clientsEvolutionChart"></canvas>
            </div>
        </div>

        {{-- =================================================== --}}
        
        

        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold">Traitements de paie</h3>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-info p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fa fa-clock-o text-2xl text-white mr-2"></i>
                        <div>
                            <h5 class="text-lg font-bold">{{ $traitementsPaieEnCours }}</h5>
                            <span class="text-white">En cours</span>
                        </div>
                    </div>
                </div>
                <div class="bg-success p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fa fa-check-circle-o text-2xl text-white mr-2"></i>
                        <div>
                            <h5 class="text-lg font-bold">{{ $traitementsPaieTerminer }}</h5>
                            <span class="text-white">Terminés</span>
                        </div>
                    </div>
                </div>
                <div class="bg-danger p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fa fa-pause-circle-o text-2xl text-white mr-2"></i>
                        <div>
                            <h5 class="text-lg font-bold">{{ $traitementsPaieInterrompu }}</h5>
                            <span class="text-white">Interrompus</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold">Documents rattachées aux clients </h3>
            </div>
            <button class="{{ request()->routeIs('materials.index') ? 'active' : '' }}">
                <a href="{{ route('materials.index') }}">
                    <i class="fa fa-file"></i> <span>{{ __('Tous les Materials') }}</span>
                </a>
            </button>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold">Derniers clients ajoutés</h3>
            </div>
            <ul class="list-group">
                @foreach ($latestClients as $client)
                    <li class="list-group-item bg-[#3b5998] hover:bg-[#3b5998]/90 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">{{ $client->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('web/js/SimpleChart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('traitementsPaieChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['En cours', 'Terminés', 'Interrompus'],
                    datasets: [{
                        data: [{{ $traitementsPaieEnCours }}, {{ $traitementsPaieTerminer }}, {{ $traitementsPaieInterrompu }}],
                        backgroundColor: ['#3B82F6', '#10B981', '#EF4444']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
        </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('clientsEvolutionChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Nombre de clients',
                    data: [65, 59, 80, 81, 56, 55],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    </script>
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('periodespaieChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Nombre de périodes de paie',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
        </script>
        
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('clientsEvolutionChart').getContext('2d');
            var myChart;
        
            function updateChart(startDate, endDate) {
                // Ici, vous devriez faire une requête AJAX pour obtenir les données filtrées
                // Pour cet exemple, nous utilisons des données statiques
                var data = [65, 59, 80, 81, 56, 55];
                var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        
                if (myChart) {
                    myChart.destroy();
                }
        
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Nombre de clients',
                            data: data,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        
            document.getElementById('updateChart').addEventListener('click', function() {
                var startDate = document.getElementById('startDate').value;
                var endDate = document.getElementById('endDate').value;
                updateChart(startDate, endDate);
            });
        
            // Initial chart render
            updateChart();
        });
        </script>
@endpush

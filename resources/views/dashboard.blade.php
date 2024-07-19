<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <style> 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Overview</h2>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de clients</h3>
                            <p class="text-3xl font-bold">{{ $clients->count() }}</p>
                        </div>
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de nouveaux clients</h3>
                            <p class="text-3xl font-bold">{{ $newClients->count() }}</p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold mb-4">Prestations</h2>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de prestations</h3>
                            <p class="text-3xl font-bold">{{ $traitementsPaie->count() }}</p>
                        </div>
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Prestations par mois</h3>
                            <canvas id="prestations-par-mois" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <script>
                        const ctxPrestationsParMois = document.getElementById('prestations-par-mois');
                        new Chart(ctxPrestationsParMois, {
                            type: 'line',
                            data: {
                                labels: [
                                    @foreach ($periodePaie as $periode)
                                        '{{ $periode->debut }}',
                                    @endforeach
                                ],
                                datasets: [{
                                    label: 'Prestations par mois',
                                    data: [
                                        @foreach ($periodePaie as $periode)
                                            {{ $traitementsPaie->where('periode_paie_id', $periode->id)->count() }},
                                        @endforeach
                                    ],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>

                    <!-- ... -->

                    <h2 class="text-2xl font-bold mb-4">Convention collective</h2>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de clients par convention collective</h3>
                            <canvas id="convention-collective" width="400" height="200"></canvas>
                        </div>
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Top 5 conventions</h3>
                            <ul>
                                @foreach ($topConventions as $convention)
                                    <li>{{ $convention->name }} ({{ $convention->clients->count() }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold mb-4">Contact</h2>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de contacts paie</h3>
                            <p class="text-3xl font-bold">{{ $traitementsPaie->where('type', 'paie')->count() }}</p>
                        </div>
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de contacts comptabilité</h3>
                            <p class="text-3xl font-bold">{{ $traitementsPaie->where('type', 'comptabilité')->count() }}
                            </p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold mb-4">Dates</h2>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de clients par date de début de prestation</h3>
                            <canvas id="clients-par-date-debut" width="400" height="200"></canvas>
                        </div>
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de clients par date de maj fiche para</h3>
                            <canvas id="clients-par-date-maj-fiche" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <script>
                        const ctxClientsParDateDebut = document.getElementById('clients-par-date-debut');
                        new Chart(ctxClientsParDateDebut, {
                            type: 'line',
                            data: {
                                labels: [
                                    @foreach ($periodePaie as $periode)
                                        '{{ $periode->debut }}',
                                    @endforeach
                                ],
                                datasets: [{
                                    label: 'Nombre de clients par date de début de prestation',
                                    data: [
                                        @foreach ($periodePaie as $periode)
                                            {{ $traitementsPaie->where('periode_paie_id', $periode->id)->count() }},
                                        @endforeach
                                    ],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        const ctxClientsParDateMajFiche = document.getElementById('clients-par-date-maj-fiche');
                        new Chart(ctxClientsParDateMajFiche, {
                            type: 'line',
                            data: {
                                labels: [
                                    @foreach ($periodePaie as $periode)
                                        '{{ $periode->updated_at }}',
                                    @endforeach
                                ],
                                datasets: [{
                                    label: 'Nombre de clients par date de maj fiche para',
                                    data: [
                                        @foreach ($periodePaie as $periode)
                                            {{ $traitementsPaie->where('periode_paie_id', $periode->id)->where('updated_at', 'LIKE', $periode->updated_at . '%')->count() }},
                                        @endforeach
                                    ],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>

                    <h2 class="text-2xl font-bold mb-4">Dates</h2>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de clients par date de début de prestation</h3>
                            <canvas id="clients-par-date-debut" width="400" height="200"></canvas>
                        </div>
                        <div class="w-1/2 px-4 mb-4">
                            <h3 class="text-lg font-bold mb-2">Nombre de clients par date de maj fiche para</h3>
                            <canvas id="clients-par-date-maj-fiche" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const ctxPrestationsParMois = document.getElementById('prestations-par-mois').getContext('2d');
        new Chart(ctxPrestationsParMois, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($prestationsParMois as $month => $count)
                        '{{ date('F Y', mktime(0, 0, 0, $month, 1)) }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Prestations par mois',
                    data: [
                        @foreach ($prestationsParMois as $count)
                            {{ $count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        </script>
    @endpush
</x-app-layout>

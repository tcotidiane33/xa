@extends('layouts.admin')

@section('title', 'Gestion des relations Gestionnaire-Client')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@push('styles')
    <style>
        select[multiple] {
            min-height: 100px;
        }
    </style>
@endpush
@section('content')
    <div class="main-content">
        <div class="container">
            </br></br></br>
        </div>
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">Gestion des relations Gestionnaire-Client</h1>

            @include('admin.partials.alerts')

            

            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.gestionnaire-client.create') }}" class="btn btn-primary">Ajouter une nouvelle
                    relation</a>
                <button type="button"
                    class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2"
                    data-toggle="modal" data-target="#transfertMasseModal">
                    Transfert en masse
                </button>
            </div>

            @include('admin.gestionnaire-client.partials.filters')

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gestionnaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gestionnaires Secondaires</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Responsable Paie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($clients as $client)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $client->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $client->gestionnairePrincipal->first()->name ?? 'Non assigné' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $client->gestionnaires->where('pivot.is_principal', true)->isNotEmpty() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $client->gestionnaires->where('pivot.is_principal', true)->isNotEmpty() ? 'Principal' : 'Secondaire' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($client->gestionnairesSecondaires->isNotEmpty())
                                        {{ $client->gestionnairesSecondaires->pluck('name')->implode(', ') }}
                                    @else
                                        Aucun
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $client->responsablePaie->name ?? 'Non assigné' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.gestionnaire-client.show', $client->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mr-2">Voir</a>
                                    <a href="{{ route('admin.gestionnaire-client.edit', $client->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-2">Éditer</a>
                                    <button type="button" class="text-blue-600 hover:text-blue-900 mr-2"
                                        data-toggle="modal" data-target="#transferModal{{ $client->id }}">
                                        Transférer
                                    </button>
                                    <form action="{{ route('admin.gestionnaire-client.destroy', $client->id) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette relation ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Aucune
                                    relation trouvée</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <div class="mt-4">
                {{ $clients->links() }}
            </div>

            @include('admin.gestionnaire-client.partials.transfer_modals')
            @include('admin.gestionnaire-client.partials.mass_transfer_modal')
        </div>
    </div>
    @include('admin.gestionnaire-client.partials.dashboard')
@endsection

@push('styles')
    <style>
        .mb-3 {
            margin-bottom: 1rem;
        }

        .label {
            display: inline-block;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }

        .label-info {
            background-color: #5bc0de;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded event fired');

            // Graphique de répartition des relations par type
            var relationsTypeOptions = {
                series: [{{ $principalCount ?? 0 }}, {{ $secondaryCount ?? 0 }}],
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: ['Principal', 'Secondaire'],
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
            var relationsTypeChart = new ApexCharts(document.querySelector("#relationsTypeChart"),
                relationsTypeOptions);
            relationsTypeChart.render();

            // Graphique des top 5 gestionnaires
            var topGestionnairesOptions = {
                series: [{
                    data: {!! json_encode($topGestionnairesData ?? []) !!}
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
                    categories: {!! json_encode($topGestionnairesLabels ?? []) !!},
                }
            };
            var topGestionnairesChart = new ApexCharts(document.querySelector("#topGestionnairesChart"),
                topGestionnairesOptions);
            topGestionnairesChart.render();

            // Graphique d'évolution du nombre de relations
            var relationsEvolutionOptions = {
                series: [{
                    name: 'Nombre de relations',
                    data: {!! json_encode($relationsEvolutionData ?? []) !!}
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
                    categories: {!! json_encode($relationsEvolutionLabels ?? []) !!},
                }
            };
            var relationsEvolutionChart = new ApexCharts(document.querySelector("#relationsEvolutionChart"),
                relationsEvolutionOptions);
            relationsEvolutionChart.render();
        });
    </script>

@endpush

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
        <div class="cbp-spmenu-push rounded-lg">
            <div class="main-content">
                <div class="panel-body widget-shadow">
                    <div class="row ">
                        <div class="card-header mb-4">
                            <h3 class="card-title">Liste des relations Gestionnaire-Client</h3>
                        </div>
                        <!-- Bouton pour ouvrir le modal -->
                        <button type="button"
                            class="text-white bg-gradient-to-r mb-3 from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 m-3"
                            data-toggle="modal" data-target="#transfertMasseModal">
                            Transfert en masse
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="transfertMasseModal" tabindex="-1" role="dialog"
                            aria-labelledby="transfertMasseModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="transfertMasseModalLabel">Transfert en masse</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.gestionnaire-client.transfert-masse') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="ancien_gestionnaire_id">Ancien Gestionnaire</label>
                                                <select name="ancien_gestionnaire_id" id="ancien_gestionnaire_id"
                                                    class="form-control" required>
                                                    @foreach ($gestionnaires as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nouveau_gestionnaire_id">Nouveau Gestionnaire</label>
                                                <select name="nouveau_gestionnaire_id" id="nouveau_gestionnaire_id"
                                                    class="form-control" required>
                                                    @foreach ($gestionnaires as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="clients">Clients à transférer</label>
                                                <select name="clients[]" id="clients" class="form-control" multiple
                                                    required>
                                                    @foreach ($clients as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Transférer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <a href="{{ route('admin.gestionnaire-client.create') }}"
                                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 m-3">Ajouter
                                    une nouvelle relation</a>
                            </div>

                            <form action="{{ route('admin.gestionnaire-client.index') }}" method="GET" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="client_id" class="form-control">
                                            <option value="">Tous les clients</option>
                                            @foreach ($clients as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ request('client_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="gestionnaire_id" class="form-control">
                                            <option value="">Tous les gestionnaires</option>
                                            @foreach ($gestionnaires as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ request('gestionnaire_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="is_principal" class="form-control">
                                            <option value="">Tous</option>
                                            <option value="1" {{ request('is_principal') == '1' ? 'selected' : '' }}>
                                                Principal</option>
                                            <option value="0" {{ request('is_principal') == '0' ? 'selected' : '' }}>
                                                Secondaire</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit"
                                            class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Filtrer</button>
                                        <a href="{{ route('admin.gestionnaire-client.index') }}"
                                            class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Réinitialiser</a>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Gestionnaire Principal</th>
                                        <th>Est Principal</th>
                                        <th>Gestionnaires Secondaires</th>
                                        <th>Responsable Paie</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($relations as $relation)
                                        <tr>
                                            <td>{{ $relation->id }}</td>
                                            <td>{{ $relation->client->name }}</td>
                                            <td>{{ $relation->gestionnaire->name ?? 'Non assigné' }}</td>
                                            {{-- <td>{{ $relation->gestionnaire ? $relation->gestionnaire->user->name : 'Non assigné' }}</td> --}}
                                            <td>{{ $relation->is_principal ? 'Oui' : 'Non' }}</td>
                                            <td>
                                                @if (is_array($relation->gestionnaires_secondaires) && count($relation->gestionnaires_secondaires) > 0)
                                                    @foreach ($relation->gestionnaires_secondaires as $gestionnaireId)
                                                        {{ App\Models\User::find($gestionnaireId)->name ?? 'N/A' }}<br>
                                                    @endforeach
                                                @else
                                                    {{-- @if (isset($relation->gestionnaire) && $relation->gestionnaire)
                                                        {{ $relation->gestionnaire->name }}
                                                    @else --}}
                                                        Non assigné
                                                    {{-- @endif --}}
                                                @endif
                                            </td>
                                            <td>{{ $relation->responsablePaie ? $relation->responsablePaie->name : 'Non assigné' }}
                                            </td>
                                            <td class="gap-10">
                                                <a href="{{ route('admin.gestionnaire-client.edit', $relation->id) }}"
                                                    class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 mb-2">Éditer</a>
                                                <form
                                                    action="{{ route('admin.gestionnaire-client.destroy', $relation->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 mb-2"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette relation ?')">Supprimer</button>
                                                </form>
                                                <button type="button"
                                                    class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-1 py-1 text-center me-2 mb-2"
                                                    data-toggle="modal" data-target="#transferModal{{ $relation->id }}">
                                                    Transférer
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $relationsLinks->links() }}
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($relations as $relation)
                            <!-- Modal pour le transfert -->
                            <div class="modal fade" id="transferModal{{ $relation->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="transferModalLabel{{ $relation->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.gestionnaire-client.transfer', $relation) }}"
                                            method="POST">
                                            @csrf
                                            {{-- @method('POST') --}}
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="transferModalLabel{{ $relation->id }}">
                                                    Transférer le client {{ $relation->client->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="new_gestionnaire_id">Nouveau gestionnaire</label>
                                                    <select name="new_gestionnaire_id" id="new_gestionnaire_id"
                                                        class="form-control" required>
                                                        @foreach ($gestionnaires as $id => $name)
                                                            @if ($id != $relation->gestionnaire_id)
                                                                <option value="{{ $id }}">{{ $name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Fermer</button>
                                                <button type="submit"
                                                    class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Transférer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="main-page">

            <div class="container  mx-auto px-4 py-8">
                <h2 class="text-2xl font-bold mb-6">Tableau de bord des relations Gestionnaire-Client</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Répartition des relations par type</h3>
                        <div id="relationsTypeChart"></div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Top 5 des gestionnaires par nombre de clients</h3>
                        <div id="topGestionnairesChart"></div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Évolution du nombre de relations</h3>
                    <div id="relationsEvolutionChart"></div>
                </div>

                <!-- Le reste de votre code pour la liste et les filtres -->
                <!-- ... -->

            </div>
        </div>

    </div>
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

@extends('layouts.admin')

@section('title', 'Gestion des relations Gestionnaire-Client')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
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

        <div class="cbp-spmenu-push">
            <div class="main-content">
                <div class="panel-body widget-shadow" >
                    <div class="row ">
                        <div class="card-header">
                            <h3 class="card-title">Liste des relations Gestionnaire-Client</h3>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('admin.gestionnaire-client.create') }}" class="btn btn-success mb-3">Ajouter
                                une nouvelle relation</a>

                            <form action="{{ route('admin.gestionnaire-client.index') }}" method="GET" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="client_id" class="form-control">
                                            <option value="">Tous les clients</option>
                                            @foreach($clients as $id => $name)
                                                <option value="{{ $id }}" {{ request('client_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="gestionnaire_id" class="form-control">
                                            <option value="">Tous les gestionnaires</option>
                                            @foreach($gestionnaires as $id => $name)
                                                <option value="{{ $id }}" {{ request('gestionnaire_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="is_principal" class="form-control">
                                            <option value="">Tous</option>
                                            <option value="1" {{ request('is_principal') == '1' ? 'selected' : '' }}>Principal</option>
                                            <option value="0" {{ request('is_principal') == '0' ? 'selected' : '' }}>Secondaire</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Filtrer</button>
                                        <a href="{{ route('admin.gestionnaire-client.index') }}" class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Réinitialiser</a>
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
                                            <td>{{ $relation->gestionnaire ? $relation->gestionnaire->user->name : 'Non assigné' }}</td>
                                            <td>{{ $relation->is_principal ? 'Oui' : 'Non' }}</td>
                                            <td>
                                                @if ($relation->gestionnaires_secondaires)
                                                    @foreach ($relation->gestionnaires_secondaires as $gestionnaireId)
                                                        @php
                                                            $gestionnaire = \App\Models\Gestionnaire::find($gestionnaireId);
                                                        @endphp
                                                        {{ $gestionnaire && $gestionnaire->user ? $gestionnaire->user->name : 'N/A' }}<br>
                                                    @endforeach
                                                @else
                                                    Aucun
                                                @endif
                                            </td>
                                            <td>{{ $relation->responsablePaie ? $relation->responsablePaie->name : 'Non assigné' }}</td>
                                            <td class="gap-10">
                                                <a href="{{ route('admin.gestionnaire-client.edit', $relation->id) }}"
                                                    class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Éditer</a>
                                                <form
                                                    action="{{ route('admin.gestionnaire-client.destroy', $relation->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette relation ?')">Supprimer</button>
                                                </form>
                                                <button type="button" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" data-toggle="modal"
                                                    data-target="#transferModal{{ $relation->id }}">
                                                    Transférer
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $relations->links() }}
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($relations as $relation)
                            <!-- Modal pour le transfert -->
                            <div class="modal fade" id="transferModal{{ $relation->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="transferModalLabel{{ $relation->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.gestionnaire-client.transfer', $relation->id) }}"
                                            method="POST">
                                            @csrf
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
                                                        @foreach (\App\Models\Gestionnaire::whereHas('user')->get() as $gestionnaire)
                                                            @if ($gestionnaire->id != $relation->gestionnaire_id)
                                                                <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->user->name }}
                                                                </option>
                                                            @endif
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
                        @endforeach
                    </div>
                </div>
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

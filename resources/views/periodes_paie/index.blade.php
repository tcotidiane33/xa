@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="row">
                </br></br>
            </div>
            <div class="breadcrumb">

                <h1>Période paie</h1>
            </div>
            <div class="container">

                <form action="{{ route('periodes-paie.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="client_id" class="form-control">
                                <option value="">Tous les clients</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="date_debut" class="form-control" placeholder="Date de début"
                                value="{{ request('date_debut') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="date_fin" class="form-control" placeholder="Date de fin"
                                value="{{ request('date_fin') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="validee" class="form-control">
                                <option value="">Tous les statuts</option>
                                <option value="1" {{ request('validee') === '1' ? 'selected' : '' }}>Validée</option>
                                <option value="0" {{ request('validee') === '0' ? 'selected' : '' }}>Non validée
                                </option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Filtrer</button>
                        </div>
                    </div>
                </form>

                <a href="{{ route('periodes-paie.create') }}" class="btn btn-success mb-3">Créer une nouvelle période</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Client</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($periodesPaie as $periode)
                            <tr>
                                <td>{{ $periode->reference }}</td>
                                <td>{{ $periode->client->name }}</td>
                                <td>{{ $periode->debut->format('d/m/Y') }}</td>
                                <td>{{ $periode->fin->format('d/m/Y') }}</td>
                                <td>{{ $periode->validee ? 'Validée' : 'Non validée' }}</td>
                                <td
                                    class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium">
                                    <a href="{{ route('periodes-paie.show', $periode) }}"
                                        class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Voir</a>
                                    <a href="{{ route('periodes-paie.edit', $periode) }}"
                                        class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                                    <form action="{{ route('periodes-paie.destroy', $periode) }}" method="POST"
                                        class="inline-block"  style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette période de paie ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $periodesPaie->links() }}

            </div>
        </div>
        
    </div>
@endsection

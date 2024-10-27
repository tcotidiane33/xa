@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="breadcrumb flex">
                <h1>Période paie</h1> <span class="m-2"><br></span>
                <a href="{{ route('periodes-paie.create') }}" class="btn btn-success  mb-3">Créer une nouvelle période</a>
            </div>

            <div class="main-content">
                <div class="page-wrapper mb-5">
                    <div class="container mx-auto mb-3">
                        <div class="container">
                            <form action="{{ route('periodes-paie.index') }}" method="GET" class="mb-4">
                                <div class="row flex">
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
                                        <select name="gestionnaire_id" class="form-control">
                                            <option value="">Tous les gestionnaires</option>
                                            @foreach ($gestionnaires as $gestionnaire)
                                                <option value="{{ $gestionnaire->id }}"
                                                    {{ request('gestionnaire_id') == $gestionnaire->id ? 'selected' : '' }}>
                                                    {{ $gestionnaire->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="date_debut" class="form-control"
                                            placeholder="Date de début" value="{{ request('date_debut') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="date_fin" class="form-control" placeholder="Date de fin"
                                            value="{{ request('date_fin') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">Filtrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="container mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Gestionnaire</th>
                                        <th>NB Bulletins</th>
                                        <th>Client</th>
                                        <th>Maj fiche para</th>
                                        <th>Réception variables</th>
                                        <th>Préparation BP</th>
                                        <th>Validation BP client</th>
                                        <th>Préparation et envoie DSN</th>
                                        <th>Accusés DSN</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periodesPaie as $periode)
                                        <tr>
                                            <td>{{ $periode->client->gestionnairePrincipal->name }}</td>
                                            <td>{{ $periode->client->nb_bulletins }}</td>
                                            <td>{{ $periode->client->name }}</td>
                                            <td><span
                                                    class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                                                    {{ $periode->client->maj_fiche_para }}</span></td>
                                            <td><span
                                                    class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                                                    {{ $periode->reception_variables }}</span></td>
                                            <td><span
                                                    class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                                                    {{ $periode->preparation_bp }}</span></td>
                                            <td><span
                                                    class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                                                    {{ $periode->validation_bp_client }}</span></td>
                                            <td><span
                                                    class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                                                    {{ $periode->preparation_envoie_dsn }}</span></td>
                                            <td><span
                                                    class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                                                    {{ $periode->accuses_dsn }}</span></td>
                                            <td>{{ $periode->notes }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $periodesPaie->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="container">

                <form action="{{ route('periodes-paie.index') }}" method="GET" class="mb-4">
                    <div class="row flex">
                        <div class="col-md-2">
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
                        <div class="col-md-2">
                            <input type="date" name="date_debut" class="form-control" placeholder="Date de début"
                                value="{{ request('date_debut') }}">
                        </div>
                        <div class="col-md-2">
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
                            <button type="submit"
                                class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Filtrer</button>
                        </div>
                    </div>
                </form>

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
                                <td> <span
                                        class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                                        {{ $periode->client->name }}</span></td>
                                <td> <span
                                        class="bg-indigo-100 text-indigo-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-indigo-400 border border-indigo-400">
                                        {{ $periode->debut->format('d/m') }}</span></td>
                                <td> <span
                                        class="bg-green-100 text-green-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                        {{ $periode->fin->format('d/m') }}</span></td>
                                <td> <span
                                        class="bg-red-100 text-red-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                        {{ $periode->validee ? 'Clôturer' : 'Non Clôturer' }}</span></td>
                                <td
                                    class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium">
                                    <a href="{{ route('periodes-paie.show', $periode) }}"
                                        class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Voir</a>
                                    <a href="{{ route('periodes-paie.edit', $periode) }}"
                                        class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                                    {{-- <form action="{{ route('periodes-paie.destroy', $periode) }}" method="POST"
                                        class="inline-block"  style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette période de paie ?')">Supprimer</button>
                                    </form> --}}
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

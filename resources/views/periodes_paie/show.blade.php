@extends('layouts.admin')

@section('title', 'Détails de la Période de Paie')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="breadcrumb">
                <h1>Détails de la période de paie</h1>
            </div>
            <div class="panel-body widget-shadow">
                <h4>{{ $periodePaie->reference }}</h4>
                <table class="table">
                    <tr>
                        <th>Client</th>
                        <td><span class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                            {{ $periodePaie->client->name }}</span></td>
                    </tr>
                    <tr>
                        <th>Date de début</th>
                        <td>  <span  class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                            {{ $periodePaie->debut->format('d/m/Y') }}</span></td>
                    </tr>
                    <tr>
                        <th>Date de fin</th>
                        <td> <span   class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">                                     
                            {{ $periodePaie->fin->format('d/m/Y') }}</span></td>
                    </tr>
                    <!-- Autres champs -->
                </table>
                <div class="mt-4">
                    <a href="{{ route('periodes-paie.edit', $periodePaie) }}"
                        class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                </div>
               
            </div>
        </div>
    </div>
    {{-- ============================================= --}}
    <div class="main-content">
        <div class="main-page">
            
            <div class="container">
                <h2 class="mt-4">Traitements de paie associés</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Gestionnaire</th>
                            <th>Nombre de bulletins</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($periodePaie->traitementsPaie as $traitement)
                            <tr>
                                <td>{{ $traitement->gestionnaire->name }}</td>
                                <td>{{ $traitement->nbr_bull }}</td>
                                <td>{{ $traitement->statut }}</td>
                                <td>
                                    <a href="{{ route('traitements-paie.show', $traitement) }}"
                                        class="btn btn-sm btn-info">Voir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('periodes-paie.edit', $periodePaie) }}"
                    class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                <a href="{{ route('periodes-paie.index') }}"
                    class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Retour
                    à la liste</a>
            </div>
            <hr>
            <div class="container">
                <h4>Historique des actions</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Action</th>
                            <th>Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($periodePaie->histories as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $history->user->name }}</td>
                                <td>{{ $history->action }}</td>
                                <td>{{ $history->details }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mb-5">
                <br>
            </div>
        </div>
    </div>

@endsection

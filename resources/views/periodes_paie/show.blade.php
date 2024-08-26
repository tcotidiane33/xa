@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="row">
                </br></br>
            </div>
            <div class="breadcrumb">
                <h1>Détails de la période de paie</h1>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $periodePaie->reference }}</h5>
                        {{-- <p><strong>Client:</strong> {{ $periodePaie->client->name }}</p> --}}
                        <p><strong>Client:</strong> {{ $periodePaie->client ? $periodePaie->client->name : 'Non défini' }}</p>
                        <p><strong>Début:</strong> {{ $periodePaie->debut ? $periodePaie->debut->format('d/m/Y') : 'Non défini' }}</p>
                        <p><strong>Fin:</strong> {{ $periodePaie->fin ? $periodePaie->fin->format('d/m/Y') : 'Non défini' }}</p>
                        <p><strong>Statut:</strong> {{ $periodePaie->validee ? 'Validée' : 'Non validée' }}</p>
                    </div>
                </div>
            
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
                        @foreach($periodePaie->traitementsPaie as $traitement)
                        <tr>
                            <td>{{ $traitement->gestionnaire->name }}</td>
                            <td>{{ $traitement->nbr_bull }}</td>
                            <td>{{ $traitement->statut }}</td>
                            <td>
                                <a href="{{ route('traitements-paie.show', $traitement) }}" class="btn btn-sm btn-info">Voir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            
                <a href="{{ route('periodes-paie.edit', $periodePaie) }}" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                <a href="{{ route('periodes-paie.index') }}" class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Retour à la liste</a>
            </div>
        </div>
    </div>
@endsection

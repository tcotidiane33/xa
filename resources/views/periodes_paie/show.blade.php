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
            
                <a href="{{ route('periodes-paie.edit', $periodePaie) }}" class="btn btn-warning">Modifier</a>
                <a href="{{ route('periodes-paie.index') }}" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
@endsection

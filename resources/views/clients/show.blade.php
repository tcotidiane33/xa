@extends('layouts.app')

@section('content')
    <h1>Détails du client</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $client->name }}</h5>
            <p class="card-text">
                <strong>Responsable Paie:</strong> {{ $client->responsablePaie->name }}<br>
                <strong>Gestionnaire Principal:</strong> {{ $client->gestionnairePrincipal->name }}<br>
                <strong>Date de début de prestation:</strong> {{ $client->date_debut_prestation ? $client->date_debut_prestation->format('d/m/Y') : 'Non définie' }}<br>
                <strong>Contact Paie:</strong> {{ $client->contact_paie ?? 'Non défini' }}<br>
                <strong>Contact Comptabilité:</strong> {{ $client->contact_comptabilite ?? 'Non défini' }}
            </p>
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">Modifier</a>
            <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client?')">Supprimer</button>
            </form>
        </div>
    </div>

    <h2 class="mt-4">Périodes de paie</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($client->periodesPaie as $periode)
                <tr>
                    <td>{{ $periode->reference }}</td>
                    <td>{{ $periode->debut->format('d/m/Y') }}</td>
                    <td>{{ $periode->fin->format('d/m/Y') }}</td>
                    <td>{{ $periode->validee ? 'Validée' : 'Non validée' }}</td>
                    <td>
                        <a href="{{ route('periodes_paie.show', $periode) }}" class="btn btn-sm btn-info">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

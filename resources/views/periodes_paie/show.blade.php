@extends('layouts.app')

@section('content')
    <h1>Détails de la période de paie</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $periodePaie->reference }}</h5>
            <p class="card-text">
                <strong>Client:</strong> {{ $periodePaie->client->name }}<br>
                <strong>Début:</strong> {{ $periodePaie->debut->format('d/m/Y') }}<br>
                <strong>Fin:</strong> {{ $periodePaie->fin->format('d/m/Y') }}<br>
                <strong>Statut:</strong> {{ $periodePaie->validee ? 'Validée' : 'Non validée' }}
            </p>
            <a href="{{ route('periodes_paie.edit', $periodePaie) }}" class="btn btn-warning">Modifier</a>
            <form action="{{ route('periodes_paie.destroy', $periodePaie) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette période de paie?')">Supprimer</button>
            </form>
        </div>
    </div>

    <h2 class="mt-4">Traitements de paie associés</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Nombre de bulletins</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodePaie->traitementsPaie as $traitement)
                <tr>
                    <td>{{ $traitement->reference }}</td>
                    <td>{{ $traitement->nbr_bull }}</td>
                    <td>
                        <a href="{{ route('traitements_paie.show', $traitement) }}" class="btn btn-sm btn-info">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

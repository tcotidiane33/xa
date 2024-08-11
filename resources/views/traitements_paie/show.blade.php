@extends('layouts.app')

@section('content')
    <h1>Détails du traitement de paie</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $traitementPaie->reference }}</h5>
            <p class="card-text">
                <strong>Client:</strong> {{ $traitementPaie->client->name }}<br>
                <strong>Période de paie:</strong> {{ $traitementPaie->periodePaie->reference }}<br>
                <strong>Nombre de bulletins:</strong> {{ $traitementPaie->nbr_bull }}<br>
                <strong>Gestionnaire:</strong> {{ $traitementPaie->gestionnaire->name }}<br>
                <strong>Date de mise à jour fiche para:</strong> {{ $traitementPaie->maj_fiche_para ? $traitementPaie->maj_fiche_para->format('d/m/Y') : 'Non définie' }}<br>
                <strong>Date de réception des variables:</strong> {{ $traitementPaie->reception_variable ? $traitementPaie->reception_variable->format('d/m/Y') : 'Non définie' }}<br>
                <!-- Ajoutez d'autres champs ici -->
            </p>
            @if($traitementPaie->pj_nbr_bull)
                <p><strong>Pièce jointe (Nombre de bulletins):</strong> <a href="{{ asset('storage/' . $traitementPaie->pj_nbr_bull) }}" target="_blank">Voir le fichier</a></p>
            @endif
            <a href="{{ route('traitements_paie.edit', $traitementPaie) }}" class="btn btn-warning">Modifier</a>
            <form action="{{ route('traitements_paie.destroy', $traitementPaie) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce traitement de paie?')">Supprimer</button>
            </form>
        </div>
    </div>
@endsection

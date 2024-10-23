@extends('layouts.admin')

@section('title', 'Détails du Traitement de Paie')

@section('content')
<div class="main-content">
    <div class="main-page">
        <div class="row">
            <div class="container">
                <h1>Détails du Traitement de Paie</h1>
                <table class="table">
                    <tr>
                        <th>Client</th>
                        <td>{{ $traitementPaie->client->name }}</td>
                    </tr>
                    <tr>
                        <th>Gestionnaire</th>
                        <td>{{ $traitementPaie->gestionnaire->name }}</td>
                    </tr>
                    <tr>
                        <th>Période de paie</th>
                        <td>{{ $traitementPaie->periodePaie->reference }}</td>
                    </tr>
                    <tr>
                        <th>Nombre de bulletins</th>
                        <td>{{ $traitementPaie->nbr_bull }}</td>
                    </tr>
                    <tr>
                        <th>Réception variables</th>
                        <td>{{ $traitementPaie->reception_variable }}</td>
                    </tr>
                    <tr>
                        <th>Préparation BP</th>
                        <td>{{ $traitementPaie->preparation_bp }}</td>
                    </tr>
                    <tr>
                        <th>Validation BP client</th>
                        <td>{{ $traitementPaie->validation_bp_client }}</td>
                    </tr>
                    <tr>
                        <th>Préparation et envoie DSN</th>
                        <td>{{ $traitementPaie->preparation_envoie_dsn }}</td>
                    </tr>
                    <tr>
                        <th>Accusés DSN</th>
                        <td>{{ $traitementPaie->accuses_dsn }}</td>
                    </tr>
                    <tr>
                        <th>Notes</th>
                        <td>{{ $traitementPaie->notes }}</td>
                    </tr>
                    <tr>
                        <th>Fichier MAJ fiche para</th>
                        <td>
                            @if($traitementPaie->maj_fiche_para_file)
                                <a href="{{ asset('storage/' . $traitementPaie->maj_fiche_para_file) }}" target="_blank">Voir le fichier</a>
                            @else
                                Aucun fichier
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fichier Réception variables</th>
                        <td>
                            @if($traitementPaie->reception_variables_file)
                                <a href="{{ asset('storage/' . $traitementPaie->reception_variables_file) }}" target="_blank">Voir le fichier</a>
                            @else
                                Aucun fichier
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fichier Préparation BP</th>
                        <td>
                            @if($traitementPaie->preparation_bp_file)
                                <a href="{{ asset('storage/' . $traitementPaie->preparation_bp_file) }}" target="_blank">Voir le fichier</a>
                            @else
                                Aucun fichier
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fichier Validation BP client</th>
                        <td>
                            @if($traitementPaie->validation_bp_client_file)
                                <a href="{{ asset('storage/' . $traitementPaie->validation_bp_client_file) }}" target="_blank">Voir le fichier</a>
                            @else
                                Aucun fichier
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fichier Préparation et envoie DSN</th>
                        <td>
                            @if($traitementPaie->preparation_envoi_dsn_file)
                                <a href="{{ asset('storage/' . $traitementPaie->preparation_envoi_dsn_file) }}" target="_blank">Voir le fichier</a>
                            @else
                                Aucun fichier
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fichier Accusés DSN</th>
                        <td>
                            @if($traitementPaie->accuses_dsn_file)
                                <a href="{{ asset('storage/' . $traitementPaie->accuses_dsn_file) }}" target="_blank">Voir le fichier</a>
                            @else
                                Aucun fichier
                            @endif
                        </td>
                    </tr>
                </table>
                <a href="{{ route('traitements-paie.edit', $traitementPaie) }}" class="btn btn-primary">Modifier</a>
                <form action="{{ route('traitements-paie.destroy', $traitementPaie) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce traitement de paie ?')">Supprimer</button>
                </form>
                <a href="{{ route('traitements-paie.index') }}" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
</div>
@endsection
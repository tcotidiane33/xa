cccc
@extends('layouts.admin')

@section('content')
<div class="main-page">
    <h2 class="title1">{{ __('Détails du client') }}</h2>
    <div class="panel-body widget-shadow">
        <h4>{{ $client->name }}</h4>
        <table class="table">
            <tr>
                <th>Responsable Paie</th>
                <td>{{ $client->responsablePaie ? $client->responsablePaie->name : 'Non assigné' }}</td>
            </tr>
            <tr>
                <th>Gestionnaire Principal</th>
                <td>{{ $client->gestionnairePrincipal ? $client->gestionnairePrincipal->name : 'Non assigné' }}</td>
            </tr>
            <tr>
                <th>Date de début de prestation</th>
                <td>{{ $client->date_debut_prestation->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Date estimative d'envoi des variables</th>
                <td>{{ $client->date_estimative_envoi_variables ? $client->date_estimative_envoi_variables->format('d/m/Y') : 'Non définie' }}</td>
            </tr>
            <tr>
                <th>Contact Paie</th>
                <td>{{ $client->contact_paie }}</td>
            </tr>
            <tr>
                <th>Contact Comptabilité</th>
                <td>{{ $client->contact_comptabilite }}</td>
            </tr>
            <tr>
                <th>Nombre de bulletins</th>
                <td>{{ $client->nb_bulletins }}</td>
            </tr>
            <tr>
                <th>Date de mise à jour fiche para</th>
                <td>{{ $client->maj_fiche_para ? $client->maj_fiche_para->format('d/m/Y') : 'Non définie' }}</td>
            </tr>
            <tr>
                <th>Convention Collective</th>
                <td>{{ $client->conventionCollective ? $client->conventionCollective->name : 'Non assignée' }}</td>
            </tr>
            <tr>
                <th>Statut</th>
                <td>{{ $client->status }}</td>
            </tr>
        </table>
        <div class="mt-4">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">Modifier</a>
            <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection

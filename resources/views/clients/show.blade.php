@extends('layouts.admin')

@section('title', 'Détails du Client')

@section('content')
<div class="main-content">
    <div class="main-page mb-5">
        <div class="breadcrumb">
            <h1>Détails du client</h1>
        </div>
        <div class="panel-body widget-shadow">
            <h4>{{ $client->name }}</h4>
            <table class="table">
                <tr>
                    <th>Email</th>
                    <td>{{ $client->email }}</td>
                </tr>
                <tr>
                    <th>Téléphone</th>
                    <td>{{ $client->phone }}</td>
                </tr>
                <tr>
                    <th>Ville</th>
                    <td>{{ $client->ville }}</td>
                </tr>
                <tr>
                    <th>Nom du Contact Paie</th>
                    <td>{{ $client->contact_paie_nom }}</td>
                </tr>
                <tr>
                    <th>Prénom du Contact Paie</th>
                    <td>{{ $client->contact_paie_prenom }}</td>
                </tr>
                <tr>
                    <th>Téléphone du Contact Paie</th>
                    <td>{{ $client->contact_paie_telephone }}</td>
                </tr>
                <tr>
                    <th>Email du Contact Paie</th>
                    <td>{{ $client->contact_paie_email }}</td>
                </tr>
                <tr>
                    <th>Nom du Contact Comptabilité</th>
                    <td>{{ $client->contact_compta_nom }}</td>
                </tr>
                <tr>
                    <th>Prénom du Contact Comptabilité</th>
                    <td>{{ $client->contact_compta_prenom }}</td>
                </tr>
                <tr>
                    <th>Téléphone du Contact Comptabilité</th>
                    <td>{{ $client->contact_compta_telephone }}</td>
                </tr>
                <tr>
                    <th>Email du Contact Comptabilité</th>
                    <td>{{ $client->contact_compta_email }}</td>
                </tr>
                <tr>
                    <th>Gestionnaire Principal</th>
                    <td>{{ $client->gestionnairePrincipal ? $client->gestionnairePrincipal->name : 'Non assigné' }}</td>
                </tr>
                <tr>
                    <th>Nombre de bulletins</th>
                    <td><span class="bg-green-100 text-red-800 text-xxl font-medium me-2 px-3 py-1.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">{{ $client->nb_bulletins }}</span></td>
                </tr>
                <tr>
                    <th>Date de mise à jour fiche para</th>
                    <td>{{ $client->maj_fiche_para ? \Carbon\Carbon::parse($client->maj_fiche_para)->format('d/m/Y') : 'Non définie' }}</td>
                </tr>
                <tr>
                    <th>Convention Collective</th>
                    <td><span class="bg-green-100 text-red-800 text-xxl font-medium me-2 px-3 py-1.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">{{ $client->conventionCollective ? $client->conventionCollective->name : 'Non assignée' }}</span></td>
                </tr>
                <tr>
                    <th>Date de début de prestation</th>
                    <td>{{ $client->date_debut_prestation ? \Carbon\Carbon::parse($client->date_debut_prestation)->format('d/m/Y') : 'Non définie' }}</td>
                </tr>
                <tr>
                    <th>Date de fin de prestation</th>
                    <td>{{ $client->date_fin_prestation ? \Carbon\Carbon::parse($client->date_fin_prestation)->format('d/m/Y') : 'Non définie' }}</td>
                </tr>
                <tr>
                    <th>Date de signature du contrat</th>
                    <td>{{ $client->date_signature_contrat ? \Carbon\Carbon::parse($client->date_signature_contrat)->format('d/m/Y') : 'Non définie' }}</td>
                </tr>
                <tr>
                    <th>Taux AT</th>
                    <td>
                        <span class="bg-indigo-100 text-indigo-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-indigo-400 border border-indigo-400">
                        {{ $client->taux_at }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Adhésion myDRH</th>
                    <td >
                        <span class="bg-red-100 text-red-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                        {{ $client->adhesion_mydrh ? 'Oui' : 'Non' }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Date d'adhésion myDRH</th>
                    <td>{{ $client->date_adhesion_mydrh ? \Carbon\Carbon::parse($client->date_adhesion_mydrh)->format('d/m/Y') : 'Non définie' }}</td>
                </tr>
            </table>
            <div class="mt-4 mb-5">
                <a href="{{ route('clients.edit', $client) }}"
                    class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="main-page mb-5">
        <div class="breadcrumb">
            <h1>Détails du client</h1>
        </div>
        <div class="panel-body widget-shadow">
            <h4>{{ $client->name }}</h4>
            <table class="table">
                <!-- Autres champs -->
                <tr>
                    <th>Date de mise à jour fiche para</th>
                    <td>{{ $client->maj_fiche_para ? \Carbon\Carbon::parse($client->maj_fiche_para)->format('d/m/Y') : 'Non définie' }}</td>
                </tr>
                <!-- Autres champs -->
            </table>
            <div class="mt-4 mb-5">
                <a href="{{ route('clients.edit', $client) }}"
                    class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
            </div>
            <div class="row mb-4">
               <hr>
            </div>
            <h4>Historique des mises à jour de la fiche de paramétrage</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date de mise à jour</th>
                        <th>Ancienne valeur</th>
                        <th>Nouvelle valeur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->histories as $history)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ $history->maj_fiche_para }}</td>
                            <td>{{ $history->maj_fiche_para }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
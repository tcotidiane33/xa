@extends('layouts.admin')

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
                        <th>Responsable Paie</th>
                        <td>{{ $client->responsablePaie ? $client->responsablePaie->name : 'Non assigné' }}</td>
                    </tr>
                    <tr>
                        <th>Gestionnaire Principal</th>
                        <td>{{ $client->gestionnairePrincipal ? $client->gestionnairePrincipal->name : 'Non assigné' }}</td>
                    </tr>
                    <tr>
                        <th>Date de début de prestation</th>
                        <td>{{ $client->date_debut_prestation ? \Carbon\Carbon::parse($client->date_debut_prestation)->format('d/m/Y') : 'Non définie' }}</td>
                    </tr>
                    <tr>
                        <th>Date estimative d'envoi des variables</th>
                        <td>{{ $client->date_estimative_envoi_variables ? \Carbon\Carbon::parse($client->date_estimative_envoi_variables)->format('d/m/Y') : 'Non définie' }}</td>
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
                        <td>{{ $client->maj_fiche_para ? \Carbon\Carbon::parse($client->maj_fiche_para)->format('d/m/Y') : 'Non définie' }}</td>
                    </tr>
                    <tr>
                        <th>Convention Collective</th>
                        <td>{{ $client->conventionCollective ? $client->conventionCollective->name : 'Non assignée' }}</td>
                    </tr>
                    <tr>
                        <th>Statut</th>
                        <td>{{ $client->status }}</td>
                    </tr>
                    <tr>
                        <th>Est-ce un cabinet ?</th>
                        <td>{{ $client->is_cabinet ? 'Oui' : 'Non' }}</td>
                    </tr>
                    <tr>
                        <th>Portefeuille Cabinet</th>
                        <td>{{ $client->portfolioCabinet ? $client->portfolioCabinet->name : 'Aucun' }}</td>
                    </tr>
                </table>
                <div class="mt-4">
                    <a href="{{ route('clients.edit', $client) }}"
                        class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                    {{-- <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">Supprimer</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
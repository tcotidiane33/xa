@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="row">
            </br>
            </br>
            </div>
            <h2 class="title1 breadcrumb ">{{ __('Modifier le client') }}</h2>
            <div class="form-three widget-shadow">
                @include('components.validation-form', [
                    'action' => route('clients.update', $client),
                    'method' => 'PUT',
                    'fields' => [
                        [
                            'type' => 'text',
                            'name' => 'name',
                            'label' => 'Nom',
                            'value' => $client->name,
                            'required' => true,
                        ],
                        [
                            'type' => 'select',
                            'name' => 'responsable_paie_id',
                            'label' => 'Responsable Paie',
                            'options' => $users->pluck('name', 'id'),
                            'value' => $client->responsable_paie_id,
                            'required' => true,
                        ],
                        [
                            'type' => 'select',
                            'name' => 'gestionnaire_principal_id',
                            'label' => 'Gestionnaire Principal',
                            'options' => $users->pluck('name', 'id'),
                            'value' => $client->gestionnaire_principal_id,
                            'required' => true,
                        ],
                        [
                            'type' => 'date',
                            'name' => 'date_debut_prestation',
                            'label' => 'Date de début de prestation',
                            'value' => $client->date_debut_prestation ? $client->date_debut_prestation->format('Y-m-d') : null,
                            'required' => true,
                        ],
                        [
                            'type' => 'date',
                            'name' => 'date_estimative_envoi_variables',
                            'label' => 'Date estimative d\'envoi des variables',
                            'value' => $client->date_estimative_envoi_variables
                                ? $client->date_estimative_envoi_variables->format('Y-m-d')
                                : null,
                        ],
                        [
                            'type' => 'email',
                            'name' => 'contact_paie',
                            'label' => 'Contact Paie',
                            'value' => $client->contact_paie,
                            'required' => true,
                        ],
                        [
                            'type' => 'email',
                            'name' => 'contact_comptabilite',
                            'label' => 'Contact Comptabilité',
                            'value' => $client->contact_comptabilite,
                            'required' => true,
                        ],
                        [
                            'type' => 'number',
                            'name' => 'nb_bulletins',
                            'label' => 'Nombre de bulletins',
                            'value' => $client->nb_bulletins,
                            'required' => true,
                        ],
                        [
                            'type' => 'date',
                            'name' => 'maj_fiche_para',
                            'label' => 'Date de mise à jour fiche para',
                            'value' => $client->maj_fiche_para ? $client->maj_fiche_para->format('Y-m-d') : null,
                        ],
                        [
                            'type' => 'select',
                            'name' => 'convention_collective_id',
                            'label' => 'Convention Collective',
                            'options' => $conventionCollectives->pluck('name', 'id'),
                            'value' => $client->convention_collective_id,
                        ],
                        [
                            'type' => 'select',
                            'name' => 'status',
                            'label' => 'Statut',
                            'options' => ['actif' => 'Actif', 'inactif' => 'Inactif'],
                            'value' => $client->status,
                            'required' => true,
                        ],
                        [
                            'type' => 'select',
                            'name' => 'is_portfolio',
                            'label' => 'Client Portefeuille',
                            'options' => [0 => 'Non', 1 => 'Oui'],
                            'value' => $client->is_portfolio,
                            'required' => true,
                        ],
                        [
                            'type' => 'select',
                            'name' => 'parent_client_id',
                            'label' => 'Client Parent (si sous-client)',
                            'options' => ['' => 'Aucun (client principal)'] + $portfolioClients->pluck('name', 'id')->toArray(),
                            'value' => $client->parent_client_id,
                        ],
                    ],
                    'submit_text' => 'Mettre à jour',
                ])
            </div>
        </div>
    </div>
@endsection
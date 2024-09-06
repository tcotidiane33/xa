@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="breadcrumb">
            <h1>Créer un nouveau client</h1>
        </div>
        <div class="main-page">
            <section class="ml-3">
                <div class="flex flex-col px-6 py-8 mx-auto  lg:py-0">
                    <div class="form-three widget-shadow ">
                        @include('components.validation-form', [
                            'action' => route('clients.store'),
                            'fields' => [
                                ['type' => 'text', 'name' => 'name', 'label' => 'Nom', 'required' => true],
                                [
                                    'type' => 'select',
                                    'name' => 'responsable_paie_id',
                                    'label' => 'Responsable Paie',
                                    'options' => $users->pluck('name', 'id'),
                                    'required' => true,
                                ],
                                [
                                    'type' => 'select',
                                    'name' => 'gestionnaire_principal_id',
                                    'label' => 'Gestionnaire Principal',
                                    'options' => $users->pluck('name', 'id'),
                                    'required' => true,
                                ],
                                [
                                    'type' => 'date',
                                    'name' => 'date_debut_prestation',
                                    'label' => 'Date de début de prestation',
                                    'required' => true,
                                ],
                                [
                                    'type' => 'date',
                                    'name' => 'date_estimative_envoi_variables',
                                    'label' => 'Date estimative d\'envoi des variables',
                                ],
                                [
                                    'type' => 'email',
                                    'name' => 'contact_paie',
                                    'label' => 'Contact Paie',
                                    'required' => true,
                                ],
                                [
                                    'type' => 'email',
                                    'name' => 'contact_comptabilite',
                                    'label' => 'Contact Comptabilité',
                                    'required' => true,
                                ],
                                [
                                    'type' => 'number',
                                    'name' => 'nb_bulletins',
                                    'label' => 'Nombre de bulletins',
                                    'required' => true,
                                ],
                                [
                                    'type' => 'date',
                                    'name' => 'maj_fiche_para',
                                    'label' => 'Date de mise à jour fiche para',
                                ],
                                [
                                    'type' => 'select',
                                    'name' => 'convention_collective_id',
                                    'label' => 'Convention Collective',
                                    'options' => $conventionCollectives->pluck('name', 'id'),
                                ],
                                [
                                    'type' => 'select',
                                    'name' => 'status',
                                    'label' => 'Statut',
                                    'options' => ['actif' => 'Actif', 'inactif' => 'Inactif'],
                                    'required' => true,
                                ],
                                [
                                    'type' => 'select',
                                    'name' => 'is_portfolio',
                                    'label' => 'Client Portefeuille',
                                    'options' => [0 => 'Non', 1 => 'Oui'],
                                    'required' => true,
                                ],
                                [
                                    'type' => 'select',
                                    'name' => 'parent_client_id',
                                    'label' => 'Client Parent (si sous-client)',
                                    'options' =>
                                        ['' => 'Aucun (client principal)'] +
                                        $portfolioClients->pluck('name', 'id')->toArray(),
                                ],
                            ],
                            'submit_text' => 'Créer',
                        ])
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="main-page">
    <h2 class="title1">{{ __('Créer un nouveau client') }}</h2>
    <div class="form-three widget-shadow">
        @include('components.validation-form', [
            'action' => route('clients.store'),
            'fields' => [
                ['type' => 'text', 'name' => 'name', 'label' => 'Nom', 'required' => true],
                ['type' => 'select', 'name' => 'responsable_paie_id', 'label' => 'Responsable Paie', 'options' => $users->pluck('name', 'id'), 'required' => true],
                ['type' => 'select', 'name' => 'gestionnaire_principal_id', 'label' => 'Gestionnaire Principal', 'options' => $users->pluck('name', 'id'), 'required' => true],
                ['type' => 'date', 'name' => 'date_debut_prestation', 'label' => 'Date de début de prestation', 'required' => true],
                ['type' => 'date', 'name' => 'date_estimative_envoi_variables', 'label' => 'Date estimative d\'envoi des variables'],
                ['type' => 'email', 'name' => 'contact_paie', 'label' => 'Contact Paie', 'required' => true],
                ['type' => 'email', 'name' => 'contact_comptabilite', 'label' => 'Contact Comptabilité', 'required' => true],
                ['type' => 'number', 'name' => 'nb_bulletins', 'label' => 'Nombre de bulletins', 'required' => true],
                ['type' => 'date', 'name' => 'maj_fiche_para', 'label' => 'Date de mise à jour fiche para'],
                ['type' => 'select', 'name' => 'convention_collective_id', 'label' => 'Convention Collective', 'options' => $conventionCollectives->pluck('name', 'id')],
                ['type' => 'select', 'name' => 'status', 'label' => 'Statut', 'options' => ['actif' => 'Actif', 'inactif' => 'Inactif'], 'required' => true],
            ],
            'submit_text' => 'Créer'
        ])
    </div>
</div>
@endsection

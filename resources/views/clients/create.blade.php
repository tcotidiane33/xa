@extends('layouts.main')

@section('content')
<div class="main-page">
    <h2 class="title1">{{ __('Créer un nouveau client') }}</h2>
    <div class="form-three widget-shadow">
        @include('components.validation-form', [
            'action' => route('clients.store'),
            'fields' => [
                [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Nom',
                    'placeholder' => 'Entrez le nom du client',
                    'required' => true
                ],
                [
                    'type' => 'select',
                    'name' => 'responsable_paie_id',
                    'label' => 'Responsable Paie',
                    'options' => $users->pluck('name', 'id'),
                    'required' => true
                ],
                [
                    'type' => 'select',
                    'name' => 'gestionnaire_principal_id',
                    'label' => 'Gestionnaire Principal',
                    'options' => $users->pluck('name', 'id'),
                    'required' => true
                ],
                [
                    'type' => 'date',
                    'name' => 'date_debut_prestation',
                    'label' => 'Date de début de prestation',
                    'required' => true
                ]
            ],
            'submit_text' => 'Créer'
        ])
    </div>
</div>
@endsection

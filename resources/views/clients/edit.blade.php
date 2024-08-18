@extends('layouts.main')

@section('content')
<div class="main-page">
    <h2 class="title1">{{ __('Modifier le client') }}</h2>
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
                    'required' => true
                ],
                [
                    'type' => 'select',
                    'name' => 'responsable_paie_id',
                    'label' => 'Responsable Paie',
                    'options' => $users->pluck('name', 'id'),
                    'value' => $client->responsable_paie_id,
                    'required' => true
                ],
                [
                    'type' => 'select',
                    'name' => 'gestionnaire_principal_id',
                    'label' => 'Gestionnaire Principal',
                    'options' => $users->pluck('name', 'id'),
                    'value' => $client->gestionnaire_principal_id,
                    'required' => true
                ],
                [
                    'type' => 'date',
                    'name' => 'date_debut_prestation',
                    'label' => 'Date de début de prestation',
                    'value' => $client->date_debut_prestation->format('Y-m-d'),
                    'required' => true
                ]
            ],
            'submit_text' => 'Mettre à jour'
        ])
    </div>
</div>
@endsection

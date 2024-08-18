@extends('layouts.admin')

@section('content')
    <div class="main-page">
        <h2 class="title1">{{ __('Liste des clients') }}</h2>
        <div class="panel-body widget-shadow">
            <div class="mb-4">
                <a href="{{ route('clients.create') }}" class="btn btn-primary">Ajouter un client</a>
            </div>

               
            @include('components.basic-table', [
                'headers' => ['Nom', 'Responsable Paie', 'Gestionnaire Principal', 'Actions'],
                'rows' => $clients->map(function ($client) {
                    return [
                        $client->name,
                        $client->responsablePaie->name,
                        $client->gestionnairePrincipal->name,

                        // '<a href="'.route('clients.show', $client).'" class="btn btn-info btn-xs">Voir</a> ' .
                        '<a href="' .
                        route('clients.edit', $client) .
                        '" class="btn btn-warning btn-xs">Modifier</a>',
                    ];
                }),
            ])
            <div class="mt-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
@endsection

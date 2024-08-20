@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <h2 class="title1">{{ __('Liste des clients') }}</h2>
            <div class="panel-body widget-shadow">
                <div class="mb-4">
                    <a href="{{ route('clients.create') }}" class="btn btn-success btn-flat btn-pri"><i class="fa fa-plus"
                            aria-hidden="true"></i> Ajouter un client</a>
                </div>

                @include('components.basic-table', [
                    'headers' => [
                        'Nom',
                        'Responsable Paie',
                        'Gestionnaire Principal',
                        'Convention Collective',
                        'Actions',
                    ],
                    'rows' => $clients->map(function ($client) {
                        return [
                            'name' => $client->name,
                            'responsable' => $client->responsablePaie
                                ? $client->responsablePaie->name
                                : 'Non assigné',
                            'gestionnaire' => $client->gestionnairePrincipal
                                ? $client->gestionnairePrincipal->name
                                : 'Non assigné',
                            'convention' => $client->conventionCollective
                                ? $client->conventionCollective->name
                                : 'Non assignée',
                            'actions' =>
                                '<a href="' .
                                route('clients.edit', $client) .
                                '" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a> ' .
                                '<form action="' .
                                route('clients.destroy', $client) .
                                '" method="POST" style="display:inline;">' .
                                csrf_field() .
                                method_field('DELETE') .
                                '<button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce client ?\')">Supprimer</button>' .
                                '</form>',
                        ];
                    }),
                    'rawColumns' => ['actions'],
                ])
                <div class="mt-4">
                    {{ $clients->links() }}
                </div>
            </div>
           
        </div>
    </div>
@endsection

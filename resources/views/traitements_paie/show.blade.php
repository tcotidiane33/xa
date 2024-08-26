@extends('layouts.admin')
@section('title', 'Détails du Traitement de Paie')
@section('content')
<div class="main-content">
    <div class="main-page">
        <div class="row">
            <br><br>
        </div>
        <div class="row">
            <div class="container">
                <h1>Détails du Traitement de Paie</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Client: {{ $traitementPaie->client->name }}</h5>
                        <p><strong>Gestionnaire:</strong> {{ $traitementPaie->gestionnaire->name }}</p>
                        <p><strong>Période:</strong> {{ $traitementPaie->periodePaie->reference }}</p>
                        <p><strong>Nombre de bulletins:</strong> {{ $traitementPaie->nbr_bull }}</p>
                        <p><strong>Réception variables:</strong> {{ $traitementPaie->reception_variable }}</p>
                        <p><strong>Préparation BP:</strong> {{ $traitementPaie->preparation_bp }}</p>
                        <p><strong>Validation BP client:</strong> {{ $traitementPaie->validation_bp_client }}</p>
                        <p><strong>Préparation et envoie DSN:</strong> {{ $traitementPaie->preparation_envoie_dsn }}</p>
                        <p><strong>Accusés DSN:</strong> {{ $traitementPaie->accuses_dsn }}</p>
                        <p><strong>TELEDEC URSSAF:</strong> {{ $traitementPaie->teledec_urssaf }}</p>
                        <p><strong>Notes:</strong> {{ $traitementPaie->notes }}</p>

                        <h6>Fichiers attachés:</h6>
                        @if($traitementPaie->maj_fiche_para_file)
                            <p><a href="{{ asset('storage/'.$traitementPaie->maj_fiche_para_file) }}" target="_blank">Fichier MAJ fiche para</a></p>
                        @endif
                        @if($traitementPaie->reception_variables_file)
                            <p><a href="{{ asset('storage/'.$traitementPaie->reception_variables_file) }}" target="_blank">Fichier Réception variables</a></p>
                        @endif
                        @if($traitementPaie->preparation_bp_file)
                            <p><a href="{{ asset('storage/'.$traitementPaie->preparation_bp_file) }}" target="_blank">Fichier Préparation BP</a></p>
                        @endif
                        @if($traitementPaie->validation_bp_client_file)
                            <p><a href="{{ asset('storage/'.$traitementPaie->validation_bp_client_file) }}" target="_blank">Fichier Validation BP client</a></p>
                        @endif
                        @if($traitementPaie->preparation_envoi_dsn_file)
                            <p><a href="{{ asset('storage/'.$traitementPaie->preparation_envoi_dsn_file) }}" target="_blank">Fichier Préparation et envoie DSN</a></p>
                        @endif
                        @if($traitementPaie->accuses_dsn_file)
                            <p><a href="{{ asset('storage/'.$traitementPaie->accuses_dsn_file) }}" target="_blank">Fichier Accusés DSN</a></p>
                        @endif
                    </div>
                </div>
                    <div class="form-group card m-4">
                        <a href="{{ route('traitements-paie.edit', $traitementPaie->id) }}" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                        <a href="{{ route('traitements-paie.index') }}" class="text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 shadow-lg shadow-pink-500/50 dark:shadow-lg dark:shadow-pink-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Retour à la liste</a>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
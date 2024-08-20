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
                <div class="card">
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
                <a href="{{ route('traitements-paie.edit', $traitementPaie->id) }}" class="btn btn-primary mt-3">Modifier</a>
                <a href="{{ route('traitements-paie.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
            </div>
        </div>
    </div>
</div>
@endsection
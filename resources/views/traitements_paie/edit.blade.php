@extends('layouts.app')

@section('content')
    <h1>Éditer un traitement de paie</h1>
    <form action="{{ route('traitements_paie.update', $traitementPaie) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="gestionnaire_id">Gestionnaire</label>
            <select name="gestionnaire_id" id="gestionnaire_id" class="form-control">
                @foreach($gestionnaires as $gestionnaire)
                    <option value="{{ $gestionnaire->id }}" {{ $traitementPaie->gestionnaire_id == $gestionnaire->id? 'elected' : '' }}>{{ $gestionnaire->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="client_id">Client</label>
            <select name="client_id" id="client_id" class="form-control">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $traitementPaie->client_id == $client->id? 'elected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="periode_paie_id">Période de paie</label>
            <select name="periode_paie_id" id="periode_paie_id" class="form-control">
                @foreach($periodesPaie as $periodePaie)
                    <option value="{{ $periodePaie->id }}" {{ $traitementPaie->periode_paie_id == $periodePaie->id? 'elected' : '' }}>{{ $periodePaie->debut }} - {{ $periodePaie->fin }}</option>
                @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nbr_bull">Nombre de bulletins</label>
                    <input type="number" name="nbr_bull" id="nbr_bull" class="form-control" value="{{ $traitementPaie->nbr_bull }}">
                </div>
                <!-- Other fields -->
                <div class="form-group">
                    <label for="reference">Référence</label>
                    <input type="text" name="reference" id="reference" class="form-control" value="{{ $traitementPaie->reference }}">
                </div>

                <div class="form-group">
                    <label for="maj_fiche_para">Mise à jour fiche para</label>
                    <input type="date" name="maj_fiche_para" id="maj_fiche_para" class="form-control" value="{{ $traitementPaie->maj_fiche_para }}">
                </div>

                <div class="form-group">
                    <label for="reception_variable">Réception variable</label>
                    <input type="date" name="reception_variable" id="reception_variable" class="form-control" value="{{ $traitementPaie->reception_variable }}">
                </div>

                <div class="form-group">
                    <label for="preparation_bp">Préparation BP</label>
                    <input type="date" name="preparation_bp" id="preparation_bp" class="form-control" value="{{ $traitementPaie->preparation_bp }}">
                </div>

                <div class="form-group">
                    <label for="validation_bp_client">Validation BP client</label>
                    <input type="date" name="validation_bp_client" id="validation_bp_client" class="form-control" value="{{ $traitementPaie->validation_bp_client }}">
                </div>

                <div class="form-group">
                    <label for="preparation_envoie_dsn">Préparation envoi DSN</label>
                    <input type="date" name="preparation_envoie_dsn" id="preparation_envoie_dsn" class="form-control" value="{{ $traitementPaie->preparation_envoie_dsn }}">
                </div>

                <div class="form-group">
                    <label for="accuses_dsn">Accusés DSN</label>
                    <input type="date" name="accuses_dsn" id="accuses_dsn" class="form-control" value="{{ $traitementPaie->accuses_dsn }}">
                </div>

                <div class="form-group">
                    <label for="teledec_urssaf">Télédéclaration URSSAF</label>
                    <input type="date" name="teledec_urssaf" id="teledec_urssaf" class="form-control" value="{{ $traitementPaie->teledec_urssaf }}">
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control">{{ $traitementPaie->notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        @endsection

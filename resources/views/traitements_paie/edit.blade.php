@extends('layouts.admin')

@section('title', 'Modifier un Traitement de Paie')

@section('content')
<div class="main-content">
    <div class="main-page">
        <div class="row">
            <br><br>
        </div>
        <div class="row">
            <div class="container">
                <h1>Modifier un Traitement de Paie</h1>
                <form id="editTraitementForm" method="POST" action="{{ route('traitements-paie.update', $traitementPaie->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="client_id">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $traitementPaie->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gestionnaire_id">Gestionnaire</label>
                        <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                            @foreach($gestionnaires as $gestionnaire)
                                <option value="{{ $gestionnaire->id }}" {{ $traitementPaie->gestionnaire_id == $gestionnaire->id ? 'selected' : '' }}>
                                    {{ $gestionnaire->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="periode_paie_id">Période de paie</label>
                        <select name="periode_paie_id" id="periode_paie_id" class="form-control" required>
                            @foreach($periodesPaie as $periode)
                                <option value="{{ $periode->id }}" {{ $traitementPaie->periode_paie_id == $periode->id ? 'selected' : '' }}>
                                    {{ $periode->reference }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nbr_bull">Nombre de bulletins</label>
                        <input type="number" class="form-control" id="nbr_bull" name="nbr_bull" value="{{ $traitementPaie->nbr_bull }}" required>
                    </div>

                    <div class="form-group">
                        <label for="reception_variable">Réception variables</label>
                        <input type="date" class="form-control" id="reception_variable" name="reception_variable" value="{{ $traitementPaie->reception_variable }}">
                    </div>

                    <div class="form-group">
                        <label for="preparation_bp">Préparation BP</label>
                        <input type="date" class="form-control" id="preparation_bp" name="preparation_bp" value="{{ $traitementPaie->preparation_bp }}">
                    </div>

                    <div class="form-group">
                        <label for="validation_bp_client">Validation BP client</label>
                        <input type="date" class="form-control" id="validation_bp_client" name="validation_bp_client" value="{{ $traitementPaie->validation_bp_client }}">
                    </div>

                    <div class="form-group">
                        <label for="preparation_envoie_dsn">Préparation et envoie DSN</label>
                        <input type="date" class="form-control" id="preparation_envoie_dsn" name="preparation_envoie_dsn" value="{{ $traitementPaie->preparation_envoie_dsn }}">
                    </div>

                    <div class="form-group">
                        <label for="accuses_dsn">Accusés DSN</label>
                        <input type="date" class="form-control" id="accuses_dsn" name="accuses_dsn" value="{{ $traitementPaie->accuses_dsn }}">
                    </div>

                    {{-- <div class="form-group">
                        <label for="teledec_urssaf">TELEDEC URSSAF</label>
                        <input type="date" class="form-control" id="teledec_urssaf" name="teledec_urssaf" value="{{ $traitementPaie->teledec_urssaf }}">
                    </div> --}}

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes">{{ $traitementPaie->notes }}</textarea>
                    </div>

                    <!-- Ajout des champs de fichiers -->
                    <div class="form-group">
                        <label for="maj_fiche_para_file">Fichier MAJ fiche para</label>
                        <input type="file" class="form-control-file" id="maj_fiche_para_file" name="maj_fiche_para_file">
                    </div>

                    <div class="form-group">
                        <label for="reception_variables_file">Fichier Réception variables</label>
                        <input type="file" class="form-control-file" id="reception_variables_file" name="reception_variables_file">
                    </div>

                    <div class="form-group">
                        <label for="preparation_bp_file">Fichier Préparation BP</label>
                        <input type="file" class="form-control-file" id="preparation_bp_file" name="preparation_bp_file">
                    </div>

                    <div class="form-group">
                        <label for="validation_bp_client_file">Fichier Validation BP client</label>
                        <input type="file" class="form-control-file" id="validation_bp_client_file" name="validation_bp_client_file">
                    </div>

                    <div class="form-group">
                        <label for="preparation_envoi_dsn_file">Fichier Préparation et envoie DSN</label>
                        <input type="file" class="form-control-file" id="preparation_envoi_dsn_file" name="preparation_envoi_dsn_file">
                    </div>

                    <div class="form-group">
                        <label for="accuses_dsn_file">Fichier Accusés DSN</label>
                        <input type="file" class="form-control-file" id="accuses_dsn_file" name="accuses_dsn_file">
                    </div>

                    <button type="submit" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#reception_variable').on('change', function() {
        var receptionDate = new Date($(this).val());
        var today = new Date();

        if(receptionDate <= today) {
            $('input[type="date"]').not('#reception_variable').prop('disabled', false);
        } else {
            $('input[type="date"]').not('#reception_variable').prop('disabled', true);
        }
    });

    $('#reception_variable').trigger('change');
});
</script>
@endpush
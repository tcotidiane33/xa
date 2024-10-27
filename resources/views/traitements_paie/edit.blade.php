@extends('layouts.admin')

@section('title', 'Modifier un Traitement de Paie')

@section('content')
<div class="main-content">
    <div class="main-page">
        <div class="row">
            <div class="container">
                <h1>Modifier un Traitement de Paie</h1>
                <form id="traitementForm" method="POST" action="{{ route('traitements-paie.update', $traitementPaie->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Section Client et Gestionnaire -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ $traitementPaie->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gestionnaire_id">Gestionnaire</label>
                            <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                                <option value="">Sélectionner un gestionnaire</option>
                                @foreach($gestionnaires as $gestionnaire)
                                    <option value="{{ $gestionnaire->id }}" {{ $traitementPaie->gestionnaire_id == $gestionnaire->id ? 'selected' : '' }}>{{ $gestionnaire->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Section Période de paie -->
                    <div class="form-group mt-4">
                        <label for="periode_paie_id">Période de paie</label>
                        <select name="periode_paie_id" id="periode_paie_id" class="form-control" required>
                            <option value="">Sélectionner une période de paie</option>
                            @foreach($periodesPaie as $periode)
                                <option value="{{ $periode->id }}" {{ $traitementPaie->periode_paie_id == $periode->id ? 'selected' : '' }}>{{ $periode->reference }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section Détails -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="form-group">
                            <label for="nbr_bull">Nombre de bulletins</label>
                            <input type="number" name="nbr_bull" id="nbr_bull" class="form-control" value="{{ $traitementPaie->nbr_bull }}" required>
                        </div>
                        <div class="form-group">
                            <label for="reception_variable">Réception des variables</label>
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
                            <label for="preparation_envoie_dsn">Préparation et envoie DSN</label>
                            <input type="date" name="preparation_envoie_dsn" id="preparation_envoie_dsn" class="form-control" value="{{ $traitementPaie->preparation_envoie_dsn }}">
                        </div>
                        <div class="form-group">
                            <label for="accuses_dsn">Accusés DSN</label>
                            <input type="date" name="accuses_dsn" id="accuses_dsn" class="form-control" value="{{ $traitementPaie->accuses_dsn }}">
                        </div>
                        <div class="form-group">
                            <label for="teledec_urssaf">Télédec URSSAF</label>
                            <input type="date" name="teledec_urssaf" id="teledec_urssaf" class="form-control" value="{{ $traitementPaie->teledec_urssaf }}">
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control">{{ $traitementPaie->notes }}</textarea>
                        </div>
                    </div>

                    <!-- Section Fichiers -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="form-group">
                            <label for="maj_fiche_para_file">Fichier MAJ fiche para</label>
                            <input type="file" name="maj_fiche_para_file" id="maj_fiche_para_file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="reception_variables_file">Fichier réception variables</label>
                            <input type="file" name="reception_variables_file" id="reception_variables_file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="preparation_bp_file">Fichier préparation BP</label>
                            <input type="file" name="preparation_bp_file" id="preparation_bp_file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="validation_bp_client_file">Fichier validation BP client</label>
                            <input type="file" name="validation_bp_client_file" id="validation_bp_client_file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="preparation_envoi_dsn_file">Fichier préparation envoi DSN</label>
                            <input type="file" name="preparation_envoi_dsn_file" id="preparation_envoi_dsn_file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="accuses_dsn_file">Fichier accusés DSN</label>
                            <input type="file" name="accuses_dsn_file" id="accuses_dsn_file" class="form-control">
                        </div>
                    </div>

                    <!-- Section Informations Supplémentaires -->
                    <div class="form-group mt-4">
                        <label for="supplementaires">Informations Supplémentaires</label>
                        <textarea name="supplementaires" id="supplementaires" class="form-control">{{ $traitementPaie->supplementaires }}</textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid p-2">
            <a href="{{ route('traitements-paie.historique') }}" class="btn btn-secondary mb-3">Voir l'historique</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion des onglets dynamiques
            const tabs = document.querySelectorAll('.nav-link');
            const tabContent = document.querySelectorAll('.tab-pane');

            // Charger l'onglet actif depuis le stockage local
            const activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                tabs.forEach(tab => tab.classList.remove('active'));
                tabContent.forEach(content => content.classList.remove('show', 'active'));

                document.querySelector(activeTab).classList.add('active');
                document.querySelector(activeTab).classList.add('show');
                document.querySelector(`[href="${activeTab}"]`).classList.add('active');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function (event) {
                    event.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));

                    // Enregistrer l'onglet actif dans le stockage local
                    localStorage.setItem('activeTab', this.getAttribute('href'));

                    tabs.forEach(tab => tab.classList.remove('active'));
                    tabContent.forEach(content => content.classList.remove('show', 'active'));

                    target.classList.add('show', 'active');
                    this.classList.add('active');
                });
            });
        });
    </script>
@endpush
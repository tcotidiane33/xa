@extends('layouts.admin')

@section('title', 'Créer un Traitement de Paie')

@section('content')
<div class="main-content">
    <div class="main-page">
        <div class="row">
            <div class="container">
                <h1>Créer un Traitement de Paie</h1>
                <form id="traitementForm" method="POST" action="{{ route('traitements-paie.store') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Onglets -->
                    <ul class="nav nav-tabs" id="traitementTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="client-tab" data-bs-toggle="tab" href="#client">Client</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gestionnaire-tab" data-bs-toggle="tab" href="#gestionnaire">Gestionnaire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="periode-tab" data-bs-toggle="tab" href="#periode">Période de paie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-bs-toggle="tab" href="#details">Détails</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="fichiers-tab" data-bs-toggle="tab" href="#fichiers">Fichiers</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Onglet Client -->
                        <div class="tab-pane fade show active" id="client">
                            <div class="form-group">
                                <label for="client_id">Client</label>
                                <select name="client_id" id="client_id" class="form-control" required>
                                    <option value="">Sélectionner un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="client-info" class="mt-3"></div>
                            <button type="button" class="btn btn-primary next-step">Suivant</button>
                        </div>

                        <!-- Onglet Gestionnaire -->
                        <div class="tab-pane fade" id="gestionnaire">
                            <div class="form-group">
                                <label for="gestionnaire_id">Gestionnaire</label>
                                <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                                    <option value="">Sélectionner un gestionnaire</option>
                                    @foreach($gestionnaires as $gestionnaire)
                                        <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="button" class="btn btn-primary next-step">Suivant</button>
                        </div>

                        <!-- Onglet Période de paie -->
                        <div class="tab-pane fade" id="periode">
                            <div class="form-group">
                                <label for="periode_paie_id">Période de paie</label>
                                <select name="periode_paie_id" id="periode_paie_id" class="form-control" required>
                                    <option value="">Sélectionner une période de paie</option>
                                    @foreach($periodesPaie as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->reference }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="button" class="btn btn-primary next-step">Suivant</button>
                        </div>

                        <!-- Onglet Détails -->
                        <div class="tab-pane fade" id="details">
                            <div class="form-group">
                                <label for="nbr_bull">Nombre de bulletins</label>
                                <input type="number" class="form-control" id="nbr_bull" name="nbr_bull" required>
                            </div>
                            <div class="form-group">
                                <label for="reception_variable">Réception variables</label>
                                <input type="date" class="form-control" id="reception_variable" name="reception_variable">
                            </div>
                            <div class="form-group">
                                <label for="preparation_bp">Préparation BP</label>
                                <input type="date" class="form-control" id="preparation_bp" name="preparation_bp">
                            </div>
                            <div class="form-group">
                                <label for="validation_bp_client">Validation BP client</label>
                                <input type="date" class="form-control" id="validation_bp_client" name="validation_bp_client">
                            </div>
                            <div class="form-group">
                                <label for="preparation_envoie_dsn">Préparation et envoie DSN</label>
                                <input type="date" class="form-control" id="preparation_envoie_dsn" name="preparation_envoie_dsn">
                            </div>
                            <div class="form-group">
                                <label for="accuses_dsn">Accusés DSN</label>
                                <input type="date" class="form-control" id="accuses_dsn" name="accuses_dsn">
                            </div>
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes"></textarea>
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="button" class="btn btn-primary next-step">Suivant</button>
                        </div>

                        <!-- Onglet Fichiers -->
                        <div class="tab-pane fade" id="fichiers">
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
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="submit" class="btn btn-success">Créer</button>
                        </div>
                    </div>
                </form>
                <form id="cancelForm" method="POST" action="{{ route('traitements-paie.cancel') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger mt-3">Annuler l'opération</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Activer l'onglet en fonction de l'ancre dans l'URL
    const hash = window.location.hash;
    if (hash) {
        const tab = document.querySelector(`a[href="${hash}"]`);
        if (tab) {
            tab.click();
        }
    }

    // Mettre à jour l'URL lorsque l'utilisateur change d'onglet
    const tabs = document.querySelectorAll('#traitementTabs a');
    tabs.forEach(tab => {
        tab.addEventListener('click', function (e) {
            history.pushState(null, null, e.target.hash);
        });
    });

    // Navigation entre les étapes
    $('.next-step').click(function() {
        const $activeTab = $('.tab-pane.active');
        const $nextTab = $activeTab.next('.tab-pane');
        if ($nextTab.length) {
            $nextTab.addClass('show active');
            $activeTab.removeClass('show active');
        }
    });

    $('.prev-step').click(function() {
        const $activeTab = $('.tab-pane.active');
        const $prevTab = $activeTab.prev('.tab-pane');
        if ($prevTab.length) {
            $prevTab.addClass('show active');
            $activeTab.removeClass('show active');
        }
    });

    // Désactiver les champs suivants tant que les champs précédents ne sont pas renseignés
    $('#traitementForm').on('change', 'input, select', function() {
        const $inputs = $('#traitementForm').find('input, select');
        let allFilled = true;
        $inputs.each(function() {
            if ($(this).val() === '' && $(this).prop('required')) {
                allFilled = false;
                return false;
            }
        });
        if (allFilled) {
            $('.next-step').prop('disabled', false);
        } else {
            $('.next-step').prop('disabled', true);
        }
    });

    $('#traitementForm').trigger('change');

    // Afficher les informations supplémentaires sur le client
    $('#client_id').change(function() {
        const clientId = $(this).val();
        if (clientId) {
            $.ajax({
                url: `/clients/${clientId}`,
                method: 'GET',
                success: function(data) {
                    $('#client-info').html(`
                        <h4>Informations sur le client</h4>
                        <p><strong>Nom:</strong> ${data.name}</p>
                        <p><strong>Email:</strong> ${data.email}</p>
                        <p><strong>Téléphone:</strong> ${data.phone}</p>
                        <p><strong>Adresse:</strong> ${data.address}</p>
                    `);
                }
            });
        } else {
            $('#client-info').html('');
        }
    });

    // Validation partielle des étapes
    $('.next-step').click(function() {
        const $activeTab = $('.tab-pane.active');
        const step = $activeTab.attr('id');
        const formData = new FormData($('#traitementForm')[0]);
        formData.append('step', step);

        $.ajax({
            url: '{{ route('traitements-paie.storePartial') }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    const $nextTab = $activeTab.next('.tab-pane');
                    if ($nextTab.length) {
                        $nextTab.addClass('show active');
                        $activeTab.removeClass('show active');
                    }
                } else {
                    alert('Une erreur est survenue');
                }
            },
            error: function() {
                alert('Une erreur est survenue');
            }
        });
    });
});
</script>
@endpush
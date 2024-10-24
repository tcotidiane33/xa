@extends('layouts.admin')

@section('title', 'Créer un Traitement de Paie')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="row">
                <div class="container">
                    <h1>Créer un Traitement de Paie</h1>
                    <form id="traitementForm" method="POST" action="{{ route('traitements-paie.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Onglets -->
                        <ul class="nav nav-tabs" id="traitementTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="client-tab" data-bs-toggle="tab" href="#client">Client</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="gestionnaire-tab" data-bs-toggle="tab"
                                    href="#gestionnaire">Gestionnaire</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="periode-tab" data-bs-toggle="tab" href="#periode">Période de
                                    paie</a>
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
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="client-info" class="mt-3"></div>
                                <button type="button" id="validate-client" class="btn btn-primary">Valider les informations
                                    du client</button>
                                <button type="button" class="btn btn-primary next-step" disabled>Suivant</button>
                            </div>

                            <!-- Onglet Gestionnaire -->
                            <div class="tab-pane fade" id="gestionnaire">
                                <div class="form-group">
                                    <label for="gestionnaire_id">Gestionnaire</label>
                                    <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                                        <option value="">Sélectionner un gestionnaire</option>
                                        @foreach ($gestionnaires as $gestionnaire)
                                            <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('gestionnaire_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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
                                        @foreach ($periodesPaie as $periode)
                                            <option value="{{ $periode->id }}">{{ $periode->reference }}</option>
                                        @endforeach
                                    </select>
                                    @error('periode_paie_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                                <button type="button" class="btn btn-primary next-step">Suivant</button>
                            </div>

                            <!-- Onglet Détails -->
                            <div class="tab-pane fade" id="details">
                                <div class="form-group">
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="nbr_bull">Nombre de bulletins</label>
                                            <input type="number" class="form-control w-full p-2.5 " id="nbr_bull"
                                                name="nbr_bull" required>
                                            @error('nbr_bull')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="reception_variable">Réception variables</label>
                                            <input type="date" class="form-control w-full p-2.5 " id="reception_variable"
                                                name="reception_variable">
                                            @error('reception_variable')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="preparation_bp">Préparation BP</label>
                                            <input type="date" class="form-control w-full p-2.5 " id="preparation_bp"
                                                name="preparation_bp" disabled>
                                            @error('preparation_bp')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="validation_bp_client">Validation BP client</label>
                                            <input type="date" class="form-control w-full p-2.5 "
                                                id="validation_bp_client" name="validation_bp_client" disabled>
                                            @error('validation_bp_client')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="preparation_envoie_dsn">Préparation et envoie DSN</label>
                                            <input type="date" class="form-control w-full p-2.5 "
                                                id="preparation_envoie_dsn" name="preparation_envoie_dsn" disabled>
                                            @error('preparation_envoie_dsn')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="accuses_dsn">Accusés DSN</label>
                                            <input type="date" class="form-control w-full p-2.5 " id="accuses_dsn"
                                                name="accuses_dsn" disabled>
                                            @error('accuses_dsn')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" disabled></textarea>
                                    @error('notes')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                                <button type="button" class="btn btn-primary next-step">Suivant</button>
                            </div>

                            <!-- Onglet Fichiers -->
                            <div class="tab-pane fade" id="fichiers">
                                <div class="form-group">
                                    <label for="maj_fiche_para_file">Fichier MAJ fiche para</label>
                                    <input type="file" class="form-control-file" id="maj_fiche_para_file"
                                        name="maj_fiche_para_file">
                                    @error('maj_fiche_para_file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="reception_variables_file">Fichier Réception variables</label>
                                    <input type="file" class="form-control-file" id="reception_variables_file"
                                        name="reception_variables_file">
                                    @error('reception_variables_file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="preparation_bp_file">Fichier Préparation BP</label>
                                    <input type="file" class="form-control-file" id="preparation_bp_file"
                                        name="preparation_bp_file">
                                    @error('preparation_bp_file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="validation_bp_client_file">Fichier Validation BP client</label>
                                    <input type="file" class="form-control-file" id="validation_bp_client_file"
                                        name="validation_bp_client_file">
                                    @error('validation_bp_client_file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="preparation_envoi_dsn_file">Fichier Préparation et envoie DSN</label>
                                    <input type="file" class="form-control-file" id="preparation_envoi_dsn_file"
                                        name="preparation_envoi_dsn_file">
                                    @error('preparation_envoi_dsn_file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="accuses_dsn_file">Fichier Accusés DSN</label>
                                    <input type="file" class="form-control-file" id="accuses_dsn_file"
                                        name="accuses_dsn_file">
                                    @error('accuses_dsn_file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // Activer l'onglet en fonction de l'ancre dans l'URL
            const hash = window.location.hash;
            if (hash) {
                $(`a[href="${hash}"]`).tab('show');
            }

            // Mettre à jour l'URL lorsque l'utilisateur change d'onglet
            $('#traitementTabs a').on('click', function(e) {
                history.pushState(null, null, e.target.hash);
                $(this).tab('show');
            });

            // Gestion de la navigation entre les onglets
            $('.next-step').on('click', function() {
                const $activeTab = $('.tab-pane.active');
                const nextTab = $activeTab.next('.tab-pane');

                if (nextTab.length) {
                    nextTab.addClass('show active');
                    $activeTab.removeClass('show active');
                }
            });

            $('.prev-step').on('click', function() {
                const $activeTab = $('.tab-pane.active');
                const prevTab = $activeTab.prev('.tab-pane');

                if (prevTab.length) {
                    prevTab.addClass('show active');
                    $activeTab.removeClass('show active');
                }
            });

            // Affichage des informations client après sélection
            $('#client_id').change(function() {
                const clientId = $(this).val();
                if (clientId) {
                    $.ajax({
                        url: `/clients/${clientId}/info`,
                        method: 'GET',
                        success: function(data) {
                            $('#client-info').html(`
                       <div class="bg-white p-6 rounded-lg shadow-md">
                        <h4 class="text-xl font-bold mb-4 text-gray-900">Informations sur le client</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Informations de base -->
                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Nom:</span>
                                    <span>${data.name}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Email:</span>
                                    <span>${data.email}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Téléphone:</span>
                                    <span>${data.phone}</span>
                                </div>
                            </div>

                            <!-- Statuts et badges -->
                            <div class="space-y-3">
                                <div class="flex flex-wrap gap-2">
                                    ${data.adhesion_mydrh ? 
                                        '<span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">MyDRH</span>' : 
                                        '<span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded">Pas MyDRH</span>'
                                    }
                                    
                                    ${data.client_forme_saisie ? 
                                        '<span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">Formé à la saisie</span>' : 
                                        '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-2.5 py-0.5 rounded">Non formé à la saisie</span>'
                                    }
                                    
                                    ${data.saisie_variables ? 
                                        '<span class="bg-purple-100 text-purple-800 text-sm font-medium px-2.5 py-0.5 rounded">Saisie variables</span>' : 
                                        '<span class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded">Pas de saisie variables</span>'
                                    }
                                    
                                    ${data.is_cabinet ? 
                                        '<span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-2.5 py-0.5 rounded">Cabinet</span>' : 
                                        '<span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded">Client direct</span>'
                                    }
                                </div>
                            </div>
                        </div>

                        <!-- Dates importantes -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Date de formation à la saisie:</span>
                                    <span>${data.date_formation_saisie}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Date d'adhésion MyDRH:</span>
                                    <span>${data.date_adhesion_mydrh}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Date de signature du contrat:</span>
                                    <span>${data.date_signature_contrat}</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Date de début de prestation:</span>
                                    <span>${data.date_debut_prestation}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Date de fin de prestation:</span>
                                    <span>${data.date_fin_prestation}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="mt-6 space-y-3">
                            <div class="flex items-center space-x-2">
                                <span class="font-semibold text-gray-700">Taux AT:</span>
                                <span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded">${data.taux_at}</span>
                            </div>
                            ${data.is_cabinet ? `
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold text-gray-700">Portefeuille Cabinet:</span>
                                        <span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded">${data.portfolio_cabinet_id}</span>
                                    </div>
                                ` : ''}
                        </div>
                        </div>
                        <hr class="mb-3">
                    `);
                            $('#validate-client').prop('disabled', false);
                        },
                        error: function() {
                            alert('Impossible de charger les informations du client.');
                        }
                    });
                } else {
                    $('#client-info').html('');
                    $('#validate-client').prop('disabled', true);
                }
            });

            // Validation des informations du client
            $('#validate-client').on('click', function() {
                $(this).prop('disabled', true);
                $('.next-step').prop('disabled', false);
            });

            // Activer les champs après soumission
            $('#reception_variable').change(function() {
                if ($(this).val()) {
                    $('#preparation_bp').prop('disabled', false);
                    checkDateDifference($(this).val(), '#preparation_bp');
                }
            });

            $('#preparation_bp').change(function() {
                if ($(this).val()) {
                    $('#validation_bp_client').prop('disabled', false);
                    checkDateDifference($(this).val(), '#validation_bp_client');
                }
            });

            $('#validation_bp_client').change(function() {
                if ($(this).val()) {
                    $('#preparation_envoie_dsn').prop('disabled', false);
                    checkDateDifference($(this).val(), '#preparation_envoie_dsn');
                }
            });

            $('#preparation_envoie_dsn').change(function() {
                if ($(this).val()) {
                    $('#accuses_dsn').prop('disabled', false);
                    checkDateDifference($(this).val(), '#accuses_dsn');
                }
            });

            $('#accuses_dsn').change(function() {
                if ($(this).val()) {
                    $('#notes').prop('disabled', false);
                    checkDateDifference($(this).val(), '#notes');
                }
            });

            function checkDateDifference(inputDate, nextFieldSelector) {
                const inputDateObj = new Date(inputDate);
                const currentDate = new Date();
                const timeDiff = currentDate.getTime() - inputDateObj.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (dayDiff > 3) {
                    $(nextFieldSelector).css('background-color', 'orange');
                } else {
                    $(nextFieldSelector).css('background-color', '');
                }
            }
        });
    </script>
@endpush

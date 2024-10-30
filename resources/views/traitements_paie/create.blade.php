@extends('layouts.admin')

@section('title', 'Créer un Traitement de Paie')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
@endpush

@section('content')
    <div class="main-content">
        <div class="main-page">
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
                            <a class="nav-link" id="periode-tab" data-bs-toggle="tab" href="#periode">Période de paie</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="fichiers-tab" data-bs-toggle="tab" href="#fichiers">Fichiers</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Onglet Client -->
                        <div class="tab-pane fade show active" id="client" role="tabpanel">
                            <div class="form-group">
                                <label for="client_id">Client</label>
                                <select name="client_id" id="client_id" class="form-control" required>
                                    <option value="">Sélectionner un client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="client-info"></div>
                            <button type="button" class="btn btn-primary next-step">Suivant</button>
                        </div>

                        <!-- Onglet Période de paie -->
                        <div class="tab-pane fade" id="periode" role="tabpanel">
                            <div class="form-group">
                                <label for="periode_paie_id">Période de paie</label>
                                <select name="periode_paie_id" id="periode_paie_id" class="form-control" required>
                                    <option value="">Sélectionner une période de paie</option>
                                    @foreach ($periodesPaie as $periode)
                                        <option value="{{ $periode->id }}" data-debut="{{ $periode->debut }}"
                                            data-fin="{{ $periode->fin }}">{{ $periode->reference }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="periode-info" class="mt-4">
                                <div id="calendar"></div>
                                <div class="progress mt-4">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                            <hr>
                            <div class=" mt-4">
                                <h4>Informations de la période de paie</h4>
                                <p><strong>Réception des variables:</strong> <span id="reception-info"></span></p>
                                <p><strong>Préparation BP:</strong> <span id="preparation-info"></span></p>
                                <p><strong>Validation BP client:</strong> <span id="validation-info"></span></p>
                                <p><strong>Préparation et envoie DSN:</strong> <span id="envoie-info"></span></p>
                                <p><strong>Accusés DSN:</strong> <span id="accuses-info"></span></p>
                                <p><strong>Télédec URSSAF:</strong> <span id="teledec-info"></span></p>
                                <p><strong>Notes:</strong> <span id="notes-info"></span></p>
                            </div>

                            <hr class="mt-2 mb-2">
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="button" class="btn btn-primary next-step">Suivant</button>
                        </div>



                        <!-- Onglet Fichiers -->
                        <div class="tab-pane fade" id="fichiers" role="tabpanel">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach (['maj_fiche_para_file' => 'Fichier MAJ fiche para', 'reception_variables_file' => 'Fichier réception variables', 'preparation_bp_file' => 'Fichier préparation BP', 'validation_bp_client_file' => 'Fichier validation BP client', 'preparation_envoi_dsn_file' => 'Fichier préparation envoi DSN', 'accuses_dsn_file' => 'Fichier accusés DSN'] as $file_id => $label)
                                    <div class="form-group">
                                        <label for="{{ $file_id }}">{{ $label }}</label>
                                        <input type="file" name="{{ $file_id }}" id="{{ $file_id }}"
                                            class="form-control">
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            // Vérification des dates pour les champs
            $('input[type="date"]').each(function() {
                const inputDate = $(this).val();
                const currentDate = new Date();
                const inputDateObj = new Date(inputDate);

                if (!inputDate || inputDateObj.getFullYear() < currentDate.getFullYear()) {
                    $(this).css('background-color', 'red');
                } else {
                    $(this).css('background-color', '');
                }
            });

            $('input[type="date"]').change(function() {
                const inputDate = $(this).val();
                const currentDate = new Date();
                const inputDateObj = new Date(inputDate);

                if (!inputDate || inputDateObj.getFullYear() < currentDate.getFullYear()) {
                    $(this).css('background-color', 'red');
                } else {
                    $(this).css('background-color', '');
                }
            });

            // Affichage des informations de la période sélectionnée
            $('#periode_paie_id').change(function() {
                const periodeId = $(this).val();
                if (periodeId) {
                    $.ajax({
                        url: `/periodes-paie/${periodeId}/info`,
                        method: 'GET',
                        success: function(data) {
                            // Mettre à jour les informations de la période
                            $('#reception-info').text(data.reception_variables);
                            $('#preparation-info').text(data.preparation_bp);
                            $('#validation-info').text(data.validation_bp_client);
                            $('#envoie-info').text(data.preparation_envoie_dsn);
                            $('#accuses-info').text(data.accuses_dsn);
                            $('#teledec-info').text(data.teledec_urssaf);
                            $('#notes-info').text(data.notes);

                            // Mettre à jour le calendrier
                            const calendarEl = document.getElementById('calendar');
                            const calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'dayGridMonth',
                                events: [{
                                        title: 'Début de la période',
                                        start: data.debut,
                                        color: 'green'
                                    },
                                    {
                                        title: 'Fin de la période',
                                        start: data.fin,
                                        color: 'red'
                                    }
                                ]
                            });
                            calendar.render();

                            // Mettre à jour la barre de progression
                            const startDate = new Date(data.debut);
                            const endDate = new Date(data.fin);
                            const currentDate = new Date();
                            const totalDays = (endDate - startDate) / (1000 * 3600 * 24);
                            const elapsedDays = (currentDate - startDate) / (1000 * 3600 * 24);
                            const progressPercentage = Math.min((elapsedDays / totalDays) * 100,
                                100);

                            $('#progress-bar').css('width', `${progressPercentage}%`).attr(
                                'aria-valuenow', progressPercentage).text(
                                `${Math.round(progressPercentage)}%`);
                        },
                        error: function() {
                            alert('Impossible de charger les informations de la période.');
                        }
                    });
                }
            });
        });
    </script>
@endpush

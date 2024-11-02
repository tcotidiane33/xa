@extends('layouts.admin')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

@endpush


@section('content')
    <div class="container">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="form-container">
                <!-- Menu des onglets -->
                <ul class="nav nav-tabs" id="clientTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="societe-tab" data-toggle="tab" href="#societe" role="tab"
                            aria-controls="societe" aria-selected="true">Société</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab"
                            aria-controls="contacts" aria-selected="false">Contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="interne-tab" data-toggle="tab" href="#interne" role="tab"
                            aria-controls="interne" aria-selected="false">Interne</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="supplementaires-tab" data-toggle="tab" href="#supplementaires"
                            role="tab" aria-controls="supplementaires" aria-selected="false">Supplémentaires</a>
                    </li>
                </ul>

                <!-- Barre de progression -->
                <div class="progress mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0"
                        aria-valuemax="100">25%</div>
                </div>

                <form id="multiStepForm" method="POST" action="{{ route('clients.storePartial') }}">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id ?? '' }}">
                    <input type="hidden" name="step" value="societe">

                    <div class="form-step" id="societe">
                        <h4>Informations Société</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name">Nom de la société *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="type_societe">Type de société</label>
                                <input type="text" class="form-control" id="type_societe" name="type_societe">
                            </div>
                            <div class="col-md-6">
                                <label for="ville">Ville</label>
                                <input type="text" class="form-control" id="ville" name="ville">
                            </div>
                            <div class="col-md-6">
                                <label for="dirigeant_nom">Nom du dirigeant</label>
                                <input type="text" class="form-control" id="dirigeant_nom" name="dirigeant_nom">
                            </div>
                            <div class="col-md-6">
                                <label for="dirigeant_telephone">Téléphone du dirigeant</label>
                                <input type="text" class="form-control" id="dirigeant_telephone"
                                    name="dirigeant_telephone">
                            </div>
                            <div class="col-md-6">
                                <label for="dirigeant_email">Email du dirigeant</label>
                                <input type="email" class="form-control" id="dirigeant_email" name="dirigeant_email">
                            </div>
                        </div>
                    </div>
                    <div class="form-step" id="contacts">
                        <h4>Contacts</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contact_paie_nom">Nom du contact paie</label>
                                <input type="text" class="form-control" id="contact_paie_nom" name="contact_paie_nom">
                            </div>
                            <div class="col-md-6">
                                <label for="contact_paie_prenom">Prénom du contact paie</label>
                                <input type="text" class="form-control" id="contact_paie_prenom"
                                    name="contact_paie_prenom">
                            </div>
                            <div class="col-md-6">
                                <label for="contact_paie_telephone">Téléphone du contact paie</label>
                                <input type="text" class="form-control" id="contact_paie_telephone"
                                    name="contact_paie_telephone">
                            </div>
                            <div class="col-md-6">
                                <label for="contact_paie_email">Email du contact paie</label>
                                <input type="email" class="form-control" id="contact_paie_email"
                                    name="contact_paie_email">
                            </div>
                            <div class="col-md-6">
                                <label for="contact_compta_nom">Nom du contact comptabilité</label>
                                <input type="text" class="form-control" id="contact_compta_nom"
                                    name="contact_compta_nom">
                            </div>
                            <div class="col-md-6">
                                <label for="contact_compta_prenom">Prénom du contact comptabilité</label>
                                <input type="text" class="form-control" id="contact_compta_prenom"
                                    name="contact_compta_prenom">
                            </div>
                            <div class="col-md-6">
                                <label for="contact_compta_telephone">Téléphone du contact comptabilité</label>
                                <input type="text" class="form-control" id="contact_compta_telephone"
                                    name="contact_compta_telephone">
                            </div>
                            <div class="col-md-6">
                                <label for="contact_compta_email">Email du contact comptabilité</label>
                                <input type="text" class="form-control" id="contact_compta_email"
                                    name="contact_compta_email">
                            </div>
                        </div>
                    </div>
                    <div class="form-step" id="interne">
                        <h4>Interne</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="responsable_paie_id">Responsable paie</label>
                                <select class="form-control select2" id="responsable_paie_id" name="responsable_paie_id">
                                    @foreach ($responsables as $responsable)
                                        <option value="{{ $responsable->id }}">{{ $responsable->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="responsable_telephone_ld">Téléphone Responsable</label>
                                <input type="text" class="form-control" id="responsable_telephone_ld"
                                    name="responsable_telephone_ld">
                            </div>
                            <div class="col-md-6">
                                <label for="gestionnaire_principal_id">Gestionnaire principal</label>
                                <select class="form-control select2" id="gestionnaire_principal_id"
                                    name="gestionnaire_principal_id">
                                    @foreach ($gestionnaires as $gestionnaire)
                                        <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="gestionnaire_telephone_ld">Téléphone Gestionnaire</label>
                                <input type="text" class="form-control" id="gestionnaire_telephone_ld"
                                    name="gestionnaire_telephone_ld">
                            </div>
                            <div class="col-md-6">
                                <label for="binome_id">Binôme</label>
                                <select class="form-control select2" id="binome_id" name="binome_id">
                                    @foreach ($gestionnaires as $gestionnaire)
                                        <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="binome_telephone_ld">Téléphone Binôme</label>
                                <input type="text" class="form-control" id="binome_telephone_ld"
                                    name="binome_telephone_ld">
                            </div>
                            <div class="col-md-6">
                                <label for="convention_collective_id">Convention Collective</label>
                                <select class="form-control select2" id="convention_collective_id"
                                    name="convention_collective_id">
                                    @foreach ($conventions as $convention)
                                        <option value="{{ $convention->id }}">{{ $convention->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="maj_fiche_para">Mise à jour fiche para</label>
                                <input type="date" class="form-control" id="maj_fiche_para" name="maj_fiche_para">
                            </div>
                        </div>
                    </div>
                    <div class="form-step" id="supplementaires">
                        <h4>Informations Supplémentaires</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="taux_at">Taux AT</label>
                                <input type="text" class="form-control" id="taux_at" name="taux_at" required>
                            </div>
                            <div class="col-md-6">
                                <label for="saisie_variables">Saisie des variables</label>
                                <input type="checkbox" class="form-control" id="saisie_variables"
                                    name="saisie_variables">
                            </div>
                            <div class="col-md-6">
                                <label for="client_forme_saisie">Client formé à la saisie</label>
                                <input type="checkbox" class="form-control" id="client_forme_saisie"
                                    name="client_forme_saisie">
                            </div>
                            <div class="col-md-6">
                                <label for="date_formation_saisie">Date de formation à la saisie</label>
                                <input type="date" class="form-control" id="date_formation_saisie"
                                    name="date_formation_saisie">
                            </div>
                            <div class="col-md-6">
                                <label for="date_debut_prestation">Date de début de prestation</label>
                                <input type="date" class="form-control" id="date_debut_prestation"
                                    name="date_debut_prestation">
                            </div>
                            <div class="col-md-6">
                                <label for="date_fin_prestation">Date de fin de prestation</label>
                                <input type="date" class="form-control" id="date_fin_prestation"
                                    name="date_fin_prestation">
                            </div>
                            <div class="col-md-6">
                                <label for="date_signature_contrat">Date de signature du contrat</label>
                                <input type="date" class="form-control" id="date_signature_contrat"
                                    name="date_signature_contrat">
                            </div>
                            <div class="col-md-6">
                                <label for="date_rappel_mail">Date de rappel par mail</label>
                                <input type="date" class="form-control" id="date_rappel_mail"
                                    name="date_rappel_mail">
                            </div>
                            <div class="col-md-6">
                                <label for="adhesion_mydrh">Adhésion MyDRH</label>
                                <input type="checkbox" class="form-control" id="adhesion_mydrh" name="adhesion_mydrh">
                            </div>
                            <div class="col-md-6">
                                <label for="date_adhesion_mydrh">Date d'adhésion MyDRH</label>
                                <input type="date" class="form-control" id="date_adhesion_mydrh"
                                    name="date_adhesion_mydrh">
                            </div>
                            <div class="col-md-6">
                                <label for="is_cabinet">Est un cabinet</label>
                                <input type="checkbox" class="form-control" id="is_cabinet" name="is_cabinet">
                            </div>
                            <div class="col-md-6">
                                <label for="portfolio_cabinet_id">Portfolio Cabinet</label>
                                <select class="form-control select2" id="portfolio_cabinet_id"
                                    name="portfolio_cabinet_id">
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary next-step">Suivant</button>
                    <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                    <button type="submit" class="btn btn-success submit-form">Soumettre</button>
                </form>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                const steps = ['societe', 'contacts', 'interne', 'supplementaires'];
                let currentStepIndex = 0;

                function showStep(index) {
                    $('.form-step').hide();
                    $(`#${steps[index]}`).show();
                }

                function updateStepButtons() {
                    $('.prev-step').prop('disabled', currentStepIndex === 0);
                    $('.next-step').prop('disabled', currentStepIndex === steps.length - 1);
                }

                function updateProgressBar() {
                    const progress = ((currentStepIndex + 1) / steps.length) * 100;
                    $('.progress-bar').css('width', `${progress}%`);
                }

                function showErrors(errors) {
                    for (const [field, messages] of Object.entries(errors)) {
                        const input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.after(`<div class="invalid-feedback">${messages.join('<br>')}</div>`);
                    }
                }

                function clearErrors() {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                }

                function submitStep(step) {
                    $.ajax({
                        url: "{{ route('clients.storePartial') }}",
                        method: 'POST',
                        data: $(`#${step}`).find(':input').serialize(),
                        success: function(response) {
                            clearErrors();
                            if (response.success) {
                                if (currentStepIndex < script steps.length - 1) {
                                    currentStepIndex++;
                                    showStep(currentStepIndex);
                                    updateStepButtons();
                                    updateProgressBar();
                                } else {
                                    toastr.success('Formulaire soumis avec succès');
                                }
                            } else {
                                if (response.errors) {
                                    showErrors(response.errors);
                                    toastr.error('Veuillez corriger les erreurs dans le formulaire');
                                } else {
                                    toastr.error('Une erreur est survenue');
                                }
                            }
                        },
                        error: function(xhr) {
                            console.log('Erreur de soumission', xhr);
                            clearErrors();
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                showErrors(xhr.responseJSON.errors);
                            }
                            toastr.error('Une erreur est survenue');
                        }
                    });
                }

                $('.next-step').on('click', function() {
                    submitStep(steps[currentStepIndex]);
                });

                $('.submit-form').on('click', function() {
                    submitStep(steps[currentStepIndex]);
                });

                $('.prev-step').on('click', function() {
                    if (currentStepIndex > 0) {
                        currentStepIndex--;
                        showStep(currentStepIndex);
                        updateStepButtons();
                        updateProgressBar();
                    }
                });

                showStep(currentStepIndex);
                updateStepButtons();
                updateProgressBar();
            });
        </>
    @endpush

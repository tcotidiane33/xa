@extends('layouts.admin')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        .form-container {
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tab-content {
            padding: 20px;
            border: 1px solid #dee2e6;
            border-top: none;
        }

        .form-actions {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .error-feedback {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .step-buttons {
            display: flex;
            justify-content: space-between;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="breadcrumb">
            <h1>Créer un nouveau client</h1>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="main-page">
            <div class="form-container">
                <!-- Onglets -->
                <ul class="nav nav-tabs" id="clientTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="societe-tab" data-bs-toggle="tab" href="#societe">Société</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="contacts-tab" data-bs-toggle="tab" href="#contacts">Contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="interne-tab" data-bs-toggle="tab" href="#interne">Informations
                            Internes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="supplementaires-tab" data-bs-toggle="tab"
                            href="#supplementaires">Informations Supplémentaires</a>
                    </li>
                </ul>

                <form id="clientForm">
                    @csrf
                    <div class="tab-content mt-3">
                        <!-- Onglet Société -->
                        <div class="tab-pane fade show active" id="societe">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="name">Nom Société *</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="type_societe">Type</label>
                                    <input type="text" class="form-control" name="type_societe">
                                </div>
                                <div class="col-md-4">
                                    <label for="ville">Ville</label>
                                    <input type="text" class="form-control" name="ville">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Nom du dirigeant</label>
                                    <input type="text" class="form-control" name="dirigeant_nom">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label>Téléphone</label>
                                    <input type="tel" class="form-control" name="dirigeant_telephone">
                                </div>
                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="dirigeant_email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date_estimative_envoi_variables">Date estimative d'envoi des variables</label>
                                <input type="date" name="date_estimative_envoi_variables"
                                    id="date_estimative_envoi_variables" class="form-control"
                                    value="{{ old('date_estimative_envoi_variables') }}">
                                @error('date_estimative_envoi_variables')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nb_bulletins">Nombre de bulletins</label>
                                <input type="number" name="nb_bulletins" id="nb_bulletins" class="form-control"
                                    value="{{ old('nb_bulletins') }}">
                                @error('nb_bulletins')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <!-- Onglet Contacts -->
                        <div class="tab-pane fade" id="contacts">
                            <h4>Contact Paie</h4>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Nom</label>
                                    <input type="text" class="form-control" name="contact_paie_nom">
                                </div>
                                <div class="col-md-3">
                                    <label>Prénom</label>
                                    <input type="text" class="form-control" name="contact_paie_prenom">
                                </div>
                                <div class="col-md-3">
                                    <label>Téléphone</label>
                                    <input type="tel" class="form-control" name="contact_paie_telephone">
                                </div>
                                <div class="col-md3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="contact_paie_email">
                                </div>
                            </div>

                            <h4>Contact Comptabilité</h4>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Nom</label>
                                    <input type="text" class="form-control" name="contact_compta_nom">
                                </div>
                                <div class="col-md-3">
                                    <label>Prénom</label>
                                    <input type="text" class="form-control" name="contact_compta_prenom">
                                </div>
                                <div class="col-md-3">
                                    <label>Téléphone</label>
                                    <input type="tel" class="form-control" name="contact_compta_telephone">
                                </div>
                                <div class="col-md-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="contact_compta_email">
                                </div>
                            </div>
                            {{-- <h4>Binômes Supplémentaires</h4>
                            <div class="form-group">
                                <label for="contact_paie">Contact Paie</label>
                                <input type="text" class="form-control" id="contact_paie" name="contact_paie">
                            </div>
                            <div class="form-group">
                                <label for="contact_comptabilite">Contact Comptabilité</label>
                                <input type="text" class="form-control" id="contact_comptabilite" name="contact_comptabilite">
                            </div> --}}
                        </div>

                        <!-- Onglet Informations Internes -->
                        <div class="tab-pane fade" id="interne">
                            <h4>Responsable paie</h4>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Responsable *</label>
                                    <select name="responsable_paie_id" class="form-control" required>
                                        <option value="">Sélectionner un responsable</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Téléphone LD</label>
                                    <input type="tel" class="form-control" name="responsable_telephone_ld">
                                    @error('tel')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <h4>Gestionnaire et Binôme</h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Gestionnaire principal *</label>
                                    <select name="gestionnaire_principal_id" class="form-control" required>
                                        <option value="">Sélectionner un gestionnaire</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="gestionnaires_secondaires">
                                            Binôme
                                        </label>
                                        <select name="binome_id" class="form-control" required>
                                            <option value="">Sélectionner un binôme</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ isset($client) && $client->binome_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('gestionnaires_secondaires')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h4>Convention Collective</h4>
                            {{-- <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Convention Collective *</label>
                                    <select name="convention_collective_id" class="form-control" required>
                                        <option value="">Sélectionner une convention collective</option>
                                        @foreach ($conventionCollectives as $convention)
                                            <option value="{{ $convention->id }}">{{ $convention->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label for="convention_collective_id">Convention Collective</label>
                                <select name="convention_collective_id" id="convention_collective_id"
                                    class="form-control">
                                    <option value="">Sélectionner une convention collective</option>
                                    @foreach ($conventionCollectives as $conventionCollective)
                                        <option value="{{ $conventionCollective->id }}">{{ $conventionCollective->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="maj_fiche_para">Date de mise à jour fiche para</label>
                                <input type="date" name="maj_fiche_para" id="maj_fiche_para" class="form-control"
                                    value="{{ old('maj_fiche_para') }}">
                                @error('maj_fiche_para')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <!-- Onglet Informations Supplémentaires -->
                        <div class="tab-pane fade" id="supplementaires">
                            <h4>Informations Supplémentaires</h4>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Saisie des variables *</label>
                                    <input type="checkbox" name="saisie_variables" value="1">
                                </div>
                                <div class="col-md-4">
                                    <label>Client formé à la saisie en ligne</label>
                                    <input type="checkbox" name="client_forme_saisie" value="1">
                                    <input type="date" name="date_formation_saisie" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="col-md-2 form-group">
                                    <label for="date_debut_prestation">Date de début de prestation</label>
                                    <input type="date" name="date_debut_prestation" id="date_debut_prestation"
                                        class="form-control" value="{{ old('date_debut_prestation') }}">
                                    @error('date_debut_prestation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="date_fin_prestation">Date de fin de prestation</label>
                                    <input type="date" name="date_fin_prestation" id="date_fin_prestation"
                                        class="form-control" value="{{ old('date_fin_prestation') }}">
                                    @error('date_fin_prestation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="date_signature_contrat">Date de signature du contrat</label>
                                    <input type="date" name="date_signature_contrat" id="date_signature_contrat"
                                        class="form-control" value="{{ old('date_signature_contrat') }}">
                                    @error('date_signature_contrat')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <h4>Taux & Adhésions</h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Taux AT *</label>
                                    <input type="text" name="taux_at" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Adhésion myDRH *</label>
                                    <input type="checkbox" name="adhesion_mydrh" value="1">
                                    <input type="date" name="date_adhesion_mydrh" class="form-control">
                                </div>
                            </div>

                            <h4>Cabinet & Portefeuille Cabinet</h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Est-ce un cabinet ?</label>
                                    <input type="checkbox" name="is_cabinet" value="1">
                                </div>
                                <div class="col-md-6">
                                    <label>Portefeuille Cabinet</label>
                                    <select name="portfolio_cabinet_id" class="form-control">
                                        <option value="">Sélectionner un portefeuille cabinet</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="step-buttons">
                            <button type="button" class="btn btn-secondary prev-step"
                                style="display: none;">Précédent</button>
                            <div>
                                <button type="button" class="btn btn-primary next-step"
                                    data-step="societe">Suivant</button>
                                <button type="button" class="btn btn-success submit-form"
                                    style="display: none;">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </form>
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
            // Configuration de Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            // Ordre des étapes
            const steps = ['societe', 'contacts', 'interne', 'supplementaires'];
            let currentStepIndex = 0;

            function updateButtons() {
                // Gestion du bouton précédent
                if (currentStepIndex > 0) {
                    $('.prev-step').show();
                } else {
                    $('.prev-step').hide();
                }

                // Gestion des boutons suivant/enregistrer
                if (currentStepIndex === steps.length - 1) {
                    $('.next-step').hide();
                    $('.submit-form').show();
                } else {
                    $('.next-step').show();
                    $('.submit-form').hide();
                }

                // Mise à jour du data-step
                $('.next-step').data('step', steps[currentStepIndex]);
            }

            // Gestion du bouton précédent
            $('.prev-step').click(function() {
                if (currentStepIndex > 0) {
                    currentStepIndex--;
                    $(`#clientTabs a[href="#${steps[currentStepIndex]}"]`).tab('show');
                    updateButtons();
                }
            });

            // Fonction de validation et soumission du formulaire
            function validateStep(step) {
                let isValid = true;
                $('.error-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');

                $(`#${step} .form-control[required]`).each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        $(this).after('<div class="error-feedback">Ce champ est requis</div>');
                        isValid = false;
                    }
                });

                return isValid;
            }

            function submitStep(step) {
                if (!validateStep(step)) {
                    toastr.error('Veuillez corriger les erreurs dans le formulaire');
                    return;
                }

                let formData = new FormData($('#clientForm')[0]);
                formData.append('step', step);

                $.ajax({
                    url: "{{ route('clients.storePartial') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Données sauvegardées avec succès');

                            if (response.nextStep) {
                                // Activer et afficher le prochain onglet
                                currentStepIndex++;
                                $(`#clientTabs a[href="#${response.nextStep}"]`).removeClass(
                                    'disabled');
                                $(`#clientTabs a[href="#${response.nextStep}"]`).tab('show');
                                updateButtons();
                            } else {
                                toastr.success('Toutes les étapes sont complétées');
                            }
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(field => {
                                const input = $(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.after(
                                    `<div class="error-feedback">${errors[field][0]}</div>`);
                            });
                            toastr.error('Veuillez corriger les erreurs dans le formulaire');
                        } else {
                            toastr.error('Une erreur est survenue');
                        }
                    }
                });
            }

            // Gestion des boutons suivant et enregistrer
            $('.next-step, .submit-form').click(function(e) {
                e.preventDefault();
                const step = $(this).data('step');
                submitStep(step);
            });

            // Gestion des onglets
            $('#clientTabs a').on('click', function(e) {
                if ($(this).hasClass('disabled')) {
                    e.preventDefault();
                    return false;
                }
                const targetStep = $(this).attr('href').replace('#', '');
                currentStepIndex = steps.indexOf(targetStep);
                updateButtons();
            });

            // Initialisation
            updateButtons();
        });
    </script>
@endpush

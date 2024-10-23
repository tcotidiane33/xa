@extends('layouts.admin')

@section('content')
    <div class="main-content mb-5">
        <h2 class="title1 breadcrumb ">{{ __('Modifier le client') }}</h2>
        <div class="form-three widget-shadow">
            <!-- Section Société -->
            <div class="section" id="societe">
                <h3 class="text-teal-400 via-teal-500 to-teal-600 hover:text-gradient-to-br">Société</h3>
                <form action="{{ route('clients.updatePartial', ['client' => $client->id, 'step' => 'societe']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="name">Nom Société *</label>
                            <input type="text" class="form-control" name="name" value="{{ $client->name }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="type_societe">Type</label>
                            <input type="text" class="form-control" name="type_societe" value="{{ $client->type_societe }}">
                        </div>
                        <div class="col-md-4">
                            <label for="ville">Ville</label>
                            <input type="text" class="form-control" name="ville" value="{{ $client->ville }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Nom du dirigeant</label>
                            <input type="text" class="form-control" name="dirigeant_nom" value="{{ $client->dirigeant_nom }}">
                        </div>
                        <div class="col-md-4">
                            <label>Téléphone</label>
                            <input type="tel" class="form-control" name="dirigeant_telephone" value="{{ $client->dirigeant_telephone }}">
                        </div>
                        <div class="col-md-4">
                            <label>Email</label>
                            <input type="email" class="form-control" name="dirigeant_email" value="{{ $client->dirigeant_email }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="date_estimative_envoi_variables">Date estimative d'envoi des variables</label>
                            <input type="date" class="form-control" id="date_estimative_envoi_variables" name="date_estimative_envoi_variables" value="{{ $client->date_estimative_envoi_variables }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nb_bulletins">Nombre de bulletins</label>
                            <input type="number" class="form-control" id="nb_bulletins" name="nb_bulletins" value="{{ $client->nb_bulletins }}">
                        </div>
                        <div class="col-md-4">
                            <label for="maj_fiche_para">Date de mise à jour fiche para</label>
                            <input type="date" class="form-control" id="maj_fiche_para" name="maj_fiche_para" value="{{ $client->maj_fiche_para }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
            <hr class="w-max h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">

            <!-- Section Contacts -->
            <div class="section" id="contacts">
                <h3 class="text-pink-500">Contacts</h3>
                <form action="{{ route('clients.updatePartial', ['client' => $client->id, 'step' => 'contacts']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h4>Contact Paie</h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Nom</label>
                            <input type="text" class="form-control" name="contact_paie_nom" value="{{ $client->contact_paie_nom }}">
                        </div>
                        <div class="col-md-3">
                            <label>Prénom</label>
                            <input type="text" class="form-control" name="contact_paie_prenom" value="{{ $client->contact_paie_prenom }}">
                        </div>
                        <div class="col-md-3">
                            <label>Téléphone</label>
                            <input type="tel" class="form-control" name="contact_paie_telephone" value="{{ $client->contact_paie_telephone }}">
                        </div>
                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="contact_paie_email" value="{{ $client->contact_paie_email }}">
                        </div>
                    </div>

                    <h4>Contact Comptabilité</h4>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Nom</label>
                            <input type="text" class="form-control" name="contact_compta_nom" value="{{ $client->contact_compta_nom }}">
                        </div>
                        <div class="col-md-3">
                            <label>Prénom</label>
                            <input type="text" class="form-control" name="contact_compta_prenom" value="{{ $client->contact_compta_prenom }}">
                        </div>
                        <div class="col-md-3">
                            <label>Téléphone</label>
                            <input type="tel" class="form-control" name="contact_compta_telephone" value="{{ $client->contact_compta_telephone }}">
                        </div>
                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="contact_compta_email" value="{{ $client->contact_compta_email }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
            <hr class="w-max h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">

            <!-- Section Informations Internes -->
            <div class="section" id="interne">
                <h3 class="text-pink-500">Informations Internes</h3>
                <form action="{{ route('clients.updatePartial', ['client' => $client->id, 'step' => 'interne']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h4>Responsable paie</h4>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Responsable *</label>
                            <select name="responsable_paie_id" class="form-control" required>
                                <option value="">Sélectionner un responsable</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $client->responsable_paie_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Téléphone LD</label>
                            <input type="tel" class="form-control" name="responsable_telephone_ld" value="{{ $client->responsable_telephone_ld }}">
                        </div>
                    </div>

                    <h4>Gestionnaire et Binôme</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Gestionnaire principal *</label>
                            <select name="gestionnaire_principal_id" class="form-control" required>
                                <option value="">Sélectionner un gestionnaire</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $client->gestionnaire_principal_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Binôme *</label>
                            <select name="binome_id" class="form-control" required>
                                <option value="">Sélectionner un binôme</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $client->binome_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
            <hr class="w-max h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">

            <!-- Section Informations Supplémentaires -->
            <div class="section" id="supplementaires">
                <h3 class="text-pink-500">Informations Supplémentaires</h3>
                <form action="{{ route('clients.updatePartial', ['client' => $client->id, 'step' => 'supplementaires']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Saisie des variables *</label>
                            <input type="checkbox" name="saisie_variables" value="1" {{ $client->saisie_variables ? 'checked' : '' }}>
                        </div>
                        <div class="col-md-4">
                            <label>Client formé à la saisie en ligne</label>
                            <input type="checkbox" name="client_forme_saisie" value="1" {{ $client->client_forme_saisie ? 'checked' : '' }}>
                            <input type="date" name="date_formation_saisie" class="form-control" value="{{ $client->date_formation_saisie ? \Carbon\Carbon::parse($client->date_formation_saisie)->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Date de début de prestation *</label>
                            <input type="date" name="date_debut_prestation" class="form-control" value="{{ $client->date_debut_prestation ? \Carbon\Carbon::parse($client->date_debut_prestation)->format('Y-m-d') : '' }}" required>
                        </div>
                        <div class="col-md-4">
                            <label>Date de fin de prestation</label>
                            <input type="date" name="date_fin_prestation" class="form-control" value="{{ $client->date_fin_prestation ? \Carbon\Carbon::parse($client->date_fin_prestation)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-6">
                            <label>Date de signature du contrat *</label>
                            <input type="date" name="date_signature_contrat" class="form-control" value="{{ $client->date_signature_contrat ? \Carbon\Carbon::parse($client->date_signature_contrat)->format('Y-m-d') : '' }}" required>
                        </div>
                    </div>

                    <h4>Taux & Adhésions</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Taux AT *</label>
                            <input type="text" name="taux_at" class="form-control" value="{{ $client->taux_at }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Adhésion myDRH *</label>
                            <input type="checkbox" name="adhesion_mydrh" value="1" {{ $client->adhesion_mydrh ? 'checked' : '' }}>
                            <input type="date" name="date_adhesion_mydrh" class="form-control" value="{{ $client->date_adhesion_mydrh ? \Carbon\Carbon::parse($client->date_adhesion_mydrh)->format('Y-m-d') : '' }}">
                        </div>
                    </div>

                    <h4>Cabinet & Portefeuille Cabinet</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Est-ce un cabinet ?</label>
                            <input type="checkbox" name="is_cabinet" value="1" {{ $client->is_cabinet ? 'checked' : '' }}>
                        </div>
                        <div class="col-md-6">
                            <label>Portefeuille Cabinet</label>
                            <select name="portfolio_cabinet_id" class="form-control">
                                <option value="">Sélectionner un portefeuille cabinet</option>
                                @foreach ($clients as $portfolioClient)
                                    <option value="{{ $portfolioClient->id }}" {{ $client->portfolio_cabinet_id == $portfolioClient->id ? 'selected' : '' }}>
                                        {{ $portfolioClient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Téléphone LD</label>
                            <input type="tel" class="form-control" name="responsable_telephone_ld" value="{{ $client->responsable_telephone_ld }}">
                        </div>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
        <div class="row mb-4">
            <hr>
         </div>
    </div>
@endsection
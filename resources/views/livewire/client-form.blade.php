<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submitForm">
        @if ($currentStep == 1)
            <div class="form-step">
                <h4>Société</h4>
                <div class="form-group">
                    <label for="name">Nom de la société</label>
                    <input type="text" class="form-control" id="name" wire:model="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="type_societe">Type de société</label>
                    <input type="text" class="form-control" id="type_societe" wire:model="type_societe">
                    @error('type_societe') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="ville">Ville</label>
                    <input type="text" class="form-control" id="ville" wire:model="ville">
                    @error('ville') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="dirigeant_nom">Nom du dirigeant</label>
                    <input type="text" class="form-control" id="dirigeant_nom" wire:model="dirigeant_nom">
                    @error('dirigeant_nom') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="dirigeant_telephone">Téléphone du dirigeant</label>
                    <input type="text" class="form-control" id="dirigeant_telephone" wire:model="dirigeant_telephone">
                    @error('dirigeant_telephone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="dirigeant_email">Email du dirigeant</label>
                    <input type="email" class="form-control" id="dirigeant_email" wire:model="dirigeant_email">
                    @error('dirigeant_email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="button" class="btn btn-primary" wire:click="nextStep">Suivant</button>
            </div>
        @endif

        @if ($currentStep == 2)
            <div class="form-step">
                <h4>Contacts</h4>
                <div class="form-group">
                    <label for="contact_paie_nom">Nom du contact paie</label>
                    <input type="text" class="form-control" id="contact_paie_nom" wire:model="contact_paie_nom">
                    @error('contact_paie_nom') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="contact_paie_prenom">Prénom du contact paie</label>
                    <input type="text" class="form-control" id="contact_paie_prenom" wire:model="contact_paie_prenom">
                    @error('contact_paie_prenom') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="contact_paie_telephone">Téléphone du contact paie</label>
                    <input type="text" class="form-control" id="contact_paie_telephone" wire:model="contact_paie_telephone">
                    @error('contact_paie_telephone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="contact_paie_email">Email du contact paie</label>
                    <input type="email" class="form-control" id="contact_paie_email" wire:model="contact_paie_email">
                    @error('contact_paie_email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="button" class="btn btn-secondary" wire:click="previousStep">Précédent</button>
                <button type="button" class="btn btn-primary" wire:click="nextStep">Suivant</button>
            </div>
        @endif

        @if ($currentStep == 3)
            <div class="form-step">
                <h4>Informations Internes</h4>
                <div class="form-group">
                    <label for="responsable_paie_id">Responsable paie</label>
                    <select class="form-control" id="responsable_paie_id" wire:model="responsable_paie_id">
                        <option value="">Sélectionner un responsable</option>
                        @foreach ($responsables as $responsable)
                            <option value="{{ $responsable->id }}">{{ $responsable->name }}</option>
                        @endforeach
                    </select>
                    @error('responsable_paie_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="responsable_telephone_ld">Téléphone ligne directe responsable</label>
                    <input type="text" class="form-control" id="responsable_telephone_ld" wire:model="responsable_telephone_ld">
                    @error('responsable_telephone_ld') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="gestionnaire_principal_id">Gestionnaire principal</label>
                    <select class="form-control" id="gestionnaire_principal_id" wire:model="gestionnaire_principal_id">
                        <option value="">Sélectionner un gestionnaire</option>
                        @foreach ($gestionnaires as $gestionnaire)
                            <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                        @endforeach
                    </select>
                    @error('gestionnaire_principal_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="binome_id">Binôme</label>
                    <select class="form-control" id="binome_id" wire:model="binome_id">
                        <option value="">Sélectionner un binôme</option>
                        @foreach ($gestionnaires as $gestionnaire)
                            <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                        @endforeach
                    </select>
                    @error('binome_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="convention_collective_id">Convention collective</label>
                    <select class="form-control" id="convention_collective_id" wire:model="convention_collective_id">
                        <option value="">Sélectionner une convention collective</option>
                        @foreach ($conventions as $convention)
                            <option value="{{ $convention->id }}">{{ $convention->name }}</option>
                        @endforeach
                    </select>
                    @error('convention_collective_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="maj_fiche_para">Mise à jour fiche paramétrage</label>
                    <input type="date" class="form-control" id="maj_fiche_para" wire:model="maj_fiche_para">
                    @error('maj_fiche_para') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="button" class="btn btn-secondary" wire:click="previousStep">Précédent</button>
                <button type="button" class="btn btn-primary" wire:click="nextStep">Suivant</button>
            </div>
        @endif

        @if ($currentStep == 4)
            <div class="form-step">
                <h4>Informations Supplémentaires</h4>
                <div class="form-group">
                    <label for="saisie_variables">Saisie des variables</label>
                    <input type="checkbox" id="saisie_variables" wire:model="saisie_variables">
                    @error('saisie_variables') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="client_forme_saisie">Client formé à la saisie</label>
                    <input type="checkbox" id="client_forme_saisie" wire:model="client_forme_saisie">
                    <input type="date" class="form-control" id="date_formation_saisie" wire:model="date_formation_saisie">
                    @error('client_forme_saisie') <span class="text-danger">{{ $message }}</span> @enderror
                    @error('date_formation_saisie') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="date_debut_prestation">Date de début de prestation</label>
                    <input type="date" class="form-control" id="date_debut_prestation" wire:model="date_debut_prestation">
                    @error('date_debut_prestation') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="date_fin_prestation">Date de fin de prestation</label>
                    <input type="date" class="form-control" id="date_fin_prestation" wire:model="date_fin_prestation">
                    @error('date_fin_prestation') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="date_signature_contrat">Date de signature du contrat</label>
                    <input type="date" class="form-control" id="date_signature_contrat" wire:model="date_signature_contrat">
                    @error('date_signature_contrat') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="date_rappel_mail">Date de rappel par mail</label>
                    <input type="date" class="form-control" id="date_rappel_mail" wire:model="date_rappel_mail">
                    @error('date_rappel_mail') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="taux_at">Taux AT</label>
                    <input type="text" class="form-control" id="taux_at" wire:model="taux_at">
                    @error('taux_at') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="adhesion_mydrh">Adhésion MyDRH</label>
                    <input type="checkbox" id="adhesion_mydrh" wire:model="adhesion_mydrh">
                    <input type="date" class="form-control" id="date_adhesion_mydrh" wire:model="date_adhesion_mydrh">
                    @error('adhesion_mydrh') <span class="text-danger">{{ $message }}</span> @enderror
                    @error('date_adhesion_mydrh') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="is_cabinet">Est un cabinet</label>
                    <input type="checkbox" id="is_cabinet" wire:model="is_cabinet">
                    @error('is_cabinet') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="portfolio_cabinet_id">Portefeuille cabinet</label>
                    <select class="form-control" id="portfolio_cabinet_id" wire:model="portfolio_cabinet_id">
                        <option value="">Sélectionner un portefeuille cabinet</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                    @error('portfolio_cabinet_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="button" class="btn btn-secondary" wire:click="previousStep">Précédent</button>
                <button type="submit" class="btn btn-success">Soumettre</button>
            </div>
        @endif
    </form>
</div>
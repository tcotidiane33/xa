<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $traitementPaieId ? 'Modifier' : 'Créer' }} un Traitement de Paie</h1>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        <div class="grid gap-6 mb-6 md:grid-cols-4">
            <div>
                <div class="form-group">
                    <label for="client_id">Client</label>
                    <select wire:model="client_id" id="client_id" class="form-control" required>
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="gestionnaire_id">Gestionnaire</label>
                    <select wire:model="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                        <option value="">Sélectionner un gestionnaire</option>
                        @foreach($gestionnaires as $gestionnaire)
                            <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                        @endforeach
                    </select>
                    @error('gestionnaire_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="periode_paie_id">Période de Paie</label>
                    <select wire:model="periode_paie_id" id="periode_paie_id" class="form-control" required>
                        <option value="">Sélectionner une période de paie</option>
                        @foreach($periodesPaie as $periode)
                            <option value="{{ $periode->id }}">{{ $periode->reference }}</option>
                        @endforeach
                    </select>
                    @error('periode_paie_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label for="nbr_bull">Nombre de Bulletins</label>
                    <input type="number" wire:model="nbr_bull" id="nbr_bull" class="form-control" required>
                    @error('nbr_bull') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="teledec_urssaf">Télédec URSSAF</label>
                    <input type="date" wire:model="teledec_urssaf" id="teledec_urssaf" class="form-control">
                    @error('teledec_urssaf') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label for="reception_variables">Réception Variables</label>
                    <input type="date" wire:model="reception_variables" id="reception_variables" class="form-control">
                    @error('reception_variables') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="preparation_bp">Préparation BP</label>
                    <input type="date" wire:model="preparation_bp" id="preparation_bp" class="form-control">
                    @error('preparation_bp') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="validation_bp_client">Validation BP Client</label>
                    <input type="date" wire:model="validation_bp_client" id="validation_bp_client" class="form-control">
                    @error('validation_bp_client') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="preparation_envoie_dsn">Préparation et Envoie DSN</label>
                    <input type="date" wire:model="preparation_envoie_dsn" id="preparation_envoie_dsn" class="form-control">
                    @error('preparation_envoie_dsn') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="accuses_dsn">Accusés DSN</label>
                    <input type="date" wire:model="accuses_dsn" id="accuses_dsn" class="form-control">
                    @error('accuses_dsn') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea wire:model="notes" id="notes" class="form-control"></textarea>
                    @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="maj_fiche_para_file">Fichier MAJ Fiche Para</label>
                    <input type="file" wire:model="maj_fiche_para_file" id="maj_fiche_para_file" class="form-control">
                    @error('maj_fiche_para_file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="reception_variables_file">Fichier Réception Variables</label>
                    <input type="file" wire:model="reception_variables_file" id="reception_variables_file" class="form-control">
                    @error('reception_variables_file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="preparation_bp_file">Fichier Préparation BP</label>
                    <input type="file" wire:model="preparation_bp_file" id="preparation_bp_file" class="form-control">
                    @error('preparation_bp_file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="validation_bp_client_file">Fichier Validation BP Client</label>
                    <input type="file" wire:model="validation_bp_client_file" id="validation_bp_client_file" class="form-control">
                    @error('validation_bp_client_file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="preparation_envoi_dsn_file">Fichier Préparation Envoi DSN</label>
                    <input type="file" wire:model="preparation_envoi_dsn_file" id="preparation_envoi_dsn_file" class="form-control">
                    @error('preparation_envoi_dsn_file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="accuses_dsn_file">Fichier Accusés DSN</label>
                    <input type="file" wire:model="accuses_dsn_file" id="accuses_dsn_file" class="form-control">
                    @error('accuses_dsn_file') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>

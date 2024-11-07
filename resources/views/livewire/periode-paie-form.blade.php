<div>
    @if (session()->has('message'))
        <div class="row"><br><br></div>
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submitForm">
        {{-- // if user hav role Admin --}}
        @if ($isAdminOrResponsable)
            <div class="form-step">
                <h4>Étape 1 : Dates de la période de paie</h4>

                <div class="form-step">
                    <h4>Étape 1 : Dates de la période de paie</h4>
                    <div id="calendar"></div> <!-- Ajout du calendrier ici -->
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div class="form-group">
                            <label for="debut">Date de début</label>
                            <input type="date" class="form-control" id="debut" wire:model="debut">
                            @error('debut')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="fin">Date de fin</label>
                            <input type="date" class="form-control" id="fin" wire:model="fin">
                            @error('fin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Créer</button>
                    </div>
                </div>
        @endif
        {{-- if user have rôle Gestionnaire --}}

        @if ($isGestionnaire)
            @if ($currentStep == 1)
                <div class="form-step">
                    <h4>Étape 1 : Sélection de la période de paie</h4>
                    <div class="form-group">
                        <label for="periodePaieId">Période de paie</label>
                        <select class="form-control" id="periodePaieId" wire:model="periodePaieId">
                            <option value="">Sélectionnez une période de paie</option>
                            @foreach ($periodesPaieNonCloturees as $periode)
                                <option value="{{ $periode->id }}">{{ $periode->reference }}</option>
                            @endforeach
                        </select>
                        @error('periodePaieId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="calendar"></div> <!-- Ajout du calendrier ici -->

                    <button type="button" class="btn btn-primary" wire:click="nextStep">Suivant</button>
                </div>
            @elseif ($currentStep == 2)
                <div class="form-step">
                    <h4>Étape 2 : Sélection du client</h4>
                    <div class="form-group">
                        <label for="clientId">Client</label>
                        <select class="form-control" id="clientId" wire:model="clientId">
                            <option value="">Sélectionnez un client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('clientId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-secondary" wire:click="previousStep">Précédent</button>
                    <button type="button" class="btn btn-primary" wire:click="nextStep">Suivant</button>
                </div>
            @elseif ($currentStep == 3)
                <div class="form-step">

                    <h4>Étape 3 : Enregistrement des variables</h4>
                    <div class="grid gap-6 mb-6 md:grid-cols-3">
                        <div>
                            <div class="form-group">
                                <label for="reception_variables">Réception variables</label>
                                <input type="date" class="form-control" id="reception_variables"
                                    wire:model="reception_variables">
                                @error('reception_variables')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="preparation_bp">Préparation BP</label>
                                <input type="date" class="form-control" id="preparation_bp"
                                    wire:model="preparation_bp" @if (!$reception_variables) disabled @endif>
                                @error('preparation_bp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="validation_bp_client">Validation BP client</label>
                                <input type="date" class="form-control" id="validation_bp_client"
                                    wire:model="validation_bp_client" @if (!$preparation_bp) disabled @endif>
                                @error('validation_bp_client')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="preparation_envoie_dsn">Préparation et envoie DSN</label>
                                <input type="date" class="form-control" id="preparation_envoie_dsn"
                                    wire:model="preparation_envoie_dsn"
                                    @if (!$validation_bp_client) disabled @endif>
                                @error('preparation_envoie_dsn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label for="accuses_dsn">Accusés DSN</label>
                                <input type="date" class="form-control" id="accuses_dsn" wire:model="accuses_dsn"
                                    @if (!$preparation_envoie_dsn) disabled @endif>
                                @error('accuses_dsn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="notes">NOTES</label>
                                <textarea class="form-control" id="notes" wire:model="notes"></textarea>
                                @error('notes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" wire:click="previousStep">Précédent</button>
                <button type="button" class="btn btn-primary" wire:click="saveVariables">Enregistrer</button>
</div>
@endif
@endif
</form>
<div class="inline-flex items-center justify-center w-full">
    <hr class="w-100 h-1 my-8 bg-gray-200 border-0 rounded dark:bg-gray-700">
    <div class="absolute px-4 -translate-x-1/2 bg-pink-100 left-1/2 dark:bg-gray-900">
        <svg class="w-4 h-4 text-gray-700 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor" viewBox="0 0 18 14">
            <path
                d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3H2a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3h-1a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Z" />
        </svg>
    </div>
</div>
<h4>Liste des périodes de paie</h4>
<table class="table">
    <thead>
        <tr>
            <th>Référence</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($periodesPaie as $periode)
            <tr>
                <td>{{ $periode->reference }}</td>
                <td>{{ $periode->debut }}</td>
                <td>{{ $periode->fin }}</td>
                <td>{{ $periode->validee ? 'Clôturée' : 'Ouverte' }}</td>
                @if ($isAdminOrResponsable)
                    <td>
                        @if ($periode->validee)
                            <button wire:click="decloturerPeriode({{ $periode->id }})"
                                class="btn btn-warning">Rouvrir</button>
                        @else
                            <button wire:click="cloturerPeriode({{ $periode->id }})"
                                class="btn btn-danger">Clôturer</button>
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
</div>

@push('scripts')
    <!-- CalendarJS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                events: [
                    @foreach ($periodesPaie as $periode)
                        {
                            title: '{{ $periode->reference }}',
                            start: '{{ $periode->debut }}',
                            end: '{{ $periode->fin }}',
                            color: '{{ $periode->validee ? '#ff0000' : '#00ff00' }}' // Rouge pour les périodes clôturées, vert pour les autres
                        },
                    @endforeach
                ]
            });
        });
    </script>
@endpush

<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submitForm">
        <div class="form-step">
            <h4>Étape 1 : Dates de la période de paie</h4>
            <div id="calendar"></div> <!-- Ajout du calendrier ici -->
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div class="form-group">
                    <label for="debut">Date de début</label>
                    <input type="date" class="form-control" id="debut" wire:model="debut">
                    @error('debut') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="fin">Date de fin</label>
                    <input type="date" class="form-control" id="fin" wire:model="fin">
                    @error('fin') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </div>
    </form>

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
                    <td>
                        @if ($periode->validee)
                            <button wire:click="decloturerPeriode({{ $periode->id }})" class="btn btn-warning">Rouvrir</button>
                        @else
                            <button wire:click="cloturerPeriode({{ $periode->id }})" class="btn btn-danger">Clôturer</button>
                        @endif
                    </td>
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
                    @foreach($periodesPaie as $periode)
                    {
                        title: '{{ $periode->reference }}',
                        start: '{{ $periode->debut }}',
                        end: '{{ $periode->fin }}',
                        color: '{{ $periode->validee ? "#ff0000" : "#00ff00" }}' // Rouge pour les périodes clôturées, vert pour les autres
                    },
                    @endforeach
                ]
            });
        });
    </script>
@endpush
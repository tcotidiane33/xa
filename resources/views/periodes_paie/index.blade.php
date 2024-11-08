@extends('layouts.admin')

@push('styles')
    <style>
        .modifiable {
            background-color: #ea00ffc7;
            /* Couleur de fond pour les champs modifiables */
        }

        .non-modifiable {
            background-color: #d285da;
            /* Couleur de fond pour les champs non modifiables */
        }

        .progress {
            background-color: #ff00f231;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #04e90c;
            height: 20px;
            text-align: center;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            /* Réduire la largeur du popup */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .table-container {
            overflow-x: auto;
            /* Ajout de l'overflow pour le tableau */
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Périodes de Paie</h1>
        @if ($currentPeriodePaie)
            <h1 class="text-2xl font-bold text-blue-600 mb-4">Période de Paie en cours : {{ $currentPeriodePaie->reference }}
            </h1>
        @else
            <h1 class="text-2xl font-bold text-red-600 mb-4">Aucune période de paie en cours</h1>
        @endif
        @if (Auth::user()->hasRole(['Admin', 'Responsable', 'Gestionnaire']))
            <div class="mb-4">
                <a href="{{ route('periodes-paie.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Créer une Période de Paie
                </a>
                <span class="p-1"></span>
                <a href="{{ route('fiches-clients.create') }}"
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    Ouvrir une fiche Client
                </a>
            </div>
        @endif

        <form action="{{ route('periodes-paie.index') }}" method="GET" class="mb-4">
            <div class="flex flex-wrap gap-4">
                <div class="w-sm md:w-1/6">
                    <select name="client_id" class="form-control">
                        <option value="">Tous les clients</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-sm md:w-1/6">
                    <select name="gestionnaire_id" class="form-control">
                        <option value="">Tous les gestionnaires</option>
                        @foreach ($gestionnaires as $gestionnaire)
                            <option value="{{ $gestionnaire->id }}"
                                {{ request('gestionnaire_id') == $gestionnaire->id ? 'selected' : '' }}>
                                {{ $gestionnaire->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-sm md:w-1/6">
                    <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                </div>
                <div class="w-sm md:w-1/6">
                    <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                </div>
                <div class="w-sm md:w-1/6">
                    <select name="validee" class="form-control">
                        <option value="">Toutes</option>
                        <option value="1" {{ request('validee') == '1' ? 'selected' : '' }}>Clôturer</option>
                        <option value="0" {{ request('validee') == '0' ? 'selected' : '' }}>Non Clôturer</option>
                    </select>
                </div>
                <div class="w-sm md:w-1/6">
                    <button type="submit" class="btn btn-primary w-full">Filtrer</button>
                </div>
            </div>
        </form>

    </div>
    <div class="bg-white w-full shadow-md rounded px-8 pt-6 pb-8 mb-4 table-container">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="periodesPaieTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Client</th>
                        <th scope="col" class="px-6 py-3">Réception variables</th>
                        <th scope="col" class="px-6 py-3">Préparation BP</th>
                        <th scope="col" class="px-6 py-3">Validation BP client</th>
                        <th scope="col" class="px-6 py-3">Préparation et envoie DSN</th>
                        <th scope="col" class="px-6 py-3">Accusés DSN</th>
                        {{-- <th scope="col" class="px-6 py-3">TELEDEC URSSAF</th> --}}
                        <th scope="col" class="px-6 py-3">NOTES</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fichesClients as $fiche)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $fiche->client->name }}</td>
                            <td class="px-6 py-4">{{ $fiche->reception_variables ? \Carbon\Carbon::parse($fiche->reception_variables)->format('d/m') : 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $fiche->preparation_bp ? \Carbon\Carbon::parse($fiche->preparation_bp)->format('d/m') : 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $fiche->validation_bp_client ? \Carbon\Carbon::parse($fiche->validation_bp_client)->format('d/m') : 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $fiche->preparation_envoie_dsn ? \Carbon\Carbon::parse($fiche->preparation_envoie_dsn)->format('d/m') : 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $fiche->accuses_dsn ? \Carbon\Carbon::parse($fiche->accuses_dsn)->format('d/m') : 'N/A' }}</td>
                            {{-- <td class="px-6 py-4">{{ $fiche->teledec_urssaf ? \Carbon\Carbon::parse($fiche->teledec_urssaf)->format('d/m') : 'N/A' }}</td> --}}
                            <td class="px-6 py-4">{{ $fiche->notes ?? 'N/A' }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('fiches-clients.edit', ['fiches_client' => $fiche->id]) }}" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                                {{-- <form action="{{ route('fiches-clients.destroy', $fiche->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $fichesClients->links() }}
            </div>
        </div>
    </div>

    <div id="calendar"></div> <!-- Ajout du calendrier ici -->


    <hr>
    <tbody>
        @foreach ($periodesPaie as $periode)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-700">
                    <span
                        class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $periode->client->name ?? 'N/A' }}</span>
                </td>
                <td class="px-4 py-3 text-gray-700">
                    <span
                        class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $periode->client->gestionnairePrincipal->name ?? 'N/A' }}</span>
                </td>
                <td class="px-4 py-3 text-gray-700">
                    <span
                        class="bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $periode->client->nb_bulletins ?? 'N/A' }}</span>
                </td>
                <td class="px-4 py-3 modifiable text-gray-700">
                    <span
                        class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $periode->client->maj_fiche_para ?? 'N/A' }}</span>
                </td>

                <!-- Champs modifiables avec input de type date -->
                <td class="px-4 py-3 modifiable">
                    <input type="date" name="reception_variables"
                        class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        data-field="reception_variables" value="{{ $periode->reception_variables ?? '' }}"
                        {{ $periode->reception_variables ? 'disabled' : '' }}>
                </td>
                <td class="px-4 py-3 modifiable">
                    <input type="date" name="preparation_bp"
                        class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        data-field="preparation_bp" value="{{ $periode->preparation_bp ?? '' }}"
                        {{ $periode->preparation_bp ? 'disabled' : '' }}>
                </td>
                <td class="px-4 py-3 modifiable">
                    <input type="date" name="validation_bp_client"
                        class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        data-field="validation_bp_client" value="{{ $periode->validation_bp_client ?? '' }}"
                        {{ $periode->validation_bp_client ? 'disabled' : '' }}>
                </td>
                <td class="px-4 py-3 modifiable">
                    <input type="date" name="preparation_envoie_dsn"
                        class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        data-field="preparation_envoie_dsn" value="{{ $periode->preparation_envoie_dsn ?? '' }}"
                        {{ $periode->preparation_envoie_dsn ? 'disabled' : '' }}>
                </td>
                <td class="px-4 py-3 modifiable">
                    <input type="date" name="accuses_dsn"
                        class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        data-field="accuses_dsn" value="{{ $periode->accuses_dsn ?? '' }}"
                        {{ $periode->accuses_dsn ? 'disabled' : '' }}>
                </td>

                <!-- Champ de texte pour les notes -->
                <td class="px-4 py-3 modifiable">
                    <textarea name="notes"
                        class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        data-field="notes">{{ $periode->notes ?? '' }}</textarea>
                </td>

                <!-- Barre de progression -->
                <td class="px-4 py-3 ">
                    <div class="relative w-full bg-gray-200 rounded h-8 ">
                        <div class="bg-blue-600 h-8 rounded" style="width: {{ $periode->progressPercentage() }}%;"></div>
                        <span
                            class="absolute inset-0 flex items-center justify-center text-white font-semibold text-sm">{{ $periode->progressPercentage() }}%</span>
                    </div>
                </td>
                <hr>
                <!-- Bouton d'enregistrement -->
                <td class="px-4 py-3">
                    <button
                        class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-2.5 save-field"
                        data-traitement-id="{{ $periode->id }}">Enregistrer</button>
                </td>
            </tr>
        @endforeach
    </tbody>

   

<script>
    function openEditPopup(ficheClientId) {
        // Remplir le formulaire avec les données de la fiche client
        fetch(`/fiches-clients/${ficheClientId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `{{ url('fiches-clients') }}/${ficheClientId}`;
                document.getElementById('fiche_client_id').value = ficheClientId;
                document.getElementById('reception_variables').value = data.reception_variables;
                document.getElementById('preparation_bp').value = data.preparation_bp;
                document.getElementById('validation_bp_client').value = data.validation_bp_client;
                document.getElementById('preparation_envoie_dsn').value = data.preparation_envoie_dsn;
                document.getElementById('accuses_dsn').value = data.accuses_dsn;
                document.getElementById('notes').value = data.notes;

                // Afficher le popup
                document.getElementById('editPopup').style.display = 'block';
            });
    }

    function closeEditPopup() {
        document.getElementById('editPopup').style.display = 'none';
    }

    function openCreatePopup(clientId) {
        document.getElementById('createForm').action = `{{ url('fiches-clients') }}`;
        document.getElementById('client_id').value = clientId;

        // Afficher le popup
        document.getElementById('createPopup').style.display = 'block';
    }

    function closeCreatePopup() {
        document.getElementById('createPopup').style.display = 'none';
    }

    $(document).ready(function() {
        const saveButtons = document.querySelectorAll('.save-field');

        saveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const traitementId = this.getAttribute('data-traitement-id');
                const row = this.closest('tr');
                const fields = row.querySelectorAll('input, textarea');

                fields.forEach(field => {
                    const fieldName = field.getAttribute('data-field');
                    const fieldValue = field.value;

                    fetch('{{ route('periodes-paie.updateField') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                traitement_id: traitementId,
                                field: fieldName,
                                value: fieldName === 'notes' ? fieldValue : null,
                                date_value: fieldName !== 'notes' ? fieldValue : null
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Champ mis à jour avec succès');
                                if (fieldName === 'reception_variables') {
                                    row.querySelector('input[name="preparation_bp"]').disabled = false;
                                } else if (fieldName === 'preparation_bp') {
                                    row.querySelector('input[name="validation_bp_client"]').disabled = false;
                                } else if (fieldName === 'validation_bp_client') {
                                    row.querySelector('input[name="preparation_envoie_dsn"]').disabled = false;
                                } else if (fieldName === 'preparation_envoie_dsn') {
                                    row.querySelector('input[name="accuses_dsn"]').disabled = false;
                                }
                            } else {
                                alert('Erreur lors de la mise à jour du champ');
                            }
                        });
                });
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#periodesPaieTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "language": {
                "lengthMenu": "Afficher _MENU_ enregistrements par page",
                "zeroRecords": "Aucun enregistrement trouvé",
                "info": "Affichage de la page _PAGE_ sur _PAGES_",
                "infoEmpty": "Aucun enregistrement disponible",
                "infoFiltered": "(filtré à partir de _MAX_ enregistrements au total)",
                "search": "Rechercher:",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            }
        });
    });
</script>
@endsection

@push('scripts')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
                    @foreach ($fichesClients as $fiche)
                        {
                            title: '{{ $fiche->client->name }} - Réception variables',
                            start: '{{ $fiche->reception_variables }}',
                            color: '#ff9f89'
                        },
                        {
                            title: '{{ $fiche->client->name }} - Préparation BP',
                            start: '{{ $fiche->preparation_bp }}',
                            color: '#f39c12'
                        },
                        {
                            title: '{{ $fiche->client->name }} - Validation BP client',
                            start: '{{ $fiche->validation_bp_client }}',
                            color: '#00c0ef'
                        },
                        {
                            title: '{{ $fiche->client->name }} - Préparation et envoie DSN',
                            start: '{{ $fiche->preparation_envoie_dsn }}',
                            color: '#3c8dbc'
                        },
                        {
                            title: '{{ $fiche->client->name }} - Accusés DSN',
                            start: '{{ $fiche->accuses_dsn }}',
                            color: '#00a65a'
                        },
                    @endforeach
                ]
            });
        });
    </script>
@endpush


{{-- $client = Client::find(4); 

$periodePaie = new PeriodePaie();
$periodePaie->reference = 'PERIODE_DECEMBER_2024';
$periodePaie->debut = '2024-12-01';
$periodePaie->fin = '2024-12-31';
$periodePaie->validee = 0;
$periodePaie->client_id = $client->id;
$periodePaie->reception_variables = '2024-12-05';
$periodePaie->preparation_bp = '2024-12-10';
$periodePaie->validation_bp_client = '2024-12-15';
$periodePaie->preparation_envoie_dsn = '2024-12-20';
$periodePaie->accuses_dsn = '2024-12-25';
$periodePaie->notes = 'Notes pour la période de décembre 2024';
$periodePaie->save(); --}}

@extends('layouts.admin')

@push('styles')
<style>
    .modifiable {
        background-color: #ea00ffc7; /* Couleur de fond pour les champs modifiables */
    }
    .non-modifiable {
        background-color: #d285da; /* Couleur de fond pour les champs non modifiables */
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
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 40%; /* Réduire la largeur du popup */
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
        overflow-x: auto; /* Ajout de l'overflow pour le tableau */
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Périodes de Paie</h1>

    <form action="{{ route('periodes-paie.index') }}" method="GET" class="mb-4">
        <div class="flex flex-wrap gap-4">
            <div class="w-sm md:w-1/6">
                <select name="client_id" class="form-control">
                    <option value="">Tous les clients</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-sm md:w-1/6">
                <select name="gestionnaire_id" class="form-control">
                    <option value="">Tous les gestionnaires</option>
                    @foreach($gestionnaires as $gestionnaire)
                        <option value="{{ $gestionnaire->id }}" {{ request('gestionnaire_id') == $gestionnaire->id ? 'selected' : '' }}>{{ $gestionnaire->name }}</option>
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
    <table id="periodesPaieTable" class="table-auto w-full">
        <thead>
            <tr>
                <th>Client</th>
                <th>Gestionnaire</th>
                <th>NB Bulletins</th>
                <th>Maj fiche para</th>
                <th class="modifiable">Réception variables</th>
                <th class="modifiable">Préparation BP</th>
                <th class="modifiable">Validation BP client</th>
                <th class="modifiable">Préparation et envoie DSN</th>
                <th class="modifiable">Accusés DSN</th>
                <th class="modifiable">NOTES</th>
                <th>Progression</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodesPaie as $periode)
                <tr>
                    <td>{{ $periode->client->name ?? 'N/A' }}</td>
                    <td>{{ $periode->client->gestionnairePrincipal->name ?? 'N/A' }}</td>
                    <td>{{ $periode->client->nb_bulletins ?? 'N/A' }}</td>
                    <td class="modifiable">{{ $periode->client->maj_fiche_para ?? 'N/A' }}</td>
                    <td class="modifiable">{{ $periode->reception_variables ?? 'N/A' }}</td>
                    <td class="modifiable">{{ $periode->preparation_bp ?? 'N/A' }}</td>
                    <td class="modifiable">{{ $periode->validation_bp_client ?? 'N/A' }}</td>
                    <td class="modifiable">{{ $periode->preparation_envoie_dsn ?? 'N/A' }}</td>
                    <td class="modifiable">{{ $periode->accuses_dsn ?? 'N/A' }}</td>
                    <td class="modifiable">{{ $periode->notes ?? 'N/A' }}</td>
                    <td>
                        <div class="progress  transition-all ease-in duration-75 dark:bg-pink-900 rounded-md group-hover:bg-opacity-0">
                            <div class="progress-bar" role="progressbar" style="width: {{ $periode->progressPercentage() }}%;" aria-valuenow="{{ $periode->progressPercentage() }}" aria-valuemin="0" aria-valuemax="100">{{ $periode->progressPercentage() }}%</div>
                        </div>
                    </td>
                    <td>
                        
                        <button class="btn btn-primary" onclick="openEditPopup({{ $periode->id }})">Modifier</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $periodesPaie->links() }}
</div>

<div id="calendar"></div> <!-- Ajout du calendrier ici -->

<hr>
<tbody>
    @foreach($periodesPaie as $periode)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3 text-gray-700">
                <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $periode->client->name ?? 'N/A' }}</span>
            </td>
            <td class="px-4 py-3 text-gray-700">
                <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $periode->client->gestionnairePrincipal->name ?? 'N/A' }}</span>
            </td>
            <td class="px-4 py-3 text-gray-700">
                <span class="bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $periode->client->nb_bulletins ?? 'N/A' }}</span>
            </td>
            <td class="px-4 py-3 modifiable text-gray-700">
                <span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $periode->client->maj_fiche_para ?? 'N/A' }}</span>
            </td>
            
            <!-- Champs modifiables avec input de type date -->
            <td class="px-4 py-3 modifiable">
                <input type="date" name="reception_variables" class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" data-field="reception_variables" value="{{ $periode->reception_variables ?? '' }}" {{ $periode->reception_variables ? 'disabled' : '' }}>
            </td>
            <td class="px-4 py-3 modifiable">
                <input type="date" name="preparation_bp" class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" data-field="preparation_bp" value="{{ $periode->preparation_bp ?? '' }}" {{ $periode->preparation_bp ? 'disabled' : '' }}>
            </td>
            <td class="px-4 py-3 modifiable">
                <input type="date" name="validation_bp_client" class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" data-field="validation_bp_client" value="{{ $periode->validation_bp_client ?? '' }}" {{ $periode->validation_bp_client ? 'disabled' : '' }}>
            </td>
            <td class="px-4 py-3 modifiable">
                <input type="date" name="preparation_envoie_dsn" class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" data-field="preparation_envoie_dsn" value="{{ $periode->preparation_envoie_dsn ?? '' }}" {{ $periode->preparation_envoie_dsn ? 'disabled' : '' }}>
            </td>
            <td class="px-4 py-3 modifiable">
                <input type="date" name="accuses_dsn" class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" data-field="accuses_dsn" value="{{ $periode->accuses_dsn ?? '' }}" {{ $periode->accuses_dsn ? 'disabled' : '' }}>
            </td>
            
            <!-- Champ de texte pour les notes -->
            <td class="px-4 py-3 modifiable">
                <textarea name="notes" class="w-26 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" data-field="notes">{{ $periode->notes ?? '' }}</textarea>
            </td>

            <!-- Barre de progression -->
            <td class="px-4 py-3 ">
                <div class="relative w-full bg-gray-200 rounded h-8 ">
                    <div class="bg-blue-600 h-8 rounded" style="width: {{ $periode->progressPercentage() }}%;"></div>
                    <span class="absolute inset-0 flex items-center justify-center text-white font-semibold text-sm">{{ $periode->progressPercentage() }}%</span>
                </div>
            </td>
<hr>
            <!-- Bouton d'enregistrement -->
            <td class="px-4 py-3">
                <button class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-2.5 save-field" data-traitement-id="{{ $periode->id }}">Enregistrer</button>
            </td>
        </tr>
    @endforeach
</tbody>

<hr>
<!-- Popup d'édition -->
<div id="editPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditPopup()">&times;</span>
        <form id="editForm" action="{{ route('periodes-paie.updateField') }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="periode_id" id="periode_id">
            <div class="form-group">
                <label for="field">Champ</label>
                <select name="field" id="field" class="form-control">
                    <option value="reception_variables">Réception variables</option>
                    <option value="preparation_bp">Préparation BP</option>
                    <option value="validation_bp_client">Validation BP client</option>
                    <option value="preparation_envoie_dsn">Préparation et envoie DSN</option>
                    <option value="accuses_dsn">Accusés DSN</option>
                    <option value="notes">NOTES</option>
                </select>
            </div>
            <div class="form-group">
                <label for="value">Valeur</label>
                <input type="text" name="value" id="value" class="form-control">
            </div>
            <div class="form-group" id="dateField" style="display: none;">
                <label for="date_value">Date</label>
                <input type="date" name="date_value" id="date_value" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const saveButtons = document.querySelectorAll('.save-field');

        saveButtons.forEach(button => {
            button.addEventListener('click', function () {
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

    function openEditPopup(periodeId) {
        document.getElementById('periode_id').value = periodeId;
        document.getElementById('editPopup').style.display = 'block';
    }

    function closeEditPopup() {
        document.getElementById('editPopup').style.display = 'none';
    }
</script>

<script>
    function openEditPopup(periodeId) {
        document.getElementById('periode_id').value = periodeId;
        document.getElementById('editPopup').style.display = 'block';
    }

    function closeEditPopup() {
        document.getElementById('editPopup').style.display = 'none';
    }

    document.getElementById('field').addEventListener('change', function() {
        var selectedField = this.value;
        var dateField = document.getElementById('dateField');
        if (selectedField === 'reception_variables' || selectedField === 'preparation_bp' || selectedField === 'validation_bp_client' || selectedField === 'preparation_envoie_dsn' || selectedField === 'accuses_dsn') {
            dateField.style.display = 'block';
            document.getElementById('value').style.display = 'none';
        } else {
            dateField.style.display = 'none';
            document.getElementById('value').style.display = 'block';
        }
    });

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

{{-- 
<div class="container">

    <form action="{{ route('periodes-paie.index') }}" method="GET" class="mb-4">
        <div class="row flex">
            <div class="col-md-2">
                <select name="client_id" class="form-control">
                    <option value="">Tous les clients</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_debut" class="form-control" placeholder="Date de début"
                    value="{{ request('date_debut') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_fin" class="form-control" placeholder="Date de fin"
                    value="{{ request('date_fin') }}">
            </div>
            <div class="col-md-2">
                <select name="validee" class="form-control">
                    <option value="">Tous les statuts</option>
                    <option value="1" {{ request('validee') === '1' ? 'selected' : '' }}>Validée</option>
                    <option value="0" {{ request('validee') === '0' ? 'selected' : '' }}>Non validée
                    </option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit"
                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Filtrer</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Client</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($periodesPaie as $periode)
                <tr>
                    <td>{{ $periode->reference }}</td>
                    <td> <span
                            class="bg-pink-100 text-pink-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400">
                            {{ $periode->client->name }}</span></td>
                    <td> <span
                            class="bg-indigo-100 text-indigo-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-indigo-400 border border-indigo-400">
                            {{ $periode->debut->format('d/m') }}</span></td>
                    <td> <span
                            class="bg-green-100 text-green-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                            {{ $periode->fin->format('d/m') }}</span></td>
                    <td> <span
                            class="bg-red-100 text-red-800 text-xxl font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                            {{ $periode->validee ? 'Clôturer' : 'Non Clôturer' }}</span></td>
                    <td
                        class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium">
                        <a href="{{ route('periodes-paie.show', $periode) }}"
                            class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Voir</a>
                        <a href="{{ route('periodes-paie.edit', $periode) }}"
                            class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                      
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $periodesPaie->links() }}

</div> --}}
@extends('layouts.admin')

@section('title', 'Admin Traitements des paies')

@section('content')
    <div class="main-content">
        <div class="container mx-auto px-4 py-8"">
            <div class="row">
                <br>
                <br>
            </div>
            <div class="row">
                <div class="container mx-auto px-4 py-8"">
                    <form action="{{ route('traitements-paie.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="client_id" class="form-control">
                                    <option value="">Tous les clients</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="gestionnaire_id" class="form-control">
                                    <option value="">Tous les gestionnaires</option>
                                    @foreach($gestionnaires as $gestionnaire)
                                        <option value="{{ $gestionnaire->id }}" {{ request('gestionnaire_id') == $gestionnaire->id ? 'selected' : '' }}>
                                            {{ $gestionnaire->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="periode_paie_id" class="form-control">
                                    <option value="">Toutes les périodes</option>
                                    @foreach($periodesPaie as $periode)
                                        <option value="{{ $periode->id }}" {{ request('periode_paie_id') == $periode->id ? 'selected' : '' }}>
                                            {{ $periode->reference }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Filtrer</button>
                            </div>
                        </div>
                    </form>
                
                    <a href="{{ route('traitements-paie.create') }}" class="btn btn-success mb-3">Créer un nouveau traitement</a>
                
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Gestionnaire</th>
                                <th>Période</th>
                                <th>Nombre de bulletins</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($traitements as $traitement)
                            <tr>
                                <td>{{ $traitement->client->name }}</td>
                                <td>{{ $traitement->gestionnaire->name }}</td>
                                <td>{{ $traitement->periodePaie->reference }}</td>
                                <td>{{ $traitement->nbr_bull }}</td>
                                <td>
                                    <a href="{{ route('traitements-paie.show', $traitement) }}" class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Voir</a>
                                    <a href="{{ route('traitements-paie.edit', $traitement) }}" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                                    {{-- <form action="{{ route('traitements-paie.destroy', $traitement) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce traitement ?')">Supprimer</button>
                                    </form> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                    {{ $traitements->links() }}
                </div>
            </div>
        </div>

       
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // Fonction pour ouvrir le modal d'édition
            function openEditModal(traitementId) {
                $.get('/traitements-paie/' + traitementId + '/edit', function(data) {
                    $('#traitementModal .modal-body').html(data);
                    $('#traitementModal').modal('show');
                });
            }

            // Fonction pour ouvrir le modal de création
            function openCreateModal() {
                $.get('/traitements-paie/create', function(data) {
                    $('#traitementModal .modal-body').html(data);
                    $('#traitementModal').modal('show');
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("Erreur lors de l'ouverture du modal de création :", textStatus,
                        errorThrown);
                });

                // Événement pour le bouton de création
                $(document).on('click', '#createTraitement', function() {
                    openCreateModal();
                });
            }
            // Événement pour le bouton d'édition
            $('.edit-traitement').on('click', function() {
                var traitementId = $(this).data('id');
                openEditModal(traitementId);
            });

            // Événement pour le bouton de créat
            $('#createTraitement').on('click', function() {
                openCreateModal();
            });

            // Gestion de la soumission du formulaire
            $(document).on('submit', '#traitementForm', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#traitementModal').modal('hide');
                        location.reload(); // Recharger la page pour afficher les changements
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            // Fonction pour colorer les cellules de date
            function colorDateCells() {
                $('.date-cell').each(function() {
                    var date = new Date($(this).text());
                    var today = new Date();
                    var threeMonthsAgo = new Date();
                    threeMonthsAgo.setMonth(today.getMonth() - 3);

                    if (date < threeMonthsAgo) {
                        $(this).css('background-color', 'red');
                    } else if (date >= threeMonthsAgo && date <= today) {
                        $(this).css('background-color', 'orange');
                    } else {
                        $(this).css('background-color', 'green');
                    }
                });
            }

            // Appeler la fonction de coloration au chargement de la page
            colorDateCells();
        });
    </script>
@endpush

@extends('layouts.admin')

@section('title', 'Créer une relation Gestionnaire-Client')

@section('content')
    <div class="main-content">
        <div class="row">
            <br>
            <br>
        </div>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <div class="breadcrumb">
                <h1>Créer une nouvelle relation Gestionnaire-Client</h1>
            </div>


            <form action="{{ route('admin.gestionnaire-client.store') }}" method="POST" enctype="multipart/form-data"
                id="gestionnaireClientForm">
                @csrf

                <div class="form-group">
                    <label for="client_id">Client</label>
                    <select name="client_id" id="client_id" class="form-control" required>
                        <option value="">Sélectionnez un client</option>
                        @foreach ($clients as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="client-info" style="display: none;">
                    <h3>Informations du client</h3>
                    <p><strong>Nom:</strong> <span id="client-name"></span></p>
                    <p><strong>Email:</strong> <span id="client-email"></span></p>
                    <p><strong>Téléphone:</strong> <span id="client-phone"></span></p>
                </div>

                <div class="form-group">
                    <label for="gestionnaire_principal_id">Gestionnaire Principal</label>
                    <select name="gestionnaire_principal_id" id="gestionnaire_principal_id" class="form-control" required>
                        <option value="">Sélectionnez un gestionnaire principal</option>
                        @foreach ($gestionnaires as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="gestionnaires_secondaires">Gestionnaires Supplémentaires</label>
                    <div id="gestionnaires-list" class="mb-2"></div>
                    <select id="gestionnaire-select" class="form-control">
                        <option value="">Sélectionnez un gestionnaire</option>
                        @foreach ($gestionnaires as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="add-gestionnaire"
                        class="mt-1 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Ajouter
                        Gestionnaire</button>
                </div>

                <div class="form-group">
                    <label for="superviseur_id">Superviseur</label>
                    <select name="superviseur_id" id="superviseur_id" class="form-control" required>
                        <option value="">Sélectionnez un superviseur</option>
                        @foreach ($superviseurs as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="document">Document</label>
                    <input type="file" name="document" id="document" class="form-control-file">
                </div>

                <button type="submit"
                    class="mt-1 text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Créer
                    la relation</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialiser Select2 pour une meilleure expérience utilisateur
            $('#client_id, #gestionnaire_principal_id, #gestionnaire-select, #superviseur_id').select2();

            // Gérer l'affichage des informations du client
            $('#client_id').change(function() {
                var clientId = $(this).val();
                if (clientId) {
                    $.ajax({
                        url: '/admin/client/' + clientId + '/info',
                        type: 'GET',
                        success: function(data) {
                            $('#client-name').text(data.name);
                            $('#client-email').text(data.email);
                            $('#client-phone').text(data.phone);
                            $('#client-info').show();
                        },
                        error: function(xhr, status, error) {
                            console.error("Erreur AJAX:", status, error);
                            alert('Erreur lors de la récupération des informations du client: ' +
                                error);
                            $('#client-info').hide();
                        }
                    });
                } else {
                    $('#client-info').hide();
                }
            });

            // Gérer l'ajout de gestionnaires supplémentaires
            $('#add-gestionnaire').click(function() {
                var selectElement = $('#gestionnaire-select');
                var selectedId = selectElement.val();
                var selectedName = selectElement.find('option:selected').text();

                if (selectedId) {
                    var existingGestionnaire = $('#gestionnaires-list').find(`[data-id="${selectedId}"]`);
                    if (existingGestionnaire.length === 0) {
                        $('#gestionnaires-list').append(`
                <div class="gestionnaire-item" data-id="${selectedId}">
                    <input type="hidden" name="gestionnaires_secondaires[]" value="${selectedId}">
                    <span>${selectedName}</span>
                    <button type="button" class="btn btn-sm btn-danger remove-gestionnaire ml-2">Supprimer</button>
                </div>
            `);
                        selectElement.val(null).trigger('change');
                    } else {
                        alert('Ce gestionnaire est déjà ajouté.');
                    }
                }
            });



            // Gérer la suppression de gestionnaires supplémentaires
            $(document).on('click', '.remove-gestionnaire', function() {
                $(this).closest('.gestionnaire-item').remove();
            });

            // Validation du formulaire
            $('#gestionnaireClientForm').submit(function(e) {
                var gestionnairesPrincipaux = $('#gestionnaire_principal_id').val();
                var gestionnairesSecondaires = $('input[name="gestionnaires_secondaires[]"]').map(
                    function() {
                        return $(this).val();
                    }).get();

                if (gestionnairesPrincipaux && gestionnairesSecondaires.includes(gestionnairesPrincipaux)) {
                    e.preventDefault();
                    alert('Le gestionnaire principal ne peut pas être aussi un gestionnaire secondaire.');
                }
            });
        });
    </script>
@endpush

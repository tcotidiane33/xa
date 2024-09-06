@extends('layouts.admin')

@section('title',
    isset($gestionnaireClient)
    ? 'Modifier la relation Gestionnaire-Client'
    : 'Créer une relation
    Gestionnaire-Client')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @push('styles')
        <style>
            select[multiple] {
                min-height: 100px;
            }
        </style>
    @endpush
@section('content')
    <div class="main-content">
        <div class="container">
            <br><br><br>
        </div>
        <div class="cbp-spmenu-push">
            <div class="main-content">
                <div class="panel-body widget-shadow">
                    <div class="row card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ isset($gestionnaireClient) ? 'Modifier la relation Gestionnaire-Client' : 'Créer une nouvelle relation Gestionnaire-Client' }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.gestionnaire-client.update', $gestionnaireClient->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="client_id">
                                        Client
                                    </label>
                                    <select name="client_id" id="client_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        @foreach($clients as $id => $name)
                                            <option value="{{ $id }}" {{ $gestionnaireClient->client_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="gestionnaire_principal_id">
                                        Gestionnaire Principal
                                    </label>
                                    <select name="gestionnaire_principal_id" id="gestionnaire_principal_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        @foreach($gestionnaires as $id => $name)
                                            <option value="{{ $id }}" {{ $gestionnaireClient->gestionnaire_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="gestionnaires_secondaires">
                                        Gestionnaires Secondaires
                                    </label>
                                    <select name="gestionnaires_secondaires[]" id="gestionnaires_secondaires" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        @foreach($gestionnaires as $id => $name)
                                            <option value="{{ $id }}" {{ in_array($id, $gestionnaireClient->gestionnaires_secondaires ?? []) ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
                                        Notes
                                    </label>
                                    <textarea name="notes" id="notes" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $gestionnaireClient->notes }}</textarea>
                                </div>
                        
                                <div class="flex items-center justify-between">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                        Mettre à jour la relation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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

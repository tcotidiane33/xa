@extends('layouts.admin')

@section('title', isset($gestionnaireClient) ? 'Modifier la relation Gestionnaire-Client' : 'Créer une relation
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
                            <form
                                action="{{ isset($gestionnaireClient) ? route('admin.gestionnaire-client.update', $gestionnaireClient->id) : route('admin.gestionnaire-client.store') }}"
                                method="POST">
                                @csrf
                                @if (isset($gestionnaireClient))
                                    @method('PUT')
                                @endif

                                <div class="form-group">
                                    <label for="client_id">Client</label>
                                    <select name="client_id" id="client_id" class="form-control" required>
                                        @foreach ($clients as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ isset($gestionnaireClient) && $gestionnaireClient->client_id == $id ? 'selected' : '' }}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gestionnaire_id">Gestionnaire Principal</label>
                                    <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                                        @foreach ($gestionnaires as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ isset($gestionnaireClient) && $gestionnaireClient->gestionnaire_id == $id ? 'selected' : '' }}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="is_principal">
                                        <input type="checkbox" name="is_principal" id="is_principal" value="1"
                                            {{ isset($gestionnaireClient) && $gestionnaireClient->is_principal ? 'checked' : '' }}>
                                        Est Principal ?
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="gestionnaires_secondaires">Gestionnaires Secondaires</label>
                                    <select name="gestionnaires_secondaires[]" id="gestionnaires_secondaires" class="form-control" multiple>
                                        @foreach($gestionnaires as $id => $name)
                                            <option value="{{ $id }}" {{ in_array($id, old('gestionnaires_secondaires', [])) ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="user_id">Responsable Paie</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        @foreach ($responsables as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ isset($gestionnaireClient) && $gestionnaireClient->user_id == $id ? 'selected' : '' }}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ isset($gestionnaireClient) ? $gestionnaireClient->notes : '' }}</textarea>
                                </div>

                                <button type="submit"
                                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">{{ isset($gestionnaireClient) ? 'Mettre à jour' : 'Créer' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                placeholder: "Sélectionnez les gestionnaires secondaires",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush

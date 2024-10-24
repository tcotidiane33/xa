@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="container mx-auto px-4 py-8">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Créer une relation Gestionnaire-Client</h1>
                    <form action="{{ route('admin.gestionnaire-client.store') }}" method="POST" id="create-relation-form">
                        @csrf
                        <!-- Section Client -->
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="">Sélectionnez un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section Gestionnaire Principal -->
                        <div class="form-group">
                            <label for="gestionnaire_id">Gestionnaire Principal</label>
                            <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                                <option value="">Sélectionnez un gestionnaire principal</option>
                                @foreach($gestionnaires as $gestionnaire)
                                    <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section Gestionnaires Secondaires -->
                        <div class="form-group">
                            <label for="gestionnaires_secondaires">Gestionnaires Secondaires</label>
                            <select name="gestionnaires_secondaires[]" id="gestionnaires_secondaires" class="form-control" multiple>
                                @foreach($gestionnaires as $gestionnaire)
                                    <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('create-relation-form').addEventListener('submit', function(event) {
    const clientSelect = document.getElementById('client_id');
    const gestionnaireSelect = document.getElementById('gestionnaire_id');

    if (!clientSelect.value) {
        alert('Veuillez sélectionner un client.');
        event.preventDefault();
    }

    if (!gestionnaireSelect.value) {
        alert('Veuillez sélectionner un gestionnaire principal.');
        event.preventDefault();
    }
});
</script>
@endpush
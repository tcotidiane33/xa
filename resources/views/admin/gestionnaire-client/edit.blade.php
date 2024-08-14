@extends('admin::index')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Modifier la relation Gestionnaire-Client</h3>
        </div>
        <div class="card-body">
            <form action="{{ admin_url('gestionnaire-client/'.$gestionnaireClient->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="client_id">Client</label>
                    <select name="client_id" id="client_id" class="form-control">
                        @foreach($clients as $id => $name)
                            <option value="{{ $id }}" {{ $gestionnaireClient->client_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="gestionnaire_id">Gestionnaire Principal</label>
                    <select name="gestionnaire_id" id="gestionnaire_id" class="form-control">
                        @foreach($gestionnaires as $id => $name)
                            <option value="{{ $id }}" {{ $gestionnaireClient->gestionnaire_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="is_principal">
                        <input type="checkbox" name="is_principal" id="is_principal" value="1" {{ $gestionnaireClient->is_principal ? 'checked' : '' }}>
                        Est Principal ?
                    </label>
                </div>
                <div class="form-group">
                    <label for="gestionnaires_secondaires">Gestionnaires Secondaires</label>
                    <select name="gestionnaires_secondaires[]" id="gestionnaires_secondaires" class="form-control" multiple>
                        @foreach($gestionnaires as $id => $name)
                            <option value="{{ $id }}" {{ in_array($id, json_decode($gestionnaireClient->gestionnaires_secondaires) ?? []) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_id">Responsable Paie</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach($responsables as $id => $name)
                            <option value="{{ $id }}" {{ isset($gestionnaireClient) && $gestionnaireClient->user_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ $gestionnaireClient->notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>
@endsection
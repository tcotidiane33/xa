@extends('admin::index')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Créer une nouvelle relation Gestionnaire-Client</h3>
        </div>
        <div class="card-body">
            <form action="{{ admin_url('gestionnaire-client') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="client_id">Client</label>
                    <select name="client_id" id="client_id" class="form-control">
                        @foreach($clients as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="gestionnaire_id">Gestionnaire Principal</label>
                    <select name="gestionnaire_id" id="gestionnaire_id" class="form-control">
                        @foreach($gestionnaires as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="is_principal">
                        <input type="checkbox" name="is_principal" id="is_principal" value="1">
                        Est Principal ?
                    </label>
                </div>
                <div class="form-group">
                    <label for="gestionnaires_secondaires">Gestionnaires Secondaires</label>
                    <select name="gestionnaires_secondaires[]" id="gestionnaires_secondaires" class="form-control" multiple>
                        @foreach($gestionnaires as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
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
                    <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Créer</button>
            </form>
        </div>
    </div>
@endsection
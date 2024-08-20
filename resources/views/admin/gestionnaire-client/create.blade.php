@extends('layouts.admin')

@section('title', 'Créer des relations Gestionnaire-Client')

@section('content')
    <div class="main-content">
        <div class="container">
            </br></br></br>
        </div>
        <div class="cbp-spmenu-push">
            <div class="main-content">
                <div class="panel-body widget-shadow">
                    <div class="row card">
                        <div class="card-header">
                            <h3 class="card-title">Créer une nouvelle relation Gestionnaire-Client</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.gestionnaire-client.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="client_id">Client</label>
                                    <select name="client_id" id="client_id" class="form-control" required>
                                        @foreach($clients as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="gestionnaire_id">Gestionnaire Principal</label>
                                    <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                                        @foreach($gestionnaires as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="is_principal">Est Principal ?</label>
                                    <input type="checkbox" name="is_principal" id="is_principal" value="1">
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
                                    <label for="responsable_paie_id">Responsable Paie</label>
                                    <select name="responsable_paie_id" id="responsable_paie_id" class="form-control" required>
                                        @foreach($responsables as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Créer</button>
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
        $('#gestionnaires_secondaires').select2({
            placeholder: "Sélectionnez les gestionnaires secondaires",
            allowClear: true
        });
    });
</script>
@endpush
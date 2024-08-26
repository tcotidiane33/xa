@extends('layouts.admin')

@section('title', 'Créer des relations Gestionnaire-Client')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
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
                            <form action="{{ route('admin.gestionnaire-client.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="client_id">Client</label>
                                    <select name="client_id" id="client_id" class="form-control" required>
                                        @foreach ($clients as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="gestionnaire_id">Gestionnaire Principal</label>
                                    <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                                        @foreach ($gestionnaires as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="is_principal">Est Principal</label>
                                    <input type="checkbox" name="is_principal" id="is_principal" value="1">
                                </div>
                                <div class="form-group">
                                    <label for="gestionnaires_secondaires">Gestionnaires Secondaires</label>
                                    <select name="gestionnaires_secondaires[]" id="gestionnaires_secondaires" class="form-control select2-multiple" multiple="multiple">
                                        @foreach($gestionnaires as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="responsable_paie_id">Responsable Paie</label>
                                    <select name="responsable_paie_id" id="responsable_paie_id" class="form-control"
                                        required>
                                        @foreach ($responsables as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="document">Document</label>
                                    <input type="file" name="document" id="document" class="form-control-file">
                                </div>
                                <button type="submit"
                                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Créer la relation</button>
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

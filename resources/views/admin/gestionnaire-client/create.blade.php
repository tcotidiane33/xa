@extends('layouts.admin')

@section('title', 'Créer une relation Gestionnaire-Client')

@section('content')
    <div class="main-content">
        <div class="container">
            </br></br></br>
        </div>

        <div class="cbp-spmenu-push">
            <div class="main-content">
                <div class="breadcrumb">
                    <h1>Créer une nouvelle relation Gestionnaire-Client</h1>
                </div>

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

                <form action="{{ route('admin.gestionnaire-client.store') }}" method="POST" enctype="multipart/form-data">
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
                        <select name="gestionnaire_principal_id" id="gestionnaire_principal_id" class="form-control"
                            required>
                            <option value="">Sélectionnez un gestionnaire principal</option>
                            @foreach ($gestionnaires as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gestionnaires_secondaires">Gestionnaires Supplémentaires</label>
                        <select name="gestionnaires_secondaires[]" id="gestionnaires_secondaires"
                            class="form-control select2-multiple" multiple>
                            @foreach ($gestionnaires as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
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

                    <button type="submit" class="btn btn-primary">Créer la relation</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                placeholder: "Sélectionnez les gestionnaires supplémentaires",
                allowClear: true,
                width: '100%'
            });

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
        });
    </script>
@endpush

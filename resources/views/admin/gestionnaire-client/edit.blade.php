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
                <div class="container">
                    <div class="breadcrumb">
                        <h1>Modifier la relation Gestionnaire-Client</h1>

                    </div>
                    <form action="{{ route('admin.gestionnaire-client.update', $gestionnaireClient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select name="client_id" id="client_id" class="form-control" required>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $gestionnaireClient->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gestionnaire_id">Gestionnaire</label>
                            <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                                @foreach ($gestionnaires as $gestionnaire)
                                    <option value="{{ $gestionnaire->id }}"
                                        {{ $gestionnaireClient->gestionnaire_id == $gestionnaire->id ? 'selected' : '' }}>
                                        {{ $gestionnaire->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_principal" name="is_principal"
                                value="1" {{ $gestionnaireClient->is_principal ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_principal">Gestionnaire Principal</label>
                        </div>
                        <button type="submit"
                            class="mt-1 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Mettre
                            à jour la relation</button>
                    </form>

                    <hr>
                    {{-- Transfert et affectations --}}
                </div>
                <div class="breadcrumb">

                    <h2>Transfert </h2>
                </div>
                <form action="{{ route('admin.gestionnaire-client.mass-transfer') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="client_ids">Sélectionner les clients</label>
                        <select name="client_ids[]" id="client_ids" class="form-control" multiple required>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="old_gestionnaire_id">Ancien gestionnaire</label>
                        <select name="old_gestionnaire_id" id="old_gestionnaire_id" class="form-control" required>
                            @foreach ($gestionnaires as $gestionnaire)
                                <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_gestionnaire_id">Nouveau gestionnaire</label>
                        <select name="new_gestionnaire_id" id="new_gestionnaire_id" class="form-control" required>
                            @foreach ($gestionnaires as $gestionnaire)
                                <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="mt-1 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Transférer
                        en masse</button>
                </form>
                <div class="breadcrumb">

                    <h2>Affectation </h2>
                </div>
                <form action="{{ route('admin.gestionnaire-client.mass-assign') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="client_ids">Sélectionner les clients</label>
                        <select name="client_ids[]" id="client_ids" class="form-control" multiple required>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gestionnaire_id">Gestionnaire</label>
                        <select name="gestionnaire_id" id="gestionnaire_id" class="form-control" required>
                            @foreach ($gestionnaires as $gestionnaire)
                                <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_principal" name="is_principal"
                            value="1">
                        <label class="form-check-label" for="is_principal">Gestionnaire Principal</label>
                    </div>
                    <button type="submit"
                        class="mt-1 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Affecter
                        en masse</button>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Configurer Client: {{ $client->name }}</h1>



    <div class="mb-4">
        <h2>Responsable de Paie</h2>
        <form action="{{ route('admin.updateResponsablePaie', $client->id) }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <select class="form-select" name="responsable_paie">
                    @foreach ($gestionnaires as $gestionnaire)
                    <option value="{{ $gestionnaire->id }}" {{ $client->respo_paie == $gestionnaire->id ? 'selected' : '' }}>
                        {{ $gestionnaire->name }}
                    </option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Modifier</button>
            </div>
        </form>
    </div>

    <div class="mb-4">
        <h2>Gestionnaire de Paie Principal</h2>
        <form action="{{ route('admin.updateGestionnairePrincipal', $client->id) }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <select class="form-select" name="gestionnaire_principal">
                    @foreach ($gestionnaires as $gestionnaire)
                    <option value="{{ $gestionnaire->id }}" {{ $client->ges_paie_prin == $gestionnaire->id ? 'selected' : '' }}>
                        {{ $gestionnaire->name }}
                    </option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Modifier</button>
            </div>
        </form>
    </div>

    <div class="mb-4">
        <h2>Accès Supplémentaire Gestionnaire</h2>
        <form action="{{ route('admin.addGestionnaireSupp', $client->id) }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <select class="form-select" name="gestionnaire_supp">
                    @foreach ($gestionnaires as $gestionnaire)
                    <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Ajouter</button>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Gestionnaire</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($client->additionalGestionnaires as $gestionnaire) --}}
                <tr>
                    <td>{{ $gestionnaire->name }}</td>
                    <td>
                        <form action="{{ route('admin.removeGestionnaireSupp', ['id' => $client->id, 'gestionnaireId' => $gestionnaire->id]) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
@endsection

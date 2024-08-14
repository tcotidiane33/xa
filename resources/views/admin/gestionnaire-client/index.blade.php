@php
    $body_classes = $body_classes ?? '';
@endphp

@extends('admin::index')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des relations Gestionnaire-Client</h3>
    </div>
    <div class="card-body">
        <a href="{{ admin_url('gestionnaire-client/create') }}" class="btn btn-success mb-3">Ajouter une nouvelle relation</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Gestionnaire Principal</th>
                    <th>Est Principal</th>
                    <th>Gestionnaires Secondaires</th>
                    <th>Responsable Paie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($relations as $relation)
                <tr>
                    <td>{{ $relation->id }}</td>
                    <td>{{ $relation->client->name }}</td>
                    <td>{{ $relation->gestionnaire->user->name }}</td>
                    <td>{{ $relation->is_principal ? 'Oui' : 'Non' }}</td>
                    <td>{{ $relation->gestionnaires_secondaires ? implode(', ', $relation->gestionnaires_secondaires) : 'Aucun' }}</td>
                    <td>Non assigné</td>
                    <td>
                        <a href="{{ admin_url('gestionnaire-client/'.$relation->id.'/edit') }}" class="btn btn-primary btn-sm">Éditer</a>
                        <form action="{{ admin_url('gestionnaire-client/'.$relation->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette relation ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
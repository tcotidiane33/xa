@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="container mx-auto px-4 py-8">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Relations Gestionnaire-Client</h1>
                    <a href="{{ route('admin.gestionnaire-client.create') }}" class="btn btn-primary mb-4">Créer une relation</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Gestionnaire Principal</th>
                                <th>Gestionnaires Secondaires</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($relations as $relation)
                                <tr>
                                    <td>{{ $relation->client->name }}</td>
                                    <td>{{ $relation->gestionnaire->name }}</td>
                                    <td>
                                        @foreach($relation->gestionnairesSecondaires() as $gestionnaire)
                                            {{ $gestionnaire->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.gestionnaire-client.edit', $relation->id) }}" class="btn btn-warning">Modifier</a>
                                        <form action="{{ route('admin.gestionnaire-client.destroy', $relation->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                        <form action="{{ route('admin.gestionnaire-client.transfer') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="client_id" value="{{ $relation->client_id }}">
                                            <input type="hidden" name="new_gestionnaire_id" value="{{ $relation->gestionnaire_id }}">
                                            <button type="submit" class="btn btn-info">Transférer</button>
                                        </form>
                                        <form action="{{ route('admin.gestionnaire-client.attach') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="client_id" value="{{ $relation->client_id }}">
                                            <input type="hidden" name="gestionnaire_id" value="{{ $relation->gestionnaire_id }}">
                                            <button type="submit" class="btn btn-success">Rattacher</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
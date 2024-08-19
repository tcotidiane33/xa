@extends('layouts.admin')

@section('content')
<div class="main-page">
    <h2 class="title1">Documents pour {{ $client->name }}</h2>
    <div class="panel-body widget-shadow">
        <a href="{{ route('clients.materials.create', $client) }}" class="btn btn-primary mb-3">Ajouter un document</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                <tr>
                    <td>{{ $material->title }}</td>
                    <td>{{ $material->type }}</td>
                    <td>
                        <a href="{{ route('clients.materials.show', [$client, $material]) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('clients.materials.edit', [$client, $material]) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('clients.materials.destroy', [$client, $material]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $materials->links() }}
    </div>
</div>
@endsection

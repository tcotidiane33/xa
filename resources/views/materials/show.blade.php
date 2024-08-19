@extends('layouts.admin')

@section('content')
<div class="main-page">
    <h2 class="title1">Détails du document pour {{ $client->name }}</h2>
    <div class="panel-body widget-shadow">
        <h4>{{ $material->title }}</h4>
        <p><strong>Type:</strong> {{ $material->type }}</p>
        <p><strong>Champ associé:</strong> {{ $material->field_name ?? 'Non spécifié' }}</p>
        @if($material->content)
            <p><strong>Fichier:</strong> <a href="{{ asset('storage/'.$material->content) }}" target="_blank">Voir le fichier</a></p>
        @endif
        @if($material->content_url)
            <p><strong>URL du contenu:</strong> <a href="{{ $material->content_url }}" target="_blank">{{ $material->content_url }}</a></p>
        @endif
        <a href="{{ route('clients.materials.edit', [$client, $material]) }}" class="btn btn-warning">Modifier</a>
        <form action="{{ route('clients.materials.destroy', [$client, $material]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">Supprimer</button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="main-page">
    <h2 class="title1">Modifier le document pour {{ $client->name }}</h2>
    <div class="form-three widget-shadow">
        <form action="{{ route('clients.materials.update', [$client, $material]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $material->title }}" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="autre" {{ $material->type == 'autre' ? 'selected' : '' }}>Autre</option>
                    <option value="document" {{ $material->type == 'document' ? 'selected' : '' }}>Document</option>
                    <option value="image" {{ $material->type == 'image' ? 'selected' : '' }}>Image</option>
                </select>
            </div>
            <div class="form-group">
                <label for="content">Fichier</label>
                <input type="file" class="form-control-file" id="content" name="content">
                @if($material->content)
                    <p>Fichier actuel : {{ $material->content }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="content_url">URL du contenu</label>
                <input type="url" class="form-control" id="content_url" name="content_url" value="{{ $material->content_url }}">
            </div>
            <div class="form-group">
                <label for="field_name">Champ associé</label>
                <input type="text" class="form-control" id="field_name" name="field_name" value="{{ $material->field_name }}">
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
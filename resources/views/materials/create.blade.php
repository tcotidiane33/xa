@extends('layouts.admin')

@section('content')
<div class="main-page">
    <h2 class="title1">Ajouter un document pour {{ $client->name }}</h2>
    <div class="form-three widget-shadow">
        <form action="{{ route('materials.store', $client) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="autre">Autre</option>
                    <option value="document">Document</option>
                    <option value="image">Image</option>
                </select>
            </div>
            <div class="form-group">
                <label for="content">Fichier</label>
                <input type="file" class="form-control-file" id="content" name="content">
            </div>
            <div class="form-group">
                <label for="content_url">URL du contenu</label>
                <input type="url" class="form-control" id="content_url" name="content_url">
            </div>
            <div class="form-group">
                <label for="field_name">Champ associé</label>
                <input type="text" class="form-control" id="field_name" name="field_name">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</div>
@endsection

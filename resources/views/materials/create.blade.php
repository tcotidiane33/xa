@extends('layouts.admin')

@section('content')
<div class="container p-4">
  <div class="container-fluid">
    <div class="row">
        <br>
        <br>
    </div>
    <div class="row">
        <div class="main">
            <h1 class="title text-2xl">Ajouter un nouveau matériel</h1>
        </div>
    </div>

    <form action="{{ route('materials.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="client_id">Client</label>
            <select name="client_id" id="client_id" class="form-control" required>
                <option value="">Sélectionnez un client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="autre">Autre</option>
                <option value="document">Document</option>
                <option value="image">Image</option>
            </select>
        </div>
        <div class="form-group">
            <label for="content">Contenu</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
<p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
            {{-- <textarea name="content" id="content" class="form-control"></textarea> --}}
        </div>
        <div class="form-group">
            <label for="content_url">URL du contenu</label>
            <input type="url" name="content_url" id="content_url" class="form-control">
        </div>
        <div class="form-group">
            <label for="field_name">Nom du champ</label>
            <input type="text" name="field_name" id="field_name" class="form-control">
        </div>
            <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Ajouter</button>
        </form>
    </div>
  </div>
</div>
@endsection

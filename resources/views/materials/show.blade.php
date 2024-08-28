@extends('layouts.admin')

@section('content')
    <div class="container main-page">
        <div class="row">
            <br>
            <br>
        </div>
        <div class="container-fluid">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
                <div
                    class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12 mb-8">
                    <div class="bg-white shadow-md rounded-lg mb-4 overflow-hidden p-3">

                        <h2 class="title1">Détails du document pour {{ $client->name }}</h2>
                        <div class="panel-body widget-shadow">
                            <h4>{{ $material->title }}</h4>
                            <p><strong>Type:</strong> {{ $material->type }}</p>
                            <p><strong>Champ associé:</strong> {{ $material->field_name ?? 'Non spécifié' }}</p>
                            @if ($material->content)
                                <p><strong>Fichier:</strong> <a href="{{ asset('storage/' . $material->content) }}"
                                        class=" inline-flex items-center justify-center p-1.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800"
                                        target="_blank">Voir le fichier</a></p>
                            @endif
                            @if ($material->content_url)
                                <p><strong>URL du contenu:</strong> <a href="{{ $material->content_url }}"
                                        target="_blank">{{ $material->content_url }}</a></p>
                            @endif
                            <a href="{{ route('materials.edit', $material) }}"
                                class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                            <form action="{{ route('materials.destroy', $material) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class=" text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Admin Traitements des paies')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="row">
                <br>
                <br>
            </div>
            <div class="row">
                <div class="container">
                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="titre" class="block text-gray-700 text-sm font-bold mb-2">Titre:</label>
                            <input type="text" name="titre" id="titre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="priorite" class="block text-gray-700 text-sm font-bold mb-2">Priorité:</label>
                            <select name="priorite" id="priorite" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="basse">Basse</option>
                                <option value="moyenne">Moyenne</option>
                                <option value="haute">Haute</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="assigne_a_id" class="block text-gray-700 text-sm font-bold mb-2">Assigné à:</label>
                            <select name="assigne_a_id" id="assigne_a_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Non assigné</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

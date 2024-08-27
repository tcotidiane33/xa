@extends('layouts.admin')

@section('title', 'Éditer un utilisateur')

@section('content')
    <div class="container mx-auto p-4 pt-6 md:p-6">
        <div class="flex justify-center mb-4">
            <h1 class="text-2xl font-bold">Éditer un utilisateur</h1>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $user->name }}" required>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $user->email }}" required>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Mot de passe (laisser vide pour ne pas modifier)</label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <label for="roles" class="block mb-2 text-sm font-medium text-gray-700">Rôles</label>
                    <select id="roles" name="roles[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" multiple required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Mettre à jour</button>
        </form>
    </div>
@endsection
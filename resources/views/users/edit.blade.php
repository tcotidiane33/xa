@extends('layouts.admin')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="container mx-auto p-4 pt-6 md:p-6">
    <h1 class="text-2xl font-bold mb-4">Modifier un utilisateur</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Nom
            </label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email
            </label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Mot de passe
            </label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                Confirmer le mot de passe
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="roles">
                Rôles
            </label>
            <select name="roles[]" id="roles" class="form-control" multiple required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('roles')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <hr class="my-6">

    <h2 class="text-xl font-bold mb-4">Clients rattachés</h2>
    <form action="{{ route('admin.users.attachClient', $user) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="client_id">
                Ajouter un client
            </label>
            <select name="client_id" id="client_id" class="form-control" required>
                <option value="">Sélectionner un client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->clients as $client)
                <tr>
                    <td class="border px-4 py-2">{{ $client->name }}</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('users.detachClient', $user) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <button type="submit" class="btn btn-danger">Détacher</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="my-6">

    <h2 class="text-xl font-bold mb-4">Transférer des clients</h2>
    <form action="{{ route('admin.users.transferClients', $user) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="new_user_id">
                Transférer à
            </label>
            <select name="new_user_id" id="new_user_id" class="form-control" required>
                <option value="">Sélectionner un utilisateur</option>
                @foreach ($users as $otherUser)
                    @if ($otherUser->id !== $user->id)
                        <option value="{{ $otherUser->id }}">{{ $otherUser->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="client_ids">
                Clients à transférer
            </label>
            <select name="client_ids[]" id="client_ids" class="form-control" multiple required>
                @foreach ($user->clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Transférer</button>
    </form>
</div>
@endsection
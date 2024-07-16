@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold mb-4">Gestion des utilisateurs</h1>
@endsection

@section('content')
<div class="container mx-auto">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Nom</th>
                <th class="py-2">Email</th>
                <th class="py-2">Rôle</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="py-2">{{ $user->name }}</td>
                <td class="py-2">{{ $user->email }}</td>
                <td class="py-2">{{ $user->role->name }}</td>
                <td class="py-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Modifier</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection

@extends('layouts.app')

@section('content')
    <h1>Liste des Utilisateurs</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Ajouter un utilisateur</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge badge-info">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Éditer</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@endsection

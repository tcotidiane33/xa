@extends('layouts.admin')

@section('title', 'Liste des utilisateurs')

@section('content')
    <div class="main-content">
        <div class="row">
            </br>
            </br>
        </div>
        <div class="container">
            <div class="breadcrumb">
            <h1>Liste des utilisateurs</h1>
            </div>
            <table class="table table-striped">
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
                                    {{ $role->name }}<br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user) }}" class="btn btn-info">Voir</a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Éditer</a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;">
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
    </div>
@endsection
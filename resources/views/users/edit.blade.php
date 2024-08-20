@extends('layouts.admin')

@section('title', 'Éditer un utilisateur')

@section('content')
    <div class="main-content">
        <div class="row">
        </br>
        </br>
    </div>
        <div class="container">
            <div class="breadcrumb">
            <h1>Éditer un utilisateur</h1>
            </div>
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
              <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe (laisser vide pour ne pas modifier)</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="roles">Rôles</label>
                        <select id="roles" name="roles[]" class="form-control" multiple required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>
    @endsection
@extends('layouts.admin')

@section('title', 'Tableau de Bord Admin')

@section('content')
<div class="container">
    <h1>Tableau de Bord</h1>

    <div class="row">
        <!-- Carte pour les rôles -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Rôles</h5>
                    <p class="card-text">{{ $totalRoles }}</p>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">Gérer les Rôles</a>
                </div>
            </div>
        </div>

        <!-- Carte pour les permissions -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Permissions</h5>
                    <p class="card-text">{{ $totalPermissions }}</p>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary">Gérer les Permissions</a>
                </div>
            </div>
        </div>

        <!-- Carte pour les utilisateurs -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Utilisateurs</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Gérer les Utilisateurs</a>
                </div>
            </div>
        </div>

        <!-- Carte pour les clients -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Clients</h5>
                    <p class="card-text">{{ $totalClients }}</p>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-primary">Gérer les Clients</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
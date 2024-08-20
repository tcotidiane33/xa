@extends('layouts.admin')

@section('title', 'Gestion des Rôles')

@section('content')
<div class="main-content">
    <div class="container">
    </br></br></br>
    </div>
    <div class="cbp-spmenu-push">
        <div class="main-content">
            <div id="page-wrapper">
                <div class="row">
                    <div class="breadcrumb">

                    <h1>Gestion des Rôles et Permissions</h1>
                    </div>
                    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Rôles :</h4>
                        </div>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-3">
                                        Créer un nouveau rôle
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Permissions</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach ($role->permissions as $permission)
                                                <span class="label label-info">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-xs btn-primary">Modifier</a>
                                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Permissions :</h4>
                        </div>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-success mb-3">
                                        Créer une nouvelle permission
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('admin.roles.assign') }}" class="btn btn-info">
                            Assigner des rôles aux utilisateurs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .mb-3 {
        margin-bottom: 1rem;
    }
    .label {
        display: inline-block;
        padding: .2em .6em .3em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
    }
    .label-info {
        background-color: #5bc0de;
    }
</style>
@endpush
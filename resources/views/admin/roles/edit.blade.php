@extends('layouts.admin')

@section('title', 'Modifier un Rôle')

@section('content')
<div class="main-content">
    <div class="container">
        <br><br><br>
    </div>
    <div class="cbp-spmenu-push">
        <div class="main-content">
            <div id="page-wrapper">
                <div class="breadcrumb">

                    <h1 class="title1">Modifier le rôle: {{ $role->name }}</h1>
                    </div>
                <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                    <div class="form-body">
                        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nom du rôle:</label>
                                <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Permissions:</label>
                                @foreach ($permissions as $permission)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                id="permission_{{ $permission->id }}"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
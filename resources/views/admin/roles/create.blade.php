@extends('layouts.admin')

@section('title', 'Créer un Rôle')

@section('content')
<div class="main-content">
    <div class="container">
        <br><br><br>
    </div>
    <div class="cbp-spmenu-push">
        <div class="main-content">
            <div id="page-wrapper">
                <div class="breadcrumb">

                    <h1 class="title1">Créer un nouveau rôle</h1>
                    </div>
                <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                    <div class="form-body">
                        <form method="POST" action="{{ route('admin.roles.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nom du rôle:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Permissions:</label>
                                @foreach ($permissions as $permission)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                id="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Créer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

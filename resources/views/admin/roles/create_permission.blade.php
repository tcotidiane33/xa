@extends('layouts.admin')

@section('title', 'Créer une Permission')

@section('content')
<div class="main-content">
    <div class="container">
        <br><br><br>
    </div>
    <div class="cbp-spmenu-push">
        <div class="main-content">
            <div id="page-wrapper">
                <div class="breadcrumb">
                    <h1 class="title1">Créer une nouvelle permission</h1>
                    </div>
                <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                    <div class="form-body">
                        <form method="POST" action="{{ route('admin.permissions.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nom de la permission:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Créer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="container">
                <div class="row">
                </br></br>
                </div>
                <div class="breadcrumb">
                    <h1>Modifier la Convention Collective</h1>
                </div>
                
                <form action="{{ route('convention-collectives.update', $conventionCollective) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $conventionCollective->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $conventionCollective->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
@endsection

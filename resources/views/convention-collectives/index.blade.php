@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="container">
                <div class="row">
                </br></br>
                </div>
                <div class="breadcrumb">

                    <h1>Conventions Collectives</h1>
                </div>
                <a href="{{ route('convention-collectives.create') }}" class="btn btn-primary mb-3">Ajouter une nouvelle convention collective</a>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conventionCollectives as $conventionCollective)
                        <tr>
                            <td>{{ $conventionCollective->id }}</td>
                            <td>{{ $conventionCollective->name }}</td>
                            <td>{{ Str::limit($conventionCollective->description, 50) }}</td>
                            <td>
                                <a href="{{ route('convention-collectives.show', $conventionCollective) }}" class="btn btn-sm btn-info">Voir</a>
                                <a href="{{ route('convention-collectives.edit', $conventionCollective) }}" class="btn btn-sm btn-primary">Modifier</a>
                                <form action="{{ route('convention-collectives.destroy', $conventionCollective) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette convention collective ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

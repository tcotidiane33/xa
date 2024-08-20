@extends('layouts.admin')

@section('content')
    <div class="main-content">

        <div class="main-page">
            <div class="container">
                <div class="row">
                </br></br>
                </div>
                <div class="breadcrumb">

                    <h1>Détails de la Convention Collective</h1>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $conventionCollective->name }}</h5>
                        <p class="card-text">{{ $conventionCollective->description }}</p>
                    </div>
                </div>
                
                <a href="{{ route('convention-collectives.edit', $conventionCollective) }}" class="btn btn-primary mt-3">Modifier</a>
                <a href="{{ route('convention-collectives.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
            </div>
        </div>
    </div>
@endsection

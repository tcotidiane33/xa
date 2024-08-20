@extends('layouts.admin')

@section('title', 'Utilisateur')

@section('content')
    <div class="main-content">
        <div class="row">
        </br>
        </br>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="breadcrumb">
                        <h1>Utilisateurs</h1>
                    </div>
                    <div class="card-body">
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                                <div class="text-lg font-bold">Nom</div>
                                <div class="text-gray-600">{{ $user->name }}</div>
                            </div>
                            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                                <div class="text-lg font-bold">Email</div>
                                <div class="text-gray-600">{{ $user->email }}</div>
                            </div>
                            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                                <div class="text-lg font-bold">Rôles</div>
                                <ul>
                                    @foreach($user->roles as $role)
                                        <li class="text-gray-600">{{ $role->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
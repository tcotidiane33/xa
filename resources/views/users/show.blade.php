@extends('layouts.admin')

@section('title', 'Utilisateur')

@section('content')
    <div class="container mx-auto p-4 pt-6 md:p-6">
        <div class="flex justify-center mb-4">
            <h1 class="text-2xl font-bold">Utilisateurs</h1>
        </div>
        <div class="card bg-white rounded-lg shadow-md">
            <div class="card-body p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg p-4">
                        <div class="text-lg font-bold">Nom</div>
                        <div class="text-gray-600">{{ $user->name }}</div>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        <div class="text-lg font-bold">Email</div>
                        <div class="text-gray-600">{{ $user->email }}</div>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        <div class="text-lg font-bold">Rôles</div>
                        <ul class="list-none mb-0">
                            @foreach($user->roles as $role)
                                <li class="text-gray-600">{{ $role->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
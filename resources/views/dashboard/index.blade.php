@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold mb-4">Tableau de bord</h1>
@endsection

@section('content')
    <div class="container mx-auto fade-in">
        <div class="container-fluid ">

            <div class="row flex auto ml-2 gap-4">
                <div class="col-sm-6 col-lg-5 border-4 gap-2 bg-info  bg-blue-500 text-white shadow rounded-lg p-2">
                    <div class="container card">
                        <div class="row card-body">
                            <div class="col ml-3">
                                <img src="https://img.icons8.com/?size=100&id=5gNd48f2S9rS&format=png&color=000000"
                                    alt="Users Icon" class="h-10 mr-3">
                            </div>
                            <div class="col flex-grow">
                                <p class="text-2xl badge text-wrap p-2 font-bold px-6 rounded bg-white text-info text-sm"
                                    style="font-size: 6rem;"><b>{{ $totalUsers }}</b></p>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-lg text-wrap font-medium">Utilisateurs</h2>
                </div>
                <div class="col-sm-6 col-lg-5 border-4 gap-2 bg-primary  bg-blue-600 text-white shadow rounded-lg p-2">
                    <div class="container card">
                        <div class="row card-body">
                            <div class="col ml-3">
                                <img src="https://img.icons8.com/?size=100&id=oSEr6GptMtuy&format=png&color=000000"
                                    alt="Clients Icon" class="h-10 mr-3">
                            </div>
                            <div class="col flex-grow">
                                <p class="text-2xl badge text-wrap p-2 font-bold px-6 rounded bg-white text-primary text-sm"
                                    style="font-size: 6rem;"><b>{{ $totalClients }}</b></p>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-lg font-medium">Clients</h2>
                </div>
                <div class="col-sm-6 col-lg-5 border-4 gap-2 bg-warning  bg-yellow-500 text-white shadow rounded-lg p-2">
                    <div class="container card">
                        <div class="row card-body">
                            <div class="col ml-3">
                                <img src="https://img.icons8.com/?size=100&id=Ah0jYxh6v6Q9&format=png&color=000000"
                                    alt="Pay Periods Icon" class="h-10 mr-3">
                            </div>
                            <div class="col flex-grow">
                                <p class="text-2xl badge text-wrap p-2 font-bold px-6 rounded bg-white text-warning text-sm"
                                    style="font-size: 6rem;"><b>{{ $totalPeriodesPaie }}</b></p>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-lg font-medium">Périodes de Paie</h2>
                </div>
                <div class="col-sm-6 col-lg-5 border-4 gap-2 bg-danger bg-red-500 text-white shadow rounded-lg p-2">
                    <div class="container card">
                        <div class="row card-body">
                            <div class="col ml-3">
                                <img src="https://img.icons8.com/?size=100&id=dSgwt6I4t2HK&format=png&color=000000"
                                    alt="Pay Process Icon" class="h-10">
                            </div>
                            <div class="col flex-grow">
                                <p class="text-2xl badge text-wrap p-2 font-bold px-6 rounded-full bg-white text-danger text-sm"
                                    style="font-size: 6rem;"><b>{{ $traitementsPaieEnCours }}</b></p>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-lg font-medium">Traitements de Paie en cours</h2>
                </div>

            </div>


            <div class="row bg-white shadow rounded-lg p-4 mt-4 flex items-center">
                <div class=" col-lg-5">
                    <h5 class="card-title text-primary">Félicitation Mr {{ Auth::user()->name }}! 🎉</h5>
                    <p class="mb-4">
                        Vous avez du succès <span class="fw-bold">{{ $successPercentage }}%</span> plus d'offres
                        aujourd'hui.
                        Vérifiez votre nouveau badge sur votre profil.
                    </p>
                    <button class="mt-2 px-4 py-2 bg-primary text-white rounded">Voir les insignes</button>
                </div>
                <div class="ml-auto  col-lg-2">
                    <img src="https://img.icons8.com/?size=100&id=RvTJZvWsqWoZ&format=png&color=000000" width="150px"
                        height="150px" alt="Badge Icon" class="h-16">
                </div>
                <div
                    class="col-sm-6 col-lg-2 gap-2 bg-transparent  bg-green-500 text-white shadow rounded-lg m-1 rounded-10 p-2">
                    <div class="flex items-center">
                        <img src="https://img.icons8.com/?size=100&id=AefXIkx4A693&format=png&color=000000" alt="Users Icon"
                            class="h-10 mr-3">
                        <div>
                            <h2 class="badge bg-success  rounded-full text-wrap font-medium">Traitements Terminer</h2>
                            <p class="badge p-2 font-bold px-6 rounded text-secondary"
                                style="font-size: 2rem;border-radius:50px;background:transparent;">
                                <b>{{ $traitementsPaieTerminer }}</b>
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="col-sm-6 col-lg-2 gap-2 bg-transparent  bg-red-500 text-white shadow rounded-lg m-1 rounded-10 p-2">
                    <div class="flex items-center">
                        <img src="https://img.icons8.com/?size=100&id=faXHmzlIKEVi&format=png&color=000000" alt="Users Icon"
                            class="h-10 mr-3">
                        <div>
                            <h2 class="badge bg-danger rounded-full text-wrap font-medium">Traitements Interrompus</h2>
                            <p class="badge p-2 font-bold px-6 rounded text-secondary"
                                style="font-size: 2rem;border-radius:50px;background:transparent;">
                                <b>{{ $traitementsPaieInterrompu }}</b>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-white mt-4 p-3">

                <h2 class="text-xl font-bold mt-8">Derniers clients</h2>
                <div class="card-body">
                    <ul class="list-disc pl-5">
                        @foreach ($latestClients as $client)
                            <li class="badge bg-secondary text-2xl p-2">{{ $client->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

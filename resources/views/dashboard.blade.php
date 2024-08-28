@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto p-4 pt-6 md:p-6">
        <div class="flex justify-center mb-4">
            <h2 class="text-2xl font-bold">{{ __('Admin Dashboard') }}</h2>
        </div>

        <div class="grid grid-cols-4 gap-4 mb-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <i class="fa fa-users text-2xl text-gray-500 mr-2"></i>
                    <div>
                        <h5 class="text-lg font-bold">{{ $totalUsers }}</h5>
                        <span class="text-gray-500">Total Utilisateurs</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <i class="fa fa-building text-2xl text-gray-500 mr-2"></i>
                    <div>
                        <h5 class="text-lg font-bold">{{ $totalClients }}</h5>
                        <span class="text-gray-500">Total Clients</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <i class="fa fa-calendar text-2xl text-gray-500 mr-2"></i>
                    <div>
                        <h5 class="text-lg font-bold">{{ $totalPeriodesPaie }}</h5>
                        <span class="text-gray-500">Périodes de paie</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <i class="fa fa-pie-chart text-2xl text-gray-500 mr-2"></i>
                    <div>
                        <h5 class="text-lg font-bold">{{ $successPercentage }}%</h5>
                        <span class="text-gray-500">Taux de réussite</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold">Traitements de paie</h3>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-info p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fa fa-clock-o text-2xl text-white mr-2"></i>
                        <div>
                            <h5 class="text-lg font-bold">{{ $traitementsPaieEnCours }}</h5>
                            <span class="text-white">En cours</span>
                        </div>
                    </div>
                </div>
                <div class="bg-success p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fa fa-check-circle-o text-2xl text-white mr-2"></i>
                        <div>
                            <h5 class="text-lg font-bold">{{ $traitementsPaieTerminer }}</h5>
                            <span class="text-white">Terminés</span>
                        </div>
                    </div>
                </div>
                <div class="bg-danger p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fa fa-pause-circle-o text-2xl text-white mr-2"></i>
                        <div>
                            <h5 class="text-lg font-bold">{{ $traitementsPaieInterrompu }}</h5>
                            <span class="text-white">Interrompus</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold">Documents rattachées aux clients </h3>
            </div>
            <button class="{{ request()->routeIs('materials.index') ? 'active' : '' }}">
                <a href="{{ route('materials.index') }}">
                    <i class="fa fa-file"></i> <span>{{ __('Tous les Materials') }}</span>
                </a>
            </button>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-bold">Derniers clients ajoutés</h3>
            </div>
            <ul class="list-group">
                @foreach ($latestClients as $client)
                    <li class="list-group-item bg-[#3b5998] hover:bg-[#3b5998]/90 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">{{ $client->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('web/js/SimpleChart.js') }}"></script>
    <script>
        // Add any dashboard-specific JavaScript here
    </script>
@endpush

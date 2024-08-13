<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
       <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-500 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold text-white">Utilisateurs</h3>
                            <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-green-500 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold text-white">Clients</h3>
                            <p class="text-3xl font-bold text-white">{{ $totalClients }}</p>
                        </div>
                        <div class="bg-yellow-500 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold text-white">Périodes de paie</h3>
                            <p class="text-3xl font-bold text-white">{{ $totalPeriodesPaie }}</p>
                        </div>
                        <div class="bg-red-500 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold text-white">Taux de réussite</h3>
                            <p class="text-3xl font-bold text-white">{{ $successPercentage }}%</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-2xl font-bold mb-4">Traitements de paie</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-indigo-500 p-4 rounded-lg shadow-md">
                                <h4 class="text-lg font-bold text-white">En cours</h4>
                                <p class="text-2xl font-bold text-white">{{ $traitementsPaieEnCours }}</p>
                            </div>
                            <div class="bg-purple-500 p-4 rounded-lg shadow-md">
                                <h4 class="text-lg font-bold text-white">Terminés</h4>
                                <p class="text-2xl font-bold text-white">{{ $traitementsPaieTerminer }}</p>
                            </div>
                            <div class="bg-pink-500 p-4 rounded-lg shadow-md">
                                <h4 class="text-lg font-bold text-white">Interrompus</h4>
                                <p class="text-2xl font-bold text-white">{{ $traitementsPaieInterrompu }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-2xl font-bold mb-4">Derniers clients ajoutés</h3>
                        <ul class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md">
                            @foreach($latestClients as $client)
                                <li class="p-4 border-b border-gray-200 dark:border-gray-600 last:border-b-0">
                                    {{ $client->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de l\'utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ $user->name }}</h3>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Rôles:</strong>
                        @foreach($user->roles as $role)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $role->name }}</span>
                        @endforeach
                    </p>
                    <p><strong>Créé le:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Dernière mise à jour:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>

                    <div class="mt-4">
                        <a href="{{ route('users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modifier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

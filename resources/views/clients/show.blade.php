<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ $client->name }}</h3>
                    <p><strong>Responsable Paie:</strong> {{ $client->responsablePaie->name }}</p>
                    <p><strong>Gestionnaire Principal:</strong> {{ $client->gestionnairePrincipal->name }}</p>
                    <p><strong>Date de début de prestation:</strong> {{ $client->date_debut_prestation->format('d/m/Y') }}</p>
                    <p><strong>Contact Paie:</strong> {{ $client->contact_paie }}</p>
                    <p><strong>Contact Comptabilité:</strong> {{ $client->contact_comptabilite }}</p>

                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Traitements de paie</h4>
                        @if($client->traitementsPaie->count() > 0)
                            <ul>
                                @foreach($client->traitementsPaie as $traitement)
                                    <li>
                                        <a href="{{ route('traitements-paie.show', $traitement) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $traitement->periode_paie->debut->format('m/Y') }} - {{ $traitement->nbr_bull }} bulletins
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Aucun traitement de paie enregistré.</p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('clients.edit', $client) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Modifier
                        </a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
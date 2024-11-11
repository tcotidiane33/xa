@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Fiches Clients</h1>
    <div class="mb-4 grid">
        <div class="title col">
            <a href="{{ route('fiches-clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Créer une Fiche Client
            </a>
        </div>
        <hr>
        <form action="{{ route('fiches-clients.migrate') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir migrer toutes les fiches clients vers la nouvelle période de paie ?');">
            @csrf
            <div>
                <label for="periode_paie_id" class="block text-sm font-medium text-gray-700">Période de Paie en cours</label>
                <select name="periode_paie_id" id="periode_paie_id" class="form-control">
                    @foreach ($periodesPaie as $periode)
                        <option value="{{ $periode->id }}">{{ $periode->reference }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Migrer vers la nouvelle période de paie
            </button>
        </form>
    </div>

    <!-- Formulaire de filtre -->
    <form method="GET" action="{{ route('fiches-clients.index') }}" class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                <select name="client_id" id="client_id" class="form-control">
                    <option value="">Tous les clients</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="periode_paie_id" class="block text-sm font-medium text-gray-700">Période de Paie</label>
                <select name="periode_paie_id" id="periode_paie_id" class="form-control">
                    <option value="">Toutes les périodes</option>
                    @foreach ($periodesPaie as $periode)
                        <option value="{{ $periode->id }}" {{ request('periode_paie_id') == $periode->id ? 'selected' : '' }}>{{ $periode->reference }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filtrer
                </button>
            </div>
        </div>
    </form>
    <div class="mb-4">
        <a href="{{ route('fiches-clients.export.excel', request()->query()) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Exporter en Excel
        </a>
        <a href="{{ route('fiches-clients.export.pdf', request()->query()) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Exporter en PDF
        </a>
    </div>
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Client</th>
                    <th scope="col" class="px-6 py-3">Période de Paie</th>
                    <th scope="col" class="px-6 py-3">Réception variables</th>
                    <th scope="col" class="px-6 py-3">Préparation BP</th>
                    <th scope="col" class="px-6 py-3">Validation BP client</th>
                    <th scope="col" class="px-6 py-3">Préparation et envoie DSN</th>
                    <th scope="col" class="px-6 py-3">Accusés DSN</th>
                    {{-- <th scope="col" class="px-6 py-3">TELEDEC URSSAF</th> --}}
                    <th scope="col" class="px-6 py-3">NOTES</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fichesClients as $fiche)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $fiche->client->name }}</td>
                        <td class="px-6 py-4">{{ $fiche->periodePaie->reference }}</td>
                        <td class="px-6 py-4">{{ $fiche->reception_variables ? \Carbon\Carbon::parse($fiche->reception_variables)->format('d/m') : 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $fiche->preparation_bp ? \Carbon\Carbon::parse($fiche->preparation_bp)->format('d/m') : 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $fiche->validation_bp_client ? \Carbon\Carbon::parse($fiche->validation_bp_client)->format('d/m') : 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $fiche->preparation_envoie_dsn ? \Carbon\Carbon::parse($fiche->preparation_envoie_dsn)->format('d/m') : 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $fiche->accuses_dsn ? \Carbon\Carbon::parse($fiche->accuses_dsn)->format('d/m') : 'N/A' }}</td>
                        {{-- <td class="px-6 py-4">{{ $fiche->teledec_urssaf ? \Carbon\Carbon::parse($fiche->teledec_urssaf)->format('d/m') : 'N/A' }}</td> --}}
                        <td class="px-6 py-4">{{ $fiche->notes ?? 'N/A' }}</td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('fiches-clients.edit', $fiche->id) }}" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                            {{-- <form action="{{ route('fiches-clients.destroy', $fiche->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $fichesClients->links() }}
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Fiches Clients</h1>
    <div class="mb-4">
        <a href="{{ route('fiches-clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Créer une Fiche Client
        </a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Client</th>
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
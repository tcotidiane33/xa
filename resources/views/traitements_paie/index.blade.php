@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('traitements-paie.create') }}" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Nouveau Traitement</a>
    </div>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Liste des Traitements de Paie</h1>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table id="traitementsPaieTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Référence</th>
                    <th scope="col" class="px-6 py-3">Client</th>
                    <th scope="col" class="px-6 py-3">Gestionnaire</th>
                    <th scope="col" class="px-6 py-3">Période de Paie</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($traitements as $traitement)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $traitement->reference }}</td>
                        <td class="px-6 py-4">{{ $traitement->client->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $traitement->gestionnaire->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $traitement->periodePaie->reference ?? 'N/A' }}</td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('traitements-paie.edit', $traitement->id) }}" class="text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</a>
                            {{-- <form action="{{ route('traitements-paie.destroy', $traitement->id) }}" method="POST" style="display:inline;">
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
            {{ $traitements->links() }}
        </div>
    </div>
</div>
@endsection
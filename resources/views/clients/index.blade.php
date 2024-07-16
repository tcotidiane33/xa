<!-- resources/views/clients/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Gestion des clients</h1>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Nom</th>
                <th class="py-2">Responsable Paie</th>
                <th class="py-2">Gestionnaire Principal</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td class="py-2">{{ $client->name }}</td>
                <td class="py-2">{{ $client->responsablePaie->name ?? 'N/A' }}</td>
                <td class="py-2">{{ $client->gestionnairePrincipal->name ?? 'N/A' }}</td>
                <td class="py-2">
                    <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-primary">Modifier</a>
                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->links() }}
</div>
@endsection

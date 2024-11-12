@extends('layouts.admin')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Tableau de Bord</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Utilisateurs -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Total Utilisateurs</h3>
            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
        </div>

        <!-- Total Clients -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Total Clients</h3>
            <p class="text-2xl font-bold">{{ $totalClients }}</p>
        </div>

        <!-- Total Périodes de Paie -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Total Périodes de Paie</h3>
            <p class="text-2xl font-bold">{{ $totalPeriodesPaie }}</p>
        </div>

        <!-- Taux de Réussite -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Taux de Réussite</h3>
            <p class="text-2xl font-bold">{{ $successPercentage }}%</p>
        </div>

        <!-- Traitements de Paie en Cours -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Traitements de Paie en Cours</h3>
            <p class="text-2xl font-bold">{{ $traitementsPaieEnCours }}</p>
        </div>

        <!-- Traitements de Paie Terminés -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Traitements de Paie Terminés</h3>
            <p class="text-2xl font-bold">{{ $traitementsPaieTerminer }}</p>
        </div>

        <!-- Traitements de Paie Interrompus -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Traitements de Paie Interrompus</h3>
            <p class="text-2xl font-bold">{{ $traitementsPaieInterrompu }}</p>
        </div>

        <!-- Total Tickets -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Total Tickets</h3>
            <p class="text-2xl font-bold">{{ $totalTickets }}</p>
        </div>

        <!-- Tickets Ouverts -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Tickets Ouverts</h3>
            <p class="text-2xl font-bold">{{ $ticketsOuverts }}</p>
        </div>

        <!-- Tickets Fermés -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Tickets Fermés</h3>
            <p class="text-2xl font-bold">{{ $ticketsFermes }}</p>
        </div>

        <!-- Tickets en Cours -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Tickets en Cours</h3>
            <p class="text-2xl font-bold">{{ $ticketsEnCours }}</p>
        </div>
    </div>

    <!-- Derniers Clients -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Derniers Clients</h3>
        <ul>
            @foreach ($latestClients as $client)
                <li>{{ $client->name }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Derniers Traitements de Paie -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Derniers Traitements de Paie</h3>
        <ul>
            @foreach ($recentTraitements as $traitement)
                <li>{{ $traitement->client->name }} - {{ $traitement->reference }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Derniers Tickets -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Derniers Tickets</h3>
        <ul>
            @foreach ($recentTickets as $ticket)
                <li>{{ $ticket->titre }} - {{ $ticket->createur->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
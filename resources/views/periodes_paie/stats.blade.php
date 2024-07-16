@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Statistiques des périodes de paie</h1>
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-lg font-medium">Statistiques</h2>
        <p>Total des périodes de paie : {{ $stats->total }}</p>
        <p>Périodes de paie validées : {{ $stats->validees }}</p>
        <p>Durée moyenne des périodes de paie : {{ $stats->duree_moyenne }} jours</p>
    </div>
</div>
@endsection

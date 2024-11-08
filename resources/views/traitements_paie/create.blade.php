@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Créer un Traitement de Paie</h1>
    @livewire('traitement-paie-form')

</div>
@endsection
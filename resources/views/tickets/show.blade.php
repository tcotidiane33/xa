<!-- resources/views/tickets/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Ticket</h1>
    <div class="card">
        <div class="card-header">
            {{ $ticket->title }}
        </div>
        <div class="card-body">
            <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
            <p><strong>Description:</strong> {{ $ticket->description }}</p>
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">Modifier</a>
        </div>
    </div>
</div>
@endsection

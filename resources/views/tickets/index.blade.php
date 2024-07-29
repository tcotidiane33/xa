<!-- resources/views/tickets/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Tickets</h1>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Créer un Ticket</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->title }}</td>
                <td>{{ ucfirst($ticket->status) }}</td>
                <td>
                    <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info">Voir</a>
                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

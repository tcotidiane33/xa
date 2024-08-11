@extends('layouts.app')

@section('content')
    <h1>Modifier le ticket</h1>

    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="{{ $ticket->titre }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $ticket->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="statut">Statut</label>
            <select class="form-control" id="statut" name="statut" required>
                <option value="ouvert" {{ $ticket->statut == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                <option value="en_cours" {{ $ticket->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="ferme" {{ $ticket->statut == 'ferme' ? 'selected' : '' }}>Fermé</option>
            </select>
        </div>
        <div class="form-group">
            <label for="priorite">Priorité</label>
            <select class="form-control" id="priorite" name="priorite" required>
                <option value="basse" {{ $ticket->priorite == 'basse' ? 'selected' : '' }}>Basse</option>
                <option value="moyenne" {{ $ticket->priorite == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                <option value="haute" {{ $ticket->priorite == 'haute' ? 'selected' : '' }}>Haute</option>
            </select>
        </div>
        <div class="form-group">
            <label for="assigne_a_id">Assigné à</label>
            <select class="form-control" id="assigne_a_id" name="assigne_a_id">
                <option value="">Non assigné</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $ticket->assigne_a_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection

@extends('layouts.app')

@section('content')
    <h1>Modifier la période de paie</h1>

    <form action="{{ route('periodes_paie.update', $periodePaie) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="reference">Référence</label>
            <input type="text" class="form-control" id="reference" name="reference" value="{{ $periodePaie->reference }}" required>
        </div>
        <div class="form-group">
            <label for="debut">Date de début</label>
            <input type="date" class="form-control" id="debut" name="debut" value="{{ $periodePaie->debut->format('Y-m-d') }}" required>
        </div>
        <div class="form-group">
            <label for="fin">Date de fin</label>
            <input type="date" class="form-control" id="fin" name="fin" value="{{ $periodePaie->fin->format('Y-m-d') }}" required>
        </div>
        <div class="form-group">
            <label for="client_id">Client</label>
            <select class="form-control" id="client_id" name="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $periodePaie->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="validee" name="validee" {{ $periodePaie->validee ? 'checked' : '' }}>
            <label class="form-check-label" for="validee">Validée</label>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
    </form>
@endsection

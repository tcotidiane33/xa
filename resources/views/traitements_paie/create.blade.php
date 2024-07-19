@extends('layouts.app')

@section('content')
    <h1>Créer un traitement de paie</h1>
    <form action="{{ route('traitements_paie.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="gestionnaire_id">Gestionnaire</label>
            <select name="gestionnaire_id" id="gestionnaire_id" class="form-control">
                @foreach($gestionnaires as $gestionnaire)
                    <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="client_id">Client</label>
            <select name="client_id" id="client_id" class="form-control">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="periode_paie_id">Période de paie</label>
            <select name="periode_paie_id" id="periode_paie_id" class="form-control">
                @foreach($periodesPaie as $periodePaie)
                    <option value="{{ $periodePaie->id }}">{{ $periodePaie->debut }} - {{ $periodePaie->fin }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="nbr_bull">Nombre de bulletins</label>
            <input type="number" name="nbr_bull" id="nbr_bull" class="form-control">
        </div>
        <!-- Other fields -->
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
@endsection

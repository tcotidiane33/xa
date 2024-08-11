@extends('layouts.app')

@section('content')
    <h1>Créer un nouveau traitement de paie</h1>

    <form action="{{ route('traitements_paie.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="reference">Référence</label>
            <input type="text" class="form-control" id="reference" name="reference" required>
        </div>
        <div class="form-group">
            <label for="client_id">Client</label>
            <select class="form-control" id="client_id" name="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="periode_paie_id">Période de paie</label>
            <select class="form-control" id="periode_paie_id" name="periode_paie_id" required>
                @foreach($periodesPaie as $periode)
                    <option value="{{ $periode->id }}">{{ $periode->reference }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="nbr_bull">Nombre de bulletins</label>
            <input type="number" class="form-control" id="nbr_bull" name="nbr_bull" required>
        </div>
        <div class="form-group">
            <label for="pj_nbr_bull">Pièce jointe (Nombre de bulletins)</label>
            <input type="file" class="form-control-file" id="pj_nbr_bull" name="pj_nbr_bull">
        </div>
        <!-- Ajoutez d'autres champs ici -->
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
@endsection

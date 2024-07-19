<!-- resources/views/traitements_paie/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Traitements de paie</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Gestionnaire</th>
                <th>Client</th>
                <th>Période de paie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($traitementsPaie as $traitementPaie)
                <tr>
                    <td>{{ $traitementPaie->gestionnaire->name }}</td>
                    <td>{{ $traitementPaie->client->name }}</td>
                    <td>{{ $traitementPaie->periodePaie->debut }} - {{ $traitementPaie->periodePaie->fin }}</td>
                    <td>
                        <a href="{{ route('traitements_paie.edit', $traitementPaie) }}" class="btn btn-primary">Éditer</a>
                        <form action="{{ route('traitements_paie.destroy', $traitementPaie) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

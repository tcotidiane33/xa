<!-- resources/views/periodes_paie/periodes_paie.blade.php -->
@extends('layouts.app')

@section('content')
<!-- resources/views/periodes_paie/periodes_paie.blade.php -->

<h1>Periodes de Paie</h1>

<table>
    <thead>
        <tr>
            <th>Début</th>
            <th>Fin</th>
            <th>Validée</th>
        </tr>
    </thead>
    <tbody>
        @foreach($periodesPaie as $periodePaie)
            <tr>
                <td>{{ $periodePaie->debut }}</td>
                <td>{{ $periodePaie->fin }}</td>
                <td>{{ $periodePaie->validee? 'Oui' : 'Non' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

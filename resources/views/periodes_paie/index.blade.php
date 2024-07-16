@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Période de paie</h1>

    <form method="GET" action="{{ route('periodes_paie.index') }}">
        <select name="periode">
            @foreach(range(0, 11) as $i)
                @php
                    $date = now()->startOfYear()->addMonths($i);
                    $value = $date->format('Y-m');
                @endphp
                <option value="{{ $value }}" {{ $periode == $value ? 'selected' : '' }}>
                    {{ $date->format('F Y') }}
                </option>
            @endforeach
        </select>

        <select name="gestionnaire_id">
            <option value="">Tous les gestionnaires</option>
            @foreach($gestionnaires as $gestionnaire)
                <option value="{{ $gestionnaire->id }}" {{ request('gestionnaire_id') == $gestionnaire->id ? 'selected' : '' }}>
                    {{ $gestionnaire->name }}
                </option>
            @endforeach
        </select>

        <select name="client_id">
            <option value="">Tous les clients</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Gestionnaire</th>
                <th>NB Bulletins</th>
                <th>Client</th>
                <th>Maj fiche para</th>
                <th>Réception variables</th>
                <th>Préparation BP</th>
                <th>Validation BP client</th>
                <th>Préparation et envoie DSN</th>
                <th>Accusés DSN</th>
                <th>TELEDEC URSSAF</th>
                <th>NOTES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($traitementsPaie as $traitement)
                <tr>
                    <td>{{ $traitement->gestionnaire->name }}</td>
                    <td>{{ $traitement->nbr_bull }}</td>
                    <td>{{ $traitement->client->name }}</td>
                    <td>{{ $traitement->maj_fiche_para }}</td>
                    <td>
                        <input type="date" value="{{ $traitement->reception_variable }}"
                               onchange="updateField('{{ $traitement->id }}', 'reception_variable', this.value)">
                    </td>
                    <td>
                        <input type="date" value="{{ $traitement->preparation_bp }}"
                               onchange="updateField('{{ $traitement->id }}', 'preparation_bp', this.value)"
                               {{ $traitement->reception_variable ? '' : 'disabled' }}>
                    </td>
                    <!-- Ajoutez les autres champs de la même manière -->
                    <td>
                        <textarea onchange="updateField('{{ $traitement->id }}', 'notes', this.value)">{{ $traitement->notes }}</textarea>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(!$periodeActuelle->validee)
        <form method="POST" action="{{ route('periodes_paie.valider') }}">
            @csrf
            <input type="hidden" name="periode" value="{{ $periode }}">
            <button type="submit">Valider la période de paie</button>
        </form>
    @endif
</div>

<script>
function updateField(id, field, value) {
    fetch('/traitements-paie/' + id + '/update-field', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ field, value })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mettre à jour l'interface utilisateur si nécessaire
        }
    });
}
</script>
@endsection

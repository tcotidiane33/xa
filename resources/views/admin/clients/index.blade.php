@extends('layouts.admin')

@section('content')
    <h1>Affectation et transfert de clients</h1>

    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Gestionnaire actuel</th>
                <th>Responsable actuel</th>
                <th>Nouveau gestionnaire</th>
                <th>Nouveau responsable</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->gestionnaire->name ?? 'N/A' }}</td>
                    <td>{{ $client->responsable->name ?? 'N/A' }}</td>
                    <form action="{{ route('admin.clients.transfer', $client) }}" method="POST">
                        @csrf
                        <td>
                            <select name="gestionnaire_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $client->gestionnaire_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="responsable_id">
                                <option value="">Aucun</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $client->responsable_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button type="submit">Transférer</button>
                        </td>
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

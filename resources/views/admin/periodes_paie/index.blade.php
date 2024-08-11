@extends('admin::index')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liste des périodes de paie</h3>
        </div>
        <div class="card-body">
            <form action="{{ admin_url('periodes-paie') }}" method="get" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <input type="date" name="periode" class="form-control" placeholder="Période">
                    </div>
                    <div class="col-md-3">
                        <select name="gestionnaire_id" class="form-control">
                            <option value="">Tous les gestionnaires</option>
                            @foreach($gestionnaires as $gestionnaire)
                                <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="client_id" class="form-control">
                            <option value="">Tous les clients</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="validee" class="form-control">
                            <option value="">Tous les statuts</option>
                            <option value="1">Validée</option>
                            <option value="0">Non validée</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </div>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Référence</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periodesPaie as $periode)
                        <tr>
                            <td>{{ $periode->id }}</td>
                            <td>{{ $periode->reference }}</td>
                            <td>{{ $periode->debut->format('d/m/Y') }}</td>
                            <td>{{ $periode->fin->format('d/m/Y') }}</td>
                            <td>{{ $periode->client->name }}</td>
                            <td>{{ $periode->validee ? 'Validée' : 'Non validée' }}</td>
                            <td>
                                <a href="{{ admin_url('periodes-paie/'.$periode->id.'/edit') }}" class="btn btn-primary btn-sm">Éditer</a>
                                @if(!$periode->validee)
                                    <form action="{{ admin_url('periodes-paie/'.$periode->id.'/valider') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $periodesPaie->links() }}
        </div>
    </div>
@endsection

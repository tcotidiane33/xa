@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-page">
            <div class="row">
                </br></br>
            </div>
            <div class="breadcrumb">

                <h1>Créer un Période de Paie</h1>
            </div>
            <div class="container">
                <form action="{{ route('periodes-paie.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="reference">Référence</label>
                        <input type="text" name="reference" id="reference" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="client_id">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="debut">Date de début</label>
                        <input type="date" name="debut" id="debut" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="fin">Date de fin</label>
                        <input type="date" name="fin" id="fin" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Créer</button>
                </form>
            </div>
        </div>
    </div>
@endsection

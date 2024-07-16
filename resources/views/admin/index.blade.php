@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clients</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td><a href="{{ route('admin.showClient', $client->id) }}" class="btn btn-primary">Configurer</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

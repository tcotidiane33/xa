@extends('layouts.admin')

@section('content')
<div class="container ">
    <div class="main">
        <h1>Materials</h1>
    </div>

    {{-- <a href="{{ route('materials.create', $client) }}" class="btn btn-primary mb-3">Ajouter un document</a> --}}

    <form action="{{ route('materials.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="client_id" class="form-control">
                    <option value="">Select Client</option>
                    @if(isset($clients))
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <select name="type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="autre" {{ request('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                    <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Document</option>
                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('materials.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Client</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
            <tr>
                <td>{{ $material->title }}</td>
                <td>{{ $material->client->name }}</td>
                <td>{{ ucfirst($material->type) }}</td>
                <td>
                    <a href="{{ route('materials.show', $material) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('materials.edit', $material) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('materials.destroy', $material) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $materials->links() }}
</div>
@endsection

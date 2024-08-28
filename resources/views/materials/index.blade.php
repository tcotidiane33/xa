@extends('layouts.admin')

@section('content')
    <div class="container ">
        <div class="page-wrapper container-fluid">

            <div class="row">
                <br>
                <br>
            </div>
            <div class="row">

                <div class="creadcrumb mb-3">
                    <h1 class="title text-2xl">Materials</h1>
                </div>

                <a href="{{ route('materials.create') }}"
                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Ajouter
                    un document</a>
            </div>

            <form action="{{ route('materials.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <select name="client_id" class="form-control">
                            <option value="">Select Client</option>
                            @if (isset($clients))
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ request('client_id') == $client->id ? 'selected' : '' }}>
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
                        <button type="submit"
                            class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Filtrer</button>
                        <a href="{{ route('materials.index') }}"
                            class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Réinitialiser</a>
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
                    @foreach ($materials as $material)
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
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $materials->links() }}
        </div>
    </div>
@endsection

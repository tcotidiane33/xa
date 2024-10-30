@extends('layouts.admin')

@section('title', 'Ajouter une nouvelle période de paie')

@section('content')
<div class="container mx-auto p-4 pt-6 md:p-6">
    <h1 class="text-2xl font-bold mb-4">Ajouter une nouvelle période de paie</h1>

    <form action="{{ route('periodes-paie.store') }}" method="POST">
        @csrf

        <div class="mb-4 w-sm group">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="debut">
                Date de début
            </label>
            <input type="date" name="debut" id="debut" class="form-control" required>
        </div>

        <div class="mb-4 w-sm group">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="fin">
                Date de fin
            </label>
            <input type="date" name="fin" id="fin" class="form-control" required>
        </div>

        <button type="submit" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Ajouter
            </span>
        </button>
    </form>
</div>
@endsection
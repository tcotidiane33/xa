<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le traitement de paie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('traitements-paie.update', $traitementPaie) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="reference" class="block text-gray-700 text-sm font-bold mb-2">Référence:</label>
                            <input type="text" name="reference" id="reference" value="{{ old('reference', $traitementPaie->reference) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="client_id" class="block text-gray-700 text-sm font-bold mb-2">Client:</label>
                            <select name="client_id" id="client_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id', $traitementPaie->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="periode_paie_id" class="block text-gray-700 text-sm font-bold mb-2">Période de paie:</label>
                            <select name="periode_paie_id" id="periode_paie_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($periodesPaie as $periode)
                                    <option value="{{ $periode->id }}" {{ old('periode_paie_id', $traitementPaie->periode_paie_id) == $periode->id ? 'selected' : '' }}>{{ $periode->reference }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="nbr_bull" class="block text-gray-700 text-sm font-bold mb-2">Nombre de bulletins:</label>
                            <input type="number" name="nbr_bull" id="nbr_bull" value="{{ old('nbr_bull', $traitementPaie->nbr_bull) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="pj_nbr_bull" class="block text-gray-700 text-sm font-bold mb-2">Pièce jointe (Nombre de bulletins):</label>
                            <input type="file" name="pj_nbr_bull" id="pj_nbr_bull" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @if($traitementPaie->pj_nbr_bull)
                                <p class="mt-2">Fichier actuel : {{ basename($traitementPaie->pj_nbr_bull) }}</p>
                            @endif
                        </div>

                        <!-- Ajoutez d'autres champs ici -->

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

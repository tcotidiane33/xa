@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="container">
        <br><br><br>
    </div>
    <h1 class="text-3xl font-bold mb-6">Détails de la relation Gestionnaire-Client</h1>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informations sur la relation
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Client
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $gestionnaireClient->client->name }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Gestionnaire Principal
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $gestionnaireClient->gestionnaire->name }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Gestionnaires Secondaires
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($gestionnaireClient->gestionnairesSecondaires->isNotEmpty())
                            <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                @foreach($gestionnaireClient->gestionnairesSecondaires as $gestionnaire)
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        {{ $gestionnaire->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            Aucun gestionnaire secondaire
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Notes
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $gestionnaireClient->notes ?? 'Aucune note' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.gestionnaire-client.edit', $gestionnaireClient->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Modifier
        </a>
        <form action="{{ route('admin.gestionnaire-client.destroy', $gestionnaireClient->id) }}" method="POST" class="inline-block ml-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette relation ?')">
                Supprimer
            </button>
        </form>
    </div>
</div>
@endsection
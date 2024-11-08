<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FicheClient;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFicheClientRequest;
use App\Http\Requests\UpdateFicheClientRequest;

class FicheClientController extends Controller
{
    public function index(Request $request)
    {
        $fichesClients = FicheClient::paginate(15);
        return view('clients.fiches_clients.index', compact('fichesClients'));
    }

    public function create()
    {
        $clients = Client::all();
        $periodesPaie = PeriodePaie::all();
        return view('clients.fiches_clients.create', compact('clients', 'periodesPaie'));
    }

    public function store(StoreFicheClientRequest $request)
    {
        $validated = $request->validated();
        FicheClient::create($validated);

        return redirect()->route('fiches-clients.index')->with('success', 'Fiche client créée avec succès.');
    }

    public function edit(FicheClient $fiches_client)
    {
        $clients = Client::all();
        $periodesPaie = PeriodePaie::all();
        return view('clients.fiches_clients.edit', compact('fiches_client', 'clients', 'periodesPaie'));
    }

    public function update(UpdateFicheClientRequest $request, FicheClient $fiches_client)
    {
        $validated = $request->validated();
        $fiches_client->update($validated);

        return redirect()->route('fiches-clients.index')->with('success', 'Fiche client mise à jour avec succès.');
    }

    public function destroy(FicheClient $fiches_client)
    {
        $fiches_client->delete();
        return redirect()->route('fiches-clients.index')->with('success', 'Fiche client supprimée avec succès.');
    }
}
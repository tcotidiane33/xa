<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Traits\TracksUserActions;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use TracksUserActions;

    public function index()
    {
        $clients = Client::paginate(15);
        return view('clients.index', compact('clients'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([/* ... */]);
        $client = Client::create($validated);
        $this->logAction('create_client', "Création du client #{$client->id}");
        return redirect()->route('clients.show', $client);
    }
    /**
     * Display the specified resource.
     */
     public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'responsable_paie_id' => 'required|exists:users,id',
            'gestionnaire_principal_id' => 'required|exists:users,id',
            'date_debut_prestation' => 'nullable|date',
            'contact_paie' => 'nullable|string|max:255',
            'contact_comptabilite' => 'nullable|string|max:255',
        ]);

        $client->update($validated);
        return redirect()->route('clients.show', $client)->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
}

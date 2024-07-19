<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with(['responsablePaie', 'gestionnairePrincipal'])->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $users = User::all();
        return view('clients.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'equired|string|max:255',
            'esponsable_paie_id' => 'equired|exists:users,id',
            'gestionnaire_principal_id' => 'equired|exists:users,id',
            'date_debut_prestation' => 'equired|date',
            'convention_collective' => 'equired|string|max:255',
            'contact_paie' => 'equired|string|max:255',
            'contact_comptabilite' => 'equired|string|max:255',
            'aj_fiche_para' => 'equired|date',
            'code_acces' => 'equired|string|max:255',
        ]);

        $client = Client::create($validatedData);

        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }

    public function edit(Client $client)
    {
        $users = User::all();
        return view('clients.edit', compact('client', 'users'));
    }

    public function update(Request $request, Client $client)
    {
        $validatedData = $request->validate([
            'name' => 'equired|string|max:255',
            'esponsable_paie_id' => 'equired|exists:users,id',
            'gestionnaire_principal_id' => 'equired|exists:users,id',
            'date_debut_prestation' => 'equired|date',
            'convention_collective' => 'equired|string|max:255',
            'contact_paie' => 'equired|string|max:255',
            'contact_comptabilite' => 'equired|string|max:255',
            'aj_fiche_para' => 'equired|date',
            'code_acces' => 'equired|string|max:255',
        ]);

        $client->update($validatedData);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
}

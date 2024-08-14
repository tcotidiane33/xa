<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Gestionnaire;
use App\Models\GestionnaireClient;
use App\Models\User;
use Illuminate\Http\Request;

class GestionnaireClientController extends Controller
{
   public function index()
{
    $relations = GestionnaireClient::with(['client', 'gestionnaire.user'])->get();
    
    return view('admin.gestionnaire-client.index', compact('relations'));
}
    
    public function create()
    {
        $clients = Client::pluck('name', 'id');
        $gestionnaires = Gestionnaire::with('user')->get()->pluck('user.name', 'id');
        $responsables = User::whereHas('roles', function($query) {
            $query->where('name', 'responsable');
        })->pluck('name', 'id');
        return view('admin.gestionnaire-client.create', compact('clients', 'gestionnaires', 'responsables'));
    }
    
    public function edit(GestionnaireClient $gestionnaireClient)
    {
        $clients = Client::pluck('name', 'id');
        $gestionnaires = Gestionnaire::with('user')->get()->pluck('user.name', 'id');
        $responsables = User::whereHas('roles', function($query) {
            $query->where('name', 'responsable');
        })->pluck('name', 'id');
        return view('admin.gestionnaire-client.edit', compact('gestionnaireClient', 'clients', 'gestionnaires', 'responsables'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'gestionnaire_id' => 'required|exists:gestionnaires,id',
            'is_principal' => 'boolean',
            'gestionnaires_secondaires' => 'nullable|array',
            'gestionnaires_secondaires.*' => 'exists:gestionnaires,id',
            'user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        if (isset($validated['gestionnaires_secondaires'])) {
            $validated['gestionnaires_secondaires'] = json_encode($validated['gestionnaires_secondaires']);
        } else {
            $validated['gestionnaires_secondaires'] = null;
        }

        $gestionnaireClient = GestionnaireClient::create($validated);

        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Relation Gestionnaire-Client créée avec succès.');
    }


    public function update(Request $request, GestionnaireClient $gestionnaireClient)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'gestionnaire_id' => 'required|exists:gestionnaires,id',
            'is_principal' => 'boolean',
            'gestionnaires_secondaires' => 'nullable|array',
            'gestionnaires_secondaires.*' => 'exists:gestionnaires,id',
            'user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        if (isset($validated['gestionnaires_secondaires'])) {
            $validated['gestionnaires_secondaires'] = json_encode($validated['gestionnaires_secondaires']);
        } else {
            $validated['gestionnaires_secondaires'] = null;
        }

        $gestionnaireClient->update($validated);

        return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Relation mise à jour avec succès.');
    }

    public function destroy(GestionnaireClient $gestionnaireClient)
    {
        $gestionnaireClient->delete();
        return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Relation supprimée avec succès.');
    }
}
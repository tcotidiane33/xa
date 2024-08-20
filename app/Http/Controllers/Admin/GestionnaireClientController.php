<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Client;
use App\Models\Gestionnaire;
use App\Models\GestionnaireClient;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Notifications\ClientAssigned;
use App\Notifications\ClientTransferred;
use App\Http\Requests\RelationsTransferts\StoreGestionnaireClientRequest;
use App\Http\Requests\RelationsTransferts\UpdateGestionnaireClientRequest;
use App\Http\Requests\RelationsTransferts\TransferGestionnaireClientRequest;

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
        $responsables = User::role('responsable')->pluck('name', 'id');
        return view('admin.gestionnaire-client.create', compact('clients', 'gestionnaires', 'responsables'));
    }
    
    public function store(StoreGestionnaireClientRequest $request)
    {
        $validated = $request->validated();
        
        $validated['gestionnaires_secondaires'] = $request->input('gestionnaires_secondaires', []);
    
        DB::transaction(function () use ($validated) {
            $gestionnaireClient = GestionnaireClient::create($validated);
    
            if ($validated['is_principal']) {
                $client = Client::find($validated['client_id']);
                $client->gestionnaire_principal_id = $validated['gestionnaire_id'];
                $client->save();
            }
    
            $gestionnaire = Gestionnaire::find($validated['gestionnaire_id']);
            $gestionnaire->user->notify(new ClientAssigned($gestionnaireClient->client));
        });
    
        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Relation Gestionnaire-Client créée avec succès.');
    }
    
    public function update(UpdateGestionnaireClientRequest $request, GestionnaireClient $gestionnaireClient)
    {
        $validated = $request->validated();
        
        $validated['gestionnaires_secondaires'] = $request->input('gestionnaires_secondaires', []);
    
        DB::transaction(function () use ($validated, $gestionnaireClient) {
            $gestionnaireClient->update($validated);
    
            if ($validated['is_principal']) {
                $client = Client::find($validated['client_id']);
                $client->gestionnaire_principal_id = $validated['gestionnaire_id'];
                $client->save();
            }
        });
    
        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Relation mise à jour avec succès.');
    }
    public function edit(GestionnaireClient $gestionnaireClient)
    {
        $clients = Client::pluck('name', 'id');
        $gestionnaires = Gestionnaire::with('user')->get()->pluck('user.name', 'id');
        $responsables = User::role('responsable')->pluck('name', 'id');
        return view('admin.gestionnaire-client.edit', compact('gestionnaireClient', 'clients', 'gestionnaires', 'responsables'));
    }

    

    public function transfer(TransferGestionnaireClientRequest $request, GestionnaireClient $gestionnaireClient)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $gestionnaireClient) {
            $oldGestionnaire = $gestionnaireClient->gestionnaire;
            $newGestionnaire = Gestionnaire::find($validated['new_gestionnaire_id']);

            $gestionnaireClient->gestionnaire_id = $newGestionnaire->id;
            $gestionnaireClient->save();

            if ($gestionnaireClient->is_principal) {
                $client = $gestionnaireClient->client;
                $client->gestionnaire_principal_id = $newGestionnaire->id;
                $client->save();
            }

            $newGestionnaire->user->notify(new ClientTransferred($gestionnaireClient->client, $oldGestionnaire->user));
            $oldGestionnaire->user->notify(new ClientTransferred($gestionnaireClient->client, $newGestionnaire->user));
        });

        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Client transféré avec succès.');
    }

    public function destroy(GestionnaireClient $gestionnaireClient)
    {
        $gestionnaireClient->delete();
        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Relation supprimée avec succès.');
    }
}

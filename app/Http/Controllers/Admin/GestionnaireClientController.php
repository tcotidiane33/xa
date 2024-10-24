<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\GestionnaireClient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\RelationCreated;
use App\Notifications\RelationUpdated;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\RelationsTransferts\StoreGestionnaireClientRequest;
use App\Http\Requests\RelationsTransferts\UpdateGestionnaireClientRequest;
use App\Http\Requests\RelationsTransferts\TransferGestionnaireClientRequest;

class GestionnaireClientController extends Controller
{
    public function index()
    {
        $relations = GestionnaireClient::with(['client', 'gestionnaire'])->get();
        return view('admin.gestionnaire-client.index', compact('relations'));
    }

    public function create()
    {
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
        return view('admin.gestionnaire-client.create', compact('clients', 'gestionnaires'));
    }

    public function store(StoreGestionnaireClientRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
    
            // Vérifier si la relation existe déjà
            $existingRelation = GestionnaireClient::where('client_id', $validated['client_id'])
                ->where('gestionnaire_id', $validated['gestionnaire_id'])
                ->first();
    
            if ($existingRelation) {
                return redirect()->back()->with('error', 'Cette relation existe déjà.');
            }
    
            $gestionnaireClient = GestionnaireClient::create([
                'client_id' => $validated['client_id'],
                'gestionnaire_id' => $validated['gestionnaire_id'],
                'is_principal' => $validated['is_principal'] ?? false,
                'gestionnaires_secondaires' => $validated['gestionnaires_secondaires'] ?? [],
            ]);
    
            DB::commit();
    
            // Envoyer une notification
            Notification::send($gestionnaireClient->gestionnaire, new RelationCreated($gestionnaireClient, auth()->user()));
    
            return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Relation créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    
    public function update(UpdateGestionnaireClientRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
    
            $gestionnaireClient = GestionnaireClient::findOrFail($id);
            $gestionnaireClient->update([
                'client_id' => $validated['client_id'],
                'gestionnaire_id' => $validated['gestionnaire_id'],
                'is_principal' => $validated['is_principal'] ?? false,
                'gestionnaires_secondaires' => $validated['gestionnaires_secondaires'] ?? [],
            ]);
    
            DB::commit();
    
            // Envoyer une notification
            Notification::send($gestionnaireClient->gestionnaire, new RelationUpdated($gestionnaireClient, auth()->user()));
    
            return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Relation mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $relation = GestionnaireClient::findOrFail($id);
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
        return view('admin.gestionnaire-client.edit', compact('relation', 'clients', 'gestionnaires'));
    }

   

    public function destroy($id)
    {
        $gestionnaireClient = GestionnaireClient::findOrFail($id);
        $gestionnaireClient->delete();

        return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Relation supprimée avec succès.');
    }

    public function transfer(TransferGestionnaireClientRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $client = Client::findOrFail($validated['client_id']);
            $oldGestionnaireId = $client->gestionnaire_principal_id;
            $client->update([
                'gestionnaire_principal_id' => $validated['new_gestionnaire_id'],
            ]);

            // Mettre à jour la relation dans la table pivot
            GestionnaireClient::where('client_id', $client->id)
                ->where('gestionnaire_id', $oldGestionnaireId)
                ->update(['gestionnaire_id' => $validated['new_gestionnaire_id']]);

            DB::commit();

            // Envoyer une notification
            Notification::send(User::find($validated['new_gestionnaire_id']), new RelationUpdated($client, auth()->user()));

            return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Client transféré avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function attach(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'gestionnaire_id' => 'required|exists:users,id',
                'is_principal' => 'nullable|boolean',
            ]);

            // Vérifier si la relation existe déjà
            $existingRelation = GestionnaireClient::where('client_id', $validated['client_id'])
                ->where('gestionnaire_id', $validated['gestionnaire_id'])
                ->first();

            if ($existingRelation) {
                return redirect()->back()->with('error', 'Cette relation existe déjà.');
            }

            $client = Client::findOrFail($validated['client_id']);
            $gestionnaireClient = GestionnaireClient::create([
                'client_id' => $validated['client_id'],
                'gestionnaire_id' => $validated['gestionnaire_id'],
                'is_principal' => $validated['is_principal'] ?? false,
            ]);

            if ($validated['is_principal']) {
                $client->update(['gestionnaire_principal_id' => $validated['gestionnaire_id']]);
            }

            DB::commit();

            // Envoyer une notification
            Notification::send(User::find($validated['gestionnaire_id']), new RelationCreated($gestionnaireClient, auth()->user()));

            return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Gestionnaire rattaché avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
}
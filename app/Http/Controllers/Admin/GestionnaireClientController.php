<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Client;
use App\Models\Document;
use App\Models\Gestionnaire;
use App\Models\GestionnaireClient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\ClientAssigned;
use App\Notifications\ClientTransferred;
use App\Http\Requests\RelationsTransferts\StoreGestionnaireClientRequest;
use App\Http\Requests\RelationsTransferts\UpdateGestionnaireClientRequest;
use App\Http\Requests\RelationsTransferts\TransferGestionnaireClientRequest;

class GestionnaireClientController extends Controller
{
    public function index(Request $request)
    {
        $query = GestionnaireClient::with(['client', 'gestionnaire.user', 'responsablePaie']);

        // Apply filters
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        if ($request->filled('gestionnaire_id')) {
            $query->where('gestionnaire_id', $request->gestionnaire_id);
        }
        if ($request->filled('is_principal')) {
            $query->where('is_principal', $request->is_principal);
        }

        $relations = $query->paginate(10);

        $clients = Client::pluck('name', 'id');
        $gestionnaires = Gestionnaire::with('user')->get()->pluck('user.name', 'id');

        return view('admin.gestionnaire-client.index', compact('relations', 'clients', 'gestionnaires'));
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

        DB::beginTransaction();
        try {
            $gestionnaireClient = GestionnaireClient::create([
                'gestionnaire_id' => $validated['gestionnaire_id'],
                'client_id' => $validated['client_id'],
                'is_principal' => $validated['is_principal'] ?? false,
                'gestionnaires_secondaires' => $validated['gestionnaires_secondaires'] ?? null,
                'user_id' => auth()->id(),
                'notes' => $validated['notes'] ?? null,
            ]);

            if ($validated['is_principal']) {
                $client = Client::findOrFail($validated['client_id']);
                $client->gestionnaire_principal_id = $validated['gestionnaire_id'];
                $client->save();
            }

            DB::commit();

            return redirect()->route('admin.gestionnaire-client.index')
                ->with('success', 'Relation Gestionnaire-Client créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la relation : ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(GestionnaireClient $gestionnaireClient)
    {
        $clients = Client::pluck('name', 'id');
        $gestionnaires = Gestionnaire::with('user')->get()->pluck('user.name', 'id');
        $responsables = User::role('responsable')->pluck('name', 'id');
        return view('admin.gestionnaire-client.edit', compact('gestionnaireClient', 'clients', 'gestionnaires', 'responsables'));
    }

    public function update(UpdateGestionnaireClientRequest $request, GestionnaireClient $gestionnaireClient)
    {
        $validated = $request->validated();
        $validated['gestionnaires_secondaires'] = $request->input('gestionnaires_secondaires', []);

        DB::transaction(function () use ($validated, $request, $gestionnaireClient) {
            $gestionnaireClient->update($validated);

            if ($validated['is_principal']) {
                $client = Client::find($validated['client_id']);
                $client->gestionnaire_principal_id = $validated['gestionnaire_id'];
                $client->save();
            }

            if ($request->hasFile('document')) {
                $path = $request->file('document')->store('documents');
                Document::create([
                    'gestionnaire_client_id' => $gestionnaireClient->id,
                    'file_path' => $path
                ]);
            }
        });

        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Relation mise à jour avec succès.');
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

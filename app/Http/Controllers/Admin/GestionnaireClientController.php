<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Client;
use App\Models\Document;
use App\Models\Gestionnaire;
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
    public function index(Request $request)
    {
        \Log::info('Début de la méthode index');

        $query = GestionnaireClient::with(['client', 'gestionnaire', 'responsablePaie']);

        // Appliquer les filtres existants
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        if ($request->filled('gestionnaire_id')) {
            $query->where('gestionnaire_id', $request->gestionnaire_id);
        }
        if ($request->filled('is_principal')) {
            $query->where('is_principal', $request->is_principal);
        }

        $relationsLinks = $query->paginate(10);
        $relationsQuery = $query->get();
        \Log::info('Nombre de relations récupérées : ' . $relationsQuery->count());

        // $clients = Client::pluck('name', 'id');
        // $gestionnaires = User::role('gestionnaire')->pluck('name', 'id');
        $relations = GestionnaireClient::with(['client', 'gestionnaire', 'responsablePaie'])->get();
        $clients = Client::pluck('name', 'id')->toArray();
        $gestionnaires = User::role('gestionnaire')->pluck('name', 'id')->toArray();

        \Log::info('Nombre de clients : ' . count($clients));
        \Log::info('Nombre de gestionnaires : ' . count($gestionnaires));

        
        // Assurez-vous que ces variables ne sont pas null
        $principalCount = GestionnaireClient::where('is_principal', true)->count() ?? 0;
        $secondaryCount = GestionnaireClient::where('is_principal', false)->count() ?? 0;
       
        \Log::info('Principal count : ' . $principalCount);
        \Log::info('Secondary count : ' . $secondaryCount);
    
        // Données pour le graphique des top 5 gestionnaires
        $topGestionnaires = User::withCount('clientsAsManager')
            ->orderByDesc('clients_as_manager_count')
            ->take(5)
            ->get();
            \Log::info('Top gestionnaires : ' . $topGestionnaires->toJson());

        // $topGestionnairesData = $topGestionnaires->pluck('clients_as_manager_count');
        // $topGestionnairesData = $topGestionnaires->pluck('clients_as_manager_count')->toArray() ?? [];
        // $topGestionnairesLabels = $topGestionnaires->pluck('name')->toArray() ?? [];
        $topGestionnairesData = $topGestionnaires->pluck('clients_as_manager_count')->map(function($count) {
            return $count ?? 0;
        })->toArray();
        
        $topGestionnairesLabels = $topGestionnaires->pluck('name')->map(function($name) {
            return $name ?? 'Sans nom';
        })->toArray();
        // Données pour le graphique d'évolution du nombre de relations
        $relationsEvolution = GestionnaireClient::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        \Log::info('Relations evolution : ' . $relationsEvolution->toJson());

        $relationsEvolutionData = $relationsEvolution->pluck('count')->toArray() ?? [];
        $relationsEvolutionLabels = $relationsEvolution->pluck('month')->toArray() ?? [];
        // $relationsEvolutionData = $relationsEvolution->pluck('count');
        // $relationsEvolutionLabels = $relationsEvolution->pluck('month');
      
        \Log::info('Fin de la méthode index');

        $gestionnaires = User::role('gestionnaire')->pluck('name', 'id');

        return view('admin.gestionnaire-client.index', compact(
            'relations',
            'relationsLinks',
            'clients',
            'gestionnaires',
            'principalCount',
            'secondaryCount',
            'topGestionnairesData',
            'topGestionnairesLabels',
            'relationsEvolutionData',
            'relationsEvolutionLabels'
        ));
    }
    public function create()
    {
        $clients = Client::pluck('name', 'id');
        $gestionnaires = User::role('gestionnaire')->pluck('name', 'id');
        $superviseurs = User::role('superviseur')->pluck('name', 'id');

        return view('admin.gestionnaire-client.create', compact('clients', 'gestionnaires', 'superviseurs'));
    }
    public function edit(GestionnaireClient $gestionnaireClient)
    {
        $clients = Client::pluck('name', 'id');
        $gestionnaires = User::role('gestionnaire')->pluck('name', 'id');
        $superviseurs = User::role('superviseur')->pluck('name', 'id');
        $responsables = User::role('responsable')->pluck('name', 'id'); // Ajoutez cette ligne

        return view('admin.gestionnaire-client.edit', compact('gestionnaireClient', 'clients', 'gestionnaires', 'superviseurs', 'responsables'));
    }
    public function getClientInfo($id)
    {
        $client = Client::findOrFail($id);
    
        $responsablePaie = $client->responsablePaie ? $client->responsablePaie->name : 'Non assigné';
        $gestionnairePrincipal = $client->gestionnairePrincipal ? $client->gestionnairePrincipal->name : 'Non assigné';
        $conventionCollective = $client->conventionCollective ? $client->conventionCollective->name : 'Non assignée';
    
        return response()->json([
            'name' => $client->name ?? 'N/A',
            'email' => $client->contact_paie ?? 'Non spécifié',
            'phone' => $client->contact_comptabilite ?? 'Non spécifié',
            'responsable_paie' => $responsablePaie,
            'gestionnaire_principal' => $gestionnairePrincipal,
            'date_debut_prestation' => $client->date_debut_prestation ? $client->date_debut_prestation->format('d/m/Y') : 'Non spécifiée',
            'date_estimative_envoi_variables' => $client->date_estimative_envoi_variables ? $client->date_estimative_envoi_variables->format('d/m/Y') : 'Non spécifiée',
            'status' => $client->status ?? 'Non spécifié',
            'nb_bulletins' => $client->nb_bulletins ?? 'Non spécifié',
            'convention_collective' => $conventionCollective
        ]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'gestionnaire_principal_id' => 'required|exists:users,id',
                'gestionnaires_secondaires' => 'nullable|array',
                'gestionnaires_secondaires.*' => 'exists:users,id',
                'superviseur_id' => 'required|exists:users,id',
                'notes' => 'nullable|string',
                'document' => 'nullable|file|max:10240',
            ]);

            $gestionnaireClient = GestionnaireClient::create([
                'client_id' => $validated['client_id'],
                'gestionnaire_id' => $validated['gestionnaire_principal_id'],
                'is_principal' => true,
                'user_id' => $validated['superviseur_id'],
                'gestionnaires_secondaires' => $validated['gestionnaires_secondaires'] ?? [],
                'notes' => $validated['notes'] ?? null,
            ]);

            if ($request->hasFile('document')) {
                $path = $request->file('document')->store('documents');
                Document::create([
                    'gestionnaire_client_id' => $gestionnaireClient->id,
                    'file_path' => $path,
                    'path' => $path, // Ajoutez cette ligne
                    'name' => $request->file('document')->getClientOriginalName(),
                    'client_id' => $validated['client_id'],
                ]);
            }

            Client::where('id', $validated['client_id'])
                ->update(['gestionnaire_principal_id' => $validated['gestionnaire_principal_id']]);

            // Envoyer des notifications
            $usersToNotify = collect([$gestionnaireClient->client->responsablePaie, $gestionnaireClient->gestionnaire])
            ->merge($gestionnaireClient->gestionnairesSecondaires() ?? [])
            ->push($gestionnaireClient->client)
            ->filter()
            ->unique();

            Notification::send($usersToNotify, new RelationCreated($gestionnaireClient, auth()->user()));

            DB::commit();
            return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Relation créée avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur création relation: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function update(UpdateGestionnaireClientRequest $request, GestionnaireClient $gestionnaireClient)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $gestionnaireClient) {
            $gestionnaireClient->update([
                'gestionnaire_id' => $validated['gestionnaire_id'],
                'is_principal' => $validated['is_principal'] ?? false,
                'gestionnaires_secondaires' => $validated['gestionnaires_secondaires'] ?? [],
                'notes' => $validated['notes'] ?? null,
            ]);

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

            // Envoyer des notifications
            $this->sendNotifications($gestionnaireClient, 'modification');
        });

        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Relation mise à jour avec succès.');
    }

    public function transfer(TransferGestionnaireClientRequest $request, GestionnaireClient $gestionnaireClient)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $gestionnaireClient) {
            $oldGestionnaire = $gestionnaireClient->gestionnaire;
            $newGestionnaire = User::findOrFail($validated['new_gestionnaire_id']);
            $client = $gestionnaireClient->client;

            // Mise à jour de la relation GestionnaireClient
            $gestionnaireClient->update([
                'gestionnaire_id' => $newGestionnaire->id
            ]);

            // Mise à jour du client si c'était le gestionnaire principal
            if ($gestionnaireClient->is_principal) {
                $client->update([
                    'gestionnaire_principal_id' => $newGestionnaire->id
                ]);
            }

            // Mise à jour des gestionnaires (si nécessaire)
            $oldGestionnaire->clientsAsManager()->detach($client->id);
            $newGestionnaire->clientsAsManager()->attach($client->id, ['is_principal' => $gestionnaireClient->is_principal]);

            // Envoyer des notifications
            $this->sendTransferNotifications($gestionnaireClient, $oldGestionnaire, $newGestionnaire);
        });

        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Client transféré avec succès.');
    }

    public function transfertMasse(Request $request)
{
    $request->validate([
        'ancien_gestionnaire_id' => 'required|exists:users,id',
        'nouveau_gestionnaire_id' => 'required|exists:users,id',
        'clients' => 'required|array',
        'clients.*' => 'exists:clients,id',
    ]);

    DB::beginTransaction();
    try {
        $ancienGestionnaire = User::findOrFail($request->ancien_gestionnaire_id);
        $nouveauGestionnaire = User::findOrFail($request->nouveau_gestionnaire_id);
        $clients = Client::whereIn('id', $request->clients)->get();

        foreach ($clients as $client) {
            $gestionnaireClient = GestionnaireClient::where('client_id', $client->id)
                ->where('gestionnaire_id', $ancienGestionnaire->id)
                ->first();

            if ($gestionnaireClient) {
                $gestionnaireClient->update(['gestionnaire_id' => $nouveauGestionnaire->id]);

                if ($gestionnaireClient->is_principal) {
                    $client->update(['gestionnaire_principal_id' => $nouveauGestionnaire->id]);
                }

                // Envoyer une notification pour chaque transfert
                $this->sendTransferNotifications($gestionnaireClient, $ancienGestionnaire, $nouveauGestionnaire);
            }
        }

        DB::commit();
        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Transfert en masse effectué avec succès.');
    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('Erreur lors du transfert en masse : ' . $e->getMessage());
        return back()->withInput()->with('error', 'Erreur: ' . $e->getMessage());
    }
}

private function sendTransferNotifications($gestionnaireClient, $ancienGestionnaire, $nouveauGestionnaire)
{
    $client = $gestionnaireClient->client;
    $detailsMessage = "Client: {$client->name}, Ancien gestionnaire: {$ancienGestionnaire->name}, Nouveau gestionnaire: {$nouveauGestionnaire->name}";

    $usersToNotify = [
        $ancienGestionnaire,
        $nouveauGestionnaire,
        $client->responsablePaie,
        $client
    ];

    Notification::send($usersToNotify, new RelationUpdated('transfert', $detailsMessage, [
        'client_id' => $client->id,
        'ancien_gestionnaire_id' => $ancienGestionnaire->id,
        'nouveau_gestionnaire_id' => $nouveauGestionnaire->id
    ]));
}
    // private function sendTransferNotifications(GestionnaireClient $gestionnaireClient, User $oldGestionnaire, User $newGestionnaire)
    // {
    //     $client = $gestionnaireClient->client;
    //     $detailsMessage = "Client: {$client->name}, Ancien gestionnaire: {$oldGestionnaire->name}, Nouveau gestionnaire: {$newGestionnaire->name}";

    //     $usersToNotify = [
    //         $oldGestionnaire,
    //         $newGestionnaire,
    //         $client->responsablePaie,
    //         // Ajoutez d'autres utilisateurs si nécessaire
    //     ];

    //     Notification::send($usersToNotify, new RelationUpdated('transfert', $detailsMessage));

    //     // Log de la notification
    //     \Log::info("Notification de transfert envoyée", [
    //         'action' => 'transfert',
    //         'details' => $detailsMessage,
    //         'users' => $usersToNotify->pluck('id')->toArray()
    //     ]);
    // }
    
}
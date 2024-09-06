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

        $query = Client::with([
            'gestionnaires' => function ($query) {
                $query->withPivot('is_principal');
            },
            'responsablePaie'
        ]);

        // Appliquer les filtres
        if ($request->filled('client_id')) {
            $query->where('id', $request->client_id);
        }
        if ($request->filled('gestionnaire_id')) {
            $query->whereHas('gestionnaires', function ($q) use ($request) {
                $q->where('users.id', $request->gestionnaire_id);
            });
        }
        if ($request->filled('is_principal')) {
            $query->whereHas('gestionnaires', function ($q) use ($request) {
                $q->where('gestionnaire_client_pivot.is_principal', $request->is_principal);
            });
        }

        $relationsLinks = $query->paginate(10);
        $relationsQuery = $query->get();
        \Log::info('Nombre de relations récupérées : ' . $relationsQuery->count());

        $relations = GestionnaireClient::with(['client', 'gestionnaire', 'responsablePaie'])->get();

        $clients = $query->paginate(10);
        $clientsList = Client::pluck('name', 'id');
        $gestionnaires = User::role('gestionnaire')->pluck('name', 'id')->toArray();

        \Log::info('Nombre de clients : ' . count($clients));
        \Log::info('Nombre de gestionnaires : ' . count($gestionnaires));


        // Assurez-vous que ces variables ne sont pas null
        $principalCount = Client::whereHas('gestionnaires', function ($q) {
            $q->where('gestionnaire_client_pivot.is_principal', true);
        })->count();

        $secondaryCount = Client::whereHas('gestionnaires', function ($q) {
            $q->where('gestionnaire_client_pivot.is_principal', false);
        })->count();


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
        $topGestionnairesData = $topGestionnaires->pluck('clients_as_manager_count')->map(function ($count) {
            return $count ?? 0;
        })->toArray();

        $topGestionnairesLabels = $topGestionnaires->pluck('name')->map(function ($name) {
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

        // Autres données pour la vue
        $gestionnaires = User::role('gestionnaire')->get(['id', 'name']);
        $stats = $this->getStats();
        \Log::info('Fin de la méthode index');

        $gestionnaires = User::role('gestionnaire')->pluck('name', 'id');

        return view('admin.gestionnaire-client.index', compact(
            'stats',
            'relations',
            'relationsLinks',
            'clients',
            'clientsList',
            'gestionnaires',
            'principalCount',
            'secondaryCount',
            'topGestionnairesData',
            'topGestionnairesLabels',
            'relationsEvolutionData',
            'relationsEvolutionLabels'
        ));
    }
    private function getStats()
{
    return [
        'principalCount' => DB::table('gestionnaire_client_pivot')->where('is_principal', true)->count(),
        'secondaryCount' => DB::table('gestionnaire_client_pivot')->where('is_principal', false)->count(),
        'topGestionnaires' => User::withCount([
            'clientsGeres' => function ($q) {
                $q->where('gestionnaire_client_pivot.is_principal', true);
            }
        ])
            ->orderByDesc('clients_geres_count')
            ->take(5)
            ->get(['id', 'name', 'clients_geres_count']),
        'relationsEvolution' => DB::table('gestionnaire_client_pivot')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
    ];
}
    public function create()
    {
        $clients = Client::pluck('name', 'id');
        $gestionnaires = User::role('gestionnaire')->pluck('name', 'id');
        $superviseurs = User::role('superviseur')->pluck('name', 'id');

        return view('admin.gestionnaire-client.create', compact('clients', 'gestionnaires', 'superviseurs'));
    }
    public function show(GestionnaireClient $gestionnaireClient)
    {
        // Chargez les relations nécessaires
        $gestionnaireClient->load(['client', 'gestionnaire', 'gestionnairesSecondaires']);

        return view('admin.gestionnaire-client.show', compact('gestionnaireClient'));
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


    public function store(StoreGestionnaireClientRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $client = Client::findOrFail($validated['client_id']);

            // Attacher le gestionnaire principal
            $client->gestionnaires()->attach($validated['gestionnaire_principal_id'], [
                'is_principal' => true,
                'user_id' => $validated['superviseur_id'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Attacher les gestionnaires secondaires
            if (!empty($validated['gestionnaires_secondaires'])) {
                $client->gestionnaires()->attach($validated['gestionnaires_secondaires'], [
                    'is_principal' => false,
                    'user_id' => $validated['superviseur_id'],
                ]);
            }

            // Mettre à jour le gestionnaire principal du client
            $client->update(['gestionnaire_principal_id' => $validated['gestionnaire_principal_id']]);

            // Gérer le document si présent
            if ($request->hasFile('document')) {
                $path = $request->file('document')->store('documents');
                $client->documents()->create([
                    'file_path' => $path,
                    'name' => $request->file('document')->getClientOriginalName(),
                ]);
            }

            // Préparer et envoyer les notifications
            $usersToNotify = $this->getUsersToNotify($client, $validated['gestionnaire_principal_id'], $validated['gestionnaires_secondaires'] ?? []);
            Notification::send($usersToNotify, new RelationCreated($client, auth()->user()));

            DB::commit();
            return redirect()->route('admin.gestionnaire-client.index')->with('success', 'Relation créée avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur création relation: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    private function getUsersToNotify($client, $gestionnaireId, $gestionnaireSecondairesIds)
    {
        return User::whereIn('id', array_merge(
            [$client->responsable_paie_id, $gestionnaireId],
            $gestionnaireSecondairesIds
        ))->get()->push($client)->unique();
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

    public function transfer(TransferGestionnaireClientRequest $request, Client $client)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $client) {
            $oldGestionnaire = $client->gestionnairePrincipal;
            $newGestionnaire = User::findOrFail($validated['new_gestionnaire_id']);

            $client->transferGestionnaire($oldGestionnaire->id, $newGestionnaire->id, true);

            $this->sendTransferNotifications($client, $oldGestionnaire, $newGestionnaire);
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

        DB::transaction(function () use ($request) {
            $clients = Client::whereIn('id', $request->clients)->get();
            foreach ($clients as $client) {
                $client->transferGestionnaire($request->ancien_gestionnaire_id, $request->nouveau_gestionnaire_id, true);
                $this->sendTransferNotifications($client, User::find($request->ancien_gestionnaire_id), User::find($request->nouveau_gestionnaire_id));
            }
        });

        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Transfert en masse effectué avec succès.');
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
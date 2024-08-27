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
use App\Notifications\RelationUpdated;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\RelationsTransferts\StoreGestionnaireClientRequest;
use App\Http\Requests\RelationsTransferts\UpdateGestionnaireClientRequest;
use App\Http\Requests\RelationsTransferts\TransferGestionnaireClientRequest;

class GestionnaireClientController extends Controller
{
    public function index(Request $request)
    {
        $query = GestionnaireClient::with(['client', 'gestionnaire.user', 'responsablePaie']);

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
        $gestionnaires = User::role('gestionnaire')->pluck('name', 'id');
        $superviseurs = User::role('superviseur')->pluck('name', 'id');

        return view('admin.gestionnaire-client.create', compact('clients', 'gestionnaires', 'superviseurs'));
    }
    public function getClientInfo($id)
    {
        $client = Client::findOrFail($id);

        // Vérification des relations
        $responsablePaie = $client->responsablePaie ? $client->responsablePaie->name : 'Non assigné';
        $gestionnairePrincipal = $client->gestionnairePrincipal ? $client->gestionnairePrincipal->name : 'Non assigné';
        $conventionCollective = $client->conventionCollective ? $client->conventionCollective->name : 'Non assignée';

        return response()->json([
            'name' => $client ? $client->name : 'N/A',
            'email' => $client->contact_paie ?? 'Non spécifié',
            'phone' => $client->contact_comptabilite ?? 'Non spécifié',
            'responsable_paie' => $responsablePaie,
            'gestionnaire_principal' => $gestionnairePrincipal,
            'date_debut_prestation' => $client->date_debut_prestation ? $client->date_debut_prestation->format('d/m/Y') : 'Non spécifiée',
            'date_estimative_envoi_variables' => $client->date_estimative_envoi_variables ? $client->date_estimative_envoi_variables->format('d/m/Y') : 'Non spécifiée',
            'status' => $client->status,
            'nb_bulletins' => $client->nb_bulletins,
            'convention_collective' => $conventionCollective
        ]);
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'gestionnaire_principal_id' => 'required|exists:users,id',
                'gestionnaires_secondaires' => 'nullable|array',
                'gestionnaires_secondaires.*' => 'exists:users,id',
                'superviseur_id' => 'required|exists:users,id',
                'notes' => 'nullable|string',
            ]);

            // $relation = GestionnaireClient::create([
            //     'client_id' => $validated['client_id'],
            //     'gestionnaire_id' => $validated['gestionnaire_principal_id'],
            //     'is_principal' => true,
            //     'gestionnaires_secondaires' => $validated['gestionnaires_secondaires'] ?? [],
            //     'user_id' => $validated['superviseur_id'],
            //     'notes' => $validated['notes'] ?? null,
            // ]);


            DB::transaction(function () use ($validated, $request) {
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
                        'file_path' => $path
                    ]);
                }

                // Mise à jour du gestionnaire principal du client
                $client = Client::find($validated['client_id']);
                $client->gestionnaire_principal_id = $validated['gestionnaire_principal_id'];
                $client->save();

                // Envoyer des notifications
                $this->sendNotifications($gestionnaireClient, 'création');
            });

            return redirect()->route('admin.gestionnaire-client.index')
                ->with('success', 'Relation Gestionnaire-Client créée avec succès.');

        } catch (\Exception $e) {
            // Log l'erreur
            \Log::error('Erreur lors de la création de la relation : ' . $e->getMessage());

            // Retourner l'erreur détaillée (à utiliser uniquement en développement)
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
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
            $newGestionnaire = Gestionnaire::find($validated['new_gestionnaire_id']);

            if ($gestionnaireClient->is_principal) {
                $gestionnaireClient->client->gestionnaire_principal_id = $newGestionnaire->id;
                $gestionnaireClient->client->save();
            }

            $gestionnaireClient->gestionnaire_id = $newGestionnaire->id;
            $gestionnaireClient->save();

            // Envoyer des notifications
            $this->sendNotifications($gestionnaireClient, 'transfert', $oldGestionnaire);
        });

        return redirect()->route('admin.gestionnaire-client.index')
            ->with('success', 'Client transféré avec succès.');
    }

    private function sendNotifications(GestionnaireClient $gestionnaireClient, $action, $oldGestionnaire = null)
    {
        $detailsMessage = "Client: " . ($gestionnaireClient->client->name ?? 'N/A') .
            ", Gestionnaire: " . ($gestionnaireClient->gestionnaire->user->name ?? 'N/A');

        $usersToNotify = [
            $gestionnaireClient->gestionnaire->user ?? null,
            $gestionnaireClient->client->responsablePaie ?? null,
            $gestionnaireClient->responsablePaie ?? null,
        ];

        // Filtrer les valeurs null
        $usersToNotify = array_filter($usersToNotify);

        if ($oldGestionnaire) {
            $usersToNotify[] = $oldGestionnaire->user ?? null;
        }

        foreach ($gestionnaireClient->gestionnairesSecondaires as $secondaryGestionnaire) {
            $usersToNotify[] = $secondaryGestionnaire ?? null;
        }

        // Filtrer à nouveau pour enlever les éventuelles valeurs null
        $usersToNotify = array_filter($usersToNotify);

        foreach ($usersToNotify as $user) {
            $user->notify(new RelationUpdated($action, $detailsMessage));
        }

        // Log de la notification
        \Log::info("Notification envoyée", [
            'action' => $action,
            'details' => $detailsMessage,
            'users' => $usersToNotify->pluck('id')
        ]);
    }
}
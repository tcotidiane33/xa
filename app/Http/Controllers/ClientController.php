<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ClientHistory;
use Illuminate\Support\Facades\DB;
use App\Models\ConventionCollective;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientManagerChangeMail;
use App\Notifications\RelationUpdated;
use App\Mail\ClientAcknowledgementMail;
use App\Notifications\NewClientCreated;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        $query = Client::with(['responsablePaie', 'gestionnairePrincipal', 'conventionCollective']);

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $clients = $query->paginate(15);

        $clientGrowthData = Client::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count');
        $clientGrowthLabels = Client::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('month');

        $topConventions = ConventionCollective::withCount('clients')
            ->orderByDesc('clients_count')
            ->take(5)
            ->get();
        $topConventionsData = $topConventions->pluck('clients_count');
        $topConventionsLabels = $topConventions->pluck('name');

        $clientsByManager = User::whereHas('clientsGestionnairePrincipal')
            ->withCount('clientsGestionnairePrincipal')
            ->orderByDesc('clients_gestionnaire_principal_count')
            ->take(10)
            ->get();
        $clientsByManagerData = $clientsByManager->pluck('clients_gestionnaire_principal_count')->toArray();
        $clientsByManagerLabels = $clientsByManager->pluck('name')->toArray();

        return view('clients.index', compact(
            'clients',
            'clientGrowthData',
            'clientGrowthLabels',
            'topConventionsData',
            'topConventionsLabels',
            'clientsByManagerData',
            'clientsByManagerLabels'
        ));
    }

    public function create()
    {
        $users = User::all();
        $conventionCollectives = ConventionCollective::all();
        $clients = Client::all();
        return view('clients.create', compact('users', 'conventionCollectives', 'clients'));
    }

    public function store(StoreClientRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            $client = Client::create($validatedData);

            // Ajouter les relations
            if (isset($validatedData['responsable_paie_id'])) {
                $client->responsablePaie()->associate($validatedData['responsable_paie_id']);
            }
            if (isset($validatedData['gestionnaire_principal_id'])) {
                $client->gestionnairePrincipal()->associate($validatedData['gestionnaire_principal_id']);
            }
            if (isset($validatedData['convention_collective_id'])) {
                $client->conventionCollective()->associate($validatedData['convention_collective_id']);
            }
            if (isset($validatedData['portfolio_cabinet_id'])) {
                $client->portfolioCabinet()->associate($validatedData['portfolio_cabinet_id']);
            }
            $client->save();

            // Envoyer les emails
            $manager = $client->gestionnairePrincipal;
            $binome = $client->binome;
            $responsablePaie = $client->responsablePaie;

            $emails = [
                $client->contact_paie_email,
                $client->contact_compta_email,
                $manager->email,
                $binome->email,
                $responsablePaie->email,
            ];

            Mail::to($client->contact_paie_email)
                ->cc($emails)
                ->send(new ClientAcknowledgementMail($manager, $client));
            Mail::to($client->contact_compta_email)
                ->cc($emails)
                ->send(new ClientManagerChangeMail($manager));

            DB::commit();
            return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Erreur lors de la création du client: " . $e->getMessage());
            return redirect()->back()->withErrors('Erreur lors de la création du client.');
        }
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $validated = $request->validated();

        $client = Client::findOrFail($id);
        $client->update($validated);

        if (isset($validated['maj_fiche_para'])) {
            ClientHistory::create([
                'client_id' => $client->id,
                'maj_fiche_para' => $validated['maj_fiche_para'],
            ]);
        }

        if (isset($validated['gestionnaires_secondaires'])) {
            $client->gestionnaires_secondaires = $validated['gestionnaires_secondaires'];
            $client->save();
        }

        // Envoyer les emails
        $emails = [
            $client->contact_paie_email,
            $client->contact_compta_email,
        ];

        Mail::to($client->contact_paie_email)
            ->cc($emails)
            ->send(new ClientAcknowledgementMail($client->gestionnairePrincipal, $client));
        Mail::to($client->contact_compta_email)
            ->cc($emails)
            ->send(new ClientManagerChangeMail($client->gestionnairePrincipal));

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }
    public function edit(Client $client)
    {
        $users = User::all();
        $conventionCollectives = ConventionCollective::all();
        $clients = Client::all();
        return view('clients.edit', compact('client', 'users', 'conventionCollectives', 'clients'));
    }

    public function show(Client $client)
    {
        $client->load(['responsablePaie', 'gestionnairePrincipal', 'conventionCollective', 'portfolioCabinet']);
        return view('clients.show', compact('client'));
    }

    public function destroy(Client $client)
    {
        DB::transaction(function () use ($client) {
            $client->gestionnaires()->detach();
            $client->delete();
        });

        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }

    public function getInfo(Client $client)
    {
        return response()->json([
            'name' => $client->name,
            'email' => $client->contact_paie,
            'phone' => $client->contact_comptabilite,
            'saisie_variables' => $client->saisie_variables,
            'client_forme_saisie' => $client->client_forme_saisie,
            'date_formation_saisie' => $client->date_formation_saisie,
            'date_debut_prestation' => $client->date_debut_prestation,
            'date_fin_prestation' => $client->date_fin_prestation,
            'date_signature_contrat' => $client->date_signature_contrat,
            'taux_at' => $client->taux_at,
            'adhesion_mydrh' => $client->adhesion_mydrh,
            'date_adhesion_mydrh' => $client->date_adhesion_mydrh,
            'is_cabinet' => $client->is_cabinet,
            'portfolio_cabinet_id' => $client->portfolio_cabinet_id,
        ]);
    }
    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'client_ids' => 'required|array',
            'client_ids.*' => 'exists:clients,id',
            'new_gestionnaire_id' => 'required|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['client_ids'] as $clientId) {
                $client = Client::findOrFail($clientId);
                $client->transferGestionnaire($client->gestionnaire_principal_id, $validated['new_gestionnaire_id'], true);
            }

            DB::commit();
            return redirect()->route('admin.clients.index')->with('success', 'Clients transférés avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function validateStep(Request $request, $step)
    {
        $rules = [];

        switch ($step) {
            case 'societe':
                $rules = [
                    'name' => 'required|string|max:255',
                    'type_societe' => 'nullable|string|max:255',
                    'ville' => 'nullable|string|max:255',
                    'dirigeant_nom' => 'nullable|string|max:255',
                    'dirigeant_telephone' => 'nullable|string|max:20',
                    'dirigeant_email' => 'nullable|email|max:255',
                ];
                break;

            case 'contacts':
                $rules = [
                    'contact_paie_nom' => 'nullable|string|max:255',
                    'contact_paie_prenom' => 'nullable|string|max:255',
                    'contact_paie_telephone' => 'nullable|string|max:20',
                    'contact_paie_email' => 'nullable|email|max:255',
                    'contact_compta_nom' => 'nullable|string|max:255',
                    'contact_compta_prenom' => 'nullable|string|max:255',
                    'contact_compta_telephone' => 'nullable|string|max:20',
                    'contact_compta_email' => 'nullable|email|max:255',
                ];
                break;

            case 'interne':
                $rules = [
                    'responsable_paie_id' => 'required|exists:users,id',
                    'responsable_telephone_ld' => 'nullable|string|max:20',
                    'gestionnaire_principal_id' => 'required|exists:users,id',
                    'binome_id' => 'required|exists:users,id',
                ];
                break;

            case 'supplementaires':
                $rules = [
                    'saisie_variables' => 'boolean',
                    'client_forme_saisie' => 'boolean',
                    'date_formation_saisie' => 'nullable|date',
                    'date_fin_prestation' => 'nullable|date',
                    'date_signature_contrat' => 'nullable|date',
                    'taux_at' => 'nullable|string|max:255',
                    'adhesion_mydrh' => 'boolean',
                    'date_adhesion_mydrh' => 'nullable|date',
                    'is_cabinet' => 'boolean',
                    'portfolio_cabinet_id' => 'nullable|exists:clients,id',
                ];
                break;
        }

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return response()->json(['success' => true]);
    }

    public function storePartial(Request $request)
    {
        $step = $request->input('step');
        $validatedData = $request->validate($this->getValidationRules($step));

        DB::beginTransaction();
        try {
            $client = $request->session()->get('client_id') ? Client::find($request->session()->get('client_id')) : new Client;

            $client->fill($validatedData);
            $client->save();

            $request->session()->put('client_id', $client->id);

            DB::commit();
            return response()->json(['success' => true, 'nextStep' => $this->getNextStep($step)]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue'], 500);
        }
    }

    public function updatePartial(UpdateClientRequest $request, Client $client, $step)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            $client->update($validatedData);

            DB::commit();
            return redirect()->back()->with('success', 'Données mises à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Erreur lors de la mise à jour du client: " . $e->getMessage());
            return redirect()->back()->withErrors('Erreur lors de la mise à jour du client.');
        }
    }

    private function getValidationRules($step)
    {
        switch ($step) {
            case 'societe':
                return [
                    'name' => 'required|string|max:255',
                    'type_societe' => 'nullable|string|max:255',
                    'ville' => 'nullable|string|max:255',
                    'dirigeant_nom' => 'nullable|string|max:255',
                    'dirigeant_telephone' => 'nullable|string|max:20',
                    'dirigeant_email' => 'nullable|email|max:255',
                ];
            case 'contacts':
                return [
                    'contact_paie_nom' => 'nullable|string|max:255',
                    'contact_paie_prenom' => 'nullable|string|max:255',
                    'contact_paie_telephone' => 'nullable|string|max:20',
                    'contact_paie_email' => 'nullable|email|max:255',
                    'contact_compta_nom' => 'nullable|string|max:255',
                    'contact_compta_prenom' => 'nullable|string|max:255',
                    'contact_compta_telephone' => 'nullable|string|max:20',
                    'contact_compta_email' => 'nullable|email|max:255',
                ];
            case 'interne':
                return [
                    'responsable_paie_id' => 'required|exists:users,id',
                    'responsable_telephone_ld' => 'nullable|string|max:20',
                    'gestionnaire_principal_id' => 'required|exists:users,id',
                    'binome_id' => 'required|exists:users,id',
                ];
            case 'supplementaires':
                return [
                    'saisie_variables' => 'boolean',
                    'client_forme_saisie' => 'boolean',
                    'date_formation_saisie' => 'nullable|date',
                    'date_fin_prestation' => 'nullable|date',
                    'date_signature_contrat' => 'nullable|date',
                    'taux_at' => 'nullable|string|max:255',
                    'adhesion_mydrh' => 'boolean',
                    'date_adhesion_mydrh' => 'nullable|date',
                    'is_cabinet' => 'boolean',
                    'portfolio_cabinet_id' => 'nullable|exists:clients,id',
                ];
            default:
                return [];
        }
    }

    private function getNextStep($currentStep)
    {
        $steps = ['societe', 'contacts', 'interne', 'supplementaires'];
        $currentIndex = array_search($currentStep, $steps);
        return $currentIndex !== false && $currentIndex < count($steps) - 1 ? $steps[$currentIndex + 1] : null;
    }

    public function updateRelation(Request $request, $userId)
    {
        // Récupérer l'utilisateur spécifique
        $user = User::findOrFail($userId);

        // Définir les détails de la notification
        $action = 'Voir les détails';
        $details = 'La relation a été mise à jour.';

        // Envoyer la notification
        $user->notify(new RelationUpdated($action, $details));

        return redirect()->back()->with('success', 'Notification envoyée avec succès.');
    }

}

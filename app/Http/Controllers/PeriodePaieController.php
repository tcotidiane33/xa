<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use App\Models\PeriodePaieHistory;
use Illuminate\Support\Facades\Log;
use App\Services\PeriodePaieService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PeriodePaie\StorePeriodePaieRequest;
use App\Http\Requests\PeriodePaie\UpdatePeriodePaieRequest;

class PeriodePaieController extends Controller
{
    protected $periodePaieService;

    public function __construct(PeriodePaieService $periodePaieService)
    {
        $this->periodePaieService = $periodePaieService;
    }

    public function index(Request $request)
    {
        $query = PeriodePaie::query();
    
        // Filtre par client
        if ($request->has('client_id') && $request->client_id) {
            $query->where('client_id', $request->client_id);
        }
    
        // Filtre par gestionnaire
        if ($request->has('gestionnaire_id') && $request->gestionnaire_id) {
            $query->whereHas('client.gestionnairePrincipal', function ($q) use ($request) {
                $q->where('id', $request->gestionnaire_id);
            });
        }
    
        // Filtre par date de début
        if ($request->has('date_debut') && !empty($request->date_debut)) {
            $query->where('debut', '>=', $request->date_debut);
        }
    
        // Filtre par date de fin
        if ($request->has('date_fin') && !empty($request->date_fin)) {
            $query->where('fin', '<=', $request->date_fin);
        }
    
        // Filtre par statut (validée ou non)
        if ($request->has('validee') && $request->validee !== '') {
            $query->where('validee', $request->validee);
        }
    
        // Filtre par mois courant
        if (!$request->has('date_debut') && !$request->has('date_fin')) {
            $query->whereMonth('debut', now()->month);
        }
    
        $periodesPaie = $query->paginate(15);
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
    
        // Déchiffrement des données pour chaque période de paie
        foreach ($periodesPaie as $periode) {
            $periode->decrypted_data = $periode->decryptedData;
        }
    
        // Récupérer les clients éligibles
        $eligibleClients = $this->periodePaieService->getEligibleClients();
        $currentPeriodePaie = PeriodePaie::where('validee', true)->latest()->first();
    
        return view('periodes_paie.index', compact('periodesPaie', 'clients', 'gestionnaires', 'eligibleClients', 'currentPeriodePaie'));
    }

    public function create()
    {
        Log::info('Début de la méthode create');
        return view('periodes_paie.create');
    }

    public function store(StorePeriodePaieRequest $request)
    {
        $validated = $request->validated();

        // Vérifier qu'il n'y a qu'une seule période de paie active par mois
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $existingPeriode = PeriodePaie::whereMonth('debut', $currentMonth)
            ->whereYear('debut', $currentYear)
            ->where('validee', true)
            ->first();
    
        if ($existingPeriode) {
            return redirect()->route('periodes-paie.index')->with('error', 'Il existe déjà une période de paie active pour ce mois.');
        }

        $periodePaie = $this->periodePaieService->createPeriodePaie($validated);

        return redirect()->route('periodes-paie.index')->with('success', 'Période de paie créée avec succès.');
    }

    public function show(PeriodePaie $periodePaie)
    {
        // Déchiffrer les données de la période de paie
        $periodePaie->decrypted_data = $periodePaie->decryptedData;

        // Récupérer les traitements de paie associés à cette période
        $traitementsPaie = TraitementPaie::where('periode_paie_id', $periodePaie->id)->get();

        return view('periodes_paie.show', compact('periodePaie', 'traitementsPaie'));
    }

    public function edit(PeriodePaie $periodePaie)
    {
        if ($periodePaie->validee && !Auth::user()->hasRole(['admin', 'responsable'])) {
            return redirect()->route('periodes-paie.index')->with('error', 'Vous n\'avez pas l\'autorisation de modifier une période validée.');
        }

        $clients = Client::all();
        return view('periodes_paie.edit', compact('periodePaie', 'clients'));
    }

    public function update(UpdatePeriodePaieRequest $request, PeriodePaie $periodePaie)
    {
        if ($periodePaie->validee && !Auth::user()->hasRole(['admin', 'responsable'])) {
            return redirect()->route('periodes-paie.index')->with('error', 'Vous n\'avez pas l\'autorisation de modifier une période validée.');
        }

        $validated = $request->validated();
        $this->periodePaieService->updatePeriodePaie($periodePaie, $validated);

        return redirect()->route('periodes-paie.index')->with('success', 'Période de paie mise à jour avec succès.');
    }

    public function destroy(PeriodePaie $periodePaie)
    {
        try {
            $this->periodePaieService->deletePeriodePaie($periodePaie);
            return redirect()->route('periodes-paie.index')->with('success', 'Période de paie supprimée avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de la période de paie : ' . $e->getMessage());
            return redirect()->route('periodes-paie.index')->with('error', 'Impossible de supprimer cette période de paie. ' . $e->getMessage());
        }
    }

    public function valider(PeriodePaie $periodePaie)
    {
        if ($this->periodePaieService->validatePeriodePaie($periodePaie)) {
            return redirect()->route('periodes-paie.index')->with('success', 'Période de paie validée avec succès.');
        } else {
            return redirect()->route('periodes-paie.index')->with('error', 'Tous les traitements de paie doivent être complets avant de valider la période.');
        }
    }

    public function close(PeriodePaie $periodePaie)
    {
        $this->periodePaieService->closePeriodePaie($periodePaie);

        return redirect()->route('periodes-paie.index')->with('success', 'Période de paie clôturée avec succès.');
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

    public function encryptOldPeriods()
    {
        $this->periodePaieService->encryptOldPeriods();

        return redirect()->route('periodes-paie.index')->with('success', 'Périodes de paie chiffrées avec succès.');
    }

    public function updateField(Request $request)
    {
        $this->periodePaieService->updateField($request);

        return redirect()->route('periodes-paie.index')->with('success', 'Champ mis à jour avec succès.');
    }

    public function getInfo($id)
    {
        $periodePaie = PeriodePaie::findOrFail($id);
        return response()->json([
            'debut' => $periodePaie->debut->format('Y-m-d'),
            'fin' => $periodePaie->fin->format('Y-m-d'),
            'progress' => $periodePaie->progressPercentage(),
        ]);
    }
}
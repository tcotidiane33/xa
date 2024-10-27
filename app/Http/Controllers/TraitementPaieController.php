<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\RelationUpdated;
use App\Http\Requests\TraitementPaie\TraitementPaieRequest;

class TraitementPaieController extends Controller
{
    public function index(Request $request)
    {
        $query = TraitementPaie::with(['client', 'gestionnaire', 'periodePaie']);

        // Ajout de filtres
        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        if ($request->has('gestionnaire_id')) {
            $query->where('gestionnaire_id', $request->gestionnaire_id);
        }
        if ($request->has('periode_paie_id')) {
            $query->where('periode_paie_id', $request->periode_paie_id);
        }

        $traitements = $query->paginate(15);
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
        $periodesPaie = PeriodePaie::all();

        return view('traitements_paie.index', compact('traitements', 'clients', 'gestionnaires', 'periodesPaie'));
    }

    public function create()
    {
        $clients = Client::all();
        $gestionnaires = User::all();
        $periodesPaie = PeriodePaie::all();
        return view('traitements_paie.create', compact('clients', 'gestionnaires', 'periodesPaie'));
    }


    public function storePartial(Request $request)
    {
        $step = $request->input('step');
        $validatedData = $request->validate($this->getValidationRules($step));
    
        DB::beginTransaction();
        try {
            $traitementPaie = $request->session()->get('traitement_paie_id') ? TraitementPaie::find($request->session()->get('traitement_paie_id')) : new TraitementPaie;
    
            $traitementPaie->fill($validatedData);
            $traitementPaie->save();
    
            $request->session()->put('traitement_paie_id', $traitementPaie->id);
    
            DB::commit();
            return response()->json(['success' => true, 'nextStep' => $this->getNextStep($step)]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue', 'error' => $e->getMessage()], 500);
        }
    }

    public function cancel(Request $request)
    {
        $traitementPaieId = $request->session()->get('traitement_paie_id');
        if ($traitementPaieId) {
            TraitementPaie::find($traitementPaieId)->delete();
            $request->session()->forget('traitement_paie_id');
        }
        return redirect()->route('traitements-paie.create')->with('error', 'Opération annulée.');
    }

    private function getValidationRules($step)
    {
        switch ($step) {
            case 'client':
                return [
                    'client_id' => 'required|exists:clients,id',
                ];
            case 'gestionnaire':
                return [
                    'gestionnaire_id' => 'required|exists:users,id',
                ];
            case 'periode':
                return [
                    'periode_paie_id' => 'required|exists:periodes_paie,id',
                ];
            case 'details':
                return [
                    'nbr_bull' => 'required|integer',
                    'reception_variable' => 'nullable|date',
                    'preparation_bp' => 'nullable|date',
                    'validation_bp_client' => 'nullable|date',
                    'preparation_envoie_dsn' => 'nullable|date',
                    'accuses_dsn' => 'nullable|date',
                    'teledec_urssaf' => 'nullable|date',
                    'notes' => 'nullable|string',
                ];
            case 'fichiers':
                return [
                    'maj_fiche_para_file' => 'nullable|file',
                    'reception_variables_file' => 'nullable|file',
                    'preparation_bp_file' => 'nullable|file',
                    'validation_bp_client_file' => 'nullable|file',
                    'preparation_envoi_dsn_file' => 'nullable|file',
                    'accuses_dsn_file' => 'nullable|file',
                ];
            default:
                return [];
        }
    }

    private function getNextStep($currentStep)
    {
        $steps = ['client', 'gestionnaire', 'periode', 'details', 'fichiers'];
        $currentIndex = array_search($currentStep, $steps);
        return $currentIndex !== false && $currentIndex < count($steps) - 1 ? $steps[$currentIndex + 1] : null;
    }


    public function store(TraitementPaieRequest $request)
    {
        $validatedData = $request->validated();

        // Gérer les uploads de fichiers
        $fileFields = [
            'maj_fiche_para_file',
            'reception_variables_file',
            'preparation_bp_file',
            'validation_bp_client_file',
            'preparation_envoi_dsn_file',
            'accuses_dsn_file'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validatedData[$field] = $request->file($field)->store('traitements_paie');
            }
        }

        // Vérifiez que gestionnaire_id est bien présent
        if (!isset($validatedData['gestionnaire_id'])) {
            return back()->withInput()->withErrors(['gestionnaire_id' => 'Le gestionnaire est requis.']);
        }
        // Vérifiez que client_id est bien présent
        if (!isset($validatedData['client_id'])) {
            return back()->withInput()->withErrors(['client_id' => 'Le client est requis.']);
        }
        // Vérifiez que periode_paie_id est bien présent
        if (!isset($validatedData['periode_paie_id'])) {
            return back()->withInput()->withErrors(['periode_paie_id' => 'La période de paie est requis.']);
        }


        // La référence sera automatiquement générée grâce au boot method du modèle
        $traitementPaie = TraitementPaie::create($validatedData);

        return redirect()->route('traitements-paie.index')
            ->with('success', 'Traitement de paie créé avec succès. Référence : ' . $traitementPaie->reference);
    }
    public function show(TraitementPaie $traitementPaie)
    {
        return view('traitements_paie.show', compact('traitementPaie'));
    }

    public function edit(TraitementPaie $traitementPaie)
    {
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
        $periodesPaie = PeriodePaie::all();
        return view('traitements_paie.edit', compact('traitementPaie', 'clients', 'gestionnaires', 'periodesPaie'));
    }

    public function update(TraitementPaieRequest $request, TraitementPaie $traitementPaie)
    {
        $validatedData = $request->validated();
        $this->handleFileUploads($request, $validatedData);

        $traitementPaie->update($validatedData);
        return redirect()->route('traitements-paie.index')->with('success', 'Traitement de paie mis à jour avec succès.');
    }

    public function destroy(TraitementPaie $traitementPaie)
    {
        $traitementPaie->delete();
        return redirect()->route('traitements-paie.index')->with('success', 'Traitement de paie supprimé avec succès.');
    }

    private function handleFileUploads(Request $request, array &$validatedData)
    {
        $fileFields = [
            'maj_fiche_para_file',
            'reception_variables_file',
            'preparation_bp_file',
            'validation_bp_client_file',
            'preparation_envoi_dsn_file',
            'accuses_dsn_file'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validatedData[$field] = $request->file($field)->store('traitements_paie');
            }
        }
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

    public function historique()
    {
        $date = Carbon::now()->subMonth();
        $traitements = TraitementPaie::where('created_at', '<', $date)
            ->with(['client', 'gestionnaire', 'periodePaie'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('traitements_paie.historique', compact('traitements'));
    }
}
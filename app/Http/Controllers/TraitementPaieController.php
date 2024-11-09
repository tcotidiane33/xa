<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use App\Models\TraitementPaie;
use Illuminate\Http\Request;
use App\Services\TraitementPaieService;
use App\Http\Requests\TraitementPaieRequest;
use Illuminate\Support\Facades\Auth;

class TraitementPaieController extends Controller
{
    protected $traitementPaieService;

    public function __construct(TraitementPaieService $traitementPaieService)
    {
        $this->traitementPaieService = $traitementPaieService;
    }

    public function index(Request $request)
    {
        $traitements = TraitementPaie::with(['client', 'gestionnaire', 'periodePaie'])->paginate(15);
        return view('traitements_paie.index', compact('traitements'));
    }

    public function create()
    {
        $gestionnaire = Auth::user();
        $clients = Client::where('gestionnaire_principal_id', $gestionnaire->id)->with('fichesClients')->get();
        $gestionnaires = User::role('gestionnaire')->get();
        $periodesPaie = PeriodePaie::all();
        return view('traitements_paie.create', compact('clients', 'gestionnaires', 'periodesPaie'));
    }

    public function store(TraitementPaieRequest $request)
    {
        $validatedData = $request->validated();

        // Vérifier si le gestionnaire connecté est rattaché au client
        $gestionnaire = Auth::user();
        $client = Client::findOrFail($validatedData['client_id']);

        if ($client->gestionnaire_principal_id !== $gestionnaire->id) {
            return redirect()->route('traitements-paie.create')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier les informations de ce client.');
        }

        $this->traitementPaieService->createTraitementPaie($validatedData);

        return redirect()->route('traitements-paie.index')
            ->with('success', 'Traitement de paie créé avec succès.');
    }

    public function show(TraitementPaie $traitementPaie)
    {
        return view('traitements_paie.show', compact('traitementPaie'));
    }

    public function edit(TraitementPaie $traitementPaie)
    {
        $clients = Client::with('fichesClients')->get();
        $gestionnaires = User::role('gestionnaire')->get();
        $periodesPaie = PeriodePaie::all();
        return view('traitements_paie.edit', compact('traitementPaie', 'clients', 'gestionnaires', 'periodesPaie'));
    }

    public function update(TraitementPaieRequest $request, TraitementPaie $traitementPaie)
    {
        $validatedData = $request->validated();

        // Vérifier si le gestionnaire connecté est rattaché au client
        $gestionnaire = Auth::user();
        $client = Client::findOrFail($validatedData['client_id']);

        if ($client->gestionnaire_principal_id !== $gestionnaire->id) {
            return redirect()->route('traitements-paie.edit', $traitementPaie)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier les informations de ce client.');
        }

        $this->traitementPaieService->updateTraitementPaie($traitementPaie, $validatedData);

        return redirect()->route('traitements-paie.index')
            ->with('success', 'Traitement de paie mis à jour avec succès.');
    }

    public function destroy(TraitementPaie $traitementPaie)
    {
        $this->traitementPaieService->deleteTraitementPaie($traitementPaie);

        return redirect()->route('traitements-paie.index')
            ->with('success', 'Traitement de paie supprimé avec succès.');
    }
}
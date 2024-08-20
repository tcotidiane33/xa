<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use App\Http\Controllers\Controller;
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
        $gestionnaires = User::role('gestionnaire')->get();
        $periodesPaie = PeriodePaie::all();
        return view('traitements_paie.create', compact('clients', 'gestionnaires', 'periodesPaie'));
    }

    public function store(TraitementPaieRequest $request)
    {
        $validatedData = $request->validated();
        $this->handleFileUploads($request, $validatedData);
        
        TraitementPaie::create($validatedData);
        return redirect()->route('traitements-paie.index')->with('success', 'Traitement de paie créé avec succès.');
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
            'maj_fiche_para_file', 'reception_variables_file', 'preparation_bp_file',
            'validation_bp_client_file', 'preparation_envoi_dsn_file', 'accuses_dsn_file'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validatedData[$field] = $request->file($field)->store('traitements_paie');
            }
        }
    }
}
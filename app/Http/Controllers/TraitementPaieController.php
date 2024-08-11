<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use App\Traits\TracksUserActions;

class TraitementPaieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use TracksUserActions;

    public function index()
    {
        $traitements = TraitementPaie::with('client', 'periodePaie')->paginate(15);
        return view('traitements_paie.index', compact('traitements'));
    }


    /**
     * Show the form for creating a new resource.
     */

 public function create()
    {
        $clients = Client::all();
        $periodesPaie = PeriodePaie::where('validee', true)->get();
        return view('traitements_paie.create', compact('clients', 'periodesPaie'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([/* ... */]);
        $traitement = TraitementPaie::create($validated);

        // Gérer les pièces jointes
        if ($request->hasFile('pj_nbr_bull')) {
            $path = $request->file('pj_nbr_bull')->store('pieces_jointes/traitements_paie');
            $traitement->update(['pj_nbr_bull' => $path]);
        }
        // ... autres pièces jointes ...

        $this->logAction('create_traitement_paie', "Création du traitement de paie #{$traitement->id}");
        return redirect()->route('traitements_paie.show', $traitement);
    }
    /**
     * Display the specified resource.
     */
    public function show(TraitementPaie $traitementPaie)
    {
        return view('traitements_paie.show', compact('traitementPaie'));
    }

    public function edit(TraitementPaie $traitementPaie)
    {
        $clients = Client::all();
        $periodesPaie = PeriodePaie::where('validee', true)->get();
        return view('traitements_paie.edit', compact('traitementPaie', 'clients', 'periodesPaie'));
    }

    public function update(Request $request, TraitementPaie $traitementPaie)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:traitements_paie,reference,' . $traitementPaie->id,
            'gestionnaire_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'periode_paie_id' => 'required|exists:periodes_paie,id',
            'nbr_bull' => 'required|integer',
            // Ajoutez d'autres règles de validation ici
        ]);

        $traitementPaie->update($validated);

        // Gestion des pièces jointes
        if ($request->hasFile('pj_nbr_bull')) {
            $path = $request->file('pj_nbr_bull')->store('pieces_jointes/traitements_paie');
            $traitementPaie->update(['pj_nbr_bull' => $path]);
        }

        return redirect()->route('traitements_paie.show', $traitementPaie)->with('success', 'Traitement de paie mis à jour avec succès.');
    }

    public function destroy(TraitementPaie $traitementPaie)
    {
        $traitementPaie->delete();
        return redirect()->route('traitements_paie.index')->with('success', 'Traitement de paie supprimé avec succès.');
    }
}

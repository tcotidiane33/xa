<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PeriodePaie;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PeriodePaie\StorePeriodePaieRequest;
use App\Http\Requests\PeriodePaie\UpdatePeriodePaieRequest;

class PeriodePaieController extends Controller
{
    public function index(Request $request)
    {
        $query = PeriodePaie::query();

        // Filtre par client
        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filtre par date de début
        if ($request->has('date_debut')) {
            $query->where('debut', '>=', $request->date_debut);
        }

        // Filtre par date de fin
        if ($request->has('date_fin')) {
            $query->where('fin', '<=', $request->date_fin);
        }

        // Filtre par statut (validée ou non)
        if ($request->has('validee')) {
            $query->where('validee', $request->validee);
        }

        $periodesPaie = $query->paginate(15);
        $clients = Client::all();

        return view('periodes_paie.index', compact('periodesPaie', 'clients'));
    }

    public function create()
    {
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
        return view('periodes_paie.create', compact('clients', 'gestionnaires'));
    }

    public function store(StorePeriodePaieRequest $request)
    {
        $periodePaie = PeriodePaie::create($request->validated());
        return redirect()->route('periodes-paie.index')->with('success', 'Période de paie créée avec succès.');
    }

    public function show(PeriodePaie $periodePaie)
    {
        $periodePaie->load('client', 'traitementsPaie.gestionnaire');
        return view('periodes_paie.show', compact('periodePaie'));
    }

    public function edit(PeriodePaie $periodePaie)
    {
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
        return view('periodes_paie.edit', compact('periodePaie', 'clients', 'gestionnaires'));
    }

    public function update(UpdatePeriodePaieRequest $request, PeriodePaie $periodePaie)
{
    $periodePaie->update($request->validated());
    return redirect()->route('periodes-paie.index')->with('success', 'Période de paie mise à jour avec succès.');
}

public function destroy(PeriodePaie $periodePaie)
{
    try {
        $periodePaie->delete();
        return redirect()->route('periodes-paie.index')->with('success', 'Période de paie supprimée avec succès.');
    } catch (\Exception $e) {
        \Log::error('Erreur lors de la suppression de la période de paie : ' . $e->getMessage());
        return redirect()->route('periodes-paie.index')->with('error', 'Impossible de supprimer cette période de paie. ' . $e->getMessage());
    }
}

    public function valider(PeriodePaie $periodePaie)
    {
        $periodePaie->update(['validee' => true]);
        return redirect()->route('periodes-paie.show', $periodePaie)->with('success', 'Période de paie validée avec succès.');
    }
}
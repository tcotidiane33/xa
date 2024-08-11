<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/PeriodePaieController.php

use App\Models\PeriodePaie;
use App\Models\Client;

class PeriodePaieController extends Controller
{
    public function index()
    {
        $periodesPaie = PeriodePaie::with('client')->paginate(15);
        return view('periodes_paie.index', compact('periodesPaie'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('periodes_paie.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:periodes_paie',
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut',
            'client_id' => 'required|exists:clients,id',
            'validee' => 'boolean',
        ]);

        $periodePaie = PeriodePaie::create($validated);
        return redirect()->route('periodes_paie.show', $periodePaie)->with('success', 'Période de paie créée avec succès.');
    }

    public function show(PeriodePaie $periodePaie)
    {
        return view('periodes_paie.show', compact('periodePaie'));
    }

    public function edit(PeriodePaie $periodePaie)
    {
        $clients = Client::all();
        return view('periodes_paie.edit', compact('periodePaie', 'clients'));
    }

    public function update(Request $request, PeriodePaie $periodePaie)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:periodes_paie,reference,' . $periodePaie->id,
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut',
            'client_id' => 'required|exists:clients,id',
            'validee' => 'boolean',
        ]);

        $periodePaie->update($validated);
        return redirect()->route('periodes_paie.show', $periodePaie)->with('success', 'Période de paie mise à jour avec succès.');
    }

    public function destroy(PeriodePaie $periodePaie)
    {
        $periodePaie->delete();
        return redirect()->route('periodes_paie.index')->with('success', 'Période de paie supprimée avec succès.');
    }
}

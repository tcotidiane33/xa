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

    public function update(Request $request, $id)
{
    $traitementPaie = TraitementPaie::findOrFail($id);

    $data = $request->validate([
        'nb_bulletins' => 'nullable|integer',
        'maj_fiche_para' => 'nullable|date',
        'reception_variables' => 'nullable|date',
        'preparation_bp' => 'nullable|date',
        'validation_bp_client' => 'nullable|date',
        'preparation_envoi_dsn' => 'nullable|date',
        'accuses_dsn' => 'nullable|date',
        'notes' => 'nullable|string',
    ]);

    // Gérer les fichiers uploadés
    $fileFields = [
        'nb_bulletins_file',
        'maj_fiche_para_file',
        'reception_variables_file',
        'preparation_bp_file',
        'validation_bp_client_file',
        'preparation_envoi_dsn_file',
        'accuses_dsn_file',
    ];

    foreach ($fileFields as $field) {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('traitement_paie_files', $filename, 'public');
            $data[$field] = $filename;
        }
    }

    $traitementPaie->update($data);

    return response()->json(['success' => true])->redirect()->route('traitements_paie.show', $traitementPaie)->with('success', 'Traitement de paie mis à jour avec succès.');

}

    public function destroy(TraitementPaie $traitementPaie)
    {
        $traitementPaie->delete();
        return redirect()->route('traitements_paie.index')->with('success', 'Traitement de paie supprimé avec succès.');
    }
}

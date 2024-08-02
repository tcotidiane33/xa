<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use OpenAdmin\Admin\Widgets\Tab;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Widgets\MultipleSteps;

class TraitementPaieController extends Controller
{
    public function index()
    {
        $traitementsPaie = TraitementPaie::with(['gestionnaire', 'client', 'periodePaie'])->paginate(15);
        return view('traitements_paie.index', compact('traitementsPaie'));
    }

    public function create()
    {
        $gestionnaires = User::where('role_id', 3)->get(); // Supposons que le rôle_id 3 soit pour les gestionnaires de paie
        $clients = Client::all();
        $periodesPaie = PeriodePaie::all();
        return view('traitements_paie.create', compact('gestionnaires', 'clients', 'periodesPaie'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gestionnaire_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'periode_paie_id' => 'required|exists:periodes_paie,id',
            'nbr_bull' => 'required|integer',
            'maj_fiche_para' => 'nullable|date',
            'reception_variable' => 'nullable|date',
            'preparation_bp' => 'nullable|date',
            'validation_bp_client' => 'nullable|date',
            'preparation_envoie_dsn' => 'nullable|date',
            'accuses_dsn' => 'nullable|date',
            'teledec_urssaf' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $traitementPaie = TraitementPaie::create($validatedData);

        return redirect()->route('traitements_paie.index')->with('success', 'Traitement de paie créé avec succès.');
    }

    public function edit(TraitementPaie $traitementPaie)
    {
        $gestionnaires = User::where('role_id', 3)->get();
        $clients = Client::all();
        $periodesPaie = PeriodePaie::all();
        return view('traitements_paie.edit', compact('traitementPaie', 'gestionnaires', 'clients', 'periodesPaie'));
    }

    public function update(Request $request, TraitementPaie $traitementPaie)
    {
        $validatedData = $request->validate([
            'gestionnaire_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'periode_paie_id' => 'required|exists:periodes_paie,id',
            'nbr_bull' => 'required|integer',
            'maj_fiche_para' => 'nullable|date',
            'reception_variable' => 'nullable|date',
            'preparation_bp' => 'nullable|date',
            'validation_bp_client' => 'nullable|date',
            'preparation_envoie_dsn' => 'nullable|date',
            'accuses_dsn' => 'nullable|date',
            'teledec_urssaf' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $traitementPaie->update($validatedData);

        return redirect()->route('traitements_paie.index')->with('success', 'Traitement de paie mis à jour avec succès.');
    }

    public function destroy(TraitementPaie $traitementPaie)
    {
        $traitementPaie->delete();
        return redirect()->route('traitements_paie.index')->with('success', 'Traitement de paie supprimé avec succès.');
    }

    public function periodesPaie()
    {
        $periodesPaie = PeriodePaie::all();
        $periode = now()->format('Y-m');
        $traitementsPaie = TraitementPaie::with(['gestionnaire', 'client', 'periodePaie'])->get(); // Define the $traitementsPaie variable

        return view('periodes_paie.index', compact('periodesPaie', 'periode', 'traitementsPaie')); // Pass all three variables to the view
    }

    public function clients()
    {
        $clients = Client::paginate(10); // paginate 10 clients per page
        return view('clients.index', compact('clients'));
    }


    public function traitementPaie(Content $content)
    {
        // $forms = [
        //     // 'test'    => Test::class,
        //     'setting' => TraitementPaie::class,
        // ];
        $steps = [
            'setting' => TraitementPaie::class,
        ];

        return $content
            ->title('TraitementPaieForm')
            ->body(MultipleSteps::make($steps));
            // ->body(Tab::forms($forms));
    }

}

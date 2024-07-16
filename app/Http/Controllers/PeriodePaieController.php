<?php

namespace App\Http\Controllers;

use App\Models\PeriodePaie;
use App\Models\Client;
use App\Models\User;
use App\Models\TraitementPaie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeriodePaieController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        $gestionnaireId = $request->input('gestionnaire_id');
        $clientId = $request->input('client_id');

        $query = TraitementPaie::whereHas('periodePaie', function ($q) use ($periode) {
            $q->where('debut', 'LIKE', "$periode%");
        });

        if ($gestionnaireId) {
            $query->where('gestionnaire_id', $gestionnaireId);
        }

        if ($clientId) {
            $query->where('client_id', $clientId);
        }

        $traitementsPaie = $query->with(['gestionnaire', 'client', 'periodePaie'])->get();

        $clients = Client::all();
        $gestionnaires = User::whereHas('role', function($q) {
            $q->whereIn('name', ['admin', 'responsable']);
        })->get();

        $periodeActuelle = PeriodePaie::where('debut', 'LIKE', "$periode%")->first();

        return view('periodes_paie.index', compact('traitementsPaie', 'clients', 'gestionnaires', 'periode', 'periodeActuelle'));
    }

    public function valider(Request $request)
    {
        $periode = $request->input('periode');

        PeriodePaie::where('debut', 'LIKE', "$periode%")->update(['validee' => true]);

        // Créer la période pour le mois suivant
        $nextPeriode = Carbon::createFromFormat('Y-m', $periode)->addMonth();
        PeriodePaie::create([
            'debut' => $nextPeriode->startOfMonth(),
            'fin' => $nextPeriode->endOfMonth(),
            'validee' => false
        ]);

        return redirect()->route('periodes_paie.index')->with('success', 'Période de paie validée et nouvelle période créée');
    }

    public function updateField(Request $request, TraitementPaie $traitementPaie)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $traitementPaie->$field = $value;
        $traitementPaie->save();

        return response()->json(['success' => true]);
    }
}

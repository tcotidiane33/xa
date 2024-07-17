<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use App\Models\TraitementPaie;
use Illuminate\Http\Request;

class DashboardController extends Controller
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

        return view('dashboard.index', compact('traitementsPaie', 'clients', 'gestionnaires', 'periode', 'periodeActuelle'));
    }
}

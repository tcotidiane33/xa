<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use Illuminate\Support\Facades\DB;
use App\Models\ConventionCollective;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        $gestionnaireId = $request->input('gestionnaire_id');
        $clientId = $request->input('client_id');
        $conventionsCollectives = ConventionCollective::all(); // or some other query
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
        $newClients = Client::where('created_at', '>=', now()->subMonth())->get(); // Get clients created in the last month
        $gestionnaires = User::whereHas('role', function ($q) {
            $q->whereIn('name', ['admin', 'responsable']);
        })->get();
        $prestationsParMois = TraitementPaie::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month');
        $periodeActuelle = PeriodePaie::where('debut', 'LIKE', "$periode%")->first();
        $periodePaie = PeriodePaie::all(); // Define the $periodePaie variable
        $topConventions = ConventionCollective::orderBy('id', 'desc')->take(5)->get();

        return view('dashboard', compact('traitementsPaie', 'clients', 'newClients', 'gestionnaires', 'periode', 'periodeActuelle', 'periodePaie', 'conventionsCollectives', 'topConventions', 'prestationsParMois'));
    }
}

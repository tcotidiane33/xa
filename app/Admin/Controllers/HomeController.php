<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use Illuminate\Support\Facades\DB;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

class HomeController extends AdminController
{
    public function index(Content $content)
    {
        $user = Auth::user();
        $successPercentage = 72; // Exemple, à remplacer par la logique pour calculer le succès

        $totalUsers = User::count();
        $totalClients = Client::count();
        $totalPeriodesPaie = PeriodePaie::count();
        $traitementsPaieEnCours = TraitementPaie::whereHas('periodePaie', function($query) {
            $query->where('validee', false);
        })->count();
        $traitementsPaieTerminer = TraitementPaie::whereHas('periodePaie', function($query) {
            $query->where('validee', true);
        })->count();

        $traitementsPaieInterrompu = TraitementPaie::whereHas('periodePaie', function($query) {
            $query->where('validee', '');
        })->count();
        $latestClients = Client::latest()->take(5)->get();

        return $content
            ->title('Tableau de bord')
            ->description('Statistiques et informations principales')
            ->view('admin.dashboard.index', compact('user','successPercentage','totalUsers', 'totalClients', 'totalPeriodesPaie', 'traitementsPaieEnCours','traitementsPaieTerminer', 'traitementsPaieInterrompu', 'latestClients'));
    }

    public function manageUsers(Content $content)
    {
        $users = User::with('role')->paginate(15);
        return $content
            ->title('Gestion des utilisateurs')
            ->description('Liste des utilisateurs')
            ->view('admin.users.index', compact('users'));
    }

    public function manageClients(Content $content)
    {
        $clients = Client::with(['responsablePaie', 'gestionnairePrincipal'])->paginate(15);
        return $content
            ->title('Gestion des clients')
            ->description('Liste des clients')
            ->view('admin.clients.index', compact('clients'));
    }

    public function managePeriodesPaie(Request $request, Content $content)
    {
        $query = PeriodePaie::query();

        // Appliquer les filtres
        if ($request->has('periode')) {
            $periode = $request->periode;
            $query->where(function($q) use ($periode) {
                $q->where('debut', '<=', $periode)
                  ->where('fin', '>=', $periode);
            });
        }

        if ($request->has('gestionnaire_id') && auth()->user()->isAdmin()) {
            $gestionnaireId = $request->gestionnaire_id;
            $query->whereHas('traitementsPaie', function($q) use ($gestionnaireId) {
                $q->where('gestionnaire_id', $gestionnaireId);
            });
        }

        if ($request->has('client_id')) {
            $clientId = $request->client_id;
            $query->whereHas('traitementsPaie', function($q) use ($clientId) {
                $q->where('client_id', $clientId);
            });
        }

        if ($request->has('validee')) {
            $query->where('validee', $request->validee);
        }

        $periodesPaie = $query->latest()->paginate(15);

        $gestionnaires = User::whereHas('role', function($q) {
            $q->where('name', 'Gestionnaire de paie');
        })->get();
        $clients = Client::all();

        return $content
            ->title('Gestion des périodes de paie')
            ->description('Liste des périodes de paie')
            ->view('admin.periodes_paie.index', compact('periodesPaie', 'gestionnaires', 'clients'));
    }

    public function validerPeriodePaie(PeriodePaie $periodePaie)
    {
        $traitementsIncomplets = $periodePaie->traitementsPaie()
            ->whereNull('teledec_urssaf')
            ->count();

        if ($traitementsIncomplets > 0) {
            admin_error('Erreur', 'Impossible de valider la période. Certains traitements de paie sont incomplets.');
            return back();
        }

        $periodePaie->update(['validee' => true]);
        admin_success('Succès', 'Période de paie validée avec succès.');
        return back();
    }

    public function statsPeriodesPaie(Request $request, Content $content)
    {
        $query = PeriodePaie::query();

        // Appliquer les mêmes filtres que dans la méthode managePeriodesPaie
        // ... (même logique de filtrage que dans managePeriodesPaie)

        if ($request->has('periode')) {
            $periode = $request->periode;
            $query->where(function($q) use ($periode) {
                $q->where('debut', '<=', $periode)
                  ->where('fin', '>=', $periode);
            });
        }

        if ($request->has('gestionnaire_id') && auth()->user()->isAdmin()) {
            $gestionnaireId = $request->gestionnaire_id;
            $query->whereHas('traitementsPaie', function($q) use ($gestionnaireId) {
                $q->where('gestionnaire_id', $gestionnaireId);
            });
        }

        if ($request->has('client_id')) {
            $clientId = $request->client_id;
            $query->whereHas('traitementsPaie', function($q) use ($clientId) {
                $q->where('client_id', $clientId);
            });
        }

        if ($request->has('validee')) {
            $query->where('validee', $request->validee);
        }
        $stats = $query->select(
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN validee = 1 THEN 1 ELSE 0 END) as validees'),
            DB::raw('AVG(DATEDIFF(fin, debut)) as duree_moyenne')
        )->first();

        return $content
            ->title('Statistiques des périodes de paie')
            ->description('Statistiques et analyses')
            ->view('admin.periodes_paie.stats', compact('stats'));
    }
}

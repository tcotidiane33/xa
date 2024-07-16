<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use App\Models\Gestionnaire;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Facades\Admin;
use OpenAdmin\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::all();
        $gestionnaires = Gestionnaire::all();

        $counts = [
            'clients' => ['label' => 'Clients', 'icon' => 'fa fa-database', 'value' => Client::count()],
            'gestionnaires' => ['label' => 'Gestionnaires', 'icon' => 'fa fa-handshake-o', 'value' => Gestionnaire::count()],
        ];

        return Admin::content(function (Content $content) use ($counts, $gestionnaires, $clients) {
            $content->header('Dashboard Admin');
            $content->description('XALLIANCE PILOT');
            $content->view('admin.index', compact('counts', 'gestionnaires', 'clients'));
        });
    }
    public function listClients()
    {
        $clients = Client::all();
        return Admin::content(function (Content $content) use ($clients) {
            $content->header('Liste des clients');
            $content->description('Sélectionnez un client pour gérer ses responsables et gestionnaires');
            $content->view('admin.client_list', compact('clients'));
        });
    }

    public function showClient($id)
    {
        $client = Client::findOrFail($id);
        $gestionnaires = Gestionnaire::all();

        return Admin::content(function (Content $content) use ($client, $gestionnaires) {
            $content->header('Détails du client');
            $content->description($client->name);
            

            $content->view('admin.client', compact('client', 'gestionnaires'));
        });
    }

    public function updateResponsablePaie(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);
        $client->respo_paie = $request->respo_paie;
        $client->save();

        return back()->with('success', 'Responsable de paie mis à jour avec succès.');
    }

    public function updateGestionnairePrincipal(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);
        $client->ges_paie_prin = $request->ges_paie_prin;
        $client->save();

        return back()->with('success', 'Gestionnaire de paie principal mis à jour avec succès.');
    }

    public function addGestionnaireSupp(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);
        $client->gestionnairesSupp()->attach($request->gestionnaire_id);

        return back()->with('success', 'Gestionnaire supplémentaire ajouté avec succès.');
    }

    public function removeGestionnaireSupp(Request $request, $clientId, $gestionnaireId)
    {
        $client = Client::findOrFail($clientId);
        $client->gestionnairesSupp()->detach($gestionnaireId);

        return back()->with('success', 'Gestionnaire supplémentaire supprimé avec succès.');
    }
}

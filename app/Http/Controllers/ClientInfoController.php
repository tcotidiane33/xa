<?php

// Nouveau contrôleur ClientInfoController
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\GestionnaireClient;
use Illuminate\Http\Request;

class ClientInfoController extends Controller
{
    public function getInfo(Request $request)
    {
        $clientId = $request->get('q');
        $gestionnaireClient = GestionnaireClient::where('client_id', $clientId)->first();

        if (!$gestionnaireClient) {
            return response()->json([]);
        }

        return response()->json([
            'gestionnaire_id' => [
                'id' => $gestionnaireClient->gestionnaire_id,
                'text' => $gestionnaireClient->gestionnaire->name,
            ],
            'superviseur_id' => [
                'id' => $gestionnaireClient->superviseur_id,
                'text' => $gestionnaireClient->superviseur ? $gestionnaireClient->superviseur->name : 'N/A',
            ],
            'responsable_id' => [
                'id' => $gestionnaireClient->responsable_id,
                'text' => $gestionnaireClient->responsable ? $gestionnaireClient->responsable->name : 'N/A',
            ],
            'gestionnaires_ids' => collect(json_decode($gestionnaireClient->gestionnaires_ids))
                ->map(function ($id) {
                    $user = \App\Models\User::find($id);
                    return ['id' => $id, 'text' => $user ? $user->name : 'N/A'];
                })->toArray(),
        ]);
    }
}

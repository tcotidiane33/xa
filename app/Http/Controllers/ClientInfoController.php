<?php

// Nouveau contrôleur ClientInfoController
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\GestionnaireClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientInfoController extends Controller
{
    public function getInfo(Request $request)
    {
        $clientId = $request->get('q');
        Log::info('Client ID: ' . $clientId);

        $gestionnaireClient = GestionnaireClient::where('client_id', $clientId)->first();
        if (!$gestionnaireClient) {
            Log::warning('GestionnaireClient not found for Client ID: ' . $clientId);
            return response()->json([]);
        }

        $gestionnaire = $gestionnaireClient->gestionnaire;
        $superviseur = $gestionnaireClient->superviseur;
        $responsable = $gestionnaireClient->responsable;

        Log::info('Gestionnaire: ' . $gestionnaire);
        Log::info('Superviseur: ' . $superviseur);
        Log::info('Responsable: ' . $responsable);

        return response()->json([
            'gestionnaire_id' => [
                'id' => $gestionnaireClient->gestionnaire_id,
                'text' => $gestionnaire ? $gestionnaire->name : 'N/A',
            ],
            'superviseur_id' => [
                'id' => $gestionnaireClient->superviseur_id,
                'text' => $superviseur ? $superviseur->name : 'N/A',
            ],
            'responsable_id' => [
                'id' => $gestionnaireClient->responsable_id,
                'text' => $responsable ? $responsable->name : 'N/A',
            ],
            'gestionnaires_ids' => collect($gestionnaireClient->gestionnaires_ids)
                ->map(function ($id) {
                    $user = \App\Models\User::find($id);
                    return ['id' => $id, 'text' => $user ? $user->name : 'N/A'];
                })->toArray(),
        ]);
    }
}

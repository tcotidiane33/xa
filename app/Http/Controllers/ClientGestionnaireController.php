<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientGestionnaireController extends Controller
{
    public function index(Request $request)
    {
        $clientId = $request->get('q');
        $client = Client::find($clientId);

        if ($client) {
            $gestionnaireId = $client->gestionnairePrincipal ? $client->gestionnairePrincipal->id : null;
            return response()->json(['gestionnaire_id' => $gestionnaireId]);
        }

        return response()->json(['gestionnaire_id' => null]);
    }
}

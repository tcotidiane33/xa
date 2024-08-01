<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\GestionnaireClient;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientInfoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api/getClientInfo', function (Request $request) {
    $clientId = $request->get('q');

    $relation = GestionnaireClient::where('client_id', $clientId)
                ->where('is_principal', 1)
                ->first();

    if ($relation) {
        $gestionnaire = User::find($relation->gestionnaire_id);
        $responsable = User::find($relation->responsable_id);
        $superviseur = User::find($relation->superviseur_id);
        $gestionnaires = User::whereIn('id', json_decode($relation->gestionnaires_ids, true))->get();

        return response()->json([
            'gestionnaire' => $gestionnaire ? $gestionnaire->only(['id', 'name', 'email']) : null,
            'responsable' => $responsable ? $responsable->only(['id', 'name', 'email']) : null,
            'superviseur' => $superviseur ? $superviseur->only(['id', 'name', 'email']) : null,
            'gestionnaires' => $gestionnaires->pluck('name', 'id')
        ]);
    }

    return response()->json(null);
});
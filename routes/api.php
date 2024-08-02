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

Route::get('/getClientInfo', function (Illuminate\Http\Request $request) {
    $clientId = $request->query('q');
    $clientInfo = GestionnaireClient::where('client_id', $clientId)->first();

    if ($clientInfo) {
        return response()->json([
            'gestionnaire' => $clientInfo->gestionnaire,
            'responsable' => $clientInfo->responsable,
            'superviseur' => $clientInfo->superviseur,
            'gestionnaires' => json_decode($clientInfo->gestionnaires_ids)
        ]);
    } else {
        return response()->json(null, 404);
    }
});
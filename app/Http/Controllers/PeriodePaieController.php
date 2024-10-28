<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\PeriodePaieHistory;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RelationUpdated;
use App\Http\Requests\PeriodePaie\StorePeriodePaieRequest;
use App\Http\Requests\PeriodePaie\UpdatePeriodePaieRequest;

class PeriodePaieController extends Controller
{
    public function index(Request $request)
    {
        $query = PeriodePaie::query();
    
        // Filtre par client
        if ($request->has('client_id') && $request->client_id) {
            $query->where('client_id', $request->client_id);
        }
    
        // Filtre par gestionnaire
        if ($request->has('gestionnaire_id') && $request->gestionnaire_id) {
            $query->whereHas('client.gestionnairePrincipal', function ($q) use ($request) {
                $q->where('id', $request->gestionnaire_id);
            });
        }
    
        // Filtre par date de début
        if ($request->has('date_debut') && !empty($request->date_debut)) {
            $query->where('debut', '>=', $request->date_debut);
        }
    
        // Filtre par date de fin
        if ($request->has('date_fin') && !empty($request->date_fin)) {
            $query->where('fin', '<=', $request->date_fin);
        }
    
        // Filtre par statut (validée ou non)
        if ($request->has('validee') && $request->validee !== '') {
            $query->where('validee', $request->validee);
        }
    
        // Filtre par mois courant
        if (!$request->has('date_debut') && !$request->has('date_fin')) {
            $query->whereMonth('debut', now()->month);
        }
    
        $periodesPaie = $query->paginate(15);
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
    
        // Déchiffrement des données pour chaque période de paie
        foreach ($periodesPaie as $periode) {
            $periode->decrypted_data = $periode->decryptedData;
        }
    
        return view('periodes_paie.index', compact('periodesPaie', 'clients', 'gestionnaires'));
    }


    public function create()
    {
        $clients = Client::all();
        $gestionnaires = User::role('gestionnaire')->get();
        return view('periodes_paie.create', compact('clients', 'gestionnaires'));
    }

    public function store(StorePeriodePaieRequest $request)
    {
        $validated = $request->validated();
        $client = Client::findOrFail($validated['client_id']);
        $reference = strtoupper(now()->format('M')) . '_' . strtoupper($client->name);

        $periodePaie = PeriodePaie::create(array_merge($validated, ['reference' => $reference]));

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'details' => 'Période de paie créée',
        ]);

        return redirect()->route('periodes-paie.index')->with('success', 'Période de paie créée avec succès.');
    }

    public function show(PeriodePaie $periodePaie)
    {
        // $periodePaie->load('client', 'histories.user');
        // Déchiffrer les données de la période de paie
    $periodePaie->decrypted_data = $periodePaie->decryptedData;

    return view('periodes_paie.show', compact('periodePaie'));
}

    public function edit(PeriodePaie $periodePaie)
    {
        if ($periodePaie->validee && !Auth::user()->hasRole(['admin', 'responsable'])) {
            return redirect()->route('periodes-paie.index')->with('error', 'Vous n\'avez pas l\'autorisation de modifier une période validée.');
        }

        $clients = Client::all();
        return view('periodes_paie.edit', compact('periodePaie', 'clients'));
    }



    public function destroy(PeriodePaie $periodePaie)
    {
        try {
            $periodePaie->delete();
            return redirect()->route('periodes-paie.index')->with('success', 'Période de paie supprimée avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de la période de paie : ' . $e->getMessage());
            return redirect()->route('periodes-paie.index')->with('error', 'Impossible de supprimer cette période de paie. ' . $e->getMessage());
        }
    }

    public function update(UpdatePeriodePaieRequest $request, PeriodePaie $periodePaie)
    {
        if ($periodePaie->validee && !Auth::user()->hasRole(['admin', 'responsable'])) {
            return redirect()->route('periodes-paie.index')->with('error', 'Vous n\'avez pas l\'autorisation de modifier une période validée.');
        }

        $validated = $request->validated();
        $periodePaie->update($validated);

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'details' => 'Période de paie mise à jour',
        ]);

        return redirect()->route('periodes-paie.index')->with('success', 'Période de paie mise à jour avec succès.');
    }

    public function valider(PeriodePaie $periodePaie)
    {
        if ($periodePaie->canBeValidated()) {
            $periodePaie->update(['validee' => true]);

            PeriodePaieHistory::create([
                'periode_paie_id' => $periodePaie->id,
                'user_id' => Auth::id(),
                'action' => 'validated',
                'details' => 'Période de paie validée',
            ]);

            return redirect()->route('periodes-paie.index')->with('success', 'Période de paie validée avec succès.');
        } else {
            return redirect()->route('periodes-paie.index')->with('error', 'Tous les traitements de paie doivent être complets avant de valider la période.');
        }
    }

    public function updateRelation(Request $request, $userId)
    {
        // Récupérer l'utilisateur spécifique
        $user = User::findOrFail($userId);

        // Définir les détails de la notification
        $action = 'Voir les détails';
        $details = 'La relation a été mise à jour.';

        // Envoyer la notification
        $user->notify(new RelationUpdated($action, $details));

        return redirect()->back()->with('success', 'Notification envoyée avec succès.');
    }

    public function encryptOldPeriods()
    {
        $periodes = PeriodePaie::where('validee', 1)->get();

        foreach ($periodes as $periode) {
            if ($periode->shouldBeEncrypted()) {
                $periode->encrypted_data = $periode->encryptedData;
                $periode->save();
            }
        }

        return redirect()->route('periodes-paie.index')->with('success', 'Périodes de paie chiffrées avec succès.');
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes_paie,id',
            'field' => 'required|string',
            'value' => 'nullable|string',
            'date_value' => 'nullable|date',
        ]);

        $periodePaie = PeriodePaie::findOrFail($request->periode_id);
        $field = $request->field;
        $value = $request->value;

        // Utiliser la valeur de date si le champ sélectionné est une date
        if (in_array($field, ['reception_variables', 'preparation_bp', 'validation_bp_client', 'preparation_envoie_dsn', 'accuses_dsn'])) {
            $value = $request->date_value;
        }

        $periodePaie->update([$field => $value]);

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'details' => "Champ $field mis à jour",
        ]);

        return redirect()->route('periodes-paie.index')->with('success', 'Champ mis à jour avec succès.');
    }
}

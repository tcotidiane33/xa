<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Material;
use App\Models\FicheClient;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use App\Models\MaterialHistory;
use App\Models\PeriodePaieHistory;
use App\Exports\ClientPeriodeExport;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PeriodePaieService
{
    public function generateReference()
    {
        $currentMonth = Carbon::now()->format('F');
        $currentYear = Carbon::now()->format('Y');
        return 'PERIODE_' . strtoupper($currentMonth) . '_' . $currentYear;
    }

    public function createPeriodePaie(array $data)
    {
        $periodePaie = PeriodePaie::create($data);
        $periodePaie->generateReference();
        $periodePaie->save();

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'details' => 'Période de paie créée',
        ]);

        return $periodePaie;
    }

    public function updatePeriodePaie(PeriodePaie $periodePaie, array $data)
    {
        $periodePaie->update($data);

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'details' => 'Période de paie mise à jour',
        ]);

        return $periodePaie;
    }

    public function openPeriodePaie(PeriodePaie $periodePaie)
    {
        $periodePaie->validee = false;
        $periodePaie->save();

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'opened',
            'details' => 'Période de paie déclôturée',
        ]);
    }

    public function closePeriodePaie(PeriodePaie $periodePaie)
    {
        $periodePaie->validee = true;
        $periodePaie->save();
    
        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'closed',
            'details' => 'Période de paie clôturée',
        ]);
    
        // Sauvegarder les fiches clients comme archives
        $this->createFilesForClients($periodePaie);
    
        // Exporter les données des clients pour la période de paie
        Excel::store(new ClientPeriodeExport($periodePaie), 'exports/clients_periode_' . $periodePaie->id . '.xlsx');
    }
    
    protected function createFilesForClients(PeriodePaie $periodePaie)
    {
        $clients = Client::all();
    
        foreach ($clients as $client) {
            $ficheClient = FicheClient::where('client_id', $client->id)
                                      ->where('periode_paie_id', $periodePaie->id)
                                      ->first();
    
            if ($ficheClient) {
                $fileName = $client->name . '_BACKUP_' . $periodePaie->reference . '_FC_' . now()->year . '.xlsx';
                $filePath = 'materials/' . $fileName;
    
                // Générer le fichier Excel
                Excel::store(new ClientPeriodeExport($periodePaie), $filePath);
    
                // Créer un enregistrement dans la table materials
                $material = Material::create([
                    'client_id' => $client->id,
                    'user_id' => Auth::id(),
                    'title' => $fileName,
                    'type' => 'excel',
                    'content_url' => $filePath,
                    'field_name' => 'Période de paie'
                ]);
    
                // Enregistrer l'historique des actions sur le matériau
                $this->logMaterialAction($material, 'created', 'Fichier de sauvegarde créé lors de la clôture de la période de paie.');
            }
        }
    }
    
    protected function logMaterialAction(Material $material, $action, $details)
    {
        MaterialHistory::create([
            'material_id' => $material->id,
            'user_id' => Auth::id(),
            'action' => $action,
            'details' => $details,
        ]);
    }
    public function deletePeriodePaie(PeriodePaie $periodePaie)
    {
        $periodePaie->delete();

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'details' => 'Période de paie supprimée',
        ]);
    }

    public function validatePeriodePaie(PeriodePaie $periodePaie)
    {
        // Vérifiez que tous les traitements de paie sont complets avant de valider la période
        $incompleteFiches = $periodePaie->fichesClients()->whereNull('accuses_dsn')->count();

        if ($incompleteFiches > 0) {
            return false;
        }

        $periodePaie->validee = true;
        $periodePaie->save();

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'validated',
            'details' => 'Période de paie validée',
        ]);

        return true;
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
    }

    public function getEligibleClients()
    {
        $nextMonth = Carbon::now()->addMonth();
        $fifteenthNextMonth = $nextMonth->copy()->day(15);

        return Client::where('date_signature_contrat', '<=', $fifteenthNextMonth)
            ->where('date_fin_prestation', '>=', $fifteenthNextMonth)
            ->get();
    }

    public function getEligibleClientsForCurrentPeriod()
    {
        $currentPeriod = PeriodePaie::where('validee', false)->latest()->first();
        if (!$currentPeriod) {
            return collect(); // Retourne une collection vide si aucune période en cours n'est trouvée
        }

        return Client::where('date_signature_contrat', '<=', $currentPeriod->fin)
            ->where('date_fin_prestation', '>=', $currentPeriod->debut)
            ->get();
    }
}

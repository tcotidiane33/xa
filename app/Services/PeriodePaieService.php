<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Material;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use App\Models\PeriodePaieHistory;
use Illuminate\Support\Facades\Auth;
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
    protected function createFilesForClients(PeriodePaie $periodePaie)
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            $traitementPaie = TraitementPaie::where('client_id', $client->id)
                                             ->where('periode_paie_id', $periodePaie->id)
                                             ->first();

            $fileName = $periodePaie->reference . 'BACKUP_' . $client->name . '.txt';
            $filePath = 'materials/' . $fileName;

            $content = "Client: {$client->name}\n";
            $content .= "Email: {$client->email}\n";
            $content .= "Téléphone: {$client->phone}\n";
            $content .= "Responsable: " . ($client->responsable ? $client->responsable->name : 'N/A') . "\n";
            $content .= "Gestionnaire: " . ($client->gestionnaire ? $client->gestionnaire->name : 'N/A') . "\n";
            $content .= "Contact Paie: {$client->contact_paie_nom} ({$client->contact_paie_email})\n";
            $content .= "Contact Comptable: {$client->contact_compta_nom} ({$client->contact_compta_email})\n";
            $content .= "Période de paie: {$periodePaie->reference}\n";
            $content .= "Début: {$periodePaie->debut->format('Y-m-d')}\n";
            $content .= "Fin: {$periodePaie->fin->format('Y-m-d')}\n";
            $content .= "Réception variables: {$traitementPaie->reception_variables_file}\n";
            $content .= "Préparation BP: {$traitementPaie->preparation_bp_file}\n";
            $content .= "Validation BP client: {$traitementPaie->validation_bp_client_file}\n";
            $content .= "Préparation et envoie DSN: {$traitementPaie->preparation_envoi_dsn_file}\n";
            $content .= "Accusés DSN: {$traitementPaie->accuses_dsn_file}\n";
            $content .= "NOTES: {$traitementPaie->notes}\n";

            Storage::put($filePath, $content);

            Material::create([
                'client_id' => $client->id,
                'user_id' => Auth::id(),
                'title' => $fileName,
                'type' => 'text',
                'content_url' => $filePath,
                'field_name' => 'Période de paie'
            ]);
        }
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

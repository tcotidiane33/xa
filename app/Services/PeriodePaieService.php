<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use App\Models\PeriodePaieHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $reference = $this->generateReference();
        $periodePaie = PeriodePaie::create(array_merge($data, ['reference' => $reference]));

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
        if ($periodePaie->canBeValidated()) {
            $periodePaie->update(['validee' => true]);

            PeriodePaieHistory::create([
                'periode_paie_id' => $periodePaie->id,
                'user_id' => Auth::id(),
                'action' => 'validated',
                'details' => 'Période de paie validée',
            ]);

            return true;
        }

        return false;
    }

    public function closePeriodePaie(PeriodePaie $periodePaie)
    {
        $periodePaie->update(['cloturee' => true]);

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'closed',
            'details' => 'Période de paie clôturée',
        ]);
    }

    public function openPeriodePaie(PeriodePaie $periodePaie)
    {
        $periodePaie->update(['cloturee' => false]);

        PeriodePaieHistory::create([
            'periode_paie_id' => $periodePaie->id,
            'user_id' => Auth::id(),
            'action' => 'opened',
            'details' => 'Période de paie déclôturée',
        ]);
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
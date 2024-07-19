<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\PeriodePaie;
use Illuminate\Http\Request;
use App\Models\TraitementPaie;
use Illuminate\Support\Facades\Mail;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Routing\Annotation\Route;

class PeriodePaieController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        $gestionnaireId = $request->input('gestionnaire_id');
        $clientId = $request->input('client_id');

        $query = TraitementPaie::whereHas('periodePaie', function ($q) use ($periode) {
            $q->where('debut', 'LIKE', "$periode%");
        });

        if ($gestionnaireId) {
            $query->where('gestionnaire_id', $gestionnaireId);
        }

        if ($clientId) {
            $query->where('client_id', $clientId);
        }

        // $traitementsPaie = $query->with(['gestionnaire', 'client', 'periodePaie'])->get();
        $traitementsPaie = $query->with(['gestionnaire', 'client', 'periodePaie'])->get();
        dd($traitementsPaie); // <--- Add this line to see what's being passed

        $clients = Client::all();
        $gestionnaires = User::whereHas('role', function($q) {
            $q->whereIn('name', ['admin', 'responsable']);
        })->get();

        $periodeActuelle = PeriodePaie::where('debut', 'LIKE', "$periode%")->first();

        return view('periodes_paie.index', compact('traitementsPaie', 'clients', 'gestionnaires', 'periode', 'periodeActuelle'));
    }

    public function periodesPaie()
    {
        $periodesPaie = PeriodePaie::all();
        return view('periodes_paie.periodes_paie', compact('periodesPaie'));
    }

    public function valider(Request $request)
    {
        $periode = $request->input('periode');

        PeriodePaie::where('debut', 'LIKE', "$periode%")->update(['validee' => true]);

        // Créer la période pour le mois suivant
        $nextPeriode = Carbon::createFromFormat('Y-m', $periode)->addMonth();
        PeriodePaie::create([
            'debut' => $nextPeriode->startOfMonth(),
            'fin' => $nextPeriode->endOfMonth(),
            'validee' => false
        ]);

        return redirect()->route('periodes_paie.index')->with('success', 'Période de paie validée et nouvelle période créée');
    }

    public function updateField(Request $request, TraitementPaie $traitementPaie)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $traitementPaie->$field = $value;
        $traitementPaie->save();

        return response()->json(['success' => true]);
    }


    /**
     * @Route("/periodes-paie/valider", name="periodes_paie_valider")
     */
    public function validerSend(Request $request)
    {
        $periode = $request->input('periode');

        $periodePaie = PeriodePaie::where('debut', 'LIKE', "$periode%")->first();

        if (!$periodePaie) {
            throw new \Exception('Periode paie not found');
        }

        if ($periodePaie->validee) {
            return redirect()->route('periodes_paie.index');
        }

        // Send reminder every 24 hours until validation
        $now = Carbon::now();
        $nextReminder = $periodePaie->created_at->addHours(24);

        if ($now > $nextReminder) {
            // Send alert (e.g. email or notification)
            $this->sendAlert($periodePaie);

            // Update next reminder date
            $periodePaie->created_at = $now;
            $periodePaie->save();
        }

        // Validate periode paie
        $periodePaie->validee = true;
        $periodePaie->save();

        return redirect()->route('periodes_paie.index');
    }

    private function sendAlert(PeriodePaie $periodePaie)
    {
        // Implement your alert sending logic here (e.g. email or notification)
        // For example:
        Mail::to('recipient_email@example.com')->send(new PeriodePaieReminder($periodePaie));
    }

}

// private function sendAlert(PeriodePaie $periodePaie)
// {
//     // Implement your alert sending logic here (e.g. email or notification)
//     // For example:
//     $message = \Swift_Message::newInstance()
//         ->setSubject('Reminder: Periode paie validation')
//         ->setFrom('your_email@example.com')
//         ->setTo('recipient_email@example.com')
//         ->setBody('Please validate the periode paie for ' . $periodePaie->getDebut()->format('Y-m'));

//     $this->get('mailer')->send($message);
// }

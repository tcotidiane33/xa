<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Client;
use Livewire\Component;
use App\Models\PeriodePaie;
use App\Models\TraitementPaie;
use Illuminate\Support\Facades\Auth;

class PeriodePaieForm extends Component
{
    public $currentStep = 1;
    public $totalSteps = 3; // Mise à jour du nombre total d'étapes
    public $reference, $debut, $fin, $periodePaieId, $clientId; // Ajout de la propriété clientId
    public $isAdminOrResponsable;
    public $isGestionnaire;
    public $periodesPaieNonCloturees;
    public $clients;
    // Propriétés pour les champs de date
    public $reception_variables, $preparation_bp, $validation_bp_client, $preparation_envoie_dsn, $accuses_dsn, $notes;


    public function mount()
    {
        $this->isAdminOrResponsable = Auth::user()->hasAnyRole(['Admin', 'Responsable']);
        $this->isGestionnaire = Auth::user()->hasAnyRole('Gestionnaire');
        $this->periodesPaieNonCloturees = PeriodePaie::getNonCloturees();
        $this->clients = Auth::user()->clientsAsGestionnaire; // Récupérer les clients rattachés au gestionnaire

    }

    public function render()
    {
        $periodesPaie = PeriodePaie::all();
        return view('livewire.periode-paie-form', [
            'periodesPaie' => $periodesPaie,
            'isAdminOrResponsable' => $this->isAdminOrResponsable,
            'isGestionnaire' => $this->isGestionnaire,
        ]);
    }

    public function submitForm()
    {
        $this->validate([
            'debut' => 'required|date',
            'fin' => 'required|date|after_or_equal:debut',
        ]);

        // Générer la référence
        $reference = $this->generateUniqueReference();

        // Enregistrer les données du formulaire
        PeriodePaie::create([
            'reference' => $reference,
            'debut' => $this->debut,
            'fin' => $this->fin,
            // 'client_id' => 0, // Indique que cela concerne tous les clients
        ]);

        session()->flash('message', 'Période de paie créée avec succès.');

        return redirect()->route('periodes-paie.index');
    }

    public function cloturerPeriode($id)
    {
        $periode = PeriodePaie::find($id);
        $periode->validee = 1;
        $periode->save();

        session()->flash('message', 'Période de paie clôturée avec succès.');
    }

    public function decloturerPeriode($id)
    {
        $periode = PeriodePaie::find($id);
        $periode->validee = 0;
        $periode->save();

        session()->flash('message', 'Période de paie rouverte avec succès.');
    }

    private function generateUniqueReference()
    {
        $currentMonth = Carbon::now()->format('F');
        $currentYear = Carbon::now()->format('Y');
        $reference = 'PERIODE_' . strtoupper($currentMonth) . '_' . $currentYear;

        // Vérifier si la référence existe déjà
        $existingReference = PeriodePaie::where('reference', $reference)->exists();
        if ($existingReference) {
            // Ajouter un suffixe unique si la référence existe déjà
            $reference .= '_' . uniqid();
        }

        return $reference;
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'periodePaieId' => 'required|exists:periodes_paie,id',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'clientId' => 'required|exists:clients,id',
            ]);
        }

        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function saveVariables()
    {
        $this->validate([
            'reception_variables' => 'required|date|after_or_equal:' . $this->debut . '|before_or_equal:' . $this->fin,
            'preparation_bp' => 'nullable|date|after_or_equal:reception_variables|before_or_equal:' . $this->fin,
            'validation_bp_client' => 'nullable|date|after_or_equal:preparation_bp|before_or_equal:' . $this->fin,
            'preparation_envoie_dsn' => 'nullable|date|after_or_equal:validation_bp_client|before_or_equal:' . $this->fin,
            'accuses_dsn' => 'nullable|date|after_or_equal:preparation_envoie_dsn|before_or_equal:' . $this->fin,
            'notes' => 'nullable|string',
        ], [
            'reception_variables.after_or_equal' => 'La date de réception des variables doit être après ou égale à la date de début de la période.',
            'reception_variables.before_or_equal' => 'La date de réception des variables doit être avant ou égale à la date de fin de la période.',
            'preparation_bp.after_or_equal' => 'La date de préparation BP doit être après ou égale à la date de réception des variables.',
            'preparation_bp.before_or_equal' => 'La date de préparation BP doit être avant ou égale à la date de fin de la période.',
            'validation_bp_client.after_or_equal' => 'La date de validation BP client doit être après ou égale à la date de préparation BP.',
            'validation_bp_client.before_or_equal' => 'La date de validation BP client doit être avant ou égale à la date de fin de la période.',
            'preparation_envoie_dsn.after_or_equal' => 'La date de préparation et envoi DSN doit être après ou égale à la date de validation BP client.',
            'preparation_envoie_dsn.before_or_equal' => 'La date de préparation et envoi DSN doit être avant ou égale à la date de fin de la période.',
            'accuses_dsn.after_or_equal' => 'La date des accusés DSN doit être après ou égale à la date de préparation et envoi DSN.',
            'accuses_dsn.before_or_equal' => 'La date des accusés DSN doit être avant ou égale à la date de fin de la période.',
        ]);

        TraitementPaie::create([
            'client_id' => $this->clientId,
            'periode_paie_id' => $this->periodePaieId,
            'reception_variables' => $this->reception_variables,
            'preparation_bp' => $this->preparation_bp,
            'validation_bp_client' => $this->validation_bp_client,
            'preparation_envoie_dsn' => $this->preparation_envoie_dsn,
            'accuses_dsn' => $this->accuses_dsn,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Variables enregistrées avec succès.');

        return redirect()->route('periodes-paie.index');
    }
}

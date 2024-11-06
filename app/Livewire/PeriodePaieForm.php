<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\PeriodePaie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PeriodePaieForm extends Component
{
    public $currentStep = 1;
    public $totalSteps = 1; // Mise à jour du nombre total d'étapes
    public $reference, $debut, $fin;
    public $isAdminOrResponsable;

    public function mount()
    {
        $this->isAdminOrResponsable = Auth::user()->hasAnyRole(['Admin', 'Responsable']);
    }

    public function render()
    {
        $periodesPaie = PeriodePaie::all();
        return view('livewire.periode-paie-form', compact('periodesPaie'));
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
}
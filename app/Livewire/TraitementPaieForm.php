<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Client;
use App\Models\PeriodePaie;
use App\Models\TraitementPaie;
use App\Models\User;

class TraitementPaieForm extends Component
{
    use WithFileUploads;

    public $traitementPaieId;
    public $clients;
    public $gestionnaires;
    public $periodesPaie;
    public $client_id;
    public $gestionnaire_id;
    public $periode_paie_id;
    public $nbr_bull;
    public $teledec_urssaf;
    public $reception_variables;
    public $preparation_bp;
    public $validation_bp_client;
    public $preparation_envoie_dsn;
    public $accuses_dsn;
    public $notes;
    public $maj_fiche_para_file;
    public $reception_variables_file;
    public $preparation_bp_file;
    public $validation_bp_client_file;
    public $preparation_envoi_dsn_file;
    public $accuses_dsn_file;

    public function mount($traitementPaieId = null)
    {
        $this->clients = Client::all();
        $this->gestionnaires = User::role('gestionnaire')->get();
        $this->periodesPaie = PeriodePaie::all();

        if ($traitementPaieId) {
            $traitementPaie = TraitementPaie::findOrFail($traitementPaieId);
            $this->traitementPaieId = $traitementPaie->id;
            $this->client_id = $traitementPaie->client_id;
            $this->gestionnaire_id = $traitementPaie->gestionnaire_id;
            $this->periode_paie_id = $traitementPaie->periode_paie_id;
            $this->nbr_bull = $traitementPaie->nbr_bull;
            $this->teledec_urssaf = $traitementPaie->teledec_urssaf;
            $this->reception_variables = $traitementPaie->reception_variables;
            $this->preparation_bp = $traitementPaie->preparation_bp;
            $this->validation_bp_client = $traitementPaie->validation_bp_client;
            $this->preparation_envoie_dsn = $traitementPaie->preparation_envoie_dsn;
            $this->accuses_dsn = $traitementPaie->accuses_dsn;
            $this->notes = $traitementPaie->notes;
        }
    }

    public function render()
    {
        return view('livewire.traitement-paie-form');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'client_id' => 'required|exists:clients,id',
            'gestionnaire_id' => 'required|exists:users,id',
            'periode_paie_id' => 'required|exists:periodes_paie,id',
            'nbr_bull' => 'required|integer',
            'teledec_urssaf' => 'nullable|date',
            'reception_variables' => 'nullable|date',
            'preparation_bp' => 'nullable|date',
            'validation_bp_client' => 'nullable|date',
            'preparation_envoie_dsn' => 'nullable|date',
            'accuses_dsn' => 'nullable|date',
            'notes' => 'nullable|string',
            'maj_fiche_para_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
            'reception_variables_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
            'preparation_bp_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
            'validation_bp_client_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
            'preparation_envoi_dsn_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
            'accuses_dsn_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
        ]);

        if ($this->traitementPaieId) {
            $traitementPaie = TraitementPaie::findOrFail($this->traitementPaieId);
            $traitementPaie->update($validatedData);
        } else {
            $traitementPaie = TraitementPaie::create($validatedData);
        }

        // Gérer les uploads de fichiers
        $fileFields = [
            'maj_fiche_para_file',
            'reception_variables_file',
            'preparation_bp_file',
            'validation_bp_client_file',
            'preparation_envoi_dsn_file',
            'accuses_dsn_file'
        ];

        foreach ($fileFields as $field) {
            if ($this->$field) {
                $traitementPaie->$field = $this->$field->store('traitements_paie');
            }
        }

        $traitementPaie->save();

        session()->flash('message', 'Traitement de paie enregistré avec succès.');

        return redirect()->route('traitements-paie.index');
    }
}
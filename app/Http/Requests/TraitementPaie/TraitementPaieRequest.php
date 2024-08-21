<?php

namespace App\Http\Requests\TraitementPaie;

use Illuminate\Foundation\Http\FormRequest;

class TraitementPaieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nbr_bull' => 'required|integer',
            'gestionnaire_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'periode_paie_id' => 'required|exists:periodes_paie,id',
            'reception_variable' => 'nullable|date',
            'preparation_bp' => 'nullable|date',
            'validation_bp_client' => 'nullable|date',
            'preparation_envoie_dsn' => 'nullable|date',
            'accuses_dsn' => 'nullable|date',
            'teledec_urssaf' => 'nullable|date',
            'notes' => 'nullable|string',
            'maj_fiche_para_file' => 'nullable|file',
            'reception_variables_file' => 'nullable|file',
            'preparation_bp_file' => 'nullable|file',
            'validation_bp_client_file' => 'nullable|file',
            'preparation_envoi_dsn_file' => 'nullable|file',
            'accuses_dsn_file' => 'nullable|file',
        ];
    }
}
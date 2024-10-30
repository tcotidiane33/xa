<?php

namespace App\Http\Requests\PeriodePaie;

use Illuminate\Foundation\Http\FormRequest;

class StorePeriodePaieRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ou utilisez une logique d'autorisation appropriée
    }

    public function rules()
    {
        return [
            'reference' => 'required|string|max:255|unique:periodes_paie,reference',
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut',
            'validee' => 'boolean',
            'client_id' => 'required|exists:clients,id',
            
            'reception_variables' => 'nullable|date',
            'preparation_bp' => 'nullable|date',
            'validation_bp_client' => 'nullable|date',
            'preparation_envoie_dsn' => 'nullable|date',
            'accuses_dsn' => 'nullable|date',
            'notes' => 'nullable|string',
        ];
    }
}
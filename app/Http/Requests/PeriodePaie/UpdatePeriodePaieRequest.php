<?php

namespace App\Http\Requests\PeriodePaie;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodePaieRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ou utilisez une logique d'autorisation appropriée
    }

    public function rules()
    {
        return [
            'reference' => 'required|string|max:255|unique:periodes_paie,reference,' . $this->periodePaie->id,
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut',
            'validee' => 'boolean',
            'client_id' => 'required|exists:clients,id',
        ];
    }
}
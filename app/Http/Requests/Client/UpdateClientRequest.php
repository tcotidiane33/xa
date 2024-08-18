<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'responsable_paie_id' => 'nullable|exists:users,id',
            'gestionnaire_principal_id' => 'nullable|exists:users,id',
            'date_debut_prestation' => 'nullable|date',
            'date_estimative_envoi_variables' => 'nullable|date',
            'date_rappel_mail' => 'nullable|date',
            'contact_paie' => 'nullable|string|max:255',
            'contact_comptabilite' => 'nullable|string|max:255',
            'status' => 'sometimes|required|string|in:actif,inactif',
            'nb_bulletins' => 'sometimes|required|integer|min:0',
            'maj_fiche_para' => 'nullable|date',
            'convention_collective_id' => 'nullable|exists:convention_collective,id',
        ];
    }
}

<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Assurez-vous que l'utilisateur est autorisé à créer un client
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type_societe' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'dirigeant_nom' => 'nullable|string|max:255',
            'dirigeant_telephone' => 'nullable|string|max:20',
            'dirigeant_email' => 'nullable|email|max:255',
            'contact_paie_nom' => 'nullable|string|max:255',
            'contact_paie_prenom' => 'nullable|string|max:255',
            'contact_paie_telephone' => 'nullable|string|max:20',
            'contact_paie_email' => 'nullable|email|max:255',
            'contact_compta_nom' => 'nullable|string|max:255',
            'contact_compta_prenom' => 'nullable|string|max:255',
            'contact_compta_telephone' => 'nullable|string|max:20',
            'contact_compta_email' => 'nullable|email|max:255',

            // Champs internes
            'responsable_paie_id' => 'nullable|exists:users,id',
            'gestionnaire_principal_id' => 'nullable|exists:users,id',
            'binome_id' => 'nullable|exists:users,id',

            // Champs supplémentaires
            'date_debut_prestation' => 'nullable|date',
            'date_estimative_envoi_variables' => 'nullable|date',
            'date_rappel_mail' => 'nullable|date',
            'contact_paie' => 'nullable|string|max:255',
            'contact_comptabilite' => 'nullable|string|max:255',
            'status' => 'required|string|in:actif,inactif',
            'nb_bulletins' => 'required|integer|min:0',
            'maj_fiche_para' => 'nullable|date',
            'convention_collective_id' => 'nullable|exists:convention_collective,id',
            'is_portfolio' => 'boolean',
            'parent_client_id' => 'nullable|exists:clients,id',

            // Nouveaux champs
            'saisie_variables' => 'boolean',
            'client_forme_saisie' => 'boolean',
            'date_formation_saisie' => 'nullable|date',
            'date_fin_prestation' => 'nullable|date',
            'date_signature_contrat' => 'nullable|date',
            'taux_at' => 'nullable|string|max:255',
            'adhesion_mydrh' => 'boolean',
            'date_adhesion_mydrh' => 'nullable|date',
            'is_cabinet' => 'boolean',
            'portfolio_cabinet_id' => 'nullable|exists:clients,id',
        ];
    }
}

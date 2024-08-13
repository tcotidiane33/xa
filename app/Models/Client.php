<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = [
        'name', 'responsable_paie_id', 'gestionnaire_principal_id', 'date_debut_prestation',
        'contact_paie', 'contact_comptabilite', 'nb_bulletins', 'maj_fiche_para',
        'convention_collective', 'status'
    ];

    protected $dates = ['date_debut_prestation', 'maj_fiche_para'];

    public function responsablePaie(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_paie_id');
    }

    public function gestionnairePrincipal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestionnaire_principal_id');
    }

    public function gestionnaireSecondaires(): HasMany
    {
        return $this->hasMany(GestionnaireSecondaire::class);
    }

    public function traitementsPaie(): HasMany
    {
        return $this->hasMany(TraitementPaie::class);
    }
    public function conventionCollective()
    {
        return $this->belongsTo(ConventionCollective::class);
    }

}
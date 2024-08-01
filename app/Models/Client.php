<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'responsable_paie_id',
        'gestionnaire_principal_id',
        'date_debut_prestation',
        'convention_collective',
        'contact_paie',
        'contact_comptabilite',
        'aj_fiche_para',
        'code_acces',
        'date_feedback_mail',
        'date_estimate_send_var'
    ];

    public function responsablePaie()
    {
        return $this->belongsTo(User::class, 'responsable_paie_id');
    }

    public function gestionnairePrincipal()
    {
        return $this->belongsTo(User::class, 'gestionnaire_principal_id');
    }

    public function gestionnaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client', 'client_id', 'gestionnaire_id');
    }

    public function traitementsPaie()
    {
        return $this->hasMany(TraitementPaie::class);
    }

    public function periodesPaie()
    {
        return $this->hasMany(PeriodePaie::class);
    }

    public function conventionCollective()
    {
        return $this->belongsTo(ConventionCollective::class);
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TraitementPaie extends Model
{
    use HasFactory;
    protected $table = 'traitements_paie';

    protected $fillable = [
        'gestionnaire_id',
        'superviseur_id',
        'responsable_id',
        'gestionnaires_ids',
        'client_id',
        'periode_paie_id',
        'reference',
        'nbr_bull',
        'maj_fiche_para',
        'reception_variable',
        'preparation_bp',
        'validation_bp_client',
        'preparation_envoie_dsn',
        'accuses_dsn',
        'teledec_urssaf',
        'notes',
        'listBoxIsEmpty',
        'pj_nbr_bull',
        'pj_maj_fiche_para',
        'pj_reception_variable',
        'pj_preparation_bp',
        'pj_validation_bp_client',
        'pj_preparation_envoie_dsn',
        'link_preparation_envoie_dsn',
        'pj_accuses_dsn',
        'link_accuses_dsn',
        'progress'
    ];

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function periodePaie()
    {
        return $this->belongsTo(PeriodePaie::class);
    }
}

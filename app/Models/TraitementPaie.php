<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraitementPaie extends Model
{
    protected $fillable = [
        'client_id', 'periode_paie_id', 'gestionnaire_id', 'reception_variables',
        'preparation_bp', 'validation_bp_client', 'preparation_envoi_dsn',
        'accuses_dsn', 'teledec_urssaf', 'notes',   'nb_bulletins_file',
        'maj_fiche_para_file',
        'reception_variables_file',
        'preparation_bp_file',
        'validation_bp_client_file',
        'preparation_envoi_dsn_file',
        'accuses_dsn_file',
    ];

    protected $dates = [
        'reception_variables', 'preparation_bp', 'validation_bp_client',
        'preparation_envoi_dsn', 'accuses_dsn', 'teledec_urssaf'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function periodePaie(): BelongsTo
    {
        return $this->belongsTo(PeriodePaie::class);
    }

    public function gestionnaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }
}
    // protected $fillable = [
    //     'gestionnaire_id',
    //     'superviseur_id',
    //     'responsable_id',
    //     'gestionnaires_ids',
    //     'client_id',
    //     'periode_paie_id',
    //     'reference',
    //     'nbr_bull',
    //     'maj_fiche_para',
    //     'reception_variable',
    //     'preparation_bp',
    //     'validation_bp_client',
    //     'preparation_envoie_dsn',
    //     'accuses_dsn',
    //     'teledec_urssaf',
    //     'notes',
    //     'listBoxIsEmpty',
    //     'pj_nbr_bull',
    //     'pj_maj_fiche_para',
    //     'pj_reception_variable',
    //     'pj_preparation_bp',
    //     'pj_validation_bp_client',
    //     'pj_preparation_envoie_dsn',
    //     'link_preparation_envoie_dsn',
    //     'pj_accuses_dsn',
    //     'link_accuses_dsn',
    //     'progress'
    // ];
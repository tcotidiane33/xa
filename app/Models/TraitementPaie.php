<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraitementPaie extends Model
{
    protected $table = 'traitements_paie';

    protected $fillable = [
        'reference', 'gestionnaire_id', 'client_id', 'periode_paie_id',
        'nbr_bull', 'reception_variable', 'preparation_bp', 'validation_bp_client',
        'preparation_envoie_dsn', 'accuses_dsn', 'teledec_urssaf', 'notes',
        'maj_fiche_para_file',
        'reception_variables_file',
        'preparation_bp_file',
        'validation_bp_client_file',
        'preparation_envoi_dsn_file',
        'accuses_dsn_file',
    ];


    protected $dates = [
        'reception_variable', 'preparation_bp', 'validation_bp_client',
        'preparation_envoie_dsn', 'accuses_dsn', 'teledec_urssaf'
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
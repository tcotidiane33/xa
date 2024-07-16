<?php

namespace App\Models;

use App\Models\PeriodePaie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TraitementPaie extends Model
{
    use HasFactory;
    protected $table = 'traitements_paie';

    protected $fillable = [
        'gestionnaire_id',
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
        'notes'
    ];

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function periodePaie()
    {
        return $this->belongsTo(PeriodePaie::class, 'periode_paie_id');
    }
}

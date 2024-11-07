<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class TraitementPaie extends Model
{
    protected $table = 'traitements_paie';

    protected $fillable = [
        'reference', 'gestionnaire_id', 'client_id', 'periode_paie_id',
        'nbr_bull', 'teledec_urssaf',
        'maj_fiche_para_file', 'reception_variables_file', 'preparation_bp_file',
        'validation_bp_client_file', 'preparation_envoi_dsn_file', 'accuses_dsn_file',
    ];

    protected $dates = [
        'teledec_urssaf'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($traitementPaie) {
            $traitementPaie->reference = 'TP-' . Str::upper(Str::random(8));
        });
    }

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


    public function getNotesAttribute($value)
    {
        $previousNotes = self::where('client_id', $this->client_id)
            ->where('periode_paie_id', '<', $this->periode_paie_id)
            ->pluck('notes')
            ->implode("\n");

        return $previousNotes . "\n" . $value;
    }
}

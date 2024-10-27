<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodePaie extends Model
{
    protected $table = 'periodes_paie';

    protected $fillable = [
        'reference', 'debut', 'fin', 'validee', 'client_id', 'reception_variables', 'preparation_bp',
        'validation_bp_client', 'preparation_envoie_dsn', 'accuses_dsn', 'notes'
    ];
    protected $dates = ['debut', 'fin'];

    protected $casts = [
        'debut' => 'date',
        'fin' => 'date',
        'validee' => 'boolean',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function traitementsPaie()
    {
        return $this->hasMany(TraitementPaie::class);
    }
    public function histories()
    {
        return $this->hasMany(PeriodePaieHistory::class);
    }

    public function canBeValidated()
    {
        // Vérifiez si tous les traitements de paie pour cette période sont complets
        return $this->traitementsPaie()->where('teledec_urssaf', null)->count() === 0;
    }
}

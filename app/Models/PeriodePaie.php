<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodePaie extends Model
{
    protected $table = 'periodes_paie';

    protected $fillable = ['reference', 'debut', 'fin', 'validee', 'client_id'];

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
    public function canBeValidated()
{
    // Vérifiez si tous les traitements de paie pour cette période sont complets
    return $this->traitementsPaie()->where('teledec_urssaf', null)->count() === 0;
}

    public function traitementsPaie()
    {
        return $this->hasMany(TraitementPaie::class);
    }
}

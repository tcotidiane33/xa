<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodePaie extends Model
{
    protected $fillable = ['debut', 'fin', 'validee'];

    protected $dates = ['debut', 'fin'];

    protected $casts = [
        'validee' => 'boolean',
    ];

    public function traitementsPaie(): HasMany
    {
        return $this->hasMany(TraitementPaie::class);
    }

    public function canBeValidated()
{
    // Vérifiez si tous les traitements de paie pour cette période sont complets
    return $this->traitementsPaie()->where('teledec_urssaf', null)->count() === 0;
}
}
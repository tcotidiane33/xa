<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

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

    public function progressPercentage()
    {
        $totalSteps = 5; // Nombre total d'étapes
        $completedSteps = 0;

        if ($this->reception_variables) $completedSteps++;
        if ($this->preparation_bp) $completedSteps++;
        if ($this->validation_bp_client) $completedSteps++;
        if ($this->preparation_envoie_dsn) $completedSteps++;
        if ($this->accuses_dsn) $completedSteps++;

        return ($completedSteps / $totalSteps) * 100;
    }

    public function getEncryptedDataAttribute()
    {
        return Crypt::encryptString(json_encode([
            'reception_variables' => $this->reception_variables,
            'preparation_bp' => $this->preparation_bp,
            'validation_bp_client' => $this->validation_bp_client,
            'preparation_envoie_dsn' => $this->preparation_envoie_dsn,
            'accuses_dsn' => $this->accuses_dsn,
            'notes' => $this->notes,
        ]));
    }

    public function getDecryptedDataAttribute()
    {
        return json_decode(Crypt::decryptString($this->encrypted_data), true);
    }

    public function shouldBeEncrypted()
    {
        return Carbon::now()->diffInDays($this->fin) >= 7;
    }
}
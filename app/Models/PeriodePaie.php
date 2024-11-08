<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodePaie extends Model
{
    use HasFactory;
    protected $table = 'periodes_paie';

    protected $fillable = [
        'reference', 'debut', 'fin', 'validee'
    ];

    protected $dates = ['debut', 'fin'];

    protected $casts = [
        'debut' => 'date',
        'fin' => 'date',
        'validee' => 'boolean',
    ];

    public function fichesClients()
    {
        return $this->hasMany(FicheClient::class);
    }

    public function generateReference()
    {
        $this->reference = 'PERIODE_' . strtoupper($this->debut->format('F_Y'));
    }

    public static function getNonCloturees()
    {
        return self::where('validee', false)->get();
    }
}
<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodePaie extends Model
{
    use HasFactory;
    protected $table = 'periodes_paie';
    protected $fillable = ['reference', 'debut', 'fin', 'validee', 'client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function traitementsPaie()
    {
        return $this->hasMany(TraitementPaie::class);
    }
}

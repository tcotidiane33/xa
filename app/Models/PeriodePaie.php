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

    protected $fillable = ['debut', 'reference', 'fin', 'gestionnaire_id', 'client_id', 'validee'];

    protected $casts = [
        'debut' => 'date',
        'fin' => 'date',
        'validee' => 'boolean',
    ];

    /**
     * Boot method to set up model event hooks.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($periodePaie) {
            $periodePaie->reference = $periodePaie->generateReference();
        });
    }

    /**
     * Generate the reference for the PeriodesPaie record.
     *
     * @return string|null
     */
    public function generateReference()
    {
        // Fetch the client name based on the client_id
        $clientName = DB::table('clients')->where('id', $this->client_id)->value('name');

        if ($clientName) {
            // Format the date
            $date = Carbon::parse($this->debut)->format('Ymd');
            // Generate the reference
            $reference = 'PDP_' . strtoupper(substr($clientName, 0, 4)) . '_' . $date;
            return $reference;
        }

        return null;
    }

    public function traitementsPaie()
    {
        return $this->hasMany(TraitementPaie::class);
    }

    public function gestionnaire()
    {
        return $this->belongsTo(Gestionnaire::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

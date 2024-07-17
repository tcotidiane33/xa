<?php

namespace App\Models;

use Carbon\Carbon;
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

    /**
     * Boot method to set up model event hooks.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($traitementPaie) {
            $traitementPaie->reference = $traitementPaie->generateReference();
        });
    }
    public function generateReference()
    {
        // Fetch the periode paie reference
        $periodePaieReference = PeriodePaie::find($this->periode_paie_id)->reference;

        // Fetch the client name based on the client_id
        $clientName = $this->client->name;

        // Format the date
        $date = Carbon::now()->format('Ymd');

        // Generate the reference
        $reference = 'TDP_' . strtoupper(substr($clientName, 0, 4)) . '_' . $periodePaieReference . '_' . $date;

        return $reference;
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // public function traitementPaie()
    // {
    //     return $this->belongsTo(traitementPaie::class, 'periode_paie_id');
    // }
    public function periodePaie()
    {
        return $this->belongsTo(PeriodePaie::class, 'periode_paie_id');
    }
}

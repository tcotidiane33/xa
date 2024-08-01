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
        'superviseur_id',
        'responsable_id',
        'gestionnaires_ids',
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
        'notes',
        'listBoxIsEmpty',
        'pj_nbr_bull',
        'pj_maj_fiche_para',
        'pj_reception_variable',
        'pj_preparation_bp',
        'pj_validation_bp_client',
        'pj_preparation_envoie_dsn',
        'link_preparation_envoie_dsn',
        'pj_accuses_dsn',
        'link_accuses_dsn',
    ];

    protected $casts = [
        'gestionnaires_ids' => 'array',
    ];

    /**
     * Boot method to set up model event hooks.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($traitementPaie) {
            $traitementPaie->reference = $traitementPaie->generateReference();
            $traitementPaie->listBoxIsEmpty = $traitementPaie->checkIfAllFieldsFilled();
        });

        static::updating(function ($traitementPaie) {
            $traitementPaie->listBoxIsEmpty = $traitementPaie->checkIfAllFieldsFilled();
        });
    }

    public function generateReference()
    {
        $periodePaieReference = $this->periodePaie->reference;
        $clientName = $this->client->name;
        $date = Carbon::now()->format('Ymd');
        return 'TDP_' . strtoupper(substr($clientName, 0, 4)) . '_' . $periodePaieReference . '_' . $date;
    }

    public function checkIfAllFieldsFilled()
    {
        // Check if all required fields are filled
        return !empty($this->nbr_bull) &&
               !empty($this->pj_nbr_bull) &&
               !empty($this->maj_fiche_para) &&
               !empty($this->pj_maj_fiche_para) &&
               !empty($this->reception_variable) &&
               !empty($this->pj_reception_variable) &&
               !empty($this->preparation_bp) &&
               !empty($this->pj_preparation_bp) &&
               !empty($this->validation_bp_client) &&
               !empty($this->pj_validation_bp_client) &&
               !empty($this->preparation_envoie_dsn) &&
               !empty($this->pj_preparation_envoie_dsn) &&
               !empty($this->link_preparation_envoie_dsn) &&
               !empty($this->accuses_dsn) &&
               !empty($this->link_accuses_dsn) &&
               !empty($this->pj_accuses_dsn);
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function superviseur()
    {
        return $this->belongsTo(User::class, 'superviseur_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function gestionnairesSupplementaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaires_ids');
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

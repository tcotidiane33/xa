<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionnaireClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'gestionnaire_id',
        'client_id',
        'is_principal',
        'gestionnaires_ids',
        'responsable_id',
        'superviseur_id'
    ];

    protected $table = 'gestionnaire_client';

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function superviseur()
    {
        return $this->belongsTo(User::class, 'superviseur_id');
    }

    public function getGestionnairesIdsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }
}

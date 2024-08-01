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
        'superviseur_id',
        // 'avatar'
    ];

    protected $table = 'gestionnaire_client';


    protected $casts = [
        'gestionnaires_ids' => 'array', // Ensure it's casted as array
    ];

    // Relations
    public function gestionnaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client', 'client_id', 'gestionnaire_id');
    }
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function superviseur()
    {
        return $this->belongsTo(User::class, 'superviseur_id');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'gestionnaire_client', 'gestionnaire_id', 'client_id');
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

       // Initialize gestionnaires_ids as an empty array if null
    public function getGestionnairesIdsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }
}

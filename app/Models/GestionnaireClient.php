<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionnaireClient extends Model
{
    use HasFactory;

    protected $table = 'gestionnaire_client';
    protected $casts = [
        'gestionnaires_secondaires' => 'array',
        'is_principal' => 'boolean',
    ];
    protected $fillable = ['gestionnaire_id', 'client_id', 'is_principal', 'user_id', 'gestionnaires_secondaires', 'notes'];

    public function gestionnaire()
    {
        return $this->belongsTo(Gestionnaire::class, 'gestionnaire_id');
    }
    
    public function responsablePaie()
{
    return $this->belongsTo(User::class, 'user_id')
        ->whereHas('roles', function($query) {
            $query->where('name', 'responsable');
        })
        ->withDefault([
            'name' => 'Non assigné'
        ]);
}
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getGestionnairesSecondairesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true);
        }
        return $value;
    }
}
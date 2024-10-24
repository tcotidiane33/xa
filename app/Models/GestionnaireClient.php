<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionnaireClient extends Model
{
    use HasFactory;

    protected $table = 'gestionnaire_client_pivot';

    protected $fillable = [
        'client_id', 'gestionnaire_id', 'is_principal', 'gestionnaires_secondaires'
    ];

    protected $casts = [
        'gestionnaires_secondaires' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function getGestionnairesSecondairesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setGestionnairesSecondairesAttribute($value)
    {
        $this->attributes['gestionnaires_secondaires'] = json_encode($value);
    }

    public function gestionnairesSecondaires()
    {
        return User::whereIn('id', $this->gestionnaires_secondaires)->get();
    }
}
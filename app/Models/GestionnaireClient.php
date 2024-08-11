<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionnaireClient extends Model
{
    use HasFactory;

    protected $table = 'gestionnaire_client';
    protected $fillable = ['gestionnaire_id', 'client_id', 'is_principal'];

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

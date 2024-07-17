<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'GID', 'user_id', 'nbr_bull', 'maj_fiche_para', 'reception_variable',
        'preparation_bp', 'validation_bp_client', 'preparation_envoie_dsn',
        'accuses_dsn', 'teledec_urssaf', 'notes'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function fonction()
    {
        return $this->user ? $this->user->fonction() : null;
    }

    public function domaine()
    {
        return $this->user ? $this->user->domaine() : null;
    }

    public function habilitation()
    {
        return $this->user ? $this->user->habilitation() : null;
    }
}

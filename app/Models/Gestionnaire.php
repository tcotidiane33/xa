<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'GID',
        'user_id',
        'responsable_id',
        'superviseur_id',
        'avatar',
        'notes'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function superviseur()
    {
        return $this->belongsTo(User::class, 'superviseur_id');
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

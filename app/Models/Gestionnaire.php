<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestionnaire extends Model
{
    protected $fillable = ['GID', 'user_id', 'responsable_id', 'superviseur_id', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->belongsToMany(Client::class, 'gestionnaire_client')
                    ->withPivot('is_principal', 'gestionnaires_secondaires');
    }

    public function clientsPrincipaux()
    {
        return $this->clients()->wherePivot('is_principal', true);
    }

    public function clientsSecondaires()
    {
        return $this->clients()->wherePivot('is_principal', false);
    }
}
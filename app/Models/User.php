<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', 'fonction_id', 'domaine_id', 'habilitation_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

      /**
     * Get the clients & gestionnaire that owns the Echeancier.
     */

    public function fonction()
    {
        return $this->belongsTo(Fonction::class);
    }
    public function gestionnaire()
    {
        return $this->belongsTo(Gestionnaire::class);
    }

    public function domaine()
    {
        return $this->belongsTo(Domaine::class);
    }

    public function habilitation()
    {
        return $this->belongsTo(Habilitation::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function clientsGeres()
    {
        return $this->belongsToMany(Client::class, 'gestionnaire_client', 'gestionnaire_id', 'client_id');
    }

    public function traitementsPaie()
    {
        return $this->hasMany(TraitementPaie::class, 'gestionnaire_id');
    }
    public function periodesPaie()
    {
        return $this->hasMany(PeriodePaie::class, 'gestionnaire_id');
    }

    /**
     * Relation : Un utilisateur peut créer plusieurs tickets.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Relation : Un utilisateur peut être assigné à plusieurs tickets (si nécessaire).
     */
    public function assignedTickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_user');
    }
}

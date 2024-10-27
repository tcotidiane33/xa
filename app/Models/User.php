<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Avihs\PostReply\Traits\HasPost;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role_id',
        'fonction_id',
        'domaine_id',
        'habilitation_id',
        'is_active'
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
        'is_active' => 'boolean',
    ];

    /**
     * Get the clients & gestionnaire that owns the Echeancier.
     */
    public function isAdmin()
    {
        return $this->hasRole('admin'); // ou toute autre logique pour déterminer si l'utilisateur est admin
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    // Dans le modèle User
    // public function clientsGeres()
    // {
    //     return $this->belongsToMany(Client::class, 'gestionnaire_client_pivot', 'gestionnaire_id', 'client_id')
    //                 ->withPivot('is_principal')
    //                 ->withTimestamps();
    // }

    public function clientsAsGestionnaire()
    {
        return $this->hasMany(Client::class, 'gestionnaire_principal_id');
    }

    public function clientsAsResponsable()
    {
        return $this->hasMany(Client::class, 'responsable_paie_id');
    }
    public function clientsResponsable()
    {
        return $this->hasMany(Client::class, 'responsable_paie_id');
    }

    public function clientsGestionnairePrincipal()
    {
        return $this->hasMany(Client::class, 'gestionnaire_principal_id');
    }



    public function clientsPrincipaux()
    {
        return $this->clientsGeres()->wherePivot('is_principal', true);
    }

    public function clientsSecondaires()
    {
        return $this->clientsGeres()->wherePivot('is_principal', false);
    }

    public function gestionnaireClients()
    {
        return $this->hasMany(GestionnaireClient::class, 'gestionnaire_id');
    }

    public function traitementsPaie()
    {
        return $this->hasMany(TraitementPaie::class, 'gestionnaire_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'createur_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'gestionnaire_client', 'user_id', 'client_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }


    public function clientsAsManager()
    {
        return $this->belongsToMany(Client::class, 'gestionnaire_client', 'gestionnaire_id', 'client_id')
            ->withPivot('is_principal')
            ->withTimestamps();
    }

    public function clientsGestionnaireSecondaire()
    {
        return $this->belongsToMany(Client::class, 'client_gestionnaire_secondaire', 'gestionnaire_id', 'client_id');
    }

    public function assignClientsEnMasse(array $clientIds, $isPrincipal = false)
    {
        DB::transaction(function () use ($clientIds, $isPrincipal) {
            foreach ($clientIds as $clientId) {
                $this->clientsGestionnaireSecondaire()->attach($clientId, ['is_principal' => $isPrincipal]);

                if ($isPrincipal) {
                    Client::find($clientId)->gestionnairesSecondaires()
                        ->where('id', '<>', $this->id)
                        ->update(['is_principal' => false]);
                }
            }
        });
    }

    // Dans le modèle User

    

}

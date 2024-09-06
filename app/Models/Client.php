<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use Filterable;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'responsable_paie_id',
        'gestionnaire_principal_id',
        'date_debut_prestation',
        'contact_paie',
        'contact_comptabilite',
        'nb_bulletins',
        'maj_fiche_para',
        'convention_collective_id', // Ajoutez cette ligne
        'status',
        'is_portfolio',
        'parent_client_id'
    ];
    protected $dates = [
        'date_debut_prestation',
        'date_estimative_envoi_variables',
        'maj_fiche_para',
        'is_portfolio' => 'boolean',
    ];
    public function subClients()
    {
        return $this->hasMany(Client::class, 'parent_client_id');
    }

    public function parentClient()
    {
        return $this->belongsTo(Client::class, 'parent_client_id');
    }
    protected $casts = [
        'date_debut_prestation' => 'datetime',
        'date_estimative_envoi_variables' => 'datetime',
        'maj_fiche_para' => 'datetime',
    ];

    // Dans le modèle Client

    public function gestionnaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client_pivot', 'client_id', 'gestionnaire_id')
                    ->withPivot('is_principal')
                    ->withTimestamps();
    }

    public function gestionnairePrincipal()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client_pivot', 'client_id', 'gestionnaire_id')
                    ->wherePivot('is_principal', true)
                    ->withTimestamps()
                    ->take(1);  // Limite le résultat à un seul enregistrement
    }

    public function gestionnairesSecondaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client_pivot', 'client_id', 'gestionnaire_id')
                    ->wherePivot('is_principal', false)
                    ->withTimestamps();
    }


    public function gestionnaireSecondaires()
    {
        return $this->gestionnaires()->wherePivot('is_principal', false);
    }

    protected function filterSearch($query, $value)
    {
        return $query->where('name', 'like', "%{$value}%")
            ->orWhere('contact_paie', 'like', "%{$value}%")
            ->orWhere('contact_comptabilite', 'like', "%{$value}%");
    }

    protected function filterStatus($query, $value)
    {
        return $query->where('status', $value);
    }

    // Dans App\Models\Client


    public function traitementsPaie(): HasMany
    {
        return $this->hasMany(TraitementPaie::class);
    }


    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function allGestionnaires()
    {
        $principal = $this->gestionnairePrincipal;
        $secondaires = $this->gestionnaireClients()->with('gestionnairesSecondaires')->get()->pluck('gestionnairesSecondaires')->flatten();

        return $principal->merge($secondaires)->unique('id');
    }
    // Dans le modèle Client
    public function transferGestionnaire($oldGestionnaireId, $newGestionnaireId, $isPrincipal = false)
    {
        DB::transaction(function () use ($oldGestionnaireId, $newGestionnaireId, $isPrincipal) {
            // Retirer l'ancien gestionnaire
            $this->gestionnaires()->detach($oldGestionnaireId);

            // Ajouter le nouveau gestionnaire
            $this->gestionnaires()->attach($newGestionnaireId, ['is_principal' => $isPrincipal]);

            // Mettre à jour le gestionnaire principal si nécessaire
            if ($isPrincipal) {
                $this->gestionnaires()->where('id', '<>', $newGestionnaireId)->update(['is_principal' => false]);
            }
        });
    }

    // Dans le modèle Client
    public function responsablePaie()
    {
        return $this->belongsTo(User::class, 'responsable_paie_id');
    }


    public function conventionCollective()
    {
        return $this->belongsTo(ConventionCollective::class);
    }

    // Dans le modèle ConventionCollective
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    // Dans le modèle User
    public function clientsAsManager()
    {
        return $this->hasMany(Client::class, 'gestionnaire_principal_id');
    }
}

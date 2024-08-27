<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use Filterable;
    use HasFactory;
    protected $fillable = [
        'name',
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

    public function gestionnaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client', 'client_id', 'gestionnaire_id')
            ->withPivot('is_principal');
    }



    public function gestionnairesSecondaires()
    {
        return $this->gestionnaires()->wherePivot('is_principal', false);
    }


    public function traitementsPaie(): HasMany
    {
        return $this->hasMany(TraitementPaie::class);
    }


    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    public function transferGestionnaire($oldGestionnaireId, $newGestionnaireId)
    {
        $this->gestionnaireClients()->where('gestionnaire_id', $oldGestionnaireId)->update(['gestionnaire_id' => $newGestionnaireId]);

        if ($this->gestionnaire_principal_id == $oldGestionnaireId) {
            $this->gestionnaire_principal_id = $newGestionnaireId;
            $this->save();
        }
    }
    public function allGestionnaires()
    {
        $principal = $this->gestionnairePrincipal;
        $secondaires = $this->gestionnaireClients()->with('gestionnairesSecondaires')->get()->pluck('gestionnairesSecondaires')->flatten();

        return $principal->merge($secondaires)->unique('id');
    }

    // Dans le modèle Client
    public function responsablePaie()
    {
        return $this->belongsTo(User::class, 'responsable_paie_id');
    }

    public function gestionnairePrincipal()
    {
        return $this->belongsTo(User::class, 'gestionnaire_principal_id');
    }

    public function conventionCollective()
    {
        return $this->belongsTo(ConventionCollective::class);
    }

}

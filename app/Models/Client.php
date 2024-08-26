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
        'status'
    ];
    protected $dates = ['date_debut_prestation', 'date_estimative_envoi_variables', 'maj_fiche_para'];

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

    public function responsablePaie(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_paie_id');
    }

    // public function gestionnairePrincipal(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'gestionnaire_principal_id');
    // }


    // public function gestionnaires()
    // {
    //     return $this->belongsToMany(Gestionnaire::class, 'gestionnaire_client')
    //         ->withPivot('is_principal', 'gestionnaires_secondaires');
    // }
    public function gestionnaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client', 'client_id', 'gestionnaire_id')
                    ->withPivot('is_principal');
    }

    public function gestionnairePrincipal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestionnaire_principal_id');
    }

    public function gestionnairesSecondaires()
    {
        return $this->gestionnaires()->wherePivot('is_principal', false);
    }
    //     public function gestionnaires()
    // {
    //     return $this->belongsToMany(User::class, 'gestionnaire_client');
    // }

    public function traitementsPaie(): HasMany
    {
        return $this->hasMany(TraitementPaie::class);
    }
    public function conventionCollective()
    {
        return $this->belongsTo(ConventionCollective::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

}

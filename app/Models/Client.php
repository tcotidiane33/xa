<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use Filterable, HasFactory, Notifiable;

    // Champs remplissables
    protected $fillable = [
        'name', 'email', 'phone', 'responsable_paie_id', 'gestionnaire_principal_id',
        'date_debut_prestation', 'contact_paie', 'contact_comptabilite', 'nb_bulletins',
        'maj_fiche_para', 'convention_collective_id', 'status', 'is_portfolio', 
        'parent_client_id', 'type_societe', 'ville', 'dirigeant_nom', 
        'dirigeant_telephone', 'dirigeant_email', 'contact_paie_nom', 
        'contact_paie_prenom', 'contact_paie_telephone', 'contact_paie_email',
        'contact_compta_nom', 'contact_compta_prenom', 'contact_compta_telephone', 
        'contact_compta_email', 'responsable_telephone_ld', 
        'gestionnaire_telephone_ld', 'binome_telephone_ld', 'binome_id',
        'saisie_variables', 'client_forme_saisie', 'date_formation_saisie',
        'date_fin_prestation', 'date_signature_contrat', 'taux_at',
        'adhesion_mydrh', 'date_adhesion_mydrh', 'is_cabinet', 'portfolio_cabinet_id'
    ];

    // Champs de date
    protected $dates = [
        'date_debut_prestation', 'date_estimative_envoi_variables', 'maj_fiche_para'
    ];

    // Casts pour les champs spécifiques
    protected $casts = [
        'date_debut_prestation' => 'datetime',
        'date_estimative_envoi_variables' => 'datetime',
        'maj_fiche_para' => 'datetime',
        'is_portfolio' => 'boolean',
    ];

    // Relations
    public function responsablePaie()
    {
        return $this->belongsTo(User::class, 'responsable_paie_id');
    }

    public function gestionnairePrincipal()
    {
        return $this->belongsTo(User::class, 'gestionnaire_principal_id');
    }

    public function binome()
    {
        return $this->belongsTo(User::class, 'binome_id');
    }

    public function conventionCollective()
    {
        return $this->belongsTo(ConventionCollective::class);
    }

    public function gestionnaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client_pivot', 'client_id', 'gestionnaire_id')
                    ->withPivot('is_principal')
                    ->withTimestamps();
    }

    public function gestionnairesSecondaires()
    {
        return $this->belongsToMany(User::class, 'gestionnaire_client_pivot', 'client_id', 'gestionnaire_id')
                    ->wherePivot('is_principal', false)
                    ->withTimestamps();
    }

    public function subClients()
    {
        return $this->hasMany(Client::class, 'parent_client_id');
    }

    public function parentClient()
    {
        return $this->belongsTo(Client::class, 'parent_client_id');
    }

    public function portfolioCabinet()
    {
        return $this->belongsTo(Client::class, 'portfolio_cabinet_id');
    }

    public function traitementsPaie()
    {
        return $this->hasMany(TraitementPaie::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function histories()
    {
        return $this->hasMany(ClientHistory::class);
    }

    // Méthode pour transférer un gestionnaire
    public function transferGestionnaire($oldGestionnaireId, $newGestionnaireId, $isPrincipal = false)
    {
        DB::transaction(function () use ($oldGestionnaireId, $newGestionnaireId, $isPrincipal) {
            $this->gestionnaires()->detach($oldGestionnaireId);
            $this->gestionnaires()->attach($newGestionnaireId, ['is_principal' => $isPrincipal]);
            if ($isPrincipal) {
                $this->gestionnaires()->where('id', '<>', $newGestionnaireId)->update(['is_principal' => false]);
                $this->update(['gestionnaire_principal_id' => $newGestionnaireId]);
            }
        });
    }

    // Méthodes de filtrage
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

    // Méthode pour enregistrer l'historique de la fiche de paramétrage
    public function saveMajFicheParaHistory()
    {
        if ($this->isDirty('maj_fiche_para')) {
            $this->histories()->create([
                'maj_fiche_para' => $this->maj_fiche_para,
            ]);
        }
    }
}
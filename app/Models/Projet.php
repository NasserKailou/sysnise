<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Projet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sigle',
        'intitule',
        'priorite_id',
        'institution_tutelle_id',
        'direction_agence',
        'contact',
        'cout',
		'cout_devise',
        'annee_demarrage',
        'date_debut_prevue',
        'date_fin_prevue',
		'date_debut_effective',
        'date_fin_effective',
        'duree',
		'statut_projet_id',
		'projet_id',
		'devise_id',
		'cadre_developpement_id',
		'date_approbation',
		'date_signature',
		'date_mise_en_vigueur',
		'date_demarrage_effectif',
		'Partenaires',
		'periode_prorogation',
		'duree_prorogation',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            /*'priorite_id' => 'integer',
            'institution_tutelle_id' => 'integer',
            'cout' => 'double',
            'date_debut' => 'date',
            'date_fin' => 'date',*/
        ];
    }
	
	public function statutProjet(): BelongsTo
    {
        return $this->belongsTo(StatutProjet::class);
    }

    public function priorite(): BelongsTo
    {
        return $this->belongsTo(Priorite::class);
    }
	
	public function devise(): BelongsTo
    {
        return $this->belongsTo(Devise::class);
    }

    public function institutionTutelle(): BelongsTo
    {
        return $this->belongsTo(InstitutionTutelle::class);
    }
	
	// Relation parent
    public function parent()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    // Relation enfants
    public function children()
    {
        return $this->hasMany(Projet::class, 'projet_id');
    }
	
	public function zoneInterventions()
    {
        return $this->belongsToMany(
            Zone::class,           // modèle lié
            'projet_zone',        // nom de la table pivot
            'projet_id',          // clé étrangère locale dans pivot
            'zone_id'              // clé étrangère du modèle lié
        )->withTimestamps();       // active la gestion automatique de created_at / updated_at
    }
	
	public function positionnementStrategiques()
    {
        return $this->belongsToMany(
            CadreLogique::class,           // modèle lié
            'projet_cadre_logique',        // nom de la table pivot
            'projet_id',          // clé étrangère locale dans pivot
            'cadre_logique_id'              // clé étrangère du modèle lié
        )->withTimestamps();       // active la gestion automatique de created_at / updated_at
    }
	
	public function pieceJointeProjets(): HasMany
    {
        return $this->hasMany(PieceJointeProjet::class);
    }
	
	public function cadreDeveloppement(): BelongsTo
    {
        return $this->belongsTo(CadreDeveloppement::class);
    }
	
	public function populationCibles()
    {
        return $this->belongsToMany(
            PopulationCible::class,           // modèle lié
            'projet_population_cible',        // nom de la table pivot
            'projet_id',          // clé étrangère locale dans pivot
            'population_cible_id' ,// clé étrangère du modèle lié
            
        )->withPivot('effectif')
		 ->withTimestamps();       
    }
	
	public function etudeDisponibles()
    {
        return $this->belongsToMany(
            Etude::class,           // modèle lié
            'projet_etude_disponible',        // nom de la table pivot
            'projet_id',          // clé étrangère locale dans pivot
            'etude_id' ,// clé étrangère du modèle lié
        )->withPivot('fichier')
		 ->withTimestamps();       
    }
	
	public function etudeEnvisagees()
    {
        return $this->belongsToMany(
            Etude::class,
            'projet_etude_envisagee',
            'projet_id',
            'etude_id'
        )->using(EtudeEnvisagee::class)
		 ->withPivot('source_financement_id')
		->withTimestamps();  
    }
	
	public function rechercheFinancements()
	{
		return $this->belongsToMany(
			SourceFinancement::class,
			'recherche_financements',
			'projet_id',
			'source_financement_id'
		)
		->using(RechercheFinancement::class)
		->withPivot(['bailleur_id', 'statut_financement_id', 'nature_financement_id', 'montant'])
		->withTimestamps();
	}
	
	public function planFinancements()
	{
		return $this->belongsToMany(
			SourceFinancement::class,
			'plan_financements',
			'projet_id',
			'source_financement_id'
		)
		->using(PlanFinancement::class)
		->withPivot(['bailleur_id', 'statut_financement_id', 'nature_financement_id', 'composante_id', 'categorie_depense_id', 'montant'])
		->withTimestamps();
	}
	
	
}

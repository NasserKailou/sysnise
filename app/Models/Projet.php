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
		'secteur_id',
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
        'user_id',
        'dispose_organe_pilotage',
        'a_audit_regulier',
        'problemes_rencontres',
        'solutions_proposees',
        'recommandations',
        'rapport_rempli_par',
        'rapport_date_remplissage',
    ];

    protected $casts = [
    'date_debut_prevue'       => 'date',
    'date_fin_prevue'         => 'date',
    'date_debut_effective'    => 'date',
    'date_fin_effective'      => 'date',
    'date_approbation'        => 'date',
    'date_signature'          => 'date',
    'date_mise_en_vigueur'    => 'date',
    'date_demarrage_effectif' => 'date',
    'rapport_date_remplissage' => 'date',
    'created_at'              => 'datetime',
    'updated_at'              => 'datetime',
    'deleted_on'              => 'datetime',
    'dispose_organe_pilotage' => 'boolean',
    'a_audit_regulier'        => 'boolean',
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
	
	 public function secteur(): BelongsTo
    {
        return $this->belongsTo(Secteur::class);
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
		return $this->hasMany(ProjetPlanFinancement::class);
	}




    // Relation avec les associations
    public function projetUsers()
    {
        return $this->hasMany(ProjetUser::class, 'projet', 'id')
                    ->with('userr');
    }

    // Alias pour faciliter l'utilisation
    public function associations()
    {
        return $this->projetUsers();
    }


    public function pilotageAnnees()
{
    return $this->hasMany(ProjetPilotageAnnee::class);
}

public function auditsExercices()
{
    return $this->hasMany(ProjetAuditsExercice::class);
}

public function rapports()
{
    return $this->hasMany(ProjetRapport::class);
}



	
	
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CadreDeveloppement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intitule',
		'type_cadre_developpement_id',
        'structure_responsable',
        'annee_debut',
        'annee_fin',
        'description',
        'cadre_developpement_id',
        'user_id',
        'institution_tutelle_id',
		'cout_total_financement',
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
            'cadre_developpement_id' => 'integer',
        ];
    }

    public function pieceJointes(): HasMany
    {
        return $this->hasMany(PieceJointe::class);
    }

    /*public function cadreDeveloppement(): BelongsTo
    {
        return $this->belongsTo(CadreDeveloppement::class);
    }*/
	
	public function orientationCadreDeveloppements()
	{
		return $this->hasMany(OrientationCadreDeveloppement::class);
		
	}
	
	public function alignementStrategiques()
    {
        return $this->belongsToMany(
            CadreLogique::class,           // modèle lié
            'alignement_strategiques',        // nom de la table pivot
            'cadre_developpement_id',          // clé étrangère locale dans pivot
            'cadre_logique_id'              // clé étrangère du modèle lié
        )->withTimestamps();       // active la gestion automatique de created_at / updated_at
    }

// Relation avec les associations
    public function cadreDeveloppementUsers()
    {
        return $this->hasMany(CadreDeveloppementUser::class, 'cadre_developpement', 'id')
                    ->with('userr');
    }

    // Alias pour faciliter l'utilisation
    public function associations()
    {
        return $this->cadreDeveloppementUsers();
    }
	
	public function financementParBailleurs()
	{
		return $this->hasMany(CD_FinancementParBailleur::class);
	}
	
	public function financementParResultats()
	{
		return $this->hasMany(CD_FinancementParResultat::class);
	}
	
	public function getFinancementParBailleursAttribute()
	{
		$totalMobilise = 0;
		$totalConsomme = 0;

		foreach ($this->financementParBailleurs as $financement) {
			$totalMobilise += $financement->montantMobilises()->sum('montant');
			$totalConsomme += $financement->montantConsommes()->sum('montant');
		}

		return [
			'total_mobilise' => $totalMobilise,
			'total_consomme' => $totalConsomme,
		];
	}
	
	public function getTotalMontantMobiliseAttribute()
	{
		return CD_FinancementAnnuelParBailleur::whereHas('financementParBailleur', function ($q) {
			$q->where('cadre_developpement_id', $this->id);
		})->where('statut_montant_financement_id', 1)
		  ->sum('montant');
	}

	public function getTotalMontantConsommeAttribute()
	{
		return CD_FinancementAnnuelParBailleur::whereHas('financementParBailleur', function ($q) {
			$q->where('cadre_developpement_id', $this->id);
		})->where('statut_montant_financement_id', 2)
		  ->sum('montant');
	}
	
	public function getTotalFinancementAttribute()
	{
		return $this->financementParBailleurs()->sum('montant');
	}

	
}

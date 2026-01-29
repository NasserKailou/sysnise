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
        'structure_responsable',
        'annee_debut',
        'annee_fin',
        'description',
        'cadre_developpement_id',
        'user_id',
        'institution_tutelle_id',
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

	
}

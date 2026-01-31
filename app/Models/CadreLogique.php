<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadreLogique extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 
    protected $fillable = [
        'intitule',
        'niveau',
        'cadre_logique_id',
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
            'cadre_logique_id' => 'integer',
        ];
    }

	
	// Relation parent
    public function parent()
    {
        return $this->belongsTo(CadreLogique::class, 'cadre_logique_id');
    }

    // Relation enfants
    public function children()
    {
        return $this->hasMany(CadreLogique::class, 'cadre_logique_id');
    }
	
	public static function getHierarchyByCadreDeveloppement($cadreDeveloppementId)
    {
        $rootCadres = self::whereIn(
            'id',
            OrientationCadreDeveloppement::where('cadre_developpement_id', $cadreDeveloppementId)
                ->pluck('cadre_logique_id')
        )->get();

        $result = [];

        $getChildren = function ($cadres) use (&$getChildren, &$result) {
            foreach ($cadres as $cadre) {
                $result[] = $cadre;
                if ($cadre->children()->exists()) {
                    $getChildren($cadre->children);
                }
            }
        };

        $getChildren($rootCadres);

        return $result;
    }
	
	public static function getProduitsByCadreDeveloppement($cadreDeveloppementId)
	{
		// 1. Récupérer le nœud racine "CMR" lié au cadre de développement
		$root = self::where('intitule', 'CMR')
			->whereIn(
				'id',
				OrientationCadreDeveloppement::where('cadre_developpement_id', $cadreDeveloppementId)
					->pluck('cadre_logique_id')
			)
			->first();

		if (!$root) {
			return collect(); // aucun CMR trouvé
		}

		$result = collect();

		// 2. Parcours récursif pour ne garder que les feuilles
		$traverse = function ($cadre) use (&$traverse, &$result) {

			if (!$cadre->children()->exists()) {
				// c'est un nœud de dernier niveau
				$result->push($cadre);
				return;
			}

			foreach ($cadre->children as $child) {
				$traverse($child);
			}
		};

		// 3. Lancer le parcours depuis CMR
		$traverse($root);

		return $result;
	}
	/*public static function getProduitsByCadreDeveloppement($cadreDeveloppementId)
	{
		// 1. Récupérer le nœud racine "CMR" lié au cadre de développement
		$root = self::where('intitule', 'CMR')
			->whereHas('orientations', function ($q) use ($cadreDeveloppementId) {
				$q->where('cadre_developpement_id', $cadreDeveloppementId);
			})
			->first();
			
		if (!$root) {
			return collect(); // aucun CMR trouvé
		}
		$result = collect();

		// 2. Parcours récursif pour ne garder que les feuilles
		$traverse = function ($cadre) use (&$traverse, &$result) {

			if (!$cadre->children()->exists()) {
				// c'est un nœud de dernier niveau
				$result->push($cadre);
				return;
			}

			foreach ($cadre->children as $child) {
				$traverse($child);
			}
		};

		// 3. Lancer le parcours depuis CMR
		$traverse($root);

		return $result;
	}*/
	

	public function cadreMesureResultats()
    {
        return $this->hasMany(CadreMesureResultat::class, 'cadre_logique_id');
    }
	
	public function orientations()
	{
		return $this->hasMany(
			OrientationCadreDeveloppement::class,
			'cadre_logique_id'
		);
	}
}

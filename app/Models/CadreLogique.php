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
	
	public static function getProduitsNonAssocieByCadreDeveloppement(int $cadreDeveloppementId,$composanteId) 
	{
		// 1. Récupérer le nœud racine "CMR"
		$root = self::where('intitule', 'CMR')
			->whereIn(
				'id',
				OrientationCadreDeveloppement::where('cadre_developpement_id', $cadreDeveloppementId)
					->pluck('cadre_logique_id')
			)
			->with('children') // préchargement
			->first();

		if (!$root) {
			return collect();
		}

		// 2. Récupérer UNE FOIS les produits déjà associés à la composante
		$cadreIdsDejaUtilises = ComposanteProduit::where('composante_id', $composanteId)
			->pluck('produit_id')
			->flip(); // clé = id (lookup O(1))

		$result = collect();

		// 3. Parcours récursif sans requêtes supplémentaires
		$traverse = function ($cadre) use (&$traverse, &$result, $cadreIdsDejaUtilises) {

			// feuille
			if ($cadre->children->isEmpty()) {

				// ne garder que ceux qui ne sont PAS déjà utilisés
				if (!isset($cadreIdsDejaUtilises[$cadre->id])) {
					$result->push($cadre);
				}

				return;
			}

			foreach ($cadre->children as $child) {
				$traverse($child);
			}
		};

		// 4. Lancer le parcours
		$traverse($root);

		return $result;
	}

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
	
	public function composanteProduit()
	{
		return $this->hasOne(ComposanteProduit::class, 'produit_id');
	}
	
	public function getCheminCompletAttribute_v0()
	{
		$hierarchie = [];
		$courant = $this;

		while ($courant) {
			array_unshift($hierarchie, $courant->intitule);
			$courant = $courant->parent;
		}

		return implode(' -> ', $hierarchie);
	}
	
	public function getCheminCompletAttribute_nok()
	{
		$hierarchie = [];

		// Recherche du cadre de développement associé
		$cadreDeveloppement = $this->orientations()
			->with('cadreDeveloppement')
			->first()?->cadreDeveloppement;

		if ($cadreDeveloppement) {
			$hierarchie[] = $cadreDeveloppement->intitule;
		}

		// Construction de la hiérarchie des cadres logiques
		$courant = $this;

		while ($courant) {
			$hierarchie[] = $courant->intitule;
			$courant = $courant->parent;
		}

		return implode(' -> ', $hierarchie);
	}
	
	public function getCheminCompletAttribute()
	{
		$hierarchie = [];

		// Remonter jusqu'à la racine
		$racine = $this;

		while ($racine->parent) {
			$racine = $racine->parent;
		}

		// Cadre de développement associé à la racine
		$orientation = $racine->orientations()->with('cadreDeveloppement')->first();

		if ($orientation && $orientation->cadreDeveloppement) {
			$hierarchie[] = $orientation->cadreDeveloppement->intitule;
		}

		// Construire la hiérarchie depuis la racine jusqu'au nœud courant
		$courant = $this;
		$niveaux = [];

		while ($courant) {
			array_unshift($niveaux, $courant->intitule);
			$courant = $courant->parent;
		}

		return implode(' -> ', array_merge($hierarchie, $niveaux));
	}
	
}

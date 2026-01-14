<?php

namespace App\Models;

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
	
	public function cadreMesureResultats()
    {
        return $this->hasMany(CadreMesureResultat::class, 'cadre_logique_id');
    }
}

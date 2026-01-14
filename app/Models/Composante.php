<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Composante extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intitule',
        'composante_id',
		'projet_id',
        'niveau',
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
        ];
		
    }

    /*public function composante(): BelongsTo
    {
        return $this->belongsTo(Composante::class);
    }*/
	
	// Relation parent
    public function parent()
    {
        return $this->belongsTo(Composante::class, 'composante_id');
    }

    // Relation enfants
    public function children()
    {
        return $this->hasMany(Composante::class, 'composante_id');
    }
	
	public static function getHierarchyByProjet($projetId)
	{
		$roots = self::where('projet_id',$projetId)->get();

		$result = [];

		$walk = function ($nodes) use (&$walk, &$result) {
			foreach ($nodes as $node) {
				$result[] = $node;

				if ($node->children()->exists()) {
					$walk($node->children);
				}
			}
		};

		$walk($roots);

		return $result;
	}

	
}

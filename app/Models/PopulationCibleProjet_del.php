<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PopulationCibleProjet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projet_id',
        'population_cible_id',
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
            'projet_id' => 'integer',
            'population_cible_id' => 'integer',
			'effectif' => 'integer',
        ];
    }

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function populationCible(): BelongsTo
    {
        return $this->belongsTo(PopulationCible::class);
    }
}

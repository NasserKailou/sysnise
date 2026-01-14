<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrientationCadreDeveloppement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intitule',
        'cadre_developpement_id',
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
            'cadre_developpement_id' => 'integer',
            'cadre_logique_id' => 'integer',
        ];
    }

    public function cadreDeveloppement(): BelongsTo
    {
        return $this->belongsTo(CadreDeveloppement::class);
    }

    public function cadreLogique(): BelongsTo
    {
        return $this->belongsTo(CadreLogique::class);
    }

}

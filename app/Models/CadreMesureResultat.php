<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadreMesureResultat extends Model
{

    protected $fillable = [
        'indicateur_id',
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
            'indicateur_id' => 'integer',
            'cadre_logique_id' => 'integer',
        ];
    }
	
	// Relation avec Indicateur
    public function indicateur()
    {
        return $this->belongsTo(Indicateur::class, 'indicateur_id', 'id');
    }

    // Relation avec CadreLogique
    public function cadreLogique()
    {
        return $this->belongsTo(CadreLogique::class, 'cadre_logique_id', 'id');
    }
	

}

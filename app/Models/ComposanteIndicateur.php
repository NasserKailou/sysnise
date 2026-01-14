<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComposanteIndicateur extends Model
{

    protected $fillable = [
        'indicateur_id',
        'composante_id',
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
            'composante_id' => 'integer',
        ];
    }
	
	// Relation avec Indicateur
    public function indicateur()
    {
        return $this->belongsTo(Indicateur::class, 'indicateur_id', 'id');
    }

    // Relation avec Composante
    public function composante()
    {
        return $this->belongsTo(Composante::class, 'composante_id', 'id');
    }
	

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComposanteProduit extends Model
{

    protected $fillable = [
        'produit_id',
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
            'produit_id' => 'integer',
            'composante_id' => 'integer',
        ];
    }
	
	// Relation avec Produit
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'id');
    }

    // Relation avec Composante
    public function composante()
    {
        return $this->belongsTo(Composante::class, 'composante_id', 'id');
    }
	

}

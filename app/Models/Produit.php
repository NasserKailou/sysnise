<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
	protected $table = 'cadre_logiques';
    use HasFactory;
	protected $fillable = [
        'intitule',
        'niveau',
        'cadre_logique_id',
    ];

	public function composanteProduits()
    {
        return $this->hasMany(ComposanteProduit::class, 'produit_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Produit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cadre_logique_id',
        'intitule',
		'annee_debut_prevu',
		'annee_fin_prevu',
		'duree_travaux',
		'cout_prevu',
		'responsable',
		'contact_responsable',
		'statut_produit_id',
		'type_produit_id',
		'description',
		'date_debut_realisation',
		'date_fin_realisation',
		'cout_realisation',
		'latitude',
		'longitude',
		
		
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

    public function cadreLogique(): BelongsTo
    {
        return $this->belongsTo(CadreLogique::class);
    }
	
	public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }
	
	public function statutProduit(): BelongsTo
    {
        return $this->belongsTo(StatutProduit::class);
    }
	
	public function typeProduit(): BelongsTo
    {
        return $this->belongsTo(TypeProduit::class);
    }
	
	public function pieceJointeProduits(): HasMany
    {
        return $this->hasMany(PieceJointeProduit::class);
    }
	
	public function zones()
    {
        return $this->belongsToMany(
            Zone::class,           // modèle lié
            'produit_zone',        // nom de la table pivot
            'produit_id',          // clé étrangère locale dans pivot
            'zone_id'              // clé étrangère du modèle lié
        )->withTimestamps();       // active la gestion automatique de created_at / updated_at
    }
}

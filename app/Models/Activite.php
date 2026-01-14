<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Activite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cadre_logique_id',
		'activite_id',
        'intitule',
		'annee_debut_prevu',
		'annee_fin_prevu',
		'duree_travaux',
		'cout_prevu',
		'responsable',
		'contact_responsable',
		'statut_activite_id',
		'type_activite_id',
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
	
	// Relation parent
    public function parent()
    {
        return $this->belongsTo(Activite::class, 'activite_id');
    }

    // Relation enfants
    public function children()
    {
        return $this->hasMany(Activite::class, 'activite_id');
    }

    public function cadreLogique(): BelongsTo
    {
        return $this->belongsTo(CadreLogique::class);
    }
	
	public function statutActivite(): BelongsTo
    {
        return $this->belongsTo(StatutActivite::class);
    }
	
	public function typeActivite(): BelongsTo
    {
        return $this->belongsTo(TypeActivite::class);
    }
	
	public function pieceJointeActivites(): HasMany
    {
        return $this->hasMany(PieceJointeActivite::class);
    }
	
	public function zones()
    {
        return $this->belongsToMany(
            Zone::class,           // modèle lié
            'activite_zone',        // nom de la table pivot
            'activite_id',          // clé étrangère locale dans pivot
            'zone_id'              // clé étrangère du modèle lié
        )->withTimestamps();       // active la gestion automatique de created_at / updated_at
    }
}

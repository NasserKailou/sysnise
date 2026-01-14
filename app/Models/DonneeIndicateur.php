<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonneeIndicateur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nature_donnee_id',
        'indicateur_id',
        'zone_id',
        'periode_id',
        'source_indicateur_id',
        'unite_indicateur_id',
        'commentaire_valeur_indicateur_id',
        'valeur',
        'statut',
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
            'nature_donnee_id' => 'integer',
            'indicateur_id' => 'integer',
            'zone_id' => 'integer',
            'periode_id' => 'integer',
            'source_indicateur_id' => 'integer',
            'unite_indicateur_id' => 'integer',
            'commentaire_valeur_indicateur_id' => 'integer',
            'valeur' => 'double',
        ];
    }

    /**
     * Constantes pour les statuts
     */
    const STATUT_EN_ATTENTE = 'en_attente';
    const STATUT_VALIDE = 'valide';
    const STATUT_REJETE = 'rejete';

    /**
     * Obtenir tous les statuts disponibles
     */
    public static function getStatuts(): array
    {
        return [
            self::STATUT_EN_ATTENTE => 'En attente',
            self::STATUT_VALIDE => 'Validé',
            self::STATUT_REJETE => 'Rejeté',
        ];
    }

    /**
     * Scope pour filtrer les données en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', self::STATUT_EN_ATTENTE);
    }

    /**
     * Scope pour filtrer les données validées
     */
    public function scopeValide($query)
    {
        return $query->where('statut', self::STATUT_VALIDE);
    }

    /**
     * Scope pour filtrer les données rejetées
     */
    public function scopeRejete($query)
    {
        return $query->where('statut', self::STATUT_REJETE);
    }

    /**
     * Valider cette donnée
     */
    public function valider(): bool
    {
        $this->statut = self::STATUT_VALIDE;
        return $this->save();
    }

    /**
     * Rejeter cette donnée
     */
    public function rejeter(): bool
    {
        $this->statut = self::STATUT_REJETE;
        return $this->save();
    }

    /**
     * Remettre en attente cette donnée
     */
    public function mettreEnAttente(): bool
    {
        $this->statut = self::STATUT_EN_ATTENTE;
        return $this->save();
    }

    /**
     * Vérifier si la donnée est en attente
     */
    public function estEnAttente(): bool
    {
        return $this->statut === self::STATUT_EN_ATTENTE;
    }

    /**
     * Vérifier si la donnée est validée
     */
    public function estValide(): bool
    {
        return $this->statut === self::STATUT_VALIDE;
    }

    /**
     * Vérifier si la donnée est rejetée
     */
    public function estRejete(): bool
    {
        return $this->statut === self::STATUT_REJETE;
    }

    public function natureDonnee(): BelongsTo
    {
        return $this->belongsTo(NatureDonnee::class);
    }

    public function indicateur(): BelongsTo
    {
        return $this->belongsTo(Indicateur::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }
	
	public function desaggregations()
    {
        return $this->hasMany(DonneeIndicateurDesagregation::class);
    }

    public function sourceIndicateur(): BelongsTo
    {
        return $this->belongsTo(SourceIndicateur::class);
    }

    public function uniteIndicateur(): BelongsTo
    {
        return $this->belongsTo(UniteIndicateur::class);
    }

    public function commentaireValeurIndicateur(): BelongsTo
    {
        return $this->belongsTo(CommentaireValeurIndicateur::class);
    }
	
	public function desagregations()
	{
		return $this->belongsToMany(
			Desagregation::class,                  // le modèle cible
			'donnee_indicateur_desagregation',     // la table pivot
			'donnee_indicateur_id',                // clé locale (dans la table pivot)
			'desagregation_id'                     // clé étrangère (dans la table pivot)
		);
	}
}

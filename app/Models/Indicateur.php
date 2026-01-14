<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicateur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'intitule',
		'type_indicateur_id',
        'definition',
        'donnees_requises',
        'methode_calcul',
        'methode_collecte',
        'source',
        'commentaire_limite',
        'niveau_desagregation',
        'periodicite',
        'unite',
        'echelle',
        'lien_avec_cadre_developpement',
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
	
	public function cadreMesureResultats()
    {
        return $this->hasMany(CadreMesureResultat::class, 'indicateur_id');
    }
	
	public function composanteIndicateurs()
    {
        return $this->hasMany(ComposanteIndicateur::class, 'indicateur_id');
    }
	
	public function desagregations()
	{
		return $this->belongsToMany(Desagregation::class, 'desagregation_indicateur', 'indicateur_id', 'desagregation_id');
	}
}

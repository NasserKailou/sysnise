<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CD_FinancementParResultat extends Pivot
{
    protected $table = 'cd_financement_par_resultats';
	

    protected $fillable = [
        'cadre_developpement_id',
        'cadre_logique_id',
        'montant',
    ];

    public function cadreLogique()
    {
        return $this->belongsTo(CadreLogique::class);
    }
	
	public function cadreDeveloppement()
	{
		return $this->belongsTo(CadreDeveloppement::class);
	}

	public function montantMobilises()
    {
        return $this->hasMany(
            CD_FinancementAnnuelParResultat::class,
            'plan_financement_id'
        )->where('statut_montant_financement_id', 1);
    }
	
	public function montantConsommes()
    {
        return $this->hasMany(
            CD_FinancementAnnuelParResultat::class,
            'plan_financement_id'
        )->where('statut_montant_financement_id', 2);
    }
	
	public function montantRecherches()
    {
        return $this->hasMany(
            CD_FinancementAnnuelParResultat::class,
            'plan_financement_id'
        )->where('statut_montant_financement_id', 3);
    }
	
	
	
	
	
	
}

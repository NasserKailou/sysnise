<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CD_FinancementParBailleur extends Pivot
{
    protected $table = 'cd_financement_par_bailleurs';
	

    protected $fillable = [
        'cadre_developpement_id',
        'bailleur_id',
        'montant',
    ];

    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class);
    }
	
	public function cadreDeveloppement()
	{
		return $this->belongsTo(CadreDeveloppement::class);
	}

	public function montantMobilises()
    {
        return $this->hasMany(
            CD_FinancementAnnuelParBailleur::class,
            'plan_financement_id'
        )->where('statut_montant_financement_id', 1);
    }
	
	public function montantConsommes()
    {
        return $this->hasMany(
            CD_FinancementAnnuelParBailleur::class,
            'plan_financement_id'
        )->where('statut_montant_financement_id', 2);
    }
	
	public function montantRecherches()
    {
        return $this->hasMany(
            CD_FinancementAnnuelParBailleur::class,
            'plan_financement_id'
        )->where('statut_montant_financement_id', 3);
    }
	
	
	
	
	
	
}

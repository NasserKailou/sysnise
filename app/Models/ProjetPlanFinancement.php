<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjetPlanFinancement extends Pivot
{
    protected $table = 'projet_plan_financements';
	

    protected $fillable = [
        'projet_id',
        'source_financement_id',
        'bailleur_id',
        'statut_financement_id',
        'nature_financement_id',
		'composante_id',
		'categorie_depense_id',
        'montant',
    ];

    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class);
    }

    public function statutFinancement()
    {
        return $this->belongsTo(StatutFinancement::class);
    }
	

    public function natureFinancement()
    {
        return $this->belongsTo(NatureFinancement::class);
    }

    public function sourceFinancement()
    {
        return $this->belongsTo(SourceFinancement::class);
    }
	
	public function composante()
    {
        return $this->belongsTo(Composante::class);
    }
	
	public function categorieDepense()
    {
        return $this->belongsTo(CategorieDepense::class);
    }
	
	public function budgetsAnnuelsPrevus()
    {
        return $this->hasMany(
            ProjetBudgetAnnuel::class,
            'plan_financement_id'
        )->where('statut_budget_id', 1);
    }
	
	public function budgetsAnnuelsDepenses()
    {
        return $this->hasMany(
            ProjetBudgetAnnuel::class,
            'plan_financement_id'
        )->where('statut_budget_id', 2);
    }
	
	public function budgetsAnnuels()
    {
        return $this->hasMany(
            ProjetBudgetAnnuel::class,
            'plan_financement_id'
        )->where('statut_budget_id', 3);
    }
	
	public function projet()
	{
		return $this->belongsTo(Projet::class);
	}
	
	
}

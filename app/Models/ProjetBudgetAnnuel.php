<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjetBudgetAnnuel extends Model
{
    protected $table = 'projet_budget_annuels';
    protected $fillable = [
        'plan_financement_id',
		'statut_budget_id',
		'annee',
        'montant',
    ];
	
	public function planFinancement()
    {
        return $this->belongsTo(
            ProjetPlanFinancement::class,
            'plan_financement_id'
        );
    }
	

}

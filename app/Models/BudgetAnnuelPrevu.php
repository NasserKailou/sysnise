<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetAnnuelPrevu extends Model
{
    
    protected $fillable = [
        'plan_financement_id',
        'categorie_depense_id',
		'annee',
        'montant',
    ];
	
	public function planFinancement()
    {
        return $this->belongsTo(
            PlanFinancement::class,
            'plan_financement_id'
        );
    }
	
	public function categorieDepense()
    {
        return $this->belongsTo(
            CategorieDepense::class,
            'categorie_depense_id'
        );
    }

}

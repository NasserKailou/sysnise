<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetAnnuelDepense extends Model
{
    
    protected $fillable = [
        'plan_financement_id',
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

}

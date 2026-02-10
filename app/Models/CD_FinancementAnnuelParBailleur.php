<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CD_FinancementAnnuelParBailleur extends Model
{
    protected $table = 'cd_financement_annuel_par_bailleurs';
    protected $fillable = [
        'plan_financement_id',
		'statut_montant_financement_id',
		'annee',
        'montant',
    ];
	
	public function financementParBailleur()
    {
        return $this->belongsTo(
            CD_FinancementParBailleur::class,
            'plan_financement_id'
        );
    }
	

}

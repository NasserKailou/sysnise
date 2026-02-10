<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CD_FinancementAnnuelParResultat extends Model
{
    protected $table = 'cd_financement_annuel_par_resultats';
    protected $fillable = [
        'plan_financement_id',
		'statut_montant_financement_id',
		'annee',
        'montant',
    ];
	
	public function financementParResultat()
    {
        return $this->belongsTo(
            CD_FinancementParResultat::class,
            'plan_financement_id'
        );
    }
	

}

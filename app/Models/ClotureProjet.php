<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClotureProjet extends Pivot
{
    protected $table = 'cloture_projets';
	

    protected $fillable = [
        'projet_id',
        'cout_effectif',
        'date_debut_effectif',
        'date_fin_effectif',
        'duree_effectif',
		'rapport_achevement',
		'conclusion_rapport_achevement',
		'date_rapport_achevement',
		'rapport_cloture',
		'conclusion_rapport_cloture',
		'date_rapport_cloture',
		'date_fermeture_comptes',
        'reference_document_fermeture_comptes',
    ];

    
	
}

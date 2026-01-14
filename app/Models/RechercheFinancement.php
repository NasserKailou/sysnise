<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RechercheFinancement extends Pivot
{
    //protected $table = 'recherche_financements';

    protected $fillable = [
        'projet_id',
        'source_financement_id',
        'bailleur_id',
        'statut_financement_id',
        'nature_financement_id',
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetAuditsExercice extends Model
{
    protected $table = 'projet_audits_exercices';
    protected $fillable = [
        'projet_id', 'exercice', 'comptes_certifies',
        'nb_recommandations_formulees', 'nb_recommandations_mises_oeuvre'
    ];

    protected $casts = [
        'comptes_certifies' => 'boolean',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
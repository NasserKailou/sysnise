<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetPilotageAnnee extends Model
{
    protected $table = 'projet_pilotage_annees';
    protected $fillable = [
        'projet_id', 'annee', 'nb_sessions_prevues', 'nb_sessions_tenues',
        'nb_recommandations_formulees', 'nb_recommandations_mises_oeuvre'
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function sessions()
    {
        return $this->hasMany(ProjetPilotageSession::class, 'projet_pilotage_annee_id');
    }
}
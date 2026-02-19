<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetPilotageSession extends Model
{
    protected $table = 'projet_pilotage_sessions';
    protected $fillable = ['projet_pilotage_annee_id', 'date_session'];

    protected $casts = [
        'date_session' => 'date',
    ];

    public function pilotageAnnee()
    {
        return $this->belongsTo(ProjetPilotageAnnee::class, 'projet_pilotage_annee_id');
    }
}
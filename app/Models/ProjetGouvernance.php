<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjetGouvernance extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'organe_pilotage_existe',
        'nb_sessions_prevues',
        'nb_sessions_tenues',
        'comptes_audites_regulierement',
        'commentaire_audit',
        'rempli_par',
        'date_remplissage',
    ];

    protected $casts = [
        'organe_pilotage_existe' => 'boolean',
        'comptes_audites_regulierement' => 'boolean',
        'date_remplissage' => 'date',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(GouvernanceSession::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(GouvernanceAudit::class);
    }

    public function problems(): HasMany
    {
        return $this->hasMany(GouvernanceProblem::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(GouvernanceRecommendation::class);
    }
}

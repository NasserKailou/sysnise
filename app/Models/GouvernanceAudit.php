<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GouvernanceAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_gouvernance_id',
        'nombre_audits_realises',
        'exercice_comptable',
        'comptes_certifies_sans_reserves',
        'nb_recommandations_etablies',
        'nb_recommandations_realisees',
    ];

    protected $casts = [
        'comptes_certifies_sans_reserves' => 'boolean',
    ];

    public function gouvernance(): BelongsTo
    {
        return $this->belongsTo(ProjectGouvernance::class, 'projet_gouvernance_id');
    }
}

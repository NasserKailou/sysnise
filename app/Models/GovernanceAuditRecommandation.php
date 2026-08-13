<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovernanceAuditRecommandation extends Model
{
    use HasFactory;

    protected $fillable = [
        'governance_audit_exercice_id',
        'libelle',
        'est_realisee',
    ];

    protected $casts = [
        'est_realisee' => 'boolean',
    ];

    public function exercice(): BelongsTo
    {
        return $this->belongsTo(GovernanceAuditExercice::class, 'governance_audit_exercice_id');
    }
}

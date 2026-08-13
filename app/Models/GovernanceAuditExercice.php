<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernanceAuditExercice extends Model
{
    use HasFactory;

    protected $fillable = [
        'governance_audit_id',
        'exercice_comptable',
        'comptes_certifies_sans_reserves',
    ];

    protected $casts = [
        'comptes_certifies_sans_reserves' => 'boolean',
    ];

    public function audit(): BelongsTo
    {
        return $this->belongsTo(GovernanceAudit::class, 'governance_audit_id');
    }

    public function recommandations(): HasMany
    {
        return $this->hasMany(GovernanceAuditRecommandation::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernanceAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'comptes_audites',
        'nombre_audits_realises',
        'commentaire',
    ];

    protected $casts = [
        'comptes_audites' => 'boolean',
        'nombre_audits_realises' => 'integer',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function exercices(): HasMany
    {
        return $this->hasMany(GovernanceAuditExercice::class)->orderBy('exercice_comptable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovernanceSolution extends Model
{
    use HasFactory;

    protected $fillable = [
        'governance_probleme_id',
        'libelle',
    ];

    public function probleme(): BelongsTo
    {
        return $this->belongsTo(GovernanceProbleme::class, 'governance_probleme_id');
    }
}

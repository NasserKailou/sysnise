<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernanceProbleme extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'libelle',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function solutions(): HasMany
    {
        return $this->hasMany(GovernanceSolution::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GouvernanceProblem extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_gouvernance_id',
        'probleme_rencontre',
        'solution_proposee',
    ];

    public function gouvernance(): BelongsTo
    {
        return $this->belongsTo(ProjetGouvernance::class, 'projet_gouvernance_id');
    }
}

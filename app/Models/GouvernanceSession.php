<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GouvernanceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_gouvernance_id',
        'date_session',
        'nb_recommandations_etablies',
        'nb_recommandations_realisees',
    ];

    protected $casts = [
        'date_session' => 'date',
    ];

    public function gouvernance(): BelongsTo
    {
        return $this->belongsTo(ProjetGouvernance::class, 'projet_gouvernance_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovernancePilotageRecommandation extends Model
{
    use HasFactory;

    protected $fillable = [
        'governance_pilotage_session_id',
        'libelle',
        'est_realisee',
    ];

    protected $casts = [
        'est_realisee' => 'boolean',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(GovernancePilotageSession::class, 'governance_pilotage_session_id');
    }
}

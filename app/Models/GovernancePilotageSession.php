<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernancePilotageSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'governance_pilotage_id',
        'date_session',
    ];

    protected $casts = [
        'date_session' => 'date',
    ];

    public function pilotage(): BelongsTo
    {
        return $this->belongsTo(GovernancePilotage::class, 'governance_pilotage_id');
    }

    public function recommandations(): HasMany
    {
        return $this->hasMany(GovernancePilotageRecommandation::class);
    }
}

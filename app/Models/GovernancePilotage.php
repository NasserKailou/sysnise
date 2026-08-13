<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernancePilotage extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'dispose_organe_pilotage',
        'nombre_sessions_prevues',
        'nombre_sessions_tenues',
    ];

    protected $casts = [
        'dispose_organe_pilotage' => 'boolean',
        'nombre_sessions_prevues' => 'integer',
        'nombre_sessions_tenues' => 'integer',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(GovernancePilotageSession::class)->orderBy('date_session');
    }
}

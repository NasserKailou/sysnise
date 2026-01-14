<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZoneIntervention extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projet_id',
        'zone_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'projet_id' => 'integer',
            'zone_id' => 'integer',
        ];
    }

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }
}

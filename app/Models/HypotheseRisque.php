<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HypotheseRisque extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cadre_logique_id',
        'hypothese',
		'risque',
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
            'cadre_logique_id' => 'integer',
        ];
    }

    public function cadreLogique(): BelongsTo
    {
        return $this->belongsTo(CadreLogique::class);
    }
}

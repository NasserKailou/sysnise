<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GouvernanceRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_gouvernance_id',
        'destinataire',
        'contenu',
    ];

    public function gouvernance(): BelongsTo
    {
        return $this->belongsTo(ProjetGouvernance::class, 'projet_gouvernance_id');
    }
}

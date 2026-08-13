<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovernanceRecommandation extends Model
{
    use HasFactory;

    protected $fillable = [
        'projet_id',
        'destinataire',
        'libelle',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }
}

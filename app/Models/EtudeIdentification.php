<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtudeIdentification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projet_id',
        'etude_id',
        'etude_disponible',
        'document_etude',
        'etude_envisagee',
        'source_financement_id',
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
            'etude_id' => 'integer',
            'etude_disponible' => 'boolean',
            'etude_envisagee' => 'boolean',
            'source_financement_id' => 'integer',
        ];
    }

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function etude(): BelongsTo
    {
        return $this->belongsTo(Etude::class);
    }

    public function sourceFinancement(): BelongsTo
    {
        return $this->belongsTo(SourceFinancement::class);
    }
}

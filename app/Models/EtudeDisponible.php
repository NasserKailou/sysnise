<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtudeDisponible extends Model
{
    use HasFactory;
	protected $table = 'projet_etude_disponible';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projet_id',
		'etude_id',
		'fichier',
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
			//'fichier' => 'string',
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
}

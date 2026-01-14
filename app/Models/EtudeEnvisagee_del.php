<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtudeEnvisagee extends Model
{
    use HasFactory;
	protected $table = 'projet_etude_envisagee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projet_id',
		'etude_id',
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

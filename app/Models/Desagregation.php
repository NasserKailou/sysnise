<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desagregation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intitule',
        'type_desagregation_id',
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
            'type_desagregation_id' => 'integer',
        ];
    }

    public function typeDesagregation(): BelongsTo
    {
        return $this->belongsTo(TypeDesagregation::class);
    }
	
	public function indicateurs()
	{
		return $this->belongsToMany(Indicateur::class, 'desagregation_indicateur', 'desagregation_id', 'indicateur_id');
	}
}

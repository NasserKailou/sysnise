<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonneeIndicateurDesagregation extends Model
{
	use HasFactory;
	 
    protected $table = 'donnee_indicateur_desagregation';

	protected $fillable = [
        'donnee_indicateur_id',
        'desagregation_id',
    ];
	
	protected function casts(): array
    {
        return [
            'id' => 'integer',
            'donnee_indicateur_id' => 'integer',
            'desagregation_id' => 'integer',
        ];
    }
	
    public function donneeIndicateur()
    {
        return $this->belongsTo(DonneeIndicateur::class);
    }


    public function desagregation()
    {
        return $this->belongsTo(Desagregation::class);
    }
}

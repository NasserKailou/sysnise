<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Zone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intitule',
        'code',
        'latitude',
        'longitude',
        'zone_id',
        'niveau',
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
        ];
		
		/*return [
            'id' => 'integer',
            'latitude' => 'double',
            'longitude' => 'double',
            'zone_id' => 'integer',
        ];*/
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }
	
	public function produits()
    {
        return $this->belongsToMany(
            Produit::class,
            'produit_zone',
            'zone_id',
            'produit_id'
        )->withTimestamps();
    }
	
	public function activites()
    {
        return $this->belongsToMany(
            Activite::class,
            'activite_zone',
            'zone_id',
            'activite_id'
        )->withTimestamps();
    }
}
